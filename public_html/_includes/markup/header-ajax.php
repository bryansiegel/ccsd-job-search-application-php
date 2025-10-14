<?php


include(dirname(__FILE__).'/header-doctype.php');


$head_title = '';
$head_description = '';

if (isset($page['title'])) {

    if ($page['title'] == $home->title)
        $head_title = $home->title;
    else {
        # append the page title to the home title
        $head_title = trim((!empty($page['title']) ? $page['title'] . ' | ' : '') . $home->title);
    }

    # set the page description
    $head_description = !empty($page['description']) ? $page['description'] : $home->meta['description'];
} 

# check and load additional css
//$addcss = '';
//if (!empty($header_css)) {
//    foreach ($header_css as $cssheet)
//        $addcss .= '<link rel="stylesheet" href="' . $cssheet . '">';
//}
?>
<head>

    <!-- meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


    <!-- google webmaster -->
    <meta name="google-site-verification" content="RmDfJfDf4qxJfma9dKAj56fm7e-wEpvnhg81TPQxAGY" />

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({'gtm.start':
                        new Date().getTime(), event: 'gtm.js'});
            var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PSQQZGN');</script>
    <!-- End Google Tag Manager -->

    <!-- bing webmaster -->
    <meta name="msvalidate.01" content="0B922EB6839EB90EB800E91E774EC5BD" />

    <!-- Mobile viewport optimization http://goo.gl/b9SaQ -->
    <!--<meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, target-densitydpi=device-dpi">-->
    <!--<meta name="viewport" content="width=900, initial-scale=1, maximum-scale=1"> -->


    <!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
    <meta http-equiv="cleartype" content="on">
    <link rel="shortcut icon" href="<?= $home->cdnimg ?>/icons/favicon.ico" />
    <!-- open graph -->
     <!-- HTML Meta Tags -->
  <title>Clark County School District</title>
  <meta name="description" content="Clark County School District, the nation’s fifth-largest school district.">

  <!-- Facebook Meta Tags -->
  <meta property="og:url" content="https://www.ccsd.net/">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Clark County School District">
  <meta property="og:description" content="Clark County School District, the nation’s fifth-largest school district.">
  <meta property="og:image" content="https://ccsd.net/_static/images/ccsd-email-logo.png">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta property="twitter:domain" content="ccsd.net">
  <meta property="twitter:url" content="https://www.ccsd.net/">
  <meta name="twitter:title" content="Clark County School District">
  <meta name="twitter:description" content="Clark County School District, the nation’s fifth-largest school district.">
  <meta name="twitter:image" content="https://ccsd.net/_static/images/ccsd-email-logo.png">

  <!-- Meta Tags Generated via https://www.opengraph.xyz -->
    
<!--
    <meta property="og:title" content="<?= $head_title; ?>" />
    <meta property="og:description" content="<?= $head_description; ?>" />
    <meta property="og:site_name" content="Clark County School District" />
    <meta property="og:type" content="website" />
    <meta property=’og:url’ content='https://ccsd.net/_static/images/ccsd-email-logo.png'/>
    <meta property='og:image:width' content='287' />
	<meta property='og:image:height' content='163' />
-->









    <title><?php echo $head_title; ?></title>
    

    <!-- styles -->
    <link rel="stylesheet" href="<?php echo $home->cdncss; ?>/<?php echo $home->source_css; ?>">
    <?php if(isset($addcss)) echo $addcss; ?>
    <link rel="stylesheet" href="<?php echo $home->cdncss; ?>/ccsd-print.2012.03.14.css" media="print">
    <!-- <link href="//fonts.googleapis.com/css?family=Open+Sans:300,700&v2" rel="stylesheet" type="text/css"> -->

    <?php if (strstr($_SERVER['REQUEST_URI'], 'district/news') || strstr($_SERVER['REQUEST_URI'], 'students/photo-contest')) : ?>
        <link rel="stylesheet" href="//static.ccsd.net/vendor/Magnific-Popup/magnific-popup.css">
    <?php endif ?>

    <!-- scripts -->
    <script src="<?php echo $home->cdnjs; ?>/modernizr.2.0.6.js"></script> 

    <!-- Typekit -->
    <script type="text/javascript" src="//use.typekit.net/wji5wcy.js"></script>
    <script type="text/javascript">try {
            Typekit.load();
        } catch (e) {
        }</script>

    <!-- GOOGLE+ SCRIPT FOR SIDEBAR WIDGET - MUST BE IN HEAD -->
    <link href="https://plus.google.com/117608427266758629271" rel="publisher" />
<link rel="image_src" href="https://ccsd.net/_static/images/ccsd-email-logo.png">


</head>


<style>
.border {
	border-style: solid solid none;
	border-width:1px;
	color: #ccc;
	margin-bottom: 10px;
	line-height: 20px;
}
</style>

<body class="internal">
<?php if(webdorks($_SESSION['ccsd-cms']['user']['username']) && strstr($_SERVER['HTTP_HOST'], 'ccsd.dev')) { include(dirname(__FILE__).'/webdorks-toolbar.php'); } ?>

<?php if(isset($user->username)) { ?>
	<?php //if(count($user->nav)>=2) { ?>
		<div style="z-index: 5; position: fixed; top: 0; background-color: #5588bb; border-top: 1px solid #77aadd; border-bottom: 1px solid #336699; padding: 10px 0; width: 100%; text-align: right;">
			<div style="width: 960px; margin: 0 auto;">
				<select onchange="if(this.value!='') { window.location.href = this.value; }">
					<option value="">Navigation...</option>
					<? foreach($user->nav as $uri => $label) { ?>
					<option value="<?php echo $uri; ?>"><?=$label; ?></option>
					<? } ?>
				</select>
			</div>
			<?php if(!empty($_SESSION)) echo date('M d Y H:i:s', $_SESSION['user']['timeout']); ?>
		</div>
	<?php //} ?>
<?php } ?>
		
		
	<div id="top_wrap">
		<!-- header -->
		<header style="margin-top: 80px;">
			<div class="logo-wrap"><a href="/"><img src="<?=$home->cdnimg; ?>/ccsd-logo-header.gif" alt="CCSD logo" width="339" height="35" /></a></div>
			<?php if(isset($user->username)) { ?>
			<div style="width: 300px; float: right; text-align: right;">
							<div style="color: #999; margin-bottom: 1em; padding-top: 10px;"><span>Welcome, <?php echo $user->givenname; ?></span> | <span style="font-weight: bold;"><a href="?_logout">Logout</a></span></div>
				<!--<?php if(count($user->nav)>=2) { ?>
				<select style="float: right;" onchange="if(this.value!='') { window.location.href = this.value; }">
					<option value="">Navigation...</option>
				<?php foreach($user->nav as $uri => $label) { ?>
					<option value="<?php echo $uri; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
				<?php } ?>-->
			</div>
			<?php } ?>
		</header> <!-- / header -->
	</div><!-- / top_wrap -->
	