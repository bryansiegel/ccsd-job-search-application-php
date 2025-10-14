<?php
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
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2X42CPJS5R"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2X42CPJS5R');
</script>


<!--
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T9WSR4C');</script>
-->
<!-- End Google Tag Manager -->

<!-- Hotjar Tracking Code for CCSD -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:5148599,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>


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


    <title><?php echo $head_title; ?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
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



</head>
