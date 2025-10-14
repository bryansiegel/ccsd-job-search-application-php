<?php
/***
#	@ file		: header-no-nav.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: carroll
#	@ purpose	: html header for ccsd home pages
# 	@ created	: 2012-05-24 1330
# 	@ modified	: 
#	@ previous	: 
#	+ 
#	+ 
***/
include(dirname(__FILE__).'/header-doctype.php');
include(dirname(__FILE__).'/header-head.php');
?>

<body>
<? if(webdorks($_SESSION['ccsd-cms']['user']['username']) && strstr($_SERVER['HTTP_HOST'], 'ccsd.dev')) { include(dirname(__FILE__).'/webdorks-toolbar.php'); } ?>