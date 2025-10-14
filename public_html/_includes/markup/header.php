<?php
include(dirname(__FILE__).'/header-doctype.php');
include(dirname(__FILE__).'/header-head.php');
?>

<body>
<?php if(webdorks($_SESSION['ccsd-cms']['user']['username']) && strstr($_SERVER['HTTP_HOST'], 'ccsd.dev')) { include(dirname(__FILE__).'/webdorks-toolbar.php'); } ?>
<?php include(dirname(__FILE__).'/header-nav.php'); ?>


