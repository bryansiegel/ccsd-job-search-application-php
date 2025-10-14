<?php
/***
#	@ file		: index.php
#	@ location	: /www/apache/htdocs/ccsd/employees/prospective/information
#	@ author	: nachti	
#	@ purpose	: useful employee information 
# 	@ created	: 2012-01-20 0920
# 	@ modified	: 2014-05-27 0928 a-to-the-double-l-a-to-the-n 
#	@ previous	: 2014-02-12 1100 a-to-the-double-l-a-to-the-n
#	+ 
#	+ 
***/
include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

$dispDate = date('n/j/Y, Y \a\t H:i:s a');

# set the page parameters
$page['ribbon'] = array('employees', $home->url.'/employees/');
$page['title'] = 'Fingerprinting Payment';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>
		<!-- content -->
		<div id="content_wrap" class="content-wrap">

			<div id="main_content_wrap" class="main-content-full-wrap" role="main content">
				<section class="content-holder">
				<h1>Fingerprinting Payment</h1>

                   <h2><?php echo $_SESSION['title']; ?></h2>

                    <p><?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?>, thank you for your payment on <?php echo $dispDate; ?>.<p>

                    <p>Your confirmation number is <strong><?php echo $_SESSION['purchaseID']; ?></strong>.</p>

                    <p>Please bring a copy of this page with you to confirm your payment.</p>

                    <p>Fingerprinting is located at 2832 E. Flamingo Rd., Las Vegas, NV 89121.</p>

                    <p>Fingerprinting is available by appointment only.</p>

                    <!--<p>Our hours are 8:00 am - 4:30 pm Monday through Thursday and Friday 1:00 pm - 4:30 pm</p> -->

                    <?php
                    if(date('U') > 1496439970 && date('U') < 1501311601) {
                            echo '<p><strong>NOTE:</strong> Our Summer hours (June 12 - July 28, 2017) are 7:00 am - 3:00 pm Monday through Thursday and Friday 1:00 pm - 3:00pm</p>';
                    }

                    ?>


				</section>
			</div> <!-- / main_content_wrap -->


		</div> <!-- /content-wrap -->


<?php

//destroy sessions
session_destroy();

include($home->inc['footer']);
?>