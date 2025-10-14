<?php
/***
#	@ file		: scripts.php
#	@ location	: /www/apache/htdocs/ccsd/_includes/markup
#	@ author	: vendivel
#	@ purpose	: 
# 	@ created	: 2011-12-20 0920
# 	@ modified	: 2012-05-23 1051 carroll
#	@ previous	: 2012-04-23 1520 carroll
#	+ 
#	+ 
***/
//include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');



# check and load additional js
$addjs = '';

if(!empty($footer_js)) {
	foreach($footer_js as $jsscript)
		$addjs .= '<script src="'.$jsscript.'"></script>'."\n";
        
}
?>

<?php 
// for Transportation only, until another department needs this implemented in their template
if (strstr($_SERVER['REQUEST_URI'], 'departments/transportation')) : ?>
<!--<script type="text/javascript" charset="UTF-8" src="https://server.iad.liveperson.net/hc/2248127/?cmd=mTagRepstate&site=2248127&buttonID=12&divID=lpButDivID-1374510339474&bt=1&c=1"></script>-->
<script type="text/javascript" charset="UTF-8" src="https://server.iad.liveperson.net/hc/2248127/?cmd=mTagRepstate&site=2248127&buttonID=1&divID=lpButDivID-1407510170018&bt=1&c=1"></script>
<?php endif ?>



<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>-->
<?php if (strstr($_SERVER['REQUEST_URI'], 'district/news') || strstr($_SERVER['REQUEST_URI'], 'students/photo-contest')) : ?>
<script src="//static.ccsd.net/vendor/Magnific-Popup/jquery.magnific-popup.min.js"></script>
<?php endif ?>

<!--<script src="/_static/js/swipe.min.js"></script>--> 
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<!-- CCSD SCRIPT -->
<script src="<?=$home->cdnjs;?>/<?=$home->source_js;?>"></script>
<?=$addjs?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>