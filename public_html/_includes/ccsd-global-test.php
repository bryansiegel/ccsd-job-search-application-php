<?php

/* * *
  #	@ file		: ccsd-global.php
  #	@ location	: /www/apache/htdocs/ccsd/_includes
  #	@ author	: carroll
  #	@ purpose	: global config and values for ccsd home page
  # 	@ created	: 2011-12-20 1009
  # 	@ modified	: 2012-10-11 1341 carroll
  #	@ previous	: 2012-10-03 1534 carroll, 2012-09-24 1046 carroll
  #	+
  #	+
 * * */
//****************************************************************************************
//		CCSDXFW Include
//		globally inherited functions and modules
//****************************************************************************************
//require('/www/apache/ccsdxfw/initializer.php');
require('/home/ccsd/public_html/ccsdxfw/initializer.php');
//****************************************************************************************
//		CONFIG
//		ccsd homepage primary config values
//****************************************************************************************
require(dirname(__FILE__) . '/ccsd-config-test.php');
//****************************************************************************************
//		GLOBAL INCLUDES
//		variable shortcuts for markup includes
//****************************************************************************************
include(dirname(__FILE__) . '/functions/handle_error.php');
include(dirname(__FILE__) . '/functions/datatable_cntrl.php');
include(dirname(__FILE__) . '/functions/ajax_support.php');

# allows developer mode code on .dev (for testing)
$is_dev = strstr($_SERVER['HTTP_HOST'], 'ccsd.dev') ? true : false;

function force_logout() {

    # destroy the session info
    unset($_COOKIE['CCSDNETSESSID']);
    $_SESSION = array();
    unset($_SESSION);

    # redirect
    $redirect = (!empty($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : str_replace('_logout', '', $_SERVER['REQUEST_URI']));

    header('location: ' . $redirect);
    exit;
}

# call logout from anywhere
if (isset($_GET['_logout'])) {
    force_logout();
}
# force redirect to secure

function force_secure() {

    global $home, $is_dev;
    # if not on secure.ccsd.net, take this request there now, except from .dev
    if ($home->domain != 'secure.ccsd.net' && !$is_dev)
        exit(header('location: https://secure.ccsd.net/' . ltrim($_SERVER['REQUEST_URI'], '/')));
}

//****************************************************************************************
//		GLOBAL DB CONNECTION
//		globally connect to db
//****************************************************************************************
// connect to ccsd mysql server this is to prevent mysql from having to many
// connections it is a bit messy and will be cleaned up latter. It was the easy way to do it
// in a short time. We basically look at the URL to determine if a connection should be made.


$name = $_SERVER['HTTP_HOST'];
$url = explode("/", $_SERVER['REQUEST_URI']);
$_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//if domain is ccsd.net then dont do anything, but if the subdomain is anything else then make a connection.
//if ($name == 'ccsd.net' || $name == 'www.ccsd.net') {
//    
//} else {
//    $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//}
//
////now if the connections are on ccsd.net make a connection on each url, these are more than likely apps.
//if ($url[1] == 'students') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'departments') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'schools') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'trustees') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'employees') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'district') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}
//
//if ($url[1] == 'community') {
//    if (!$_dB_ccsd) {
//        $_dB_ccsd = mysql_pconnect('trmysql.ccsd.net', 'admin', '3HE|U#[NIOSwc[224df');
//    }
//}


//or die(handle_error('maintenance'));
# set all mysql output to utf8

if ($_dB_ccsd) {

    mysql_set_charset('utf8');
}



//****************************************************************************************
//		GLOBAL DB CONNECTION
//		globally connect to db
//****************************************************************************************
# connect to ccsd mysql server
//echo"<pre>";var_dump($_dB_nr_CONN, $_dB_nr_USER, $_dB_nr_PASS );exit;
//$_dB_nr_ccsd = mysql_connect( $_dB_nr_CONN, $_dB_nr_USER, $_dB_nr_PASS )
//$_dB_nr_ccsd = mysql_connect('heraclitus.ccsd.net:3306', 'httpd', 'httpd' )
//	or die(handle_error('maintenance'));
# set all mysql output to utf8
//mysql_set_charset('utf8');
//****************************************************************************************
//		ADDITIONAL 
//		no comments yet
//****************************************************************************************
# determine if we made a request to a /.tool file without js/ajax and inject a clean body
if (strstr($_SERVER['REQUEST_URI'], '/.') && !is_request_ajax()) {
    include($home->inc['ajax-body']);
}


/** SESSION MANAGEMENT * */
/** STILL IN BETA * */
if (!session_id()) {
    setcookie('CCSDNETSESSID', session_id(), time() + 3600, '/');
}

//echo '<!--';
//echo 'sid'.session_id();
//echo '-->';


function insert_new_db($post, $table, $options = '') {
    $submitted = time();
    $query = "INSERT INTO $table (createdTime) VALUES ('$submitted')";
    $result = mysql_query($query) or die(mysql_error() . $query);
    if ($result == true) {
        $tableFields = $table . 'Fields';
        $pid = mysql_insert_id();
        foreach ($post as $key => $val) {
            $query = "INSERT INTO $tableFields (pid, name, data) VALUES ('$pid', '$key', '$val')";
            $result = mysql_query($query) or die(mysql_error() . $query);
        }
    }
}

//if(empty($_SERVER['HTTP_USER_AGENT']))
	//mail('rcarroll@interact.ccsd.net', 'user agent', arr_to_str($_SERVER));

//if(empty($_SERVER['HTTP_HOST']))
//	mail('rcarroll@interact.ccsd.net', 'http host', arr_to_str($_SERVER));
