<?php
#####
#	@ array.php (2009-11-05 3:32 AM carroll)
#	@ previous (2009-11-05 2:55 AM carroll)
#	+ array functions
#	+ manipulation, array to string etc
#####

# intializer check
$initialized['functions']['logout'] = 'OK';

# logout of authenticated session
# session, if not set, will destroy the entire session
# msg, message to user why session ended
# href, url to send the user to on logout, if not set, defaults to host
function logout($session=NULL, $msg=NULL, $href=NULL) {
	
	global $_SESSION;
	
	# if the session is defined, delete specific part of the session
	if($session) {
		unset($_SESSION[$session]);
	# else unset the entire session
	} else unset($_SESSION);
	
	//# if a hash cookie exists, unset it
	//if($_COOKIE[$session.'_hash'])
	//	setcookie($session.'_hash', '', time() - 3600);
	
	# if the logout message is set
	if($msg) $_SESSION['end'] = $msg;
	
	// TODO : match server protocol
	$exit_url = $href ? $href : 'http://'.$_SERVER['HTTP_HOST'];
	
	# exit the user
	header('location: '.$exit_url);
}

# eof