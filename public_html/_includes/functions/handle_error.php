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

# nice error handler
function handle_error($error = '', $footer = false) {
	
	global $home;
	
	$error	= (string) $error;
	
	$errors	= array(
			'maintenance',
			'runtime-level1',	# used when error executes above header
			'runtime-level2',	# used when header/styling information is already loaded
			'404'
		);
	
	if($error=='') {
		
		# aww shucks!
		include($home->errors.'/general.html');
		
		# lets go out with style
		include($home->inc['footer']);
		
		exit;	
		
	} elseif(!in_array($error, $errors)) {
	
		
		if($footer == true) {
			
			echo(
			'<div id="content_wrap" class="content-wrap"><div id="main_content_wrap" class="main-content-full-wrap" role="main"><section class="content-holder">'.
			'<p>'.$error.'</p></section></div></div>') ;
			
			include($home->inc['footer']);
			
		} else {
			echo $error;
		}
		
		
	} else {
		switch($error) {
			
			# global maintenance
			case 'maintenance':
				
				include($home->errors.'/maintenance.html');
			
			break;
			
			# global maintenance
			case 'runtime-level1':
				
				include($home->errors.'/runtime-level1.php');
			
			break;
			
			# global maintenance
			case 'runtime-level2':
				
				include($home->errors.'/runtime-level1.php');
			
			break;
			
			# not found!
			case '404':
				
				include($home->errors.'/404.php');
			
			break;
		}
	}
	exit;
}