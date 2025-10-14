<?php
#####
#	@ ocisupport.php (2010-07-11 1418 carroll)
#	@ previous (2010-02-26 12:41 PM carroll)
#	+ string functions
#	+ oracle support functions
#	+ extend oracle php functions and syntax
#####

# intializer check
$initialized['functions']['ocisupport'] = 'OK';

# gets the nextval from the requested sequence
function oci_nextid($sequence, $db_conn) {
	# gets the next val (next row id)
	# for table structures where the insert id must be variablized to create rows in relation tables
	
	# query the nextval
	$query = "SELECT $sequence.NEXTVAL FROM dual";
	$stmt = ociparse($db_conn, $query);
	ociexecute($stmt);
	ocifetchinto($stmt, $row, OCI_ASSOC);
	$nextid = $row['NEXTVAL'];
	
	# oracle cleanup
	ocifreestatement($stmt);
	// cannot log off here, or we disconnect the scripts db connection
	//ocilogoff($db_conn);
	
	# return the next id
	return $nextid;
}

# escape a string before entering it into oracle. replaces ' with '' for /
function oci_stresc($str) {
	# strip the slashes then replace ' for ''
	$esc_str = str_replace("'", "''", stripslashes($str));
	# return the escaped string
	return $esc_str;
}
# reverse oci_stresc function (for display)
function oci_strclean($str) {
	$ocistr = stripslashes($str);
	$ocistr = str_replace(array("''", "/'"), array("'", "'"), $ocistr);
	return $ocistr;
}
# oracle limit subquery wrapper
function oci_limit($query, $start, $end) {
	# creates a LIMIT for a given query, must define start and end
	# mimics MySQLs LIMIT 0,1 syntax
	return "select * from (select x.*, rownum as position from ($query)x) where position between $start and $end";
}
# sends an email of error stats for failed oracle queries
function oci_sqlerr($err=array(), $mode=2, $query=NULL) {
	# mode 0 = silent, passive (email,  no alerts)
	# mode 1 = alert user
	# mode 2 = alert user, email report
	# mode 3 = debug (immediatly echo full error details)

	global $_SESSION;
	
	$email = 'mvendivel@ccsd.net';
	# the http referrer (page before request)
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
				"SESSION:\n".$session_str."\n\r-----\n\r".
				"SQL:\n".$sql_str."\n\r-----\n\r".
				"QUERY:\n".$query;
	
	switch ($mode) {
		case 0: # silent	
			# send the email, leave headers undefined so server is identified
			@mail($email, 'OCI-ERROR '.date('M d, Y h:i A'), $message);	
		break;
		case 1: # alert user
			die('An error occurred completing your request. You may need to log back in.');
		break;
		case 2: # alert user and email report			
			# send the email, leave headers undefined so server is identified
			$status = mail($email, 'OCI-ERROR '.date('M d, Y h:i A'), $message);
		
			if($status==TRUE)
				$status_msg = "\n\nThe error was reported";
			
			# alert user
			die("An error occurred completing your request. You may need to log back in.$status_msg");
		break;
		case 3:	# debugging, alert user, provide details
			echo $file."\n\n";
			echo $query."\n\n";
			print_r($err);
			exit;
		break;
	}
}
# oracle clob insert/update 
function oci_clob($query, $data, $conn) {
	$clob = ocinewdescriptor($conn,OCI_D_LOB);
	$stmt = ociparse($conn, $query);
	oci_bind_by_name($stmt,":THE_CLOB",$clob, -1, OCI_B_CLOB);
	ociexecute($stmt, OCI_DEFAULT) or oci_sqlerr(ocierror($stmt), 0);
	$clob->save($data);
	ocifreestatement($stmt);
	ocicommit($conn);
}

# eof