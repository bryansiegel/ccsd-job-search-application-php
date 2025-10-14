<?php
require_once("/www/apache/htdocs/ccsd/_includes/support/stripe/lib/Stripe.php");

Stripe::setApiKey("sk_live_oPWgH0JiPG4xJojFvJ6JlTR4");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

$_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
// Create the charge on Stripe's servers - this will charge the user's card
try {
    $charge = Stripe_Charge::create(array(
            "amount" => $_SESSION['total'], // amount in cents, again
            "currency" => "usd",
            "card" => $token,
            "description" => "$_SESSION[fname] $_SESSION[lname] : $_SESSION[type] : $_SESSION[last4] : $_SESSION[bdate]")
    );


} catch(Stripe_CardError $e) {
    // The card has been declined
    $_SESSION['sError'] = $e;
    exit;
}

$_SESSION['purchaseID'] = $charge->id;
$email = $_POST['stripeEmail'];

$fname = addslashes($_SESSION['fname']);
$lname = addslashes($_SESSION['lname']);
$amount = $_SESSION['total']/100;$now = date('U');
$dispDate = date('n/j/Y, Y \a\t H:i:s', $now);

/*PUT INTO DATABASE*/
$query = "INSERT INTO ccsd.fingerprinting
                  (fname, lname, bdate, paymentType, amountPaid, confNum, touched, last4)
                  VALUES
                  ('$fname', '$lname',  '$_SESSION[bdate]', '$_SESSION[type]', '$amount', '$_SESSION[purchaseID]','$now', '$_SESSION[last4]')
                 ";
$result = mysql_query($query,$_dB_ccsd);


//send the confirmation email
$msg = "<p>$_SESSION[fname] $_SESSION[lname], thank you for your payment of $$amount on $dispDate.</p> ";
$msg .= "<p>Your confirmation number is $_SESSION[purchaseID].</p>";
$msg .= "<p>Please keep this email for your records.</p>";

//mail headers
$headers = "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
$headers .= "MIME-Version: 1.0 " . "\r\n";
$headers .= "From: noreply@interact.ccsd.net";

mail($email, 'Fingerprint Payment Receipt', $msg, $headers);

header("Location: .thanks.php");
exit;
?>
