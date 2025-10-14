<?php
// Define the username and password
// Define the username-password pairs
$username1 = 'TISS';
$password1 = 'CCSD2025';

$username2 = 'ADMIN';
$password2 = 'Pass123';

$username3 = 'USER';
$password3 = 'Pass456';

// Check if the Authorization header is present
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Protected Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authorization required.';
    exit;
} else {
    $inputUser = $_SERVER['PHP_AUTH_USER'];
    $inputPass = $_SERVER['PHP_AUTH_PW'];

    if ($inputUser === $username1 && $inputPass === $password1) {
        // echo 'Welcome, user 1!';
    } elseif ($inputUser === $username2 && $inputPass === $password2) {
        // echo 'Welcome, user 2!';
    } elseif ($inputUser === $username3 && $inputPass === $password3) {
        // echo 'Welcome, user 3!';
    } else {
        header('WWW-Authenticate: Basic realm="My Protected Area"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid credentials.';
        exit;
    }
}
?>

<?php


include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

# set the page parameters
$page['ribbon'] = array('Employees', $home->url . '/employees/');
$page['title'] = 'Cybersecurity';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>

<!-- ? Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
    /*Overwrite messed up second nav*/
    .quick-nav-wrap {
        padding: 20px 2px 10px 20px !important;
    }
    .page-title {
        font-size: 2em !important;
        color: #004E92 !important;
        margin-bottom: 20px !important;
        text-align: center !important;
    }
    
	.tools h4 {
		font-size: 1.25rem;
	}
	
	.reports  {
		font-size: 17px !important;
/* 		color: #004E92 !important; */
		color: #444 !important;
		font-weight: 600;
	}

	
    .step-circle {
        width: 60px;
        height: 60px;
        background-color: #eeeeee;
        color: #333;
        font-size: 1.2em;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
/*         margin: 0 auto 10px; */
        border: 2px solid lightgrey;
    }
    
    .step-dragons {
	    display: flex;
		margin: -65px 5px 10px 35px; 
    }

	.resources {
		float: left;
	margin: 1em 0;
    margin-top: 1em;
    margin-right: 0px;
    margin-bottom: 1em;
	padding: 0 0 0 30px;
	}
    .tabbed-layout {
        margin: 20px auto;
        width: 90%;
    }

    .tabs {
        display: flex;
        justify-content: space-around;
        margin-bottom: 15px;
        border-bottom: 2px solid #ccc;
    }

    .tab-button {
        background: none;
        border: none;
        padding: 10px 20px;
        font-size: 1em;
        cursor: pointer;
        color: #004E92;
        border-bottom: 2px solid transparent;
        transition: border-color 0.3s, color 0.3s;
    }

    .tab-button.active {
        border-bottom: 2px solid #004E92;
        color: #004E92;
        font-weight: bold;
    }

    .tab-button:hover {
        color: #1771b7;
    }

    .tab-content {
        display: none;
        padding: 15px;
        background-color: #fafafa;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .tab-content.active {
        display: block;
    }

    nav {
        width: 960px;
    }

    /* mega menu list */
    .nav-menu {
        display: block;
        position: relative;
        list-style: none;
        margin: 0;
        padding: 0;
        z-index: 15;
        background-color: #0d3a5d;
        font-family: "proxima-nova", helvetica, sans-serif;

    }

    /* a top level navigation item in the mega menu */
    .nav-item {
        list-style: none;
        display: inline-block;
        padding: 0;
        margin: 0;

    }

    /* first descendant link within a top level navigation item */
    .nav-item > a {
        position: relative;
        display: inline-block;
        /*             padding: .7em .91em; */
        padding: .7em 9px;
        margin: 0;
        height: 77px;
        box-sizing: border-box;
        color: white;

    }


    .nav-item > a.more-options::after {
        background-image: url(/_static/images/icons/down-arrow-white.svg);
        box-sizing: content-box;
        content: "";
        display: inline-block;
        width: 9px;
        height: 9px;
        margin-left: 8px;
        background-repeat: no-repeat;
        background-position: center center;
        vertical-align: middle;
    }

    /* focus/open states of first descendant link within a top level
       navigation item */
    .nav-item a:focus,
    .nav-item a.open {
        border-bottom: 1px solid rgba(23, 113, 183, 0.35);
    }

    .nav-item a:focus {
        color: white;
        outline: 0;
        border-bottom: 6px solid #1771b7;

    }

    .nav-item a:hover {
        text-decoration: none;
        color: white;
    }

    /* open state of first descendant link within a top level
       navigation item */
    .nav-item > a.open {
        background-color: #0d3a5d;

        z-index: 1;
    }

    /* sub-navigation panel */
    .sub-nav {
        width: 905px;
        position: absolute;
        z-index: 20 !important;
        display: none;
        top: 4.5em;
        left: 0;
        padding: 1.375em 1.5625em;
        border: 1px solid #dedede;
        background-color: #fff;
        box-shadow: 2px 2px 10px 0px rgba(0, 0, 0, 0.15);
    }

    /* sub-navigation panel open state */
    .sub-nav.open {
        display: block;
        z-index: 20 !important;
        position: absolute;
    }

    /* list of items within sub-navigation panel */
    .sub-nav ul {
        display: inline-block;
        vertical-align: top;
        margin: 0 2.5em 0 0;
        padding: 0;
        width: 20%;
    }

    /* list item within sub-navigation panel */
    .sub-nav li {
        display: block;
        list-style-type: none;
        margin: 0;
        padding: 0;
        line-height: 20px;

    }

    .sub-nav li a {
        color: #555555;
        font-size: .875em;
        line-height: 30px;
        text-decoration: none;
    }

    .sub-nav li a:hover {
        color: #1771b7;
        border-bottom: 1px solid rgba(23, 113, 183, 0.35);
    }

    .sub-nav li a:focus {
        color: #1771b7;
        border-bottom: 1px solid rgba(23, 113, 183, 0.35);
    }


    #header_alert p {
        font-size: 17px;
        line-height: 22px;
        font-weight: bold;
        margin-top: 10px;
    }

    #header_alert a {
        color: white;
        text-align: center;
    }

    #alert_inner p {
        position: relative;
        top: 3px;
    }
    .alert span {
        font-size: 22px;
        font-weight: bold;
    }

    .alert p {
        margin: 5px 0 0;
    }

    .alert img {
        display: block;
        margin-bottom: 10px;
    }

    .container-jobs {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
        text-align: center;
    }
    
    
    .container-jobs-resources {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
    }

    .card {
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin: 10px;
        padding: 20px;
        width: 30%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }

    .card-footer {
        margin-top: auto;
        border: 0px !important;
        background-color: #f4f4f4 !important;
    }

    .card img {
        margin-left: auto;
		margin-right: auto;
		max-width: 40%;
        border-radius: 5px 5px 0 0;
    }

    .card h3 {
        margin: 15px 0;
    }

    .card p {
        color: #555;
    }

    .faq-section {
        margin: 5px auto;
        /*padding: 20px;*/
        box-sizing: border-box;
    }

    .faq-section h2 {
        text-align: center;
        color: #004E92;
        margin-bottom: 30px;
        font-size: 2em;
    }

    .faq-item {
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 15px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .faq-question {
        width: 100%;
        background: #f3f3f3;
        border: none;
        outline: none;
        padding: 15px 20px;
        font-size: 1.1em;
        font-weight: bold;
        color: #004E92;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: background 0.3s;
        text-align: left;
    }

    .faq-question:hover {
        background-color: #e6e6e6;
    }

    .faq-answer {
        display: none;
        padding: 15px 20px;
        background-color: #fafafa;
        font-size: 0.95em;
        color: #333;
        border-top: 1px solid #ddd;
    }

    .faq-question.active + .faq-answer {
        display: block;
    }

    .faq-question i {
        transition: transform 0.3s ease;
    }

    .faq-question.active i {
        transform: rotate(180deg);
    }



    .timeline {
        position: relative;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: #004E92;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
    }

    .timeline-item {
        padding: 20px 40px;
        position: relative;
        background-color: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 45%;
    }

    .timeline-item.left {
        left: 5%;
    }

    .timeline-item.right {
        left: 50%;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #004E92;
        border: 4px solid #fff;
        top: 20px;
        border-radius: 50%;
        z-index: 1;
    }

    .timeline-item.left::after {
        right: -10px;
    }

    .timeline-item.right::after {
        left: -10px;
    }

    .timeline-item h3 {
        margin: 0;
        font-size: 1.2em;
        color: #004E92;
    }

    .timeline-item p {
        margin: 10px 0 0;
        font-size: 0.95em;
        color: #333;
    }

    .timeline-item i {
        font-size: 1.5em;
        color: #004E92;
        margin-right: 10px;
    }

    .events-section {
        /*margin: 40px auto;*/
        /*padding: 20px;*/
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        padding-top: 5px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .events-section h2 {
        font-size: 2em;
        color: #004E92;
        margin-bottom: 20px;
    }

    .events-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
    }

    .event-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 30%;
        box-sizing: border-box;
        text-align: left;
    }

    .event-card h3 {
        font-size: 20px;
        color: #004E92;
        margin-bottom: 10px;
    }

    .event-card p {
        font-size: 0.95em;
        color: #333;
        margin: 5px 0;
    }

    @media (max-width: 768px) {
        .event-card {
            width: 45%;
        }
        .timeline::after {
            left: 20px;
        }

        .timeline-item {
            width: 100%;
            padding-left: 60px;
            margin-bottom: 20px;
        }

        .timeline-item.left,
        .timeline-item.right {
            left: 0;
        }

        .timeline-item::after {
            left: 20px;
        }
        .card {
            width: 45%;
        }

        .faq-section,
        .contact {
            width: 90%;
            margin: 20px auto;
            padding: 10px 15px;
        }

        .faq-question {
            font-size: 1em;
            padding: 12px 15px;
        }

        .faq-answer {
            padding: 12px 15px;
        }
    }

    @media (max-width: 480px) {
        .card {
            width: 100%;
        }
        .event-card {
            width: 100%;
        }
    }
</style>

<!-- content -->
<div id="content_wrap" class="content-wrap">
    <div id="main_content_wrap" class="main-content-full-wrap" role="main">

<!--        header-->
        <section class="content-holder">
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="images/FirewallFinalApproved.png" alt="Firewall Dragon"
                     style="max-width: 20%; height: auto;">
                <div>
                    <h1>Cybersecurity</h1>
                    <h2 style="text-align:left !important;font-size:24px !important;">Safe, Smart, and Secure—With
                        Firewall by Your Side</h2>
                </div>
            </div>
            <p>Clark County School District is committed to protecting every student’s digital journey through strong
                policies, proactive education, and family partnership.</p>
        </section>

<!--        Sub Navigation-->
            <section style="background-color:#eeeeee;width:100%;">
                <div style="display: flex; padding: 10px;">
                    <a style="flex: 1 1 0%; height: 50px; background-color: rgb(204, 204, 204); color: rgb(0, 0, 0); text-align: center; line-height: 50px; text-decoration: none; font-weight: bold; border-radius: 4px; margin-right: 5px; font-size: 16px;"
                            href="#parents" data-asw-orgfontsize="16">Parents</a>
                    <a style="flex: 1 1 0%; height: 50px; background-color: rgb(204, 204, 204); color: rgb(0, 0, 0); text-align: center; line-height: 50px; text-decoration: none; font-weight: bold; border-radius: 4px; margin-right: 5px; font-size: 16px;"
                       href="#tools" data-asw-orgfontsize="16">Tools</a>
                    <a style="flex: 1 1 0%; height: 50px; background-color: rgb(204, 204, 204); color: rgb(0, 0, 0); text-align: center; line-height: 50px; text-decoration: none; font-weight: bold; border-radius: 4px; margin-right: 5px; font-size: 16px;"
                       href="#concern" data-asw-orgfontsize="16">Concerns</a>
                    <a style="flex: 1 1 0%; height: 50px; background-color: rgb(204, 204, 204); color: rgb(0, 0, 0); text-align: center; line-height: 50px; text-decoration: none; font-weight: bold; border-radius: 4px; font-size: 16px;"
                       href="#info" data-asw-orgfontsize="16">Info</a>
                </div>
            </section>
            <br>

<!--        Events-->
            <section class="events-section">
                <h3 class="page-title">Upcoming Events</h3>
                <iframe id="" class="" style="height: 310px; width: 100%;"
                        src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;ctz=America%2FLos_Angeles&amp;mode=AGENDA&amp;showPrint=0&amp;src=MDE0MjE1YWE2MzM3ZTIzOWM3NjA2YTJmOTQwZWUzYjY1YTQ2M2RhZTcxMjEzMTNmZDRiYmFiN2I1ZDA1N2RlMEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&amp;color=%23C0CA33&amp;quot; style=&amp;quot;border:solid 1px #777&amp;quot; width=&amp;quot;800&amp;quot; height=&amp;quot;600&amp;quot; frameborder=&amp;quot;0&amp;quot; scrolling=&amp;quot;no&amp;quot;"
                        frameborder="0" scrolling="auto"
                        data-src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;ctz=America%2FLos_Angeles&amp;showPrint=0&amp;src=MDE0MjE1YWE2MzM3ZTIzOWM3NjA2YTJmOTQwZWUzYjY1YTQ2M2RhZTcxMjEzMTNmZDRiYmFiN2I1ZDA1N2RlMEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&amp;color=%23C0CA33&amp;quot; style=&amp;quot;border:solid 1px #777&amp;quot; width=&amp;quot;800&amp;quot; height=&amp;quot;600&amp;quot; frameborder=&amp;quot;0&amp;quot; scrolling=&amp;quot;no&amp;quot;">
                </iframe>
            </section>

<!--        FAQ's-->
            <section class="faq-section" style="margin-top:50px;">
                <a id="parents"></a>
                <h2>What Parents Need to Know</h2>
                <p>As a parent, it’s important to know that cybersecurity plays a big role in keeping your child safe
                    while they learn online. From school devices to educational apps, we take steps to protect student
                    information and block harmful content. But staying safe online is a team effort! Talk to your child
                    about creating strong passwords, being careful with what they click, and never sharing personal
                    info. If you ever have questions or concerns, we’re here to help—working together makes a big
                    difference in keeping our students safe and secure.</p>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-circle-info"></i> Acceptable Use Policy (Regulation 797.2)</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>The Acceptable Use Policy (Regulation 797.2) explains the rules for using school district
                            technology and internet safely and responsibly.</p>
                        <a href="https://ccsd.net/district/acceptable-use-policy/" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-file"></i> FERPA / COPPA / CIPA Compliance</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>FERPA, COPPA, and CIPA compliance ensures that student information is kept private, safe, and
                            used appropriately when using school technology and online tools.</p>
                        <a href="https://safe.ccsd.net/" target="_blank" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-shield"></i> Student Data Protection</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Student Data Protection ensures that all personal student information is kept secure and used
                            only for educational purposes.</p>
                        <a href="https://safe.ccsd.net/" target="_blank" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span><i class="fa-solid fa-folder-open"></i> Resources</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
<!--                         <div class="container-jobs-resources"> -->
	                        <ul>
		                        <li><a href="https://ccsd.net/district/acceptable-use-policy/">Acceptable Use Policy (Regulation 797.2)</a></li>
		                        <li><a href="https://studentprivacy.ed.gov/ferpa" target="_blank">FERPA Compliance</a></li>
		                        <li><a href="https://www.ftc.gov/legal-library/browse/rules/childrens-online-privacy-protection-rule-coppa" target="_blank">COPPA Compliance</a></li>
		                        <li><a href="https://www.fcc.gov/consumers/guides/childrens-internet-protection-act" target="_blank">CIPA Compliance</a></li>
		                        <li><a href="https://safe.ccsd.net/" target="_blank">Student Data Protection</a></li>
<!-- 		                        <li>Downloadable infographics</li> -->
                    		</ul>
	                        
	                        
<!--
                            <div class="card">
                                <h3>Acceptable Use Policy (Regulation 797.2)</h3>
                                <p>The Acceptable Use Policy (Regulation 797.2) explains the rules for using school
                                    district technology and internet safely and responsibly.</p>
                                <a href="" class="button-blue-standard">Learn More</a>
                            </div>
-->
<!--
                            <div class="card">
                                <h3>FERPA / COPPA / CIPA Compliance</h3>
                                <p>FERPA, COPPA, and CIPA compliance ensures that student information is kept private,
                                    safe, and used appropriately when using school technology and online tools.</p>
                                <a href="" class="button-blue-standard">Learn More</a>
                            </div>
-->
<!--
                            <div class="card">
                                <h3>Student Data Protection</h3>
                                <p>Para-Professional, Accountant, Custodian, etc. </p>
                                <a href="" class="button-blue-standard">Apply</a>
                                <br>
                            </div>
-->
<!--                         </div> -->
                    </div>
                </div>

            <div class="tabbed-layout">
                <div class="tabs">
                    <button class="tab-button active" data-tab="tab1"><i class="fa-solid fa-handshake-angle"></i> Platform-Specific Guidance</button>
                    <button class="tab-button" data-tab="tab2"><i class="fa-solid fa-shield"></i> Internet Safety Basics</button>
                    <button class="tab-button" data-tab="tab3"><i class="fa-solid fa-wifi"></i> Home Wi-Fi Guidance</button>
                </div>
                <div class="tab-content active" id="tab1">
                    <ul>
                        <li>TikTok: Enable privacy, monitor screen time, avoid oversharing.</li>
                        <li>Discord: Review server access, enable content filters, monitor DMs.</li>
                        <li>Instagram: Set accounts to private, approve followers, manage screen time.</li>
                    </ul>
                </div>
                <div class="tab-content" id="tab2">
                    <ul>
                        <li>Use parental controls from ISPs or phone providers.</li>
                        <li>Avoid clicking suspicious links or downloading unknown apps.</li>
                        <li>Protect personal information.</li>
                    </ul>
                </div>
                <div class="tab-content" id="tab3">
                    <ul>
                        <li>Secure admin access.</li>
                        <li>Use strong firewall settings.</li>
                        <li>Consider apps like Who’s on My WiFi.</li>
                    </ul>
                </div>
            </div>
            </section>

<!--            Tools-->
            <section class="tools">
            <a id="tools"></a>
            <h2 class="page-title">Recommended Tools</h2>
            <div class="container-jobs">
                <div class="card">
                    <img src="images/malwarebytes.png" alt="Malwarebytes">
                    <h4 class="tools">Malwarebytes </h4>
                    <p><strong>Antivirus</strong></p>
<!--                     <h5>Antivirus</h5> -->
<!--
                    <p>Malwarebytes is antivirus software that helps protect devices from viruses, malware, and other
                        online threats.</p>
-->
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="images/womn.png" alt="Who’s on My WiFi – Network monitoring">
                    <h4 class="tools">Who’s on My WiFi</h4>
                    <p><strong>Network monitoring</strong></p>

<!--                     <h5>Network monitoring.</h5> -->
<!--
                    <p>Who’s on My WiFi is a network monitoring tool that helps you see which devices are connected to
                        your Wi-Fi, so you can keep your home network secure.</p>
-->
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="card">
                    <img src="images/gfl.png" alt="Google Family Link – Track activity">
                    <h4 class="tools">Google Family Link</h4>
                    <p><strong>Track activity</strong></p>
<!--                     <h5>Track activity</h5> -->
<!--
                    <p>Google Family Link is a parental control app that lets you track your child’s device activity,
                        manage app usage, and set screen time limits.</p>
-->
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
            </div>
            </section>

<!--            Concerns-->
            <section class="concerns">
            <a id="concern"></a>
            <div style="color:white; background-color:#0D3A5D;padding:10px;text-align:center;">
                <i class="fas fa-exclamation-triangle" style="font-size:32px"></i>
                <h3 style="color:white !important;">Report a Concern</h3>
                <p>For urgent issues, responses will be provided within 24 hours to ensure timely support and resolution. For general concerns or inquiries, please allow 3–5 business days for a response. We are committed to addressing all matters with care and efficiency, prioritizing according to urgency.</p>
                <a href="" class="button-blue-standard" style="background-color:lightgrey;color:black !important;">Report a Concern</a>
            </div>
            <div class="container-jobs">
                <div class="card">
                    <div class="step-circle">1</div>
                    <div class="step-dragons"><img src="images/Firewall-School.png" alt="FireWall-School" style="max-width: 55%;"></div>
					<p><span class="reports">Contact the school</span></p>
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">School Search</a>
                    </div>
                </div>
                <div class="card">
                    <div class="step-circle">2</div>
                    <div class="step-dragons"><img src="images/Firewall-SafeVoice.png" alt="FireWall-SafeVoice" style="max-width: 55%;"></div>
                    <p><span class="reports">Use SafeVoice</span></p>
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">Learn More</a>
                    </div>
                </div>
                <div class="card">
                    <div class="step-circle">3</div>
                    <div class="step-dragons"><img src="images/Firewall-Computer-Shield-new.png" alt="FireWall-IT Support" style="max-width: 55%;"></div>
                    <p><span class="reports">Submit through I.T. support</span></p>
                    <div class="card-footer">
                        <a href="" class="button-blue-standard">Contact I.T.</a>
                    </div>
                </div>
            </div>
            </section>

<!--            Info-->
            <section class="info">
            <a id="info"></a>
            <h2 class="page-title">How CCSD Protects Students</h2>
            <p>Clark County School District (CCSD) prioritizes student safety by implementing robust cybersecurity
                measures. These include using tools like GoGuardian to filter and monitor student devices, ensuring
                endpoint protection on all district computers, and maintaining 24/7 monitoring of district systems to
                detect and address potential threats. CCSD is committed to transparency, with browsing activity
                monitored only on district-provided devices, ensuring a secure and trustworthy digital environment for
                students.</p>
            <div class="timeline">
                <div class="timeline-item left">
                    <h3 style="font-size:21px !important;"><i class="fas fa-shield-alt"></i> Tools Used</h3>
                    <p>GoGuardian for filtering and monitoring student devices.</p>
                </div>
                <div class="timeline-item right">
                    <h3 style="font-size:21px !important;"><i class="fas fa-desktop"></i> Endpoint Protection</h3>
                    <p>Endpoint protection on all District computers.</p>
                </div>
                <div class="timeline-item left">
                    <h3 style="font-size:21px !important;"><i class="fas fa-clock"></i> 24/7 Monitoring</h3>
                    <p>24/7 monitoring of district systems.</p>
                </div>
                <div class="timeline-item right">
                    <h3 style="font-size:21px !important;"><i class="fas fa-eye"></i> Transparency</h3>
                    <p>Browsing activity is monitored only on CCSD devices.</p>
                </div>
            </div>
        </section>
    </div> <!-- /main_content_wrap -->

</div> <!-- /content_wrap -->

<script>
    // FAQ Accordion
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', () => {
                const isActive = button.classList.contains('active');
                document.querySelectorAll('.faq-question').forEach(btn => btn.classList.remove('active'));
                if (!isActive) {
                    button.classList.add('active');
                }
            });
        });

        // Tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabContainer = button.closest('.tabbed-layout');
                const tabId = button.getAttribute('data-tab');

                tabContainer.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                tabContainer.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

                button.classList.add('active');
                tabContainer.querySelector(`#${tabId}`).classList.add('active');
            });
        });
    });
</script>

<?php include($home->inc['footer']); ?>
