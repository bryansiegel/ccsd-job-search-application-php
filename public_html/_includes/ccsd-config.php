<?php
/***
#	@ file		: ccsd-config.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: carroll
#	@ purpose	: global config and values for ccsd home page
# 	@ created	: 2011-12-20 1009
# 	@ modified	: 2012-11-13 1117 carroll
#	@ previous	: 2012-10-10 1047 carroll
#	+ 
#	+ 
***/
$home							= array();
# page title, abbreviated in templates
$home['title']					= 'Clark County School District';
$home['domain']					= $_SERVER['HTTP_HOST'];
$home['url']					= 'https://'.$_SERVER['HTTP_HOST'];
//****************************************************************************************
//		STATIC FILE NAME VERSION STRINGS
//		file version names for javascript and css files
//****************************************************************************************
$home['source_js']	= 'ccsd.2019.02.26.js';
$home['source_css']	= 'ccsd.2014.05.28.css';
//****************************************************************************************
//		STATIC CDN
//		point static content to the correct location
//****************************************************************************************
//$home['cdn']					= '//static.ccsd.net/ccsd/';
//$home['cdnimg']					= strstr($_SERVER['HTTP_HOST'], 'ccsd.net') ? '//static.ccsd.net/ccsd/images' : '/_static/images'; // //ccsd.dev
//$home['cdnjs']					= strstr($_SERVER['HTTP_HOST'], 'ccsd.net') ? '//static.ccsd.net/ccsd/js' : '/_static/js';
// must evaluate CSS and static capabilities //ccsd.net
//$home['cdncss']					= strstr($_SERVER['HTTP_HOST'], 'ccsd.net') ? '//'.$home['domain'].'/_static/css' : '/_static/css' ;
$home['cdn']					= '//static.ccsd.net/ccsd/';
$home['cdnimg']					=  '/_static/images'; // //ccsd.dev
$home['cdnjs']					=  '/_static/js';
// must evaluate CSS and static capabilities //ccsd.net
$home['cdncss']					=  '/_static/css' ;
//****************************************************************************************
//		CONFIG PATHS
//		variable shortcuts for markup includes
//****************************************************************************************
//$home['path']					= '/www/apache/htdocs/ccsd';
$home['path']					= '/home/ccsd/public_html';
$home['errors']					= $home['path'].'/_errors';
$home['includes']				= $home['path'].'/_includes';
//****************************************************************************************
//		MARKUP INCLUDES
//		variable shortcuts for markup includes
//****************************************************************************************
$home['inc']['header']			= $home['includes'].'/markup/header.php';
$home['inc']['header-nonav']	= $home['includes'].'/markup/header-no-nav.php';
$home['inc']['header-basic']	= $home['includes'].'/markup/header-basic.php';
$home['inc']['header-ajax']		= $home['includes'].'/markup/header-ajax.php';
$home['inc']['breadcrumbs'] 	= $home['includes'].'/markup/breadcrumbs.php';
$home['inc']['explore'] 		= $home['includes'].'/markup/explore-box.php';
$home['inc']['news-box'] 		= $home['includes'].'/markup/news-box.php';
$home['inc']['trending']		= $home['includes'].'/markup/trending-sidebar.php';
$home['inc']['social']			= $home['includes'].'/markup/social-sidebar.php';
$home['inc']['social-custom']	= $home['includes'].'/markup/social-sidebar-custom.php';
$home['inc']['footer']			= $home['includes'].'/markup/footer-tracking.php';
$home['inc']['footer-test']		= $home['includes'].'/markup/footer-test.php';
$home['inc']['footer-basic']	= $home['includes'].'/markup/footer-basic.php';
$home['inc']['footer-jsonly']	= $home['includes'].'/markup/footer-jsonly.php';
$home['inc']['ajax-body']		= $home['includes'].'/markup/ajax-body-wrap.php';
$home['inc']['ajax-footer']		= $home['includes'].'/markup/ajax-body-footer.php';
$home['inc']['login']			= $home['includes'].'/markup/login.php';
//****************************************************************************************
//		PHP INCLUDES
//		variable shortcuts for php includes
//****************************************************************************************
$home['inc']['live-board']		= $home['includes'].'/functions/live-board-meeting.php';
$home['inc']['pagination']		= $home['includes'].'/functions/pagination.php';
$home['inc']['ccsdnews']		= $home['includes'].'/functions/ccsdnews.php';
//****************************************************************************************
//		META DATA
//		values reserved for header meta data
//****************************************************************************************
$home['meta']['description']	= 'Rich, full-featured site offering school, employment, and community education program information.';
//****************************************************************************************
//		HOME PACKAGE
//		objectify $home array
//****************************************************************************************
$home = (object) $home;


//****************************************************************************************
//		PAGE PARAMS
//		
//****************************************************************************************
$page = array('ribbon', 'title', 'description');


//****************************************************************************************
//		CUSTOM SOCIAL
//		refer to social-sidebar-custom.php
//****************************************************************************************
$social = array(
			'partnership' => array('twitter' => '@CCSDPartnership', 'twitter_id' => '322426958728265728', 'facebook' => 'ccsd.net'),
			'recruitment' => array('twitter' => '@Teach_Vegas', 'twitter_id' => '331925726192340993', 'facebook' => 'ccsd.net', 'linkedin' => '9025')
			);

//****************************************************************************************
//		WORDPRESS NEWSROOM DB VARIABLES
//		ccsdnews.php
//****************************************************************************************

//$_dB_nr_CONN = 'newsroom.ccsd.net';
//$_dB_nr_USER = 'httpd';
//$_dB_nr_PASS = 'httpd';

# eof ccsd-config.php