<?php
#####
#	@ array.php (2010-09-01 1344 carroll)
#	@ previous (2010-05-18 1355 carroll)
#	+ array functions
#	+ manipulation, array to string etc
#####

# intializer check
$initialized['functions']['array'] = 'OK';

# simply ensure that we're dealing with an array
function array_ensure($arr) {
	if (!is_array($arr)) $arr = array();
	return $arr;
}
# case insensitive in_array
function in_arrayi($needle, $haystack) {
	$found = false;
	foreach($haystack as $value)
		if(strtolower($value) == strtolower($needle))
			$found = true;

	return $found;
}
# do str_replace on all matched values of an array
function array_val_replace($search = array(), $replace = array(), $subject = array()) {
	foreach($subject as $key=>$value) {
		$value = trim($value);
		if(in_array($value, $search))
			$subject[$key] = str_replace($search, $replace, $value);
	}
	return $subject;
}
# recursive array to string - good for debuging/emailing arrays
function arr_to_str($arr=array()) {
	# create a global variable to count when dealing with multidimensional arrays
	global $_ats_DIMENSIONS;
	# declare recursion as part of the function
	$recursion = __FUNCTION__;
	# initialize an empty string for each instance
	$str = '';
	# increment the counter each time the function runs within a given loop
	++$_ats_DIMENSIONS;
	# if the provided array is empty, return an empty string
	if(empty($arr)) return '';
	# else loop through the array and add the key=>val pair to the output string
	foreach ($arr as $key => $val)
		$str .= str_pad("", $_ats_DIMENSIONS*3, " ", STR_PAD_LEFT)."[$key] ".(is_array($val)?"\n".$recursion($val):$val)."\n";
	# decrement the counter each time we move out toward the main array
	--$_ats_DIMENSIONS;
	# trash the global variable $_ats_DIMENSIONS when the function is complete
	if($_ats_DIMENSIONS==0) unset($GLOBALS['_ats_DIMENSIONS']);
	# return the string
 	return $str;
}


function obj_to_arr($d) {
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	}
	else {
		// Return array
		return $d;
	}
}


# eof