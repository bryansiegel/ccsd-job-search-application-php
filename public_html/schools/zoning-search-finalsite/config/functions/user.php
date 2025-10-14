<?php
#####
#	@ user.php (2013-07-11 0742 carroll)
#	@ previous 2012-10-16 0929 carroll), (2012-09-19 1504 carroll), (2012-09-13 1518 carroll), (2012-09-11 1611 carroll)=
#	+ various user functions
#####

# intializer check
$initialized['functions']['user'] = 'OK';


/*

SELECT f.firstclass_pk, f.tracking_id, u.person_id, f.firstclass_id, e.email_address, u.first_name, u.last_name,
	u.pos_cd, p.pos_desc, u.ccsd_classification, u.grp, u.ccsd_location, l.location_code, l.location_level, l.location_title, u.status, u.ccsd_terminated
	FROM firstclass_table f, user_table u, email_table e, ccsd_location_table l, poscodes p
	WHERE f.tracking_id = u.tracking_id
	AND u.ccsd_location = l.location_pk
	AND f.tracking_id = e.tracking_id
	AND u.pos_cd = p.pos_cd(+)
	
	
	# username lookup
	// AND lower(f.firstclass_id) = lower('$oci_username')
	
	# fc pk lookup
	// AND f.firstclass_pk = '$fc_user_pk'
	
	# person id lookup
	// AND u.person_id = '$person_id'
	
*/

# user for login purposes
/*
function get_user_profile($username) {
		
	$profile = get_user_status($username);
	
	if(empty($profile)) {
	
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
			$remote_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['REMOTE_ADDR'])) 
			$remote_ip = $_SERVER['REMOTE_ADDR'];
		mail('tlien@interact.ccsd.net', 'user not found', $user_query."\n\n$remote_ip");
		$is_mail = mail('rcarroll@interact.ccsd.net', 'user not found', $user_query."\n\n$remote_ip");
		die("There was a problem logging you in.\n\n".($is_mail?"The issue has been reported and you will be notified when it's resolved.":NULL));
	
	} else {
		
		# get the user privileges
		$profile['privileges'] = get_user_privileges($profile['fc_user_pk']);
	
	}
	return $profile;
}
*/
function get_user_profile($username) {
	
	# username adjustments
	$username = stripslashes($username);
	$oci_username = str_replace("'", "''", $username);
	
	# connect to the db server, make sure we can finish authentication once LDAP is done
	$_dB_newstaff = @ocilogon("new_staff", "n3ws1a44", "rehostdb")
		or die('Unable to Authenticate, please try again later. (DB)');
		
	# get the firstclass pk, tracking id, and stored username
	$user_query = "SELECT f.firstclass_pk, f.tracking_id, u.person_id, f.firstclass_id, e.email_address, u.first_name, u.last_name,";
	$user_query .= " u.pos_cd, p.pos_desc, u.ccsd_classification, u.grp, u.ccsd_location, l.location_code, l.location_level, l.location_title, u.status, u.ccsd_terminated";
	$user_query .= " FROM firstclass_table f, user_table u, email_table e, ccsd_location_table l, poscodes p";
	$user_query .= " WHERE f.tracking_id = u.tracking_id";
	$user_query .= " AND u.ccsd_location = l.location_pk";
	$user_query .= " AND f.tracking_id = e.tracking_id";
	$user_query .= " AND u.grp = p.grp(+) AND u.pos_cd = p.pos_cd(+)";
	$user_query .= " AND lower(f.firstclass_id) = lower('$oci_username')";
	
	$user_stmt = OCIParse($_dB_newstaff, $user_query);
	ociexecute($user_stmt);
	ocifetchinto($user_stmt, $user, OCI_ASSOC);
	# exit immediately if the user is not found
	if(!ocirowcount($user_stmt)) {
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remote_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$remote_ip = $_SERVER['REMOTE_ADDR'];
		}
		
		mail('tlien@interact.ccsd.net', 'user not found - '.$oci_username, $user_query."\n\n$remote_ip");
		//$is_mail = mail('rcarroll@interact.ccsd.net', 'user not found - '.$oci_username, $user_query."\n\n$remote_ip");
		die("There was a problem logging you in. (Error Code: 001)\n\n".($is_mail?"The issue has been reported and you will be notified when it's resolved. ":NULL));
	}
	
	# get user privileges from newstaff
	$priv_query = "SELECT privilege FROM firstclass_privilege WHERE firstclass_entry = ".$user['FIRSTCLASS_PK']." AND privilege IS NOT NULL ORDER BY privilege ASC";
	$priv_stmt = OCIParse($_dB_newstaff, $priv_query);
	ociexecute($priv_stmt);
	$privileges = array();
	while(ocifetchinto($priv_stmt, $priv, OCI_ASSOC)) {
		$privileges[] = $priv['PRIVILEGE'];
	}

	# log the session id
	$ret['CCSDSESSID']		= strstr($_SERVER['HTTP_HOST'], 'ccsd') ? $_COOKIE['CCSDSESSID'] : NULL;
	# declare space to track single sign on
	//$ret['ccsdsso']			= '';
	# set the parameters for the output array, usable by the developer to control permissions, logging, etc.
	$ret['username'] 		= $user['FIRSTCLASS_ID'];
	$ret['fc_user_pk']		= $user['FIRSTCLASS_PK'];
	$ret['tracking_id'] 	= $user['TRACKING_ID'];
	$ret['person_id'] 		= $user['PERSON_ID'];
	$ret['surname'] 		= $user['LAST_NAME'];
	$ret['givenname'] 		= $user['FIRST_NAME'];
	$ret['commonname'] 		= $user['FIRST_NAME'].' '.$user['LAST_NAME'];
	$ret['useremail'] 		= $user['EMAIL_ADDRESS'];
	$ret['classification'] 	= $user['CCSD_CLASSIFICATION'];
	$ret['position'] 		= $user['POS_CD'];
	$ret['group'] 			= $user['GRP'];
	$ret['lcode']			= $user['LOCATION_CODE'];
	$ret['ltitle']			= $user['LOCATION_TITLE'];
	$ret['loclvl']			= $user['LOCATION_LEVEL'];
	$ret['status']			= $user['STATUS'];
	$ret['terminated']		= !empty($user['CCSD_TERMINATED']) ? strtotime($user['CCSD_TERMINATED']) : null;
	$ret['privileges'] 		= $privileges;
	
	//if(!isset($user['STATUS']))
		//mail('rcarroll@interact.ccsd.net', 'user func', $_SERVER['REQUEST_URI']."\n".$username);
	
	
	# oracle cleanup
	ocifreestatement($user_stmt);
	ocifreestatement($priv_stmt);
	ocilogoff($_dB_newstaff);
	//ldap_unbind($ds);
	# return the output array
	return $ret;
}

function get_user_profile_ess_fix($username) {
	/*
	$_dB_USER = 'httpd';
	$_dB_PASS = 'httpd';
	$_dB_CONN = 'heraclitus.ccsd.net';

	$conn = mysql_connect($_dB_CONN, $_dB_USER, $_dB_PASS);
	if (!$conn) {
	    die('Unable to Authenticate, please try again later. (DB)' . mysql_error());
	}

	mysql_select_db("zend_users_dev");

	# username adjustments
	$username = strtolower( stripslashes($username) );

	//Grabbing Login Data from Server
	$query = "SELECT * FROM zend_users_dev.users WHERE USERNAME='$username' LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	// temp hack
	//exec("wget -qO- http://206.194.10.53/users/search/integrity/$row[ID] &> /dev/null");


	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	*/
	/* OLD CURL
	// Use API to fetch user's data
			$service_url = 'https://ccsdapps.net/application/api/checkuser';
			$curl = curl_init($service_url);
			$curl_post_data = array(
				"req" => 55,	// 55 is the code designated/assigned by TISS-Technical Resources
				"username" => strtolower($username),
			);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

			$result = json_decode(curl_exec($curl), true);
			//die(var_dump($result));
			curl_close($curl);
	OLD CURL */
	//in users dev table priv is delim by comma, so exploding.
	//$privileges = explode(',', $row['GROUPS']);
	//if ($result['success'] != "true")
	//	die("User not validated");
	$service_url = 'http://ccsdapps.net/unsecure/index.php?username='.urlencode($username);
	$result = json_decode(file_get_contents($service_url), true);
			$row = $result['data'];
	$personNo=$row['PERSON_NO'];
	$personGroup = $row['PRI_EMP_GROUP'];

/*
	//==========================================================================
	// Get group code -- needed because zend_users_dev doesn't have it
	//==========================================================================
	$_dB_cisintr1 = @ocilogon("cis_intr1", "jumpprod", "rehostdb")
		or die('Unable to Authenticate, please try again later. (DB)');
	$q = "SELECT * FROM CUSERDB1.PERSON_DETAIL where PERSON_NO=$personNo";
	$detailRows = OCIParse($_dB_cisintr1, $q);
	ociexecute($detailRows);
	while(ocifetchinto($detailRows, $detailRow, OCI_ASSOC)){
		$personGroup = $detailRow['PRI_EMP_GROUP'];
	}
	oci_free_statement($detailRows);
	oci_close($_dB_cisintr1);

	//==========================================================================
	// Get EMPID -- needed because zend_users_dev sometimes doesn't have it
	//==========================================================================
	$_dB_cisintr1 = @ocilogon("cis_intr1", "jumpprod", "rehostdb")
		or die('Unable to Authenticate, please try again later. (DB)');
	$q = "SELECT * FROM CUSERDB1.PERSON where PERSON_NO=$personNo";
	$detailRows = OCIParse($_dB_cisintr1, $q);
	ociexecute($detailRows);
	while(ocifetchinto($detailRows, $detailRow, OCI_ASSOC)){
		$empid = $detailRow['EMPID'];
		$ssn = $detailRow['SSN'];
	}
	oci_free_statement($detailRows);
	oci_close($_dB_cisintr1);


    //Extract Alias, if an @ exist, then add key 0 and 1 together.
    $rowAlias=explode(',',$row['ALIAS']);
	$rowAlias=explode('@',$rowAlias[0]);
	if(isset($rowAlias[1])){
	$rowAlias=$rowAlias[0].'@'.$rowAlias[1];
	}
	else {
	$rowAlias=$rowAlias[0].'@interact.ccsd.net';
	}
	*/
	//$ldapauth_arr['CCSDSESSID'] = md5(microtime());
	$ldapauth_arr['CCSDSESSID']	= strstr($_SERVER['HTTP_HOST'], 'ccsd') ? $_COOKIE['CCSDSESSID'] : NULL;
	$ldapauth_arr['username'] = $username;
	$ldapauth_arr['fc_user_pk'] = $row['PK'];
	$ldapauth_arr['tracking_id'] = $row['TRACKINGID'];
	$ldapauth_arr['person_id'] = $row['EMPID'];
	$ldapauth_arr['surname'] = $row['LNAME'];
	$ldapauth_arr['givenname'] = $row['FNAME'];
	$ldapauth_arr['commonname'] = $row['FNAME'] . ' ' . $row['LNAME'];
	$ldapauth_arr['useremail'] = $row['EMAIL'];
	$ldapauth_arr['classification'] = 'CCSD_EMPLOYEE';
	$ldapauth_arr['position'] = ''; // job code? not present in new
	$ldapauth_arr['group'] = $row['PRI_EMP_GROUP'];
	$ldapauth_arr['lcode'] = $row['PRI_WORK_LOC'];
	$ldapauth_arr['location'] = $row['LOC_NAME'];
	$ldapauth_arr['poscode'] = $row['PRI_JOB_POS_CODE'];
	$ldapauth_arr['postitle'] = $row['POSITION_TITLE'];
	$ldapauth_arr['ssn'] = $row['SSN'];
	//$ldapauth_arr['ltitle'] =
	//$ldapauth_arr['loclvl'] =
	$ldapauth_arr['status'] = 'active';
	$ldapauth_arr['terminated'] = '';
	$ldapauth_arr['privileges'] = $row['GROUPS'];
	$ldapauth_arr['display_name'] = $row['KNOWN_AS'];
	//$ldapauth_arr['pwd'] = $row['PWD'];

	//==========================================================================
	// UPDATE OUR TABLE FOR DATA INTEGRITY -- zend_users_dev
	//==========================================================================
	//$query = "UPDATE zend_users_dev.users SET EMPID='$empid', SSN='$ssn', PERSONNO='$personNo' WHERE USERNAME='$username'";
	//$result = mysql_query($query);


	# return the output array
	return $ldapauth_arr;
}

# utility function for getting user status and basic info
function get_user_status($username = null, $fc_user_pk = null, $person_id = null) {
	
	if(is_null($username) && is_null($fc_user_pk) && is_null($person_id))
		exit('No arguments passed.');
	
	# connect to the db server, make sure we can finish authentication once LDAP is done
	$_dB_newstaff = @ocilogon("new_staff", "n3ws1a44", "rehostdb")
		or die('Unable to Authenticate, please try again later. (DB)');
	# get the firstclass pk, tracking id, and stored username
	$user_query = "SELECT f.firstclass_pk, f.tracking_id, u.person_id, f.firstclass_id, e.email_address, u.first_name, u.last_name,"
		." u.pos_cd, p.pos_desc, u.ccsd_classification, u.grp, u.ccsd_location, l.location_code, l.location_level, l.location_title, u.status, u.ccsd_terminated"
		." FROM firstclass_table f, user_table u, email_table e, ccsd_location_table l, poscodes p"
		." WHERE f.tracking_id = u.tracking_id"
		." AND u.ccsd_location = l.location_pk"
		." AND f.tracking_id = e.tracking_id"
		." AND u.grp = p.grp(+) AND u.pos_cd = p.pos_cd(+)";
	
	# the value to lookup
	if(!is_null($username)) {
		
		# username adjustments
		$username = stripslashes($username);
		$oci_username = str_replace("'", "''", $username);
		
		$user_query .= " AND lower(f.firstclass_id) = lower('$oci_username')";
		
	} elseif(!is_null($fc_user_pk))
		$user_query .= " AND f.firstclass_pk = '".((int) $fc_user_pk)."'";
	
	elseif(!is_null($person_id)) 
		$user_query .= " AND u.person_id = '".((int) $person_id)."'";
	
	
	
	$user_stmt = ociparse($_dB_newstaff, $user_query);
	ociexecute($user_stmt);
	ocifetchinto($user_stmt, $user, OCI_ASSOC);
	# return false if not found
	if(!ocirowcount($user_stmt))
		return false;
	else {
		
		# setup return array
		$ret 					= array();
		$ret['username'] 		= $user['FIRSTCLASS_ID'];
		$ret['fc_user_pk']		= $user['FIRSTCLASS_PK'];
		$ret['tracking_id'] 	= $user['TRACKING_ID'];
		$ret['person_id'] 		= $user['PERSON_ID'];
		$ret['surname'] 		= $user['LAST_NAME'];
		$ret['givenname'] 		= $user['FIRST_NAME'];
		$ret['commonname'] 		= $user['FIRST_NAME'].' '.$user['LAST_NAME'];
		$ret['useremail'] 		= $user['EMAIL_ADDRESS'];
		$ret['classification'] 	= $user['CCSD_CLASSIFICATION'];
		$ret['position'] 		= $user['POS_CD'];
		$ret['pos_desc'] 		= $user['POS_DESC'];
		$ret['group'] 			= $user['GRP'];
		$ret['lcode']			= $user['LOCATION_CODE'];
		$ret['ltitle']			= $user['LOCATION_TITLE'];
		$ret['loclvl']			= $user['LOCATION_LEVEL'];
		$ret['status']			= $user['STATUS'];
		$ret['terminated']		= !empty($user['CCSD_TERMINATED']) ? strtotime($user['CCSD_TERMINATED']) : null;
		$ret['privileges']		= array();
		
		# oracle cleanup
		ocifreestatement($user_stmt);
		ocilogoff($_dB_newstaff);
		# return the output array
		return $ret;
	}	
}

# utility function for getting user status and basic info
function get_user_info_cis($person_id = null) {
	
	if(is_null($person_id))
		exit('No arguments passed.');
	$service_url = 'https://ccsdapps.net/application/api/checkuser';
			$curl = curl_init($service_url);
			$curl_post_data = array(
				"req" => 55,	// 55 is the code designated/assigned by TISS-Technical Resources
				"empid" => $person_id,
			);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

			$result = json_decode(curl_exec($curl), true);
			curl_close($curl);
			//die(var_dump($row));
	//in users dev table priv is delim by comma, so exploding.
	//$privileges = explode(',', $row['GROUPS']);
			$row = $result['data'];
	# connect to the db server, make sure we can finish authentication once LDAP is done
	//$_dB_rehostdb = @ocilogon("cis_intr1", "jumpprod", "rehostdb")
		//or die('Unable to Authenticate, please try again later. (DB)');
	# get the firstclass pk, tracking id, and stored username
	// $user_query = "SELECT f.firstclass_pk, f.tracking_id, u.person_id, f.firstclass_id, e.email_address, u.first_name, u.last_name,"
	// 	." u.pos_cd, p.pos_desc, u.ccsd_classification, u.grp, u.ccsd_location, l.location_code, l.location_level, l.location_title, u.status, u.ccsd_terminated"
	// 	." FROM firstclass_table f, user_table u, email_table e, ccsd_location_table l, poscodes p"
	// 	." WHERE f.tracking_id = u.tracking_id"
	// 	." AND u.ccsd_location = l.location_pk"
	// 	." AND f.tracking_id = e.tracking_id"
	// 	." AND u.grp = p.grp(+) AND u.pos_cd = p.pos_cd(+)";
	
	// # the value to lookup
	// if(!is_null($username)) {
		
	// 	# username adjustments
	// 	$username = stripslashes($username);
	// 	$oci_username = str_replace("'", "''", $username);
		
	// 	$user_query .= " AND lower(f.firstclass_id) = lower('$oci_username')";
		
	// } elseif(!is_null($fc_user_pk))
	// 	$user_query .= " AND f.firstclass_pk = '".((int) $fc_user_pk)."'";
	
	// elseif(!is_null($person_no)) 
	// 	$user_query .= " AND u.person_id = '".((int) $person_no)."'";
	/*
	$user_query = "
		SELECT 
			P.PERSON_NO,
			P.EMPID,
			P.FNAME,
			P.LNAME,
			PD.SITE,
			PD.EMAIL,
			L.TXTSITECODE,
			L.TXTSITENAME,
			L.TXTSITENAMESHORT
		FROM 
			CUSERDB1.PERSON p,
			CUSERDB1.PERSON_DETAIL pd,
			CUSERDB1.LOCATION l
		WHERE 
			P.empid IS NOT NULL 
			AND P.PERSON_NO = PD.PERSON_NO 
			AND LPAD(PD.SITE, 4, 0) = LPAD(L.TXTSITECODE, 4, 0) 
			AND P.EMPID = '$person_id' 
			AND rownum <= 1";

	$user_stmt = ociparse($_dB_rehostdb, $user_query);
	ociexecute($user_stmt);
	ocifetchinto($user_stmt, $user, OCI_ASSOC);
	# return false if not found
	if(!ocirowcount($user_stmt))
		return false;
	else {
		*/
		# setup return array
		$ret                     = array();
		$ret['PERSON_NO']        = $row['PERSONNO'];
		$ret['EMPID']            = $row['EMPID'];
		$ret['FNAME']            = $row['FNAME'];
		$ret['LNAME']            = $row['LNAME'];
		$ret['COMMONNAME']       = $row['FNAME'].' '.$row['LNAME'];
		$ret['SITE']             = $row['PRI_WORK_LOC'];
		$ret['EMAIL']            = $row['EMAIL'];
		$ret['TXTSITECODE']      = $row['PRI_WORK_LOC'];
		$ret['TXTSITENAME']      = $row['LOC_NAME'];
		$ret['TXTSITENAMESHORT'] = $row['LOC_NAME'];
		// $ret['username'] 		= $user['FIRSTCLASS_ID'];
		// $ret['fc_user_pk']		= $user['FIRSTCLASS_PK'];
		// $ret['tracking_id'] 	= $user['TRACKING_ID'];
		// $ret['person_id'] 		= $user['PERSON_ID'];
		// $ret['surname'] 		= $user['LAST_NAME'];
		// $ret['givenname'] 		= $user['FIRST_NAME'];
		// $ret['commonname'] 		= $user['FIRST_NAME'].' '.$user['LAST_NAME'];
		// $ret['useremail'] 		= $user['EMAIL_ADDRESS'];
		// $ret['classification'] 	= $user['CCSD_CLASSIFICATION'];
		// $ret['position'] 		= $user['POS_CD'];
		// $ret['pos_desc'] 		= $user['POS_DESC'];
		// $ret['group'] 			= $user['GRP'];
		// $ret['lcode']			= $user['LOCATION_CODE'];
		// $ret['ltitle']			= $user['LOCATION_TITLE'];
		// $ret['loclvl']			= $user['LOCATION_LEVEL'];
		// $ret['status']			= $user['STATUS'];
		// $ret['terminated']		= !empty($user['CCSD_TERMINATED']) ? strtotime($user['CCSD_TERMINATED']) : null;
		// $ret['privileges']		= array();
		
		# oracle cleanup
		//ocifreestatement($user_stmt);
		//ocilogoff($_dB_rehostdb);
		# return the output array
		return $ret;
		
}

# utility function for getting users privileges
function get_user_privileges($fc_user_pk = int) {
	/*
	# connect to the db server, make sure we can finish authentication once LDAP is done
	$_dB_newstaff = @ocilogon("new_staff", "n3ws1a44", "rehostdb")
		or die('Unable to authenticate, please try again later. (DB)');

	# get user privileges from newstaff
	$priv_query = 'SELECT privilege FROM firstclass_privilege WHERE firstclass_entry = '.$fc_user_pk.' AND privilege IS NOT NULL ORDER BY privilege ASC';
	$priv_stmt = OCIParse($_dB_newstaff, $priv_query);
	ociexecute($priv_stmt);
	$privileges = array();
	while(ocifetchinto($priv_stmt, $priv, OCI_ASSOC))
		$privileges[] = $priv['PRIVILEGE'];
	
	# oracle cleanup
	ocifreestatement($priv_stmt);
	ocilogoff($_dB_newstaff);
	# return the output array
	*/
	$service_url = 'https://ccsdapps.net/application/api/checkuser';
			$curl = curl_init($service_url);
			$curl_post_data = array(
				"req" => 55,	// 55 is the code designated/assigned by TISS-Technical Resources
				"pk" => strtolower($fc_user_pk),
			);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

			$result = json_decode(curl_exec($curl), true);
			curl_close($curl);
			//die(var_dump($row));
	//in users dev table priv is delim by comma, so exploding.
	//$privileges = explode(',', $row['GROUPS']);
			$row = $result['data'];
			$privileges = $row['GROUPS'];
	return $privileges;
}


# eof user.php
