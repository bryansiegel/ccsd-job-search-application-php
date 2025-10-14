<?php
#####
#	@ permissions.php (2012-11-06 1256 carroll)
#	@ previous (2012-11-01 0929 carroll), (2012-03-22 1252 carroll), (2009-12-22 11:55 AM carroll)
#	+ permission functions
#	+ access control lists, permission checks etc
#####

# intializer check
$initialized['functions']['permissions'] = 'OK';

# determine if the user (logged in or not) is a webdork (ccsd web production staff)
function webdorks($username=NULL) {
	
	# usernames
	$webdorks = array(
		//'ahuskins', 	# allan huskins
		'booboo',		# crystal gittler
		//'csquat',		# chris squatritto
		'dalvarez',		# david alvarez
		//'graywolf',		# troy miller
		//'jsummers',		# jay summers
		//'mvendivel',	# mike vendivel
		//'rk9',		# robert carroll
		//'afelix1',		# Alex Felix
		//'wray',			# dan wray
		//'ckennedy',		#christian kennedy
		//'ynachti',		# yassine nachti
		'ausnlsea',		# @hack Principal - add here so he can have access
		//'imzadi',		# ryse lawrence - qa testers, no longer get this
		//'tll8300'		# tammy leet 	- qa testers, no longer get this
		//'mendojc',      # Judy Mendoza AD username
		'alvard',       # David Alvarez AD username
		'gittlcd',      # Crystal AD
		'siegebm',      # Bryan AD
		);
	
	# by house/vpn ip subnet
	//$house = (strstr($_SERVER['REMOTE_ADDR'], '206.194.49.') || strstr($_SERVER['REMOTE_ADDR'], '206.194.48.')) && !strstr($_SERVER['REMOTE_ADDR'], '206.194.49.71') ? true : false;
	$vpn = strstr($_SERVER['REMOTE_ADDR'], '192.168.83.' ) ? true : false;
	
	$internal = strstr($_SERVER['REMOTE_ADDR'], '10.158.210.50' ) ? true : false;

	
	# qa team, exclusion
	$qa_team = array(
		'206.194.49.60', // tammy
		'206.194.49.61', // reese
		'206.194.49.100', // sinanian
		'10.158.210.50', // Bryan
	);
	# if on the qa team, return false
	//if(in_array($_SERVER['REMOTE_ADDR'], $qa_team))
	//	return false;
	
	# everything else
	if(in_array(strtolower($username), $webdorks) || $vpn || $internal) return true;
	else return false;
}

# eof
