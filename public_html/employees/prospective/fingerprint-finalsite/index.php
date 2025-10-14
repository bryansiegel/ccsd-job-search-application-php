<?php

require('../includes/ccsd-global.php');

if(isset($_POST['Submit'])) {
    //error check
    if($_POST['fname'] == '') {
        $error = 1;
        $fnameError = 1;
    }
    if($_POST['lname'] == '') {
        $error = 1;
        $fnameError = 1;
    }
    if($_POST['month'] == '') {
        $error = 1;
        $monthError = 1;
    }
    if($_POST['day'] == '') {
        $error = 1;
        $dayError = 1;
    }
    if($_POST['year'] == '') {
        $error = 1;
        $yearError = 1;
    }


    if($error != 1) {
        $_SESSION['fname'] =  $_POST['fname'];
        $_SESSION['lname'] =  $_POST['lname'];
        $_SESSION['type'] = $_POST['type'];
        $_SESSION['last4'] = $_POST['last4'];
        $_SESSION['month'] = $_POST['month'];
        $_SESSION['day'] = $_POST['day'];
        $_SESSION['year'] = $_POST['year'];

        //build birthdate
        $_SESSION['bdate'] = $_POST['month'].'/'.$_POST['day'].'/'.$_POST['year'];

        header("Location: confirm.php");
        exit;
    }
}


#get the fingerprinting type
if(isset($_GET['type']) && $_GET['type'] == 'new') {
    $_SESSION['title'] = "Eligibility Check";
    $_SESSION['type'] = $_GET['type'];
    $_SESSION['total'] = 6000;
}
elseif(isset($_GET['type']) && $_GET['type'] == 'renew') {
    $_SESSION['title'] = "License Renewal";
    $_SESSION['type'] = $_GET['type'];
    $_SESSION['total'] = 1500;
}
elseif(isset($_GET['type']) && $_GET['type'] == 'vol') {
    $_SESSION['title'] = "Volunteer Eligibility Check";
    $_SESSION['type'] = $_GET['type'];
    $_SESSION['total'] = 5500;

}
else {
    header("Location: http://ccsd.net/departments/police-services/");
    exit;
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
				<h1>Fingerprinting Payment</h1>

                    <form action="index.php" method="post" name="pay" id="pay">
                      <table name="finger" id="finger" cellspacing="5" cellpadding="10" border="0">
                        <tr>
                          <td><strong>Please complete ALL fields</strong><br />
                              <?php
                              if($fnameError == 1) {
                                  echo "<br /><strong>Please complete your first name.</strong>";
                              }
                              if($lnameError == 1) {
                                  echo "<br /><strong>Please complete your last name.</strong>";
                              }
                              if($fnameError == 1) {
                                  echo "<br /><strong>Please complete your first name.</strong>";
                              }
                              if($monthError == 1) {
                                  echo "<br /><strong>Please choose your birth month.</strong>";
                              }
                              if($dayError == 1) {
                                  echo "<br /><strong>Please choose the day of your birth.</strong>";
                              }
                              if($yearError == 1) {
                                  echo "<br /><strong>Please choose your birth year.</strong>";
                              }
                              ?>
                          </td>
                        </tr>
                          <tr>
                              <td>Please enter your legal name as it appears on your valid government issued photo ID.</td>
                          </tr>
                        <tr>
                          <td><label for="fname">First Name:</label> <input name="fname" type="text" id="fname" maxlength="60" value="<?php echo $_SESSION['fname']; ?>"></td>
                        </tr>
                        <tr>
                          <td><label for="lname">Last Name:</label> <input name="lname" type="text" id="lname" maxlength="60" value="<?php echo $_SESSION['lname']; ?>" ?></td>
                        </tr>
                          <tr>
                              <td><label for="last4">Last Four Digits of Social Security Number:</label> <input name="last4" type="text" id="last4" size="6" maxlength="4"  value="<?php echo $_SESSION['last4']; ?>"></td>
                          </tr>
                          <tr>
                              <td>
                          Birthdate:
                          <label for="month">Birth Month</label>
                          <select name="month" id="month">
                              <option value="">Month</option>
                              <?php
                              for($i=1; $i<=12; $i++) {
                                  echo '<option value="'.$i.'"'; if($_SESSION['month'] == $i) { echo ' selected';} echo '>'.$i.'</option>';
                              }
                              ?>
                          </select>
                           /
                                  <label for="day">Birth Day</label>
                          <select name="day" id="day">
                              <option value="">Day</option>
                              <?php
                              for($i=1; $i<=31; $i++) {
                                  echo '<option value="'.$i.'"'; if($_SESSION['day'] == $i) { echo ' selected';} echo '>'.$i.'</option>';
                              }
                              ?>
                          </select>
                          /
                          <label for="year">Birth Year</label>
                          <select name="year" id="year">
                              <option value="">Year</option>
                              <?php
                              for($i=date('Y')-17; $i>=1930; $i--) {
                                  echo '<option value="'.$i.'"'; if($_SESSION['year'] == $i) { echo ' selected';} echo '>'.$i.'</option>';
                              }
                              ?>
                          </select>
                          </td>
                          </tr>
                          <tr>
    <td>
        Type: <strong><?php echo $_SESSION['title']; ?></strong><br>
        <?php
        if ($_SESSION['type'] == 'new') {
            echo '<span style="color:#ff0100;">New hires, Contractors, Employees on the 5 year fingerprint rotation</span>';
        } elseif ($_SESSION['type'] == 'renew') {
            echo '<span style="color:#ff0100;"> </span>';
        } elseif ($_SESSION['type'] == 'vol') {
            echo '<span style="color:#ff0100;">Volunteers & PreService Students</span>';
        }
        ?>
    </td>
</tr>
                          
                          
<!--
                          <tr>
                              <td>Type: <strong><?php echo $_SESSION['title']; ?></strong><br><span style="color:#ff0100;">New hires, Contractors, Employees on the 5 year fingerprint rotation</span>
</td>
                          </tr>
-->
                          <tr>
                              <td>Total: <strong><?php echo '$'.$_SESSION['total']/100; ?></strong><br/><span style="color:#ff0100;">*Refunds will not be issued under any circumstances</span></td>

                          </tr>
                          <tr>
                              <td>
                        <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
				        <input type="submit" name="Submit" value="Continue"></td>
                          </tr>
                          </table>
                        </form>

				</section>
			</div> <!-- / main_content_wrap -->


		</div> <!-- /content-wrap -->

<?php include($home->inc['footer']); ?>