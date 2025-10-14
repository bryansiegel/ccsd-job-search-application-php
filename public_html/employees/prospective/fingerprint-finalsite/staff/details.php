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

if(isset($_POST[update])) {
    $now = date('U');
    $query = "UPDATE ccsd.fingerprinting SET
              redeemed='$now'
              WHERE confNum='$_POST[confNum]'
             ";
    $result = mysql_query($query, $_dB_ccsd);

}


$query = "SELECT fname, lname, bdate, paymentType, amountPaid, confNum, touched, redeemed
          FROM ccsd.fingerprinting
          WHERE confNum='$_REQUEST[confNum]'
         ";
$result = mysql_query($query, $_dB_ccsd);

$row = mysql_fetch_array($result);
$fname = stripslashes($row['fname']);
$lname = stripslashes($row['lname']);
if($row['type'] == 'new') {
    $type = "New";
}
else {
    $type = "Renew";
}

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

                    <p><a href="index.php">Return</a> to admin home page</p>

                    <form action="details.php" method="post" name="pay" id="pay">
                      <table class="simple-table" name="max" id="max" cellspacing="0">
                        <tr>
                          <td><label for="first name">First Name:</label> <strong><?php echo $fname; ?></strong></td>
                        </tr>
                        <tr>
                          <td><label for="last name">Last Name:</label> <strong><?php echo $lname; ?></strong></td>
                        </tr>
                          <tr>
                              <td><label for="Birthdate">Birthdate:</label> <strong><?php echo $row['bdate']; ?></strong></td>
                          </tr>

                          <tr>
                              <td><label for="type">Type:</label> <strong><?php echo $type; ?></strong></td>
                          </tr>
                          <tr>
                              <td><label for="total">Total:</label> <strong><?php echo '$'.$row['amountPaid']; ?></strong></td>
                          </tr>
                          <tr>
                              <td><label for="paid on">Paid On:</label> <strong><?php echo date('n/j/Y, Y \a\t H:i:s', $row['touched']); ?></strong></td>
                          </tr>
                          <tr>
                              <td><label for="confirmation">Confirmation #:</label> <strong><?php echo $row['confNum']; ?></strong></td>
                          </tr>
                          <tr>
                              <td><label for="confirmation">Redeemed:</label>
                                  <?php if($row['redeemed'] == '') {
                                      echo '<input name="redeemed" type="checkbox">';
                                  }
                                  else {
                                      echo '<strong>'.date('n/j/Y, Y \a\t H:i:s', $row['redeemed']).'</strong>';
                                  }
                                  ?>
                              </td>
                          </tr>
                            <?php
                            if($row['redeemed'] == '') {
                                echo '
                                  <tr>
                                      <td>
                                        <input name="confNum" type="hidden" value="'.$row['confNum'].'">
                                        <input name="update" type="submit"  value="Update">
                                      </td>
                                  </tr>
                                ';
                            }
                            ?>
                          </table>
                        </form>

				</section>
			</div> <!-- / main_content_wrap -->


		</div> <!-- /content-wrap -->

<?php include($home->inc['footer']); ?>