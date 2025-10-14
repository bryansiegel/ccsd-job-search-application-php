<?php

if(!isset($_POST['Submit'])) {
    header("Location: http://ccsd.net/employees/prospective/fingerprint/staff/");
    exit;
}


include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');
$_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');


# set the page parameters
$page['ribbon'] = array('employees', $home->url.'/employees/');
$page['title'] = 'Fingerprinting Payment';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>
<meta name="robots" content="noindex, nofollow">
		<!-- content -->
		<div id="content_wrap" class="content-wrap">

			<div id="main_content_wrap" class="main-content-full-wrap" role="main content">
				<section class="content-holder">
				<h1>Fingerprinting Payment Admin</h1>


                    <?php
                    //do the search
                    if(isset($_POST['Submit']) && $_POST['Submit'] == 'Search') {
                        //$parts = explode(" ", $_POST['search']);

                        $query = "SELECT fname, lname, amountPaid, confNum, touched, last4
                                  FROM ccsd.fingerprinting
                                  WHERE fname LIKE '$_POST[search]' || lname LIKE '$_POST[search]' || last4 LIKE '$_POST[search]'
                                  ORDER BY touched DESC
                                 ";
                        $result = mysql_query($query, $_dB_ccsd);

                        if(mysql_num_rows($result) == 0) {
                            echo '<p><strong>There are no results with that name.  <a href="index.php">Return</a> to search page.</strong></p>';
                        }
                        else {
                            echo '
                            <table border="0">
                            <tr>
                            <th align="left">Name</th>
                            <th align="left">SSN</th>
                            <th align="left">Amount Paid</th>
                            <th align="left">Date Paid</th>
                            <th align="left">Confirmation Number</th>
                            </tr>
                            ';
                            while($row = mysql_fetch_array($result)) {
                                $fname = stripslashes($row['fname']);
                                $lname = stripslashes($row['lname']);
                                echo '
                                <tr>
                                  <td width="20%">'.$fname.' '.$lname.'</td>
                                  <td width="20%">'.$row['last4'].'</td>
                                  <td width="20%">$'.$row['amountPaid'].'</td>
                                  <td width="20%">'.date('n/j/Y', $row['touched']).'</td>
                                  <td><a href="details.php?confNum='.$row['confNum'].'"</a>'.$row['confNum'].'</a></td>
                                </tr>';
                            }
                            echo '</table>';
                        }
                    }

                    ?>


				</section>
			</div> <!-- / main_content_wrap -->


				
			</div> <!-- /sidebar-wrap -->
		</div> <!-- /content-wrap -->

<?php include($home->inc['footer']); ?>