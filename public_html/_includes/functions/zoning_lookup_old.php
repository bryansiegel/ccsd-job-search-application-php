<?php
/***
#	@ file		: zoning_lookup.php
#	@ location	: /www/apache/htdocs/ccsd/schools/zoning/search
#	@ author	: carroll
#	@ purpose	: searches zoning GIS information for schools by address
# 	@ created	: 2012-03-26 1240
# 	@ modified	: 2014-01-22 1414 tmiller
#	@ previous	: 2013-01-30 1414 carroll, 2012-10-31 0913 carroll, 2012-08-22 1541 vendivel, 2012-04-02 1424 carroll
#	+ 
#	Added pd param for mobile
#	+ 
***/
function zoning_lookup($house = null, $pd = null, $street = null, $uniqueid = null, $year = null) {

    /*
     * Not using the global to conect.  Change to mysql_pconnect and added error if it doesn't connect
     */
	global $_dB_ccsd;

	# prep values
	$house		= (int) preg_replace('/[^0-9]/', '', $house);
	//$pd			= (string) preg_replace('/[^a-z ]/i', '', strtolower($pd));
	$street		= (string) preg_replace('/[^a-z ]/i', '', strtolower($street));
	$uniqueid	= (int) preg_replace('/[^0-9]/', '', $uniqueid);
	$year		= $year == 0 || empty($year) ? date('Y'): $year;

	
	# sister schools, each line is a pair for a swap value
    if($year==2017) {
        $sister_schs = array(
            '365' => '239', '239' => '365',    # lunt/cambeiro				cambeiro/lunt
            '238' => '281', '281' => '238',    # vanderburg/twitchell		twitchell/vanderburg
            '248' => '306', '306' => '248',    # cartwright/gehring		gehring/cartwright
            '363' => '372', '372' => '363',    # mcmillan/katz				katz/mcmillan
            '368' => '371', '371' => '368',    # eisenberg/kahre			kahre/eisenberg
            '236' => '247', '247' => '236',    # wolfe/guy					guy/wolfe
            '284' => '347', '347' => '284',    # bilbray/scherkenbach		scherkenbach/bilbray
            '526' => '271', '271' => '526',    # ward/dailey				dailey/ward
            '233' => '381', '381' => '233',    # wilhelm/dr perkins		dr perkins/wilhelm
            '462' => '358', '358' => '462',    # wynn/roundy				roundy/wynn
            '310' => '364', '364' => '310',    # cox/woolley				woolley/cox
            '254' => '442', '442' => '254',    # cortez/diaz				diaz/cortez
            '430' => '314', '314' => '430',    # lowman/manch				manch/lowman
            '350' => '484', '484' => '350',    # hayden/duncan				duncan/hayden
            '921' => '903', '903' => '921',    # treem/thorpe				thorpe/treem
            //'913'	=> '901', '901' => '913',	# mitchell/marthaking 		marthaking/mitchell
            '221' => '658', '658' => '221',    # rundle/jkeller			jkeller/rundle
            '373' => '463', '463' => '373'        # wiener/hill			    hill/wiener
        );
    }
    if($year==2018 or $year==2019) {
        $sister_schs = array(
            '365' => '239', '239' => '365',    # lunt/cambeiro				cambeiro/lunt
            '238' => '281', '281' => '238',    # vanderburg/twitchell		twitchell/vanderburg
            '248' => '306', '306' => '248',    # cartwright/gehring		gehring/cartwright
            '363' => '372', '372' => '363',    # mcmillan/katz				katz/mcmillan
            '368' => '371', '371' => '368',    # eisenberg/kahre			kahre/eisenberg
            '236' => '247', '247' => '236',    # wolfe/guy					guy/wolfe
            '284' => '347', '347' => '284',    # bilbray/scherkenbach		scherkenbach/bilbray
            '526' => '271', '271' => '526',    # ward/dailey				dailey/ward
            '233' => '381', '381' => '233',    # wilhelm/dr perkins		dr perkins/wilhelm
            '462' => '358', '358' => '462',    # wynn/roundy				roundy/wynn
            '310' => '364', '364' => '310',    # cox/woolley				woolley/cox
            '254' => '442', '442' => '254',    # cortez/diaz				diaz/cortez
            '430' => '314', '314' => '430',    # lowman/manch				manch/lowman
            '350' => '484', '484' => '350',    # hayden/duncan				duncan/hayden
            '921' => '903', '903' => '921',    # treem/thorpe				thorpe/treem
            //'913'	=> '901', '901' => '913',	# mitchell/marthaking 		marthaking/mitchell
            '221' => '658', '658' => '221',    # rundle/jkeller			jkeller/rundle
            '373' => '463', '463' => '373'        # wiener/hill			    hill/wiener
        );
    }
		# changes for 2018
		if($year==2013) {
		    //$sister_schs['0373'] = '0463';			# wiener/hill
			//$sister_schs['0463'] = '0373';			# hill/wiener
		}

	# some query magic

    # New connection
    $zoneSearch = mysql_connect( "trmysql.ccsd.net", "httpd", "httpd");

    if (!$zoneSearch) {
        die('Could not connect: db1' . mysql_error());
    }

    /*
    *	Needed to program this modifier in because 
    *	Robert's code sucks MAJOR ballsacks
    *
    */

    # if house number is the only field filled out
    if ($house && !$street) {
    	$modifier = " ST_NUMBER LIKE '$house' ";
    } 

    # if street name is the only field filled out
    else if($street && !$house) {
    	$modifier = " ST_NAME LIKE '$street%' ";
    } 

    # if house number AND street name are both filled out
    else if($house && $street) {
    	$modifier = " ST_NUMBER LIKE '$house' AND ST_NAME LIKE '$street%' ";
    }

    # this id is utilized via javascript/ajax to select the chosen location
    # uniqueid only shows up if the search generated a range of locations
    if($uniqueid !=null) {
    	$modifier .= "AND uniqueid = $uniqueid";
    }


    #handle the year
    if($year == '2017') {$lookupTable = '2012zoning.zoning1718_ic';}
    else {$lookupTable = '2012zoning.zoning1819_ic';}

    # new columns from infinite campus
    # much better because it has exact streets
    $query = "
    		SELECT 
    			UNIQUEID, ST_NUMBER, ST_DIR, ST_NAME, ST_TYPE, BLDGAPT, CITY, ZIP,
    			SK, S1, S2, S3, S4, S5, S6, S7, S8, S9, S10, S11, S12,
    			SK_NAME, S1_NAME, S2_NAME, S3_NAME, S4_NAME, S5_NAME, S6_NAME, 
    			S7_NAME, S8_NAME, S9_NAME, S10_NAME, S11_NAME, S12_NAME
    		FROM ";
    $query .= "$lookupTable ";
	$query .= "WHERE " . $modifier . '
			ORDER BY ST_NUMBER ASC, ST_NAME ASC, BLDGAPT ASC';

	//echo $query;


    $result = mysql_query($query, $_dB_ccsd);

    if($result) {

    	$results = mysql_num_rows($result);
		$retarr = array();

	   	while($row = mysql_fetch_array($result)) {
	   		$retarr[$row['UNIQUEID']] = $row;

	   		if($results==1) {
	   			$retarr[$row['UNIQUEID']]['house'] = $row['ST_NUMBER'];
	   			$retarr[$row['UNIQUEID']]['stdir'] = $row['ST_DIR'];
	   			$retarr[$row['UNIQUEID']]['street'] = $row['ST_NAME'];
	   			$retarr[$row['UNIQUEID']]['streettype'] = $row['ST_TYPE'];
	   			$retarr[$row['UNIQUEID']]['bldgapt'] = $row['BLDGAPT'];
	   			$retarr[$row['UNIQUEID']]['city'] = $row['CITY'];
	   			$retarr[$row['UNIQUEID']]['zipcode'] = $row['ZIP'];

				# all grades
				$retarr[$row['UNIQUEID']]['schools'] =
					array($row['SK'], $row['S1'], $row['S2'], $row['S3'], $row['S4'], $row['S5'], $row['S6'], 
					$row['S7'], $row['S8'], $row['S9'], $row['S10'], $row['S11'], $row['S12']);

				# elementary
				$retarr[$row['UNIQUEID']]['es'] =
					array_unique(array($row['SK'], $row['S1'], $row['S2'], $row['S3'], $row['S4'], $row['S5']));

				# check for sister school, add it if so, flag for notification
				$sisters = array();

				$retarr[$row['UNIQUEID']]['shared'] = array();

				// iterate through the ES schools of specific zoned address to populate any sister schools
				foreach($retarr[$row['UNIQUEID']]['es'] as $schcode) {

					# if this school is in the sister schools array
					if(in_array($schcode, $sister_schs)) {

						# add the sister school to the list
						$retarr[$row['UNIQUEID']]['shared'][$schcode] = $sister_schs[$schcode];

						// associate the zoned school code with the sister school
						$schArr[$schcode] = getSisterSchoolInfo($sister_schs[$schcode]);

						# store flag for later
						$sisters[] = true;
					}
				}

				// return the school code mapping for sister school of specific zoned school
				$retarr[$row['UNIQUEID']]['shared']['sisterMap'] = $schArr;

				# flag sister schools
				$retarr[$row['UNIQUEID']]['is_shared'] = !empty($sisters) ? true : false;

				# flag prime 6 option (if kindergarten and first are not the same)
				//$retarr[$row['UNIQUEID']]['is_prime6'] = ($row['gk'] != $row['g1']) ? true : false ;

				if(($row['SK'] != $row['S1']) && $row['SK'] != 322) {
					$retarr[$row['UNIQUEID']]['is_prime6'] = true;
				}

				else {
					$retarr[$row['UNIQUEID']]['is_prime6'] = false;
				}

			}
   		}
        //var_dump($retarr);
   		return $retarr;
   	}

	else {
		return array();
	}
}

// for convenience -- this could improve or be moved to a full API
// this function is to be used for sister school info only since
// we're only passing back limited info
function getSisterSchoolInfo($loc) {

	// need left hand 0 because CIS prepends their loc with a 0
	$loc = str_pad($loc, 4, "0", STR_PAD_LEFT);

	// conn settings
	//$conn = oci_connect('cis_intr1', 'jumpprod', 'rehostdb');
    $conn = oci_connect('cis_intr1', 'jumpprod', 'rehostdb');


    if (!$conn) {
	    $e = oci_error();
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	    die('Could not connect to CIS db.');
	}

	// grab only the school of a particular location


	$query = "SELECT txtsitecode, txtsitename, txtphone 
				FROM cuserdb1.location 
				WHERE txtsitetype = 'School' 
					AND txtsitecode = '$loc'";
	 //echo $query;
	// execute
	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	// populate an array to be passed back 
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		
		// trim left zero
		$row['TXTSITECODE'] = ltrim($row['TXTSITECODE'], '0');

		$school = array( 'TXTSITECODE'=>$row['TXTSITECODE'], 'TXTSITENAME'=>$row['TXTSITENAME'], 'TXTPHONE'=>$row['TXTPHONE'] );
	}

	// pass the school info back
	return $school;

}
 //    $query = 'SELECT keycode, lowaddress, hiaddress, city, pd, street, streettype, zipcode, crecord, leftright ,'
	// 	." LPAD(gk,4,'0') gk, LPAD(g1,4,'0') g1, LPAD(g2,4,'0') g2, LPAD(g3,4,'0') g3, LPAD(g4,4,'0') g4, LPAD(g5,4,'0') g5,"
	// 	." LPAD(g6,4,'0') g6, LPAD(g7,4,'0') g7, LPAD(g8,4,'0') g8, LPAD(g9,4,'0') g9, LPAD(g10,4,'0') g10, LPAD(g11,4,'0') g11, LPAD(g11,4,'0') g12"
	// 	.' FROM 2012zoning.zoning'.$year.' WHERE'
	// 	.' lowaddress > 0'
	// 	.' AND even = '.($house % 2 == 0 ? 1 : 0)
	// 	.($house	!=null ? " AND ('$house' BETWEEN lowaddress AND hiaddress)" : '')
	// 	.($pd		!=null ? " AND pd = '$pd'" : '')
	// 	.($street	!=null ? " AND (LOWER(street) LIKE '$street%')" : '')
	// 	.($keycode	!=null ? " AND keycode = $keycode" : '')
	// 	.' ORDER BY street, lowaddress';
		
	// //echo $query;

	// //$result = mysql_query($query, $_dB_ccsd);
 //    $result = mysql_query($query, $zoneSearch);
	
	// $results = mysql_num_rows($result);
	
	// if($results) {

	// 	$retarr = array();
	// 	while($row = mysql_fetch_assoc($result)) {
			
	// 		$retarr[$row['keycode']] = $row;
			
	// 		if($results==1) {
	// 			# all grades
	// 			$retarr[$row['keycode']]['schools'] =
	// 				array($row['gk'], $row['g1'], $row['g2'], $row['g3'], $row['g4'], $row['g5'], $row['g6'], 
	// 					$row['g7'], $row['g8'], $row['g9'], $row['g10'], $row['g11'], $row['g12']);
				
				
	// 			# elementary
	// 			$retarr[$row['keycode']]['es'] =
	// 				array_unique(array($row['gk'], $row['g1'], $row['g2'], $row['g3'], $row['g4'], $row['g5']));
				
	// 			# check for sister school, add it if so, flag for notification
	// 			$sisters = array();
				
	// 			$retarr[$row['keycode']]['shared'] = array();
	// 			foreach($retarr[$row['keycode']]['es'] as $schcode) {
	// 				# if this school is in the sister schools array
	// 				if(in_array($schcode, $sister_schs)) {
	// 					# add the sister school to the list
	// 					$retarr[$row['keycode']]['shared'][$schcode] = $sister_schs[$schcode];
	// 					# store flag for later
	// 					$sisters[] = true;
	// 				}
	// 			}
				
	// 			# flag sister schools
	// 			$retarr[$row['keycode']]['is_shared'] = !empty($sisters) ? true : false;
				
	// 			# flag prime 6 option (if kindergarten and first are not the same)
	// 			//$retarr[$row['keycode']]['is_prime6'] = ($row['gk'] != $row['g1']) ? true : false ;

 //                if(($row['gk'] != $row['g1']) && $row['gk'] != 322) {$retarr[$row['keycode']]['is_prime6'] = true;}
 //                else {$retarr[$row['keycode']]['is_prime6'] = false;}
	// 		}
	// 	}	
	// 	return $retarr;
	// }
	// else return array();

//}


# eof zoning_lookup.php
