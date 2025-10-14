<?php
#####
#	@ form_tools.php (2012-03-29 0948 carroll)
#	@ previous (2010-04-08 0909 carroll)
#	+ form tools
#	+ validate form post data
#####

# intializer check
$initialized['functions']['form_tools'] = 'OK';

# check required fields against form input
function check_required($required, $post) {
	# initilize the blank var
	$blank = NULL;
	# extract the first empty key from $_POST matching a field specified above
	foreach ($required as $field=>$descr) {
		if ($post[$field]==NULL) {
			$blank = $descr;
			break;
		}
	}
	# return validation result
	if (!is_null($blank)) {
		$responses = array("Please fill in your $blank.", "Sorry, we need to know the $blank.", "Provide the $blank, then try again.");
		$response = $responses[array_rand($responses,1)];
		exit($response);
	}
}

# captcha validation
function validate_captcha($post_value) {
	
	if(empty($_SESSION['CAPTCHA']) || !isset($_SESSION['CAPTCHA']))
		exit('Invalid CAPTCHA entry, please try again. (error 1)');
	
	# return error if it does not match
	if($post_value != $_SESSION['CAPTCHA'])
    	exit('Invalid CAPTCHA entry, please try again. (error 2)');
}

# eof
