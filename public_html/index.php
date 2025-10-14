<?php
/* * *
  # @ file	    : index.php
  # @ location	: /www/apache/htdocs/ccsd
  # @ author	: Clark County School District.
 test
 * * */
$debug = false;

if ($debug == true) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}


if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
	exit();
}
include('_includes/ccsd-global.php');

//NOTES: PLEASE DO NOT USE EDGE INCLUDES, PLEASE USE REAL REALITVE INCLUDES INSTEAD.
# set the page parameters
$page['ribbon'] = array('home', $home->url . '/');
//var_dump($page);
$page['title'] = 'Clark County School District';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

# include the site header
//include($home->inc['header']); 
include('_includes/markup/header.php');
//var_dump($home->inc['header']);

###### PAGE SPECIFIC ######
# news areas
//include($home->inc['ccsdnews']);
include('_includes/functions/ccsdnews.php');
//var_dump($home->inc['ccsdnews']);

$featured = array();
$newsroomjson = file_get_contents('_includes/newsroomdata.json');
$featured = json_decode($newsroomjson, TRUE);

$trending_sql = array();
$trending = file_get_contents('_includes/trending.json');
$trending_sql = json_decode($trending, TRUE);

$supeintdata = array();
$supedata = file_get_contents('_includes/supeintdata.json');
$supeintdata = json_decode($supedata, TRUE);


//echo"<pre>";var_dump($supeintdata);exit;
//$events = get_ccsd_events(6);
//$news = get_ccsd_news(5);
//$news_sections = array('general', 'students', 'schools', 'parents', 'employees', 'community');
////$news_list = get_ccsd_news_and_events(NULL,$news_section);
//foreach ($news_sections AS $news_section) {
//    $news_arr[$news_section] = get_ccsd_news_and_events(null, $news_section, 0, 5);
//}
//
//$straight_post = get_ccsd_news_straight_record(null,null,0,1);
# pat personally
//$pats = get_pat(null, 0, 3);

# needed for Jobs list
//include('/www/apache/htdocs/ccsd/employees/includes/functions.php');

# board meeting check
//var_dump($home->inc['live-board']);


$live_board_meeting = include($home->inc['live-board']);


//$live_board_meeting = include('_includes/functions/live-board-meeting.php');
#turn off live board meetings on Thursdays
#if(date("N") == "5" && (date("H") == 03)) {
#    $query = "UPDATE ccsd.streaming SET flash='0'";
#    mysql_query($query, $_dB_ccsd);
#}
?>
<script>(function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; window.key = 'WT8Z8BLT@PF6F1LT'; window.url = '//www.k12insight.com/'; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//www.k12insight.com/Lets-Talk/LtTabJs.aspx"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'Lets-Talk'));</script>


<h1 class="hidden">Clark County School District Homepage</h1>
<div id="page_wrap">
	<!-- SLIDER AREA -->
	<div class="slider-trending">
		<div class="trend-box">
			<h2 class="trend-title">Quick Links</h2>
			<ul id="trend_list" class="trending-list" style="display: block;">
				<li class="trend-item"><a href="/parents/infinite-campus.php"
						aria-label="Campus Portal Parent Information">Campus Portal Parent Information </a></li>

				<li class="trend-item"><a href="https://ccsd.net/district/backtoschool/legal-notices.html"
						aria-label="2024-2025 Legal Notices">
						2025-2026 Legal Notices</a>
				</li>

<!--
					<li class="trend-item"><a href="https://newsroom.ccsd.net/resources/"
						aria-label="2024-2025 Legal Notices">
						2025-2026 Legal Notices</a>
				</li>
-->
				<li class="trend-item"><a href="/district/data/" aria-label="District Data">District Data</a></li>
				<li class="trend-item"><a href="https://recruitment.ccsd.net/"
						aria-label="Recruitment Information">Recruitment Information</a></li>
				<li class="trend-item"><a href="/employees/current/services/" aria-label="Employee Services">Employee
						Services</a></li>
				<li class="trend-item"><a href="/district/anti-racism/" aria-label="Policy 5139 Anti-Racism, Equity, and
						Inclusion">Policy 5139 Anti-Racism, Equity, and
						Inclusion</a></li>
			</ul>
		</div>
		<?php
		//Featured News story on ccsd.net
		
		include('_includes/api/featured-news-test.php'); ?>

<!--
<div id="news_box">
	    <a href="https://ccsd.net/district/superintendent-selection/" id="news_item_1" data-item="1" class="current news-item-wrap clearfix" style="top: 0; opacity: 1;text-decoration:none !important;" target="_blank">
		        <div style="position: relative;">
		            <img class="news-img" style="top: 0;" src="https://ccsd.net/_static/images/sup.png" alt="Superintendent Search">
			            <div class="news-copy-wrap" style="top: 250px !important;">
				               <div class="news-copy">
							   <h1>Superintendent Search Community Forum</h1>
				                </div>
			            </div>
						<div class="news-shadow"></div>
		        </div>
	    </a>
</div>
	</div>
-->

		<section>
				<!-- NEWS THUMBNAILS -->
				<div id="news_thumbs">

					<?php
					//left news story on ccsd.net
					include('_includes/api/left-news-test.php');
					?>

					<?php
					//middle news story on ccsd.net
					include('_includes/api/middle-news-test.php');
					?>

					<?php
					//right news story on ccsd.net
					include('_includes/api/right-news-test.php');
					?>

					<div class="clear-both" style="margin-bottom: 40px;"></div>
				</div>

				<!-- <div class="news-horiz-rule"></div> -->




				<div class="clear-both" style="margin-bottom: 40px;">
					<!-- END SLIDER AREA -->



					<!-- BOARD MEETING NOTIFICATION https://ccsd.eduvision.tv/live.aspx -->

					<?php include('includes/homepageVideo.php'); ?>

				</div>
				<!-- END BOARD MEETING NOTIFICATION -->



				<!--
<div align="center" style="margin-top: 40px;">
		<a class="BTSR-notice more-link2" href="https://backtoschool.ccsd.net/" aria-label="Back To School"><img src="https://ccsd.net/_static/images/2024-backtoschool.jpg" alt="Back to School" /></a>
	</div>

	<div align="center" style="margin-top:10px;margin-bottom:-35px;padding-bottom:10px;">
		<h2 class="BTSR-notice BTSR-label"><span><a class="BTSR-notice" href="https://ccsd.net/district/backtoschool/legal-notices.html" aria-label="Back to  School Legal Notices">Back to  School Legal Notices</a></span></h2>

	 </div>
	 <div align="center" style="margin-bottom:20px;height:70px;margin-left: 385px;margin-right: auto;">
		 <a style="margin-right: 20px;" class="more-link" href="https://ccsd.net/district/backtoschool/assets/pdf/24-25-Back-to-School-Legal-Notices-English.pdf" target="_blank" aria-label="English Back To School Legal Notices">English</a>
		 <a  class="more-link" href="https://ccsd.net/district/backtoschool/assets/pdf/24-25-Back-to-School-Legal-Notices-Spanish.pdf" target="_blank" aria-label="Spanish Back To School Legal Notices">Spanish</a>

	 </div>
-->






				<!--
  <div align="center" >
	  <a class="BTSR-notice" href="https://ccsd.net/district/dataincident/"><img src="/_static/images/CyberSecurity" alt="District CyberSecurity" /><br/ >
<div align="center">
		 <h2 class="BTSR-label">Notice of Cybersecurity Incident</h2>
	 </div>
 </a>
 </div>  
-->


				<!--
  <div align="center" >
	  <a class="BTSR-notice" href="https://data.ccsd.net/"><img src="/_static/images/AARSI-District-Data.jpg" alt="District Data" /><br/ >
<div align="center">
		 <h2 class="BTSR-label">CCSD’s District Data</h2>
	 </div>
 </a>
 </div>  
-->




				<!--
  <div align="center" >
	  <a class="BTSR-notice" href="https://data.ccsd.net/"><img src="/_static/images/AARSI-District-Data.jpg" alt="District Data" /><br/ >
<div align="center">
		 <h2 class="BTSR-label">CCSD’s District Data</h2>
	 </div>
 </a>
 </div>  
-->

				<!-- <insert code here manually for board meetings> -->
				
<!--

<section class="live-stream-notification">
	<div>		
		<p><strong>2025 Student Graduation Live Event Schedule</strong> <br>
			<a href="https://ccsdgraduations.eduvision.tv/LiveEvents" target="_blank">View the Live Stream Graduation Events</a> 
		</p>
	</div>
	</section>
-->


				
<!--

<section class="live-stream-notification">
 
	<div>		
		<p><strong>CCSD Live Stream</strong> <br>
			View the stream on <a href="https://ccsd.eduvision.tv/live.aspx" target="_blank">Eduvision</a> 
			or <a href="https://www.youtube.com/channel/UCb8dUIsat7U7lTjXYPFs_Ww" target="_blank" >YouTube</a>
		</p>
		<div class="board-meeting-disclaimer">
			If you're having trouble viewing the live stream, call 702-799-2988
		</div> 
		 <div id="spanish-on" class="dynamic-content">
			 <p><strong>Español:</strong> <a href="https://ccsd.eduvision.tv/LiveChannelPlayer.aspx?qev=6zseFFegtzjNZq8essXM9Q%253d%253d" target="_blank">Eduvision</a></p>
			 <p class="board-meeting-disclaimer">Si tie ne problemas con el link en español, llame al (702) 855-9646 y use la clave 776225 para accesar la junta exclusivamente con audio. Por favor ponga su teléfono en silencio cuando entre la llamada.</p>
		 </div>
			
			
	</div> 
		
</section>
-->




				<div class="news-horiz-rule"></div>


								<!-- MAIN CONTENT AREA -->
<main id="main_content_wrap">
    <!-- HOMEPAGE CARDS/TILES -->
    <div class="content-full-wrap">
        <div id="card1" class="card-wrapper">
            <a id="newsroom" href="https://newsroom.ccsd.net/">
                <div class="card-image" style="border-bottom: 1px solid #ebebeb;">
                    <img src="/_static/images/newdesign/newsroom-new.png" alt="Newsroom - New Logo" />
                </div>
                <h2 class="card-title">Newsroom</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    Get the latest news, information and press releases about CCSD.
                </div>
            </div>
        </div>

<!--
				<div id="card1" class="card-wrapper">
					<a id="we-are" href="https://weare.ccsd.net/" aria-label="We are CCSD">
						<div class="card-image"><img src="/_static/images/WeAre.jpg" alt="We are CCSD" /></div>
						<h2 class="card-title">We are CCSD</h2>
					</a>
					<div class="card-content">
						<div class="card-text">The Clark County School District celebrates the collective effort of the
							Southern Nevada community to educate the children of Clark County.</div>
					</div>
				</div>
-->

        <div id="card2" class="card-wrapper cards-bottom-row">
            <a id="teach-vegas" href="https://recruitment.ccsd.net/" aria-label="Teach With CCSD">
                <div class="card-image">
                    <img src="/_static/images/Recruitment-front.png" alt="Teach with CCSD" />
                </div>
                <h2 class="card-title">Teach with CCSD</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    The Clark County School District is seeking highly motivated employees who are committed to helping students thrive.
                </div>
            </div>
        </div>

        <div id="card3" class="card-wrapper">
            <a id="contact-us" href="https://ccsd.net/contactus/" aria-label="Contact Us">
                <div class="card-image">
                    <img src="/_static/images/LetsTalk.jpg" alt="Contact Us" />
                </div>
                <h2 class="card-title">Contact Us</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    Ask <span style="color:#707070;font-weight: 600;">questions.</span><br>
                    Get <span style="color:#707070;font-weight: 600;">answers.</span><br>
                    Share <span style="color:#707070;font-weight: 600;">feedback.</span>
                </div>
            </div>
        </div>

        <div id="card4" class="card-wrapper">
            <a id="trustees" href="https://ccsd.net/trustees/" aria-label="Trustees">
                <div class="card-image">
                    <img src="/_static/images/newdesign/trustees-new.jpg" alt="Board of School Trustees group photo" />
                </div>
                <h2 class="card-title">Trustees</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    Get to know your Board of School Trustees and learn about upcoming board meetings.
                </div>
            </div>
        </div>

        <div id="card5" class="card-wrapper cards-bottom-row">
            <a id="we-are" href="https://weare.ccsd.net/" aria-label="We are CCSD">
                <div class="card-image">
                    <img src="/_static/images/WeAre.jpg" alt="We are CCSD" />
                </div>
                <h2 class="card-title">We are CCSD</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    The Clark County School District celebrates the collective effort of the Southern Nevada community to educate the children of Clark County.
                </div>
            </div>
        </div>
        
        
			<!--
					<a id="newsroom" href="http://newsroom.ccsd.net/" aria-label="Newsroom">
						<div class="card-image"><img src="/_static/images/newdesign/newsroom.jpg" alt="Newsroom" /></div>
						<h2 class="card-title">Newsroom</h2>
					</a>
					<div class="card-content">
						<div class="card-text">Get the latest news, information and press releases about CCSD.</div>
					</div>
			-->
        
        

        <div id="card6" class="card-wrapper cards-bottom-row">
            <a id="safevoice" href="https://ccsd.net/students/safevoice" aria-label="SafeVoice">
                <div class="card-image">
                    <img src="/_static/images/newdesign/safevoice.jpg" alt="SafeVoice" />
                </div>
                <h2 class="card-title">SafeVoice</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    SafeVoice is the new statewide reporting system for threats to school and reports of bullying.
                </div>
            </div>
        </div>

        <div id="card7" class="card-wrapper">
            <a id="infinite-campus" href="https://ccsd.net/parents/infinite-campus-choice.php" aria-label="Infinite Campus">
                <div class="card-image">
                    <img src="/_static/images/newdesign/infinite-campus.jpg" alt="Infinite Campus" />
                </div>
                <h2 class="card-title">Infinite Campus</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    A fast and easy way for parents and students to check their grades, assignments and class schedules.
                </div>
            </div>
        </div>
        
	       <!--
			<div id="card7" class="card-wrapper cards-bottom-row">
					<a id="capital-improvement" href="https://sites.google.com/nv.ccsd.net/reorg">
						<div class="card-image"><img src="/_static/images/newdesign/1-for-kids-min.jpg" alt="" /></div>
						<h2 class="card-title">School Organizational Teams</h2>
					</a>
						<div class="card-content">
							<div class="card-text">Information related to SOTs and NRS 388G</div>
						</div>
			</div>
		-->
        
        
        <div id="card8" class="card-wrapper">
            <a id="focus-2024" href="https://fmp.ccsd.net/" aria-label="Facility Master Plan">
                <div class="card-image">
                    <img src="/_static/images/newdesign/FacilityMasterPlan.png" alt="Facility Master Plan" />
                </div>
                <h2 class="card-title">Facility Master Plan</h2>
            </a>
            <div class="card-content">
                <div class="card-text">
                    The Facility Master Plan reflects community feedback to ensure our schools meet the evolving needs of students, families, and educators.
                </div>
            </div>
        </div>


		<!--
				<div id="card8" class="card-wrapper">
					<a id="focus-2024" href="https://sites.google.com/nv.ccsd.net/focus2024">
						<div class="card-image"><img src="/_static/images/newdesign/focus-2024.jpg" alt="" /></div>
						<h2 class="card-title">Focus: 2024</h2>
					</a>
					<div class="card-content">
						<div class="card-text">Learn more about CCSD's five-year strategic plan and get updates on our
							progress.</div>
					</div>
				</div>
		-->

        <div style="clear:both;"></div>
    </div>
    <br />
    
    <!--
 <div align="center" >
	  <a class="BTSR-notice" style="margin-top:-35px !important;" href="https://ccsd.net/district/dataincident/">
--><!-- <img src="/_static/images/CyberSecurity" alt="District CyberSecurity" /> --><!-- <br/ > -->
					<!--
<div align="center">
		 <h2 class="BTSR-label">Notice of Cybersecurity Incident</h2>
	 </div>
 </a>
 </div>  
-->
    
    
</main>


					<!-- END HOMEPAGE CARDS/TILES -->


					<!-- TEMPORARY NEW SUP SECTION (OLD SUP BLOG IS IN NEXT SECTION BELOW) -->
					<div id="new_sup_section">
						    <div class="hero">
						        <img src="/_static/images/working-file_svg.svg" alt="Superintendent Ebert">
						    </div>
						    <div class="sup-content" >
						        <h2>Superintendent</h2>
						        <span class="sup-name">Jhone Ebert</span>
						        <p>Jhone Ebert brings over three decades of experience, passion, and proven leadership to her Superintendent of the Clark County School District (CCSD) role. A longtime Southern Nevada resident and CCSD educator, Superintendent Ebert has dedicated her career to ensuring that every student—no matter their background or zip code—has the opportunity to succeed in school and life.</p>
						    	<a id="sup-blog-btn" class="more-link" href="/district/superintendent/">Read more</a>

						        <div style="clear:both;"></div>
						    </div>
						</div>
						<div style="clear:both;"></div>
				

				<!-- END MAIN CONTENT WRAP -->

			</div>
			<!-- <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];window.key='WT8Z8BLT@PF6F1LT';window.url='//www.k12insight.com/';if (d.getElementById(id))return;js = d.createElement(s);js.id = id;js.src = "//www.k12insight.com/Lets-Talk/LtTabJs.aspx";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'Lets-Talk'));</script> -->
			<!-- /page_wrap -->
			<?php //var_dump($home->inc['footer']); ?>
			<?php //include($home->inc['footer']); ?>
			<?php include('_includes/markup/footer-tracking.php'); ?>
			<script src="_static/js/ccsd.2014.01.31.js"></script>
			<script>(function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; window.key = 'WT8Z8BLT@PF6F1LT'; window.url = '//www.k12insight.com/'; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//www.k12insight.com/Lets-Talk/LtTabJs.aspx"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'Lets-Talk'));</script>