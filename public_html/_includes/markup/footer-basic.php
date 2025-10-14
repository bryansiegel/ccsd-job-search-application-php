<?php
/***
#	@ file		: footer-basic.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ purpose	: footer collection for ccsd home page, no tracking
# 	@ created	: 2012-02-07 1149
# 	@ modified	: 2012-03-21 1647 carroll
#	@ previous	: 
#	+ 
#	+ 
***/

# footer html/menu etc
include(dirname(__FILE__).'/footer-html.php');

# javscript, core, no tracking
include(dirname(__FILE__).'/scripts.php');
?>

</body>
</html>
<?php 
# close db
mysql_close($_dB_ccsd);

# gtfo
exit;
?>