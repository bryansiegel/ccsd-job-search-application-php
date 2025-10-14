<?php

# fill the ribbon
$gateway = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$gateway = $gateway[0];

# set the page parameters
$page['ribbon'] = array($gateway, $home->url.'/'.$gateway);
$page['title'] = '';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';


# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>
		<!-- content -->
		<div id="content_wrap" class="content-wrap">

			<div id="main_content_wrap" class="main-content-wrap" role="main">
				<section class="content-holder">
