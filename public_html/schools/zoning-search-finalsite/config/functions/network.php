<?php
#####
#	@ network.php (2010-11-16 1236 carroll)
#	@ previous (2010-06-29 1419 carroll), (2010-01-25 12:37 PM carroll), (2009-11-09 9:05 AM carroll)
#	+ network/session functions
#	+ remote ip, ip range, etc
#####

# intializer check
$initialized['functions']['network'] = 'OK';

# get users ip address, even if they are behind a ccsd proxy
function remote_ip() {
	
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		$remote_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	elseif (isset($_SERVER['REMOTE_ADDR'])) 
		$remote_ip = $_SERVER['REMOTE_ADDR'];
	
	return explode(',', $remote_ip)[0];
}
# check remote/user ip against range to check x(.x)(.x) ( do not end in a . )
function ip_range($range_to_check) {

	# get the remote users ip address, proxy or not
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	elseif (isset($_SERVER['REMOTE_ADDR']))
		$user_ip = $_SERVER['REMOTE_ADDR'];
	
	# explode the ip range to check
	$range = explode('.', $range_to_check);
	# explode the remote user ip
	$remote = explode('.', $user_ip);
	# set the initial values for i and retval
	$i = 0;
	$retval = false;
	# incrementally check if each octet in the remote ip is matched by range_to_check
	while($i <= count($range)) {
		# if the range octet is equal to the remote octet
		if($range[$i] == $remote[$i]) {
			# while range octect and remote octect are equal, stay true
			$retval = true;
			# if i is equal to the number of octet to check, break the loop
			if($i == count($range)-1) break;
			# else continue incrementing
			else { ++$i; continue; }
		# immediately retrun false if the octets to not match
		} else return false;
	}
	# return the value
	return $retval;
}

# checks user IP against in district network resources
function is_district_net() {
	
	if(ip_range('10') || ip_range('206.194.48') || ip_range('206.194.49') || ip_range('206.194.4')) return true;
	else return false;
	
	
}

# detect if the client is using the ccsd proxy
function detect_ccsd_proxy() {
	
	/*
	$proxies = array();
	//$proxies[$server['ip']] = $server;
	$tests = array(
		'REMOTE_ADDR'			=> $_SERVER['REMOTE_ADDR'],
		'HTTP_X_FORWARDED_FOR'	=> !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '',
		'HTTP_X_FORWARDED'		=> !empty($_SERVER['HTTP_X_FORWARDED']) ? $_SERVER['HTTP_X_FORWARDED'] : '',
		'HTTP_FORWARDED_FOR'	=> !empty($_SERVER['HTTP_FORWARDED_FOR']) ? $_SERVER['HTTP_FORWARDED_FOR'] : '',
		'HTTP_CLIENT_IP'		=> !empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : '',
		'HTTP_VIA'				=> !empty($_SERVER['HTTP_VIA']) ? $_SERVER['HTTP_VIA'] : ''
	);
	
	# check if the remote address is a ccsd proxy box, return true if so
	if(in_array($_SERVER['REMOTE_ADDR'], array_keys($proxies)))
		return true;
	else return false;
	*/
	
	# fetch active dns list of proxy boxes
	$proxies = dns_get_record('proxy.ccsd.net');
	
	$ret = false;
	# loop through the proxies, if the remote address is a proxy box, return true
	foreach($proxies as $key => $server)
		if($server['ip'] == $_SERVER['REMOTE_ADDR'])
			return true;
	
	# return false if we got to here without a match
	return $ret;
}
