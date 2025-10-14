<?php
/***
#	@ file		: login.php
#	@ location	: /www/apache/htdocs/ccsd/_include/markup
#	@ author	: carroll
#	@ purpose	: standard html login form
# 	@ created	: 2012-03-05 1144
# 	@ modified	: 2012-04-20 1501 carroll
#	@ previous	: 2012-03-26 0932 carroll
#	+ 
#	+ 
***/

# check for a full url, otherwise default to local file
$login_url = isset($login_url) ? $login_url : '.login.php';

?>

		<h2>Employee Login</h2>
		
		<div class="login-wrap">
			
			<form id="ialogin" class="simple-form ajax-login" method="post" action="<?=$login_url; ?>">
								    	
			    <label for="iausername">Username</label><br>
			    <input name="iausername" id="iausername" type="text" placeholder="Interact&#8482; Username"><br>  
			
			    <label for="iapassword">Password</label><br>  
			    <input name="iapassword" id="iapassword" type="password" placeholder="Interact&#8482; Password"><br>
				
				<img class="ajax-login-loader" style="display: none;" alt="Authenticating..." src="//static.ccsd.net/ccsd/images/loaders/eee-666-small.gif">
			    <input id="submit" type="submit" value="Login"><a href="https://secure2.ccsd.net/Password/Forgotten">Forget your password?</a>
			    
				<hr />
		    	<p>This system is for the use of authorized users only. Individuals using this computer system without authority, or in excess of their authority, are subject to having all of their activities on this system monitored and recorded by system personnel. <a href="http://ccsd.net/district/acceptable-use-policy" target="_blank">View Acceptable Use Policy</a></p>
		    	<p>Your IP address has been logged : <?=remote_ip(); ?></p>
			    
			</form>
		
		</div>