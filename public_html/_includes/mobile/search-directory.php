<?php
/***
#	@ file		: search-directory.php
#	@ location	: /www/apache/htdocs/ccsd/_includes/mobile
#	@ author	: carroll
#	@ purpose	: searches directory for location by string
# 	@ created	: 2012-07-31 0935
# 	@ modified	: 
#	@ previous	: 
#	+ 
#	+ 
***/
include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

# get the template api
include('/www/apache/htdocs/cms/templates/template.api.php');

# the query string
$q 			= $_GET['dept'];
$action 	= $_GET['action'];
$nameuri 	= $_GET['nameuri'];

# create an instance of the template api
$directory = new template_api();

if($action == 'search') {
	# search the directory
	$results = $directory->search($q);
	
	# display no results
	if(empty($results['similar']) && empty($results['exact'])) echo "No results found";
	
	# create html
	$html = array();
	
	if (!empty($results['exact'])) {
	    //$html[] = '<h2>Exact Results</h2><ul data-role="listview" data-theme="c">';
	    foreach ($results['exact'] as $exact) {
	        $html[] = '<li data-role="list-divider" class="ui-body ui-body-b"><a class="ui-bar" style="text-decoration:none; weight: bold;color:black;" href="/district/directory/' . $exact['nameuri'] . '">' . $exact['title'] . '</a></li>';
	    }
		//$html[] = '</ul>';
	}
	
	if(!empty($results['similar'])) {
	    //$html[] = '<h2>Similar Results</h2><ul data-role="listview" data-theme="c">';
	    foreach ($results['similar'] as $similar) {
	        //$html[] = '<li><a href="/district/directory/' . $similar['nameuri'] . '" >' . $similar['title'] . '</a></li>';
	        $html[] = '<li><a href="#details" data-transition="slide" onclick="lookup_details(\''.$similar['nameuri'].'\');" >' . $similar['title'] . '</a></li>';
	    }
	   	//$html[] = '</ul>';
	}
	# populate the list
	echo implode('', $html);
	//exit;
}


######testing
if($action == 'get_details') {
	# search for the nameuri
	$org = $directory->directory($nameuri);

	$html = '<h2>'.$org['title'].'</h2>
			<div class="addr-txt">'.$org['location']['address'].'<br />
	    		'.$org['location']['city'].', '.$org['location']['zip'].'<br />
	    		Phone: <a href="tel:'.$org['location']['phone'].'">'.$org['location']['phone'].'</a><br />
	    		Fax: '.$org['location']['fax'];
	    		
	if($org['location']['url'] != NULL && !empty($org['location']['url'])) { 
		$html .= '<br />Web: <a href="'.$org['location']['url'].'" target="_blank">'.$org['location']['url'].'</a>';
	}
	    		
	$html .= '</div>';
	echo $html;
	exit;
}



