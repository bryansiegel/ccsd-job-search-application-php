<?php
/***
#	@ file		: ccsd-global.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: carroll
#	@ purpose	: global config and values for ccsd home page
# 	@ created	: 2011-12-20 1009
# 	@ modified	: 2012-02-03 1102 carroll
#	@ previous	: 2012-01-06 1958 carroll
#	+ 
#	+ 
***/

# checks if the request was made by AJAX
function is_request_ajax() {
	return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') ? true : false ;
}
# nice clean exit for .files when ajax fails
function dot_file_exit() {
	
	global $home, $_dB_ccsd;
	if(!is_request_ajax()) {
		include($home->inc['ajax-footer']);
		exit;
	}
}
# nice exit forms when ajax fails
function ajaxexit($str = ''){
	
	if(is_request_ajax())
		exit($str);
	else {
		echo '<p style="font-weight: bold;">'.$str.'</p>';
		echo '<p><a href="'.$_SERVER['HTTP_REFERER'].'">GO BACK</a></p>';
		dot_file_exit();
	}
}