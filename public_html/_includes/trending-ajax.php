<?php
/***
#	@ file		: trending-ajax.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: vendivel
#	@ purpose	: requests data from chart beat for trending sidebar
# 	@ created	: 2012-01-26 1930
# 	@ modified	: 2012-02-02 1333 carroll
#	@ previous	: 
#	+ 
#	+ 
***/

$from = $_SERVER['HTTP_REFERER'];
# the url that executed the error
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
# uri query string
$qstr = $_SERVER['QUERY_STRING'];
# define the script that executed the error
$file = $_SERVER['SCRIPT_FILENAME'];

# parse the session array into text string
$session_str = arr_to_str($_SESSION);
# parse the error array into text string
$sql_str = arr_to_str($err);
# parse message body
$message = 	"TIMESTAMP: ".date('M d, Y H:i:s')."\n\r-----\n\r".
			"USER: ".$_SERVER['REMOTE_ADDR']."\n\r-----\n\r".
			"CLIENT: ".$_SERVER['HTTP_USER_AGENT']."\n\r-----\n\r".
			"REFERRER: ".$from."\n\r-----\n\r".
			"URL: ".$url."\n\r-----\n\r".
			"QUERY STRING: ".$qstr."\n\r-----\n\r".
			"FILE: ".$file."\n\r-----\n\r".
			"SESSION:\n".$session_str."\n\r-----\n\r";

//deprecated (rc)
//mail('rcarroll@interact.ccsd.net', 'trending', $message);



/*
function trending() {
	# request string
	$chartbeat_request = 'http://api.chartbeat.com/live/toppages/?'
		.'host=ccsd.net'
		.'&limit=8'
		.'&apikey=17a79aa65ad5f7c663af4e4c1211ed1f';
	
	$json_resp = @file_get_contents($chartbeat_request, 0, null, null);
	$json_data = json_decode($json_resp);
	
	$html = array();
	foreach ( $json_data as $trend ) {
		// filter out index page
	    if($trend->path != '/') { 

	    	$page_title = str_replace(array('|','-'), '|', $trend->i);
	    	$page_title = reset(explode('|', $page_title));
	    	
	    	$html[] = '<li class="trending-item"><a href="'.$trend->path.'">'.$page_title.'</a></li>';
	    }
	}
	return implode('', $html);
}
echo trending();
*/
# eof trending-ajax.php