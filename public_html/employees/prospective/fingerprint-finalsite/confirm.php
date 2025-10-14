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


echo '<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
  // This identifies your website in the createToken call below
  Stripe.setPublishableKey(\'pk_live_ZQuyGcZ2MiTd55w6hXkVqlUE\');
  // ...
</script>';


if(isset($_POST['go']) && $_POST['go'] == 'Go'){
    include("action.php");
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
				<h1>Fingerprinting Payment Confirmation</h1>

                   <h2><?php echo $_SESSION['title']; ?></h2>

                    <form action="confirm.php" method="post" name="pay" id="pay">
                      <table name="finger" id="finger" cellspacing="5" cellpadding="10">
                        <tr>
                          <td><label for="first name">First Name:</label> <strong><?php echo $_SESSION['fname']; ?></strong></td>
                        </tr>
                        <tr>
                          <td><label for="last name">Last Name:</label> <strong><?php echo $_SESSION['lname']; ?></strong></td>
                        </tr>
                          <tr>
                              <td><label for="last four">Last Four Digits of Social Security Number:</label> <strong><?php echo $_SESSION['last4']; ?></strong></td>
                          </tr>

                          <tr>
                              <td><label for="type">Type:</label> <strong><?php echo $_SESSION['title']; ?></strong></td>
                          </tr>
                          <tr>
                              <td><label for="total">Total:</label> <strong><?php echo '$'.$_SESSION['total']/100; ?></strong></td>
                          </tr>
                          <tr>
                              <td>
                                  <!-- FOR STRIPE -->
                                  <input type="hidden" name="go" value="Go">
                                  <script
                                      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                      data-key="pk_live_ZQuyGcZ2MiTd55w6hXkVqlUE"
                                      data-amount="<?php echo $_SESSION['total']; ?>"
                                      data-name="Fingerprinting"
                                      data-allow-remember-me="false"
                                      data-description="<?php echo $_SESSION['fname'].' '.$_SESSION['lname'].' - $'.$_SESSION['total']/100; ?>"
                                      data-image="CCSD.png">
                                  </script>
                          </tr>
                          <tr>
                              <td><a href="index.php?type=<?php echo $_SESSION['type']; ?>">Return</a> to previous page.</a></td>
                          </tr>
                          </table>
                        </form>


				</section>
			</div> <!-- / main_content_wrap -->


		</div> <!-- /content-wrap -->

<?php include($home->inc['footer']); ?>