<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//cron is set to run every TODO: add time
$to = "wordpress-support-user@nv.ccsd.net";
$subject = "ccsd.net email server confirmation " . $_SERVER['SERVER_NAME'];;
$message = "Email Test Successfull";
$headers = "From: wordpress-support-user@nv.ccsd.net" . "\r\n" .
    "Reply-To: wordpress-support-user@nv.ccsd.net" . "\r\n" .
    "Return-Path: wordpress-support-user@nv.ccsd.net" . "\r\n" . // For bounce handling
    // "CC: thomas.meyer@arisant.com" . "\r\n" .
    "MIME-Version: 1.0" . "\r\n" .
    "Content-Type: text/plain; charset=UTF-8";


//make sure only cron can access this page
if (empty($_SERVER["REMOTE_ADDR"])) {
    mail($to, $subject, $message, $headers);
} else {
    //redirect to homepage
    header("Location: https://ccsd.net");
    exit();
}
?>