<?php

require "mysql.php";

require('../config/initializer.php');
/*
Handle Next Year Zoning Information
	setting this variable to true will allow side-by-side search results for the current school year and next school  year
	ensure the next year table is available when this is true, all years in code will update based on current year 
*/
$handle_next_year	= false;
$curent_year_range	= '2024-2025';
$next_year_range	= '2025-2026';

# ccsd location lookup
include(CCSDLOCATION);

# include zoning lookup function, (moved to /_includes/functions for mobile use)
include('../includes/zoning_lookup.php');

ini_set('display_errors', false);

//print_r($_GET);
$house = isset($_GET['house']) ? $_GET['house'] : null;
$street = isset($_GET['street']) ? $_GET['street'] : null;
$uniqueid = isset($_GET['uniqueid']) ? (int)$_GET['uniqueid'] : null;
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y'); //date('n') >= 6 ? date('Y') + 1 : date('Y')

# handle uniqueid differences between years
if($handle_next_year && ($_GET['ytype']=='next' && ($year == date('Y') + 1))) {
	$uniqueid = null;
}

//echo $year;


$matches = zoning_lookup($house, null, $street, $uniqueid, $year);
//print_r($matches);
#NOTE: YEARLY UPDATE
?>
	
<div style="padding-top:10px;padding-bottom:10px;margin-top:20px;margin-bottom:30px;font-weight:bold;background-color:#eeeeee;border-top:1px solid #2C5B96;border-bottom:1px solid #2C5B96;"><p style="font-weight:bold;font-size:1em; text-align: center;">Not the right address? <a href="./" >Try another search</a></p></div>

	    <h3><? if($year == '2025') { echo '2024 - 2025 School Year';} else { echo '2025 - 2026 School Year';} ?></h3>
        <? if(count($matches)==1) {
			# reset the array index
			$match = reset($matches);
			//echo print_r($matches);
			# school location code for each grade..., lets reduce this to unique location codes
			//$match = array_unique($match);
		?>
		

		<? #if(empty($_GET['year'])) { ?>
			<div style="clear: both;" class="school-year-choice">
				<? 
				// can't use this since new data doesn't have crecord or leftright
				if(ip_range('10') || ip_range('206.194')) { 
				?>
				<!-- <div style="float: right; color: #777; font-weight: bold;"><em>Grid #<?=$match['crecord']; ?><?=$match['leftright']; ?></em></div> -->
				<? } ?>
				<h4 style="margin: 0 0 .5em; padding: 0;">
				<? // =!empty($_GET['house'])? $_GET['house'] : $match['house']; ?>
				<? //=(!empty($match['pd'])? $match['pd'].' ':'').$match['street']; ?>
				<?=$match['ST_NUMBER']?> <?=$match['ST_DIR']?> <?=$match['ST_NAME']?> <?=$match['ST_TYPE']?><?=($match['BLDGAPT']) ? ', Apt '.$match['BLDGAPT'] : NULL ?>, <?=$match['city']; ?>,
				<?=$match['zipcode']; ?></h4>
				<? if($handle_next_year) { ?>
				School Year: <a href="#current" class="active" id="current_year_ctl" onclick="$('#current_results').show();$('#next_year_results').hide();$(this).addClass('active');$('#next_year_ctl').removeClass('active');">
				<?=$curent_year_range;?></a> <a href="#next-year" id="next_year_ctl" onclick="get_next_year();$(this).addClass('active');$('#current_year_ctl').removeClass('active');"><?=$next_year_range;?></a><? } ?>
			</div>
		<? #} ?>
		
		<? if(empty($_GET['year'])) { ?><div id="current_results"><? } ?>
				
			<? if($match['is_prime6']) { ?>

				<? if(in_array('0315', $match['schools'])) { ?>
                <h3>Prime 6 Zoning</h3>
				<p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a></p>
				<p>Students in kindergarten are assigned to attend Carson Elementary School (ES).  Students who wish to remain at Carson ES in grades 1 through 5 must apply for, and be accepted into,
					the Carson ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.</p>
				<p>Students in grades 1 through 5 are assigned to attend the elementary school listed below, but, as noted above, may opt to apply for the Carson ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.
					Students who do not wish to attend the elementary school listed below, or do not wish to apply for, or are not accepted into, the Carson ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>,
					may exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a> to attend Matt Kelly ES.</p>
				
				<? } elseif(in_array('0427', $match['schools'])) { ?>
                <h3>Prime 6 Zoning</h3>
				<p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="blank">Prime 6 Zoning Option</a></p>
				<p>Students in kindergarten are assigned to attend Gilbert Elementary School (ES).  Students who wish to remain at Gilbert ES in grades 1 through 5 must apply for, and be accepted into,
					the Gilbert ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.</p>
				<p>Students in grades 1 through 5 are assigned to attend the elementary school listed below, but, as noted above, may opt to apply for the Gilbert ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.
					Students who do not wish to attend the elementary school listed below, or do not wish to apply for, or are not accepted into, the Gilbert ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>,
					may exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a> to attend Kermit Booker ES.</p>
				
				<? } elseif(in_array('0411', $match['schools'])) { ?>
                <h3>Prime 6 Zoning</h3>
				<p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="blank">Prime 6 Zoning Option</a></p>
				<p>Students in kindergarten are assigned to attend Hoggard Elementary School (ES).  Students who wish to remain at Hoggard ES in grades 1 through 5 must apply for, and be accepted into,
					the Hoggard ES <a hdanref="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.</p>
				<p>Students in grades 1 through 5 are assigned to attend the elementary school listed below, but, as noted above, may opt to apply for the Hoggard ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.
					Students who do not wish to attend the elementary school listed below, or do not wish to apply for, or are not accepted into, the Hoggard ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>,
					may exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a> to attend Fitzgerald ES.</p>
				
				<? } elseif(in_array('0324', $match['schools'])) { ?>
                <h3>Prime 6 Zoning</h3>
				<p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="blank">Prime 6 Zoning Option</a></p>
				<p>Students in kindergarten are assigned to attend Mackey Elementary School (ES).  Students who wish to remain at Mackey ES in grades 1 through 5 must apply for, and be accepted into,
					the Mackey ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.</p>
				<p>Students in grades 1 through 5 are assigned to attend the elementary school listed below, but, as noted above, may opt to apply for the Mackey ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>.
					Students who do not wish to attend the elementary school listed below, or do not wish to apply for, or are not accepted into, the Mackey ES <a href="http://ccsd.net/schools/magnet-cta/" target="_blank">Magnet Program</a>,
					may exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a> to attend Fitzgerald ES.</p>



                <? } elseif($year == '2020') { ?>

                    <? if(in_array('0413', $match['schools'])) { ?>
                        <h3>Prime 6 Zoning</h3>
                        <p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>.</p>
                        <p>Kindergarten through 5th-grade students are assigned to the elementary school listed below,<br />
                            Or may opt to apply for a <a href="https://magnet.ccsd.net/site.php" target="_blank">Magnet Program</a>. Neighborhood elementary magnet programs include;</p>

                        <ul>
                            <li>Carson ES- International Baccalaureate,</li>
                            <li>Gilbert ES- Communications and Creative Arts,</li>
                            <li>Hoggard ES- Math and Science,</li>
                            <li>Mackey ES- Leadership and Global Communication,</li>
                        </ul>

                        <p>Or may opt to exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>
                            to enroll at the kindergarten assigned, neighborhood option school.</p>


                    <? } elseif(in_array('0410', $match['schools'])) { ?>
                        <h3>Prime 6 Zoning</h3>
                        <p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>.</p>
                        <p>Kindergarten through 5th-grade students are assigned to the elementary school listed below,<br />
                            Or may opt to apply for a <a href="https://magnet.ccsd.net/site.php" target="_blank">Magnet Program</a>. Neighborhood elementary magnet programs include;</p>

                        <ul>
                            <li>Carson ES- International Baccalaureate,</li>
                            <li>Gilbert ES- Communications and Creative Arts,</li>
                            <li>Hoggard ES- Math and Science,</li>
                            <li>Mackey ES- Leadership and Global Communication,</li>
                        </ul>

                        <p>Or may opt to exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>
                            to enroll at the kindergarten assigned, neighborhood option school.</p>

                    <? } elseif(in_array('0521', $match['schools'])) { ?>
                        <h3>Prime 6 Zoning</h3>
                        <p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>.</p>
                        <p>Kindergarten through 5th-grade students are assigned to the elementary school listed below,<br />
                            Or may opt to apply for a <a href="https://magnet.ccsd.net/site.php" target="_blank">Magnet Program</a>. Neighborhood elementary magnet programs include;</p>

                        <ul>
                            <li>Carson ES- International Baccalaureate,</li>
                            <li>Gilbert ES- Communications and Creative Arts,</li>
                            <li>Hoggard ES- Math and Science,</li>
                            <li>Mackey ES- Leadership and Global Communication,</li>
                        </ul>

                        <p>Or may opt to exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>
                            to enroll at the kindergarten assigned, neighborhood option school.</p>

                    <? } elseif(in_array('0319', $match['schools'])) { ?>
                        <h3>Prime 6 Zoning</h3>
                        <p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>.</p>
                        <p>Kindergarten through 5th-grade students are assigned to the elementary school listed below,<br />
                            Or may opt to apply for a <a href="https://magnet.ccsd.net/site.php" target="_blank">Magnet Program</a>. Neighborhood elementary magnet programs include;</p>

                        <ul>
                            <li>Carson ES- International Baccalaureate,</li>
                            <li>Gilbert ES- Communications and Creative Arts,</li>
                            <li>Hoggard ES- Math and Science,</li>
                            <li>Mackey ES- Leadership and Global Communication,</li>
                        </ul>

                        <p>Or may opt to exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>
                            to enroll at the kindergarten assigned, neighborhood option school.</p>

                    <? } elseif(in_array('0513', $match['schools'])) { ?>
                        <h3>Prime 6 Zoning</h3>
                        <p><b>PLEASE NOTE:</b> This address qualifies for a <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>.</p>
                        <p>Kindergarten through 5th-grade students are assigned to the elementary school listed below,<br />
                            Or may opt to apply for a <a href="https://magnet.ccsd.net/site.php" target="_blank">Magnet Program</a>. Neighborhood elementary magnet programs include;</p>

                        <ul>
                            <li>Carson ES- International Baccalaureate,</li>
                            <li>Gilbert ES- Communications and Creative Arts,</li>
                            <li>Hoggard ES- Math and Science,</li>
                            <li>Mackey ES- Leadership and Global Communication,</li>
                        </ul>

                        <p>Or may opt to exercise their <a href="http://ccsd.net/schools/zoning/maps/prime-6.pdf" target="_blank">Prime 6 Zoning Option</a>
                            to enroll at the kindergarten assigned, neighborhood option school.</p>
                        <? } ?>


                <? } else { ?>

					<? if(in_array('0466', $match['schools'])) { ?>
					<p><strong>Notice:</strong> Students in Kindergarten are assigned to attend Piggott Elementary School (ES). Students who wish to remain at
						Piggott ES in grades 1 through 5 must apply for, and be accepted into the Piggott Magnet Program.</p>
					<? } ?>

					<? if(in_array('0911', $match['schools'])) { ?>
						<p><strong>Notice:</strong>  Students in Kindergarten are assigned to attend McCaw Elementary School (ES). Students who wish to remain at
							McCaw ES in grades 1 through 5 must apply for, and be accepted into the McCaw Magnet Program.</p>
					<? } ?>

					<? if(in_array('203', $match['schools'])) { ?>
						<p><strong>Notice:</strong>  Students in Kindergarten are assigned to attend Sheila Tarr Elementary School (ES). Students who wish to remain at
							Sheila Tarr ES in grades 1 through 5 must apply for, and be accepted into the Sheila Tarr Magnet Program.</p>
					<? } ?>








                    <!-- ADDING PRIME 6 ZONING ADDITION ON MARCH 18, 2016-->
					<? if(in_array('0413', $match['schools'])) { ?>
						<h3>Prime 6 Zoning</h3>
						<p>Kindergarten is assigned to <?php echo $match['SK_NAME']; ?> Elementary School.
							Grades 1 - 5 are assigned to <?php echo $match['S1_NAME']; ?> Elementary School with
							the option to attend <?php echo $match['SK_NAME']; ?> Elementary School.</p>
					<? } ?>

					<? if(in_array('0410', $match['schools'])) { ?>
						<h3>Prime 6 Zoning</h3>
						<p>Kindergarten is assigned to <?php echo $match['SK_NAME']; ?> Elementary School.
							Grades 1 - 5 are assigned to <?php echo $match['S1_NAME']; ?> Elementary School with
							the option to attend <?php echo $match['SK_NAME']; ?> Elementary School.</p>
					<? } ?>

					<? if(in_array('0521', $match['schools'])) { ?>
						<h3>Prime 6 Zoning</h3>
						<p>Kindergarten is assigned to <?php echo $match['SK_NAME']; ?> Elementary School.
							Grades 1 - 5 are assigned to <?php echo $match['S1_NAME']; ?> Elementary School with
							the option to attend <?php echo $match['SK_NAME']; ?> Elementary School.</p>
					<? } ?>

					<? if(in_array('0319', $match['schools'])) { ?>
						<h3>Prime 6 Zoning</h3>
						<p>Kindergarten is assigned to <?php echo $match['SK_NAME']; ?> Elementary School.
							Grades 1 - 5 are assigned to <?php echo $match['S1_NAME']; ?> Elementary School with
							the option to attend <?php echo $match['SK_NAME']; ?> Elementary School.</p>
					<? } ?>

					<? if(in_array('0513', $match['schools'])) { ?>
						<h3>Prime 6 Zoning</h3>
						<p>Kindergarten is assigned to <?php echo $match['SK_NAME']; ?> Elementary School.
							Grades 1 - 5 are assigned to <?php echo $match['S1_NAME']; ?> Elementary School with
							the option to attend <?php echo $match['SK_NAME']; ?> Elementary School.</p>
					<? } ?>





				<? } ?>
			<? } ?>
			
			<? if($match['is_shared']) { ?>
			<div style="background-color: #fff89e; padding: 1em;">
				<h3 class="no-space">Shared Attendance Zone</h3>
				<p><strong>Notice:</strong> The elementary schools listed below share an attendance boundary. You may contact either to find out which school to enroll in.</p>
			</div>
			<? } ?>
			
			<table class="simple-table-rows" name="matches<?=!empty($_GET['year']) ? '_'.$_GET['year'] : ''; ?>" id="matches<?=!empty($_GET['year']) ? '_'.$_GET['year'] : ''; ?>" cellspacing="0" width="100%">
				<thead>
		    		<tr>  
				        <th style="width: 50px;">Grades</th>
				        <th>School</th>
                        <th><? if($year == '2025') { echo '2024 - 2025 Schedule';} else { echo '2025 - 2026 Schedule';} ?></th>
				        <th>Transportation</th>
				    </tr>
			    </thead>
			    
			    <tbody>
					<?
                    //echo 's2 '.$match['S2_NAME'];

                    foreach($match['schools'] as $grade=>$code) {
					// print_r($match);
					# needed for lookup because loc is prepended with 0 in cis location table
					$code = str_pad($code, 4, "0", STR_PAD_LEFT);

                    //var_dump($match);

					# cache the location data in session to save on CIS requests
					//$school = !isset($_SESSION['ZONING-RESULT'][$code]) ? reset(schoolinfo(array('txtsitecode'=>$code))) : $_SESSION['ZONING-RESULT'][$code];
					$mongo = new MongoDB\Driver\Manager('mongodb://commsUnitUser:ekhbwn6CbRET5eBW@mongodb1.ccsd.net:27017,mongodb2.ccsd.net:27017,mongodb3.ccsd.net:27017/?replicaSet=ccsd-mongo-apps&tls=true&tlsAllowInvalidHostnames=true&authSource=ccsdnet');




					$where = new MongoDB\Driver\Query(['TXTSITECODE' => $code], ['limit' => 1]);
					$school = get_object_vars($mongo->executeQuery('ccsdnet.locations', $where)->toArray()[0]);

                    //var_dump($school);
					// $trans_url ='http://transportation.ccsd.net:8080/edulog/webquery/WebQueryRequestController?action=9'
					// 	.'&year='.date('Y')
					// 	.'&address='.urlencode($house.' '.$match['street'].' '.$match['streettype'])
					// 	.'&grade='.($grade==0 ? 'K' : str_pad($grade, 2, 0, STR_PAD_LEFT))
					// 	.'&program=&clientRequest=Go&action=1';

                    $schedConn = mysql_connect('trmysql.ccsd.net', 'httpd', 'H!2m;Leg+z%ZP7KC');
                    if (!$schedConn) {
			    error_log(print_r('Could not connect to db',true));
                        die('Could not connect: db' . mysql_error());
                    }
                    $getSched = "SELECT currentYear,nextYear
                                 FROM 2012zoning.schedules
                                 WHERE location='$code';
                                ";
                    $schedQuery = mysql_query($getSched,$schedConn);

                    $schedRow = mysql_fetch_array($schedQuery);
					?>
					<tr>
					    <td class="text-center b"><span style="font-size: 120%; font-weight: bold;"><?=$grade==0 ? 'K' : $grade;?></span></td>
					    <td>

<!--                            School-->
					    	<a href="<?php echo $school['TXTSITEWEB'] ?>">

                                <?=$school['TXTSITENAME']; ?></a>


                            <br>


<!--                            Telephone-->
					    	<?=preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $school['TXTPHONE']); ?>
						    <?

						    # add sister school
						    if($match['is_shared'] && ($grade>=0 && $grade<=5)) {
								$code = ltrim($code, '0');

								// assign the sister school map to $sister for cleaner echos
						    	$sister = $match['shared']['sisterMap'][$code];

						    
						    ?>
<!--					    		School-->
                                <br><br><a href="<?=str_pad($sister['TXTSITEWEB'], 4, "0", STR_PAD_LEFT); ?>"><?=$sister['TXTSITENAME']; ?></a>



<!--                                Telephone-->
                                <br><?=preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $sister['TXTPHONE']); ?>
					    	<? } ?>
					    </td>
                        <? if($year == "2024") { ?>
                        <td class="text-center"><?php echo $schedRow['currentYear']; ?></td>
                        <? }

                        else { ?>
                        <td class="text-center"><?php echo $schedRow['nextYear']; ?></td>
                        <? } ?>
					    <td class="text-center"><a href="http://trans-webinfo.ccsd.net/InfoLocator/InfoLocator/Locator.aspx?OrgGuid=ORG-CCSD&ProfileGuid=CCSD-PROFILE-3" target="_blank">Bus Eligibility</a></td>
					</tr>
					<? } ?>
				</tbody>
			</table>
		<? if(empty($_GET['year'])) { ?></div><? } ?>
		<? if($handle_next_year && empty($_GET['year'])) { ?>
		<div id="next_year_results"></div>
		<script>
		var loaded_next_year = false;
		function get_next_year() {
			
			if(loaded_next_year == true) {
				$('#current_results').hide();
				$('#next_year_results').show();
			} else if(loaded_next_year != true) {

				$('#current_results').hide();
				$('#next_year_results').html('<div style="color: #999; padding: 20px; text-align: center;"><strong>Searching...</strong><br /><br /><img src="/_static/images/loaders/loader.gif" alt="loader" width="32" height="32" /></div>');
				
				$.ajax({
					url: '.search',
					type: 'get',
					cache: 'false',
					data: { house: '<?=$house; ?>', street: '<?=$street; ?>', uniqueid : $('#uniqueid').val(), year : '<?=date('Y')+1; ?>', ytype: 'next' },
					success: function(resp) {
					
						$('#next_year_results').html(resp);						
						$('#matches_<?=date('Y')+1; ?> tbody tr:odd').addClass('odd');
						$('#matches_<?=date('Y')+1; ?> tbody tr:even').addClass('even');
						$('#next_year_results').show();
						loaded_next_year = true;
					}
				});
			}
		}
		</script>
		<? } ?>	
		
	<? } else if(count($matches)>1) { ?>
		<table class="simple-table-rows" name="matches" id="matches" cellspacing="0" width="100%">
			<thead>
	    		<tr>  
			        <th width="50%">Address</th>
			        <th>City</th>
			        <th>Zip</th> 
			    </tr>
		    </thead>
		    <tbody>
			<? foreach($matches as $key=>$match) {
				$uniqueid_link = is_request_ajax() ? 'href="javascript:" onclick="byuniqueid('.$match['UNIQUEID'].', '.$year.');"' : 'href="?uniqueid='.$match['UNIQUEID'].'"' ;
			?>
				<tr>
				    <td><a <?=$uniqueid_link?>><?=$match['ST_NUMBER']?> <?=$match['ST_DIR']?> <?=$match['ST_NAME']?> <?=$match['ST_TYPE']?><?=($match['BLDGAPT']) ? ', Apt '.$match['BLDGAPT'] : NULL ?></a></td>
				    <td><?=$match['CITY']; ?></td>
				    <td><?=$match['ZIP']; ?></td>
				</tr>
			<? } ?>
			</tbody>
		</table>
	<? } elseif(count($matches)==0) { ?>
		<div class="no-matches">
			<hr><h2>No Matches</h2>
			<p>If your search yields <b>NO MATCHES</b>, try leaving the Street Number field blank and entering only the first 3 letters of the Street Name. Never enter street directions (N, S, E, W) or street types (Ave, Dr, St) in the Street Field).</p>
			<p>Need help? View the <a href="/schools/zoning/resources/address-troubleshooting-guide-2013.pdf" target="_blank">Address Troubleshooting Guide</a></p>
			<p>Still need help? Contact the <a href="http://ccsd.net/district/directory/demographics-zoning-gis-department">Demographics, Zoning &amp; GIS Department</a> at 702-799-6430</p>
		</div>
	<? } ?>

<? dot_file_exit(); ?>
