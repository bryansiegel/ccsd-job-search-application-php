<?php
#####
#	@ str_check.php (2009-11-17 11:08 AM carroll)
#	@ previous (2009-11-08 7:15 AM carroll)
#	+ string checker
#	+ validates and checks string formats, email, phone, url etc
#####

# intializer check
$initialized['functions']['string_check'] = 'OK';

# validate email address format
function is_email($str) {
	if (preg_match("/[a-z0-9\._-]+@([a-z0-9][a-z0-9-]*[a-z0-9]\.)+([a-z]+\.)?([a-z]+)$/", $str)) return true;
	return false;
}
# validate if a string is alpha numeric
function is_alphanumeric($str) {
	if (preg_match("/([a-zA-Z0-9]+)/", $str)) return true;
	return false;
}
# validate if a string is a phone number
function is_phone($str) {
	# matches any phone number format ie. (123) 456-7890, 123-456-7890 etc
	if(eregi("\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}", $str)) return true;
	return false;
}

# eof