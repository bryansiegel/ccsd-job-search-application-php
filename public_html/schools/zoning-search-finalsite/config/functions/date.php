<?php
#####
#	@ date.php (2010-04-13 1500 carroll)
#	@ previous (2010-04-06 945 carroll)
#	+ date functions
#	+ formatting, conversion, date to simple etc
#####

# intializer check
$initialized['functions']['date'] = 'OK';

# convert a timestamp to a plain english time str. eg. 1 Day 2hrs 35 mins ago
function simple_date($date) {
	# get the number of seconds from the date until now
	$nSeconds = time() - $date;
	$nSeconds = abs($nSeconds);
	# calculate number of days  in the seconds	
	$numDays = floor($nSeconds/86400);
	# subtract the seconds from the total days to get the remaining hours
	$remaining = abs($nSeconds-($numDays*86400));
	# calculate number of hours in the remaining seconds	
	$numHours = floor($remaining/3600);
	# subtract the seconds from days+hours to get the remaining minutes
	$remaining = abs($nSeconds-(($numDays*86400)+($numHours*3600)));
	# calculate number of minutes in the remaining seconds
	$numMinutes = floor($remaining/60);
	
	$str = '';
	# start rewriting the return string to 'text time'
	# if there is 365 or more days
	if($numDays>=365) $str = round($numDays/365).' year'.(($numDays/365)>1?'s':NULL).' ago';
	# if there is 30 or more days
	if($numDays>=30) $str = round($numDays/30).' month'.(($numDays/30)>1?'s':NULL).' ago';
	# if there is 7 or more days
	$about = !is_int($numDays/7)?'about ':'';
	if($numDays>=7 && $numDays<30) $str = $about.round($numDays/7).' week'.(($numDays/7)>1?'s':NULL).' ago';
	# if there are less than 7 days
	if($numDays<7) {
		# if there is 1 or more days
		if($numDays>=1) $str .= $numDays. ' day'.($numDays>1?'s':NULL);
		# if there is 1 or more hours
		if($numHours>=1) $str .= ($numDays>=1?' ':'').$numHours. ' hr'.($numHours>1?'s':NULL);
		# if there is 1 or more minutes
		if($numMinutes>=10) $str .= ($numHours>=1?' ':'').$numMinutes. ' min'.($numMinutes>1?'s':NULL);
		$str .= ' ago';
	}
	# if less than 10 minutes
	if($nSeconds<=600) $str = 'within 10 minutes';
	# set str to real date if no calculation matched, catchall
	if($str==NULL or $str=='') $str = date('M d, Y h:i a', $date);
	# return the string
	return $str;
}

# eof