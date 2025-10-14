<?php
#####
#	@ str_format.php (2010-12-22 1304 carroll)
#	@ previous (2009-11-14 8:47 AM carroll)
#	+ string formatting
#	+ phone number, ssn
#####

# intializer check
$initialized['functions']['str_format'] = 'OK';

# format a phone number
function phormat($str) {
	
	$sanitized = preg_replace("/[^0-9]/", ' ', $str);
	$str = preg_replace("/[^0-9]/", "", $str);
	
	if(strlen($str) == 7)
		return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $str);
	elseif(strlen($str) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $str);
	else
		return $sanitized;
}
# format a social security number
function format_ssn($str) {

	$str = preg_replace("/[^0-9]/", "", $str);
	
	if(strlen($str) == 9)
		return preg_replace("/([0-9]{3})([0-9]{2})([0-9]{4})/", "$1-$2-$3", $str);
	else
		return $str;
}

# eof