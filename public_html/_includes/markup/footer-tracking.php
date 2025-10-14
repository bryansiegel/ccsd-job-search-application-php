<?php

# footer html/menu etc
include(dirname(__FILE__).'/footer-html.php');

# javscript, core and tracking
include(dirname(__FILE__).'/scripts.php');
include(dirname(__FILE__).'/scripts-assets.php');

# don't track department/template intranet pages
if((!isset($template['page']['intranet']) || $template['page']['intranet'] != 1) && $home->domain != 'secure.ccsd.net')
	include(dirname(__FILE__).'/scripts-tracking.php');
?>

<!-- This site is converting visitors into subscribers and customers with OptinMonster - https://optinmonster.com-->
<script type="text/javascript" src="https://a.omappapi.com/app/js/api.min.js" data-account="87830" data-user="78114" async></script>
<!-- / OptinMonster -->

</body>
</html>
<?php
# close db
if(isset($_dB_ccsd)) mysql_close($_dB_ccsd);

# gtfo
exit;
?>