<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9WSR4C"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
<!-- End Google Tag Manager (noscript) -->    

    <style>
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
			content:"";
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
            border-bottom: 1px solid rgba(23,113,183,0.35);
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
            box-shadow: 2px 2px 10px 0px rgba(0,0,0,0.15);
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
            border-bottom: 1px solid rgba(23,113,183,0.35);
        }

        .sub-nav li a:focus {
            color: #1771b7;
            border-bottom: 1px solid rgba(23,113,183,0.35);
        }

        .sub-nav-group.trustees {
        	width: 14%;
        	text-align: center;
        	margin-right: 2em;
        }

        .sub-nav-group.trustees-general {
        	float: left;
        	margin-right: 4em;
        }

        .sub-nav-group:last-child {
        	margin-right: 0;
        }

        .top-level-link {
            color: white;
            font-weight: bold;
            font-size: 1.51rem;
            text-decoration: none;
            padding: 0.8em 1.4em;

        }

        .section-headline {
            font-size: 1.0625em;
            color: #1771b7;
            font-weight: bold;
            margin-bottom: 7px !important;
        }

        .trustee-name {
        	font-weight: bold;
        }

        .trustee-img {
        	display:block;
        	margin-bottom:6px;
            border:none !important;
        }

        .long-link {
        	line-height: 18px !important; 
        }

        li.extra-space {
        	padding: 7px 0;
        }
        li.trustee-space {
	        padding-bottom: 30px;
	        margin-bottom: 30px;
        }

        .second-row {
        	margin-top: 30px;
        }

        #header_alert {
            background-color: #1771b7; /* Standard CCSD Blue */
            /*background-color: #DB0A5B;*/ /* Raspberry Color */
            color: #fff;

        }

        #header_alert p{
            font-size: 17px;
            line-height: 22px;
            font-weight: bold;
            margin-top: 10px;
        }

        #header_alert a {
            color:white;
            text-align: center;
        }
        
        #alert_inner {
            width: 960px;
            margin: 0 auto;
            text-align: center;

        }

        #alert_inner p {
            position: relative;
            top: 3px;
        }

        .alert-icon {
            width: 30px;
            float: left;
            margin-right: 5px;
            position: relative;
            left: 262px;
            top: 1px;
        }

        .hidden {
            position: absolute;
            left: -10000px;
            top: auto;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }
		.teachvegas-img {
			width: 600px;
			height: auto;
			padding-bottom:23px;
			margin-top: 8px;
		}
		.teachvegas-link {
			line-height: 25px !important;
		}
   .blue-text-white {
	width: 90px !important;
	background: #1771b7;
    box-shadow: 0px 3px 6px 0 rgba(0,0,0,0.4);
    border-radius: 5px;
    font-size: 16px !important;
    font-weight: bold;
    color: #fff !important;
/*     padding: 12px 20px !important; */
    cursor: pointer;
    text-align: center;
    text-decoration: none !important;
    display: inline-block;
    margin: 10px 0 15px;
}
.blue-text-white2{
width: 90px !important;
	background: #1771b7;
/*     box-shadow: 0px 3px 6px 0 rgba(0,0,0,0.4); */
    border-radius: 5px;
    font-size: 16px !important;
    font-weight: 550;
    color: #fff !important;
/*     padding: 12px 20px !important; */
    cursor: pointer;
    text-align: center;
    text-decoration: none !important;
    display: inline-block;
    margin-left: 5px;
    margin-right: 5px;

}

    </style>

<!--  Alert Message  -->
<!-- <div id="header_alert">
    <div id="alert_inner">
        <div class="alert-icon"><img src="/_static/images/icons/information-icon.svg" alt=""></div>
        <div id="clear"></div>
        <p><a id="alert-banner" href="https://aarsiapps.ccsd.net/survey/">Message text goes here...</a></p>
    </div>
</div> -->

<!-- Header Toolbar -->

<div id="toolbar_banner">
	<div id="toolbar_banner_inner">
			<a class="skip-to-content" href="#main_content_wrap">Skip to main content</a>
			<div id="google_translate_element" aria-label="Translate the page">
			</div>
			<div id="have_question" role="region" aria-label="Question - Contact Us"><span class="question-orange">Have A Question? </span><span class="blue-text-white2"><a href="https://ccsd.net/contactus/" style="color:#ffffff; text-decoration: none;">Contact Us</a></span> or <span class="phone-bold">702-799-CCSD</span></div>
	</div>
</div>
<div id="top_wrap" role="banner">		
		<!-- header -->
		<header>
			<div class="logo-wrap"><a href="/"><img src="/_static/images/ccsd-logo-header.svg" alt="CCSD logo" width="350" height="34" /></a></div>
			<div class="search-wrap">

		<!-- Form's action must be the results page's URL -->
			<form method="get" action="/search.php">
			  <!-- Search field's name must be addsearch -->
              <label for="addsearch" class="hidden">Search</label>
			  <input type="text" name="addsearch" id="addsearch" class="addsearch" />
              <input type="submit" class="search-btn" value="Search" />
</form>			
</div>
		</header> <!-- / header -->
        
    <!-- navigation -->
    <nav role="navigation">
		<div class="quick-nav-wrap">
				<ul class="quick-nav-list">
					<li><a id="about" href="https://newsroom.ccsd.net/">News</a></li>
					<li><a id="schools" href="/schools/">Schools</a></li>
					<li><a id="jobs" href="/employees/prospective/">Jobs</a></li>
					<li><a id="infinite-campus" href="/parents/infinite-campus-choice.php">Infinite Campus</a></li>
					<li><a id="calendar" href="/district/calendar">Calendar</a></li>
					<li><a id="safevoice" href="/students/safevoice/">SafeVoice</a></li>
					<li><a id="transportation" href="https://transportation.ccsd.net/">Transportation</a></li>
					<li><a id="open-book" href="/district/open-book/">Open Book</a></li>
					<li><a id="zoning" href="/schools/zoning/">Zoning</a></li>
					<li><a id="directory" href="/district/directory">Directory</a></li>
				</ul>
			</div>
        <ul class="nav-menu">
            <li class="nav-item" style="margin-left: 10px;">
               <a href="/" class="top-level-link">Home</a> 
            </li>
            <li class="nav-item">
                <a href="?students" class="top-level-link more-options">Students</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group" >
                        <li class="section-headline">Student Information</li>
                        <li><a href="/students/">General Information</a></li>
                        <li><a href="/students/school-reunion-information/">School Reunion Info</a></li>
                        <li><a href="http://transcripts.ccsd.net">Transcript Request</a></li>
                        <li><a href="https://sites.google.com/nv.ccsd.net/ccsdstudentactivities/home">Secondary Student Activities</a></li>
                        <li><a href="https://sites.google.com/nv.ccsd.net/ccsd-athletics/home">Secondary Student Athletics</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
                        <li><a href="/students/safevoice/">SafeVoice</a></li>
                        <li class="extra-space"><a href="https://ccsd.net/district/backtoschool/assets/pdf/PUB-776-CCSD.Code-Conduct-0125-ENG.pdf" class="long-link">Student Code of Conduct (PDF)</a></li>
                        <li class="extra-space"><a href="https://ccsd.net/district/backtoschool/assets/pdf/PUB-776-CCSD.Code-Conduct-0125-SPA.pdf" class="long-link">C&oacute;digo de Conducta Estudiantil (PDF)</a></li>
                        <li><a href="/students/#curriculum">Curriculum Overviews</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">School Information</li>
                        <li><a href="/schools/contact-information/">Search for a school</a></li>
                        <li><a href="/schools/websites/">List of school websites</a></li>
                        <li><a href="/schools/zoning/">Zoning search and maps</a></li>
                        <li class="extra-space"><a href="/students/graduation-schedule.php" class="long-link">Student Graduation Schedule</a></li>
                        <li class="extra-space"><a href="/students/resources/pdf/BellSchedule-2025-2026.pdf" class="long-link">School Bell Schedule (PDF)</a></li>
                        <li class="extra-space"><a href="/district/summer/" class="long-link">Summer School Information</a></li>


                    </ul>
                    <ul class="sub-nav-group" style="width:21% !important;">
                        <li class="section-headline">Student Opportunities</li>
                        <li><a href="https://engage.ccsd.net/volunteer/">PAYBAC Program</a></li>
                        <li><a href="/students/scholarships/" target="_blank">Scholarships</a></li>
                        <li><a href="https://thepef.org/scholarships-plus/">Scholarships Plus</a></li>
                        <li><a href="https://ccsd.net/district/ccsd-reads/" >Summer Reading Challenge</a></li> 
<!--                         <li class="extra-space"><a href="http://www.nevadayouth.org" class="long-link">Youth Employment Services</a></li> -->
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline" style="width:190px;">Additional Information</li>
                        <li class="extra-space"><a href="https://niaa.com/landing/index" target="_blank" class="long-link">Nevada Interscholastic Activities Association (NIAA)</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
<!--                         <li><a href="http://vegaspbs.org/index.aspx?NID=257">Homework Hotline</a></li> -->
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li><a href="/students/bully/">Say No To Bullying</a></li>
                        <li><a href="/community/mentalhealth/" target="_blank">Mental Health Resources</a></li>
                        <li><a href="  https://cceu.ccsd.net/foster-care/" target="_blank">CCSD Foster Care Department</a></li>
                        <li><a href="http://ssd.ccsd.net/shsmedicaid/" target="_blank">CCSD Medicaid School Health Services</a></li>
                        <li style="width:190px;"><a href="https://ede.ccsd.net/achieving-equity-and-access/">Achieving Equity and Access</a></li>
                        <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Plan for the Safe Return to In-Person Instrucon (PDF)</a></li>
                        <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023-Revision_SP.pdf">Plan de regreso seguro a las escuelas (PDF)</a></li>
                        <li><a href="https://ccsd.net/district/anti-racism/pdf/FinalLetterSuperintendentStudentEquityAccessAdvisoryCommission.pdf" target="_blank">Superintendent's Student Equity and Access Advisory Commission Letter (PDF)</a></li>
						<li><a href="https://ccsd.net/district/anti-racism/pdf/2023Scorecard-EquityAccess.pdf" target="_blank">2023 Scorecard - Achieving Equity and Access (PDF)</a></li>


                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="?parents" class="top-level-link more-options">Parents</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <li class="section-headline">School Information</li>
                        <li><a href="/schools/contact-information/">Search for a school</a></li>
                        <li><a href="/schools/websites/">List of school websites</a></li>
                        <li><a href="/schools/zoning/">Zoning search and maps</a></li>
<!--                         <li class="extra-space"><a href="http://ssd.ccsd.net/charter" class="long-link"/>District Sponsored Charter Schools</a></li> -->
                        <li class="extra-space"><a href="/students/resources/pdf/BellSchedule-2025-2026.pdf" class="long-link">School Bell Schedule (PDF)</a></li>
                        <li class="extra-space"><a href="/district/summer/" class="long-link">Summer School Information</a></li>


                    </ul>
                    <ul class="sub-nav-group" style="width: 25%;">
                        <li class="section-headline">Registration</li>
                        <li><a href="/parents/enrollment/">Registering For School</a></li>
<!--                         <li><a href="http://itsyourchoice.ccsd.net/open-enrollment/">Open Enrollment</a></li> -->
                        <li><a href="http://itsyourchoice.ccsd.net">Change of School Assignment (COSA)</a></li>
                        <li><a href="http://magnet.ccsd.net">Magnet Schools</a></li>
                    </ul>
                       <div class="second=row" style="margin-top:-220px;">
                    <ul class="sub-nav-group" style="width: %;">
<!-- 
                        <li class="section-headline">Assembly Bill 195 - English Language Learner Division</li>
                        <li><a href="https://ccsd.net/parents/resources/pdf/English-Learner-Pupil-and-Parental-Rights.pdf">English Learner Pupil and Parental Rights (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/Alumno-Aprendiente-del-idioma-Inglés-y-Derechos-de-los-Padres.pdf">Alumno Aprendiente del idioma Inglés y Derechos de los Padres (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-Tagalog.pdf">Tagalog - Mga Karapatan ng Estudyante na Mag-aaral ng Ingles at ng Magulang (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-Amheric.pdf">Amharic - ﻿ናይ ኢንግሊሽ ትምህርቲ ተማሃራይን ወለድን መሰላት (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-Chinese.pdf">Chinese -  英语学习者学生和家长的权利 (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-Vietnamese.pdf">Vietnamese -  Các Quyền của Phụ Huynh và Học Sinh Học Tiếng Anh (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-SWAHILI.pdf">Swahili - Wasomi wa Lugha ya Kiingereza na Haki za Wazazi (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-ARABIC.pdf">Arabic -  طالب متعلم اللغة الإنجليزية وحقوق الوالدين (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/AB-195-dari.pdf">Dari -  دانش آموز و حقوق والدین زبان آموز انگلیسی (PDF)</a></li>-->

                    </ul>
<!--
                     <ul class="sub-nav-group" style="width: 20%;">
                        <li class="section-headline">General Information</li>
                       <li><a href="/parents/index.php">Parent General Information</a></li>
                    </ul>
-->
					<div style="padding-left: 450px;margin-top:68px">
<!-- 					<ul class="sub-nav-group" style="width: 40%; padding-bottom: 35px;margin-top:-60px;"> -->
	
                     <ul class="sub-nav-group" style="width: 40%; padding-bottom: 35px;margin-top:-60px;">
                         <li class="section-headline">District Information</li>
<!--                         <li class="extra-space"><a href="/district/directory/office-of-the-superintendent" class="long-link">Office of the Superintendent</a></li> -->
                       <li><a href="/parents/">General Information</a></li>
                       <li><a href="https://ccsd.net/district/data/">District Data</a></li>
                       <li><a href="https://ccsd.net/parents/ab195.php">Assembly Bill 195 - English Language Learner Division</a></li>
                        <li class="extra-space"><a href="https://cpd.ccsd.net//" class="long-link">Curriculum and Professional Development Division</a></li>
<!--                         <li class="extra-space"><a href="/departments/cpd/" class="long-link">Curriculum and Professional Development Division</a></li> -->
                        <li class="extra-space"><a href="https://aarsi.ccsd.net/" class="long-link" >Assessment, Accountability, Research &amp; School Improvement</a></li>
                        <li class="extra-space"><a href="https://ccsd.net/district/title-1/" class="long-link" >Title I Services</a></li>
                        <li class="extra-space"><a href="/district/policies-regulations/" class="long-link">CCSD Policies and Regulations</a></li>
                        <li class="extra-space"><a href="https://backtoschool.ccsd.net/" class="long-link" target="_blank">Back to School Guide</a></li>
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li class="extra-space"><a href="/parents/volunteer-chaperone-training/volunteer-chaperone-training" class="long-link">Volunteer Chaperone Training</a></li>
                        <li><a href="http://ssd.ccsd.net/gifted-education-services/">Gifted Education Services</a></li>
                        <li class="extra-space"><a href="http://ssd.ccsd.net/special-education-resources/" class="long-link">Special Education Services</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
<!--                         <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">CCSD Reorganization</a></li> -->
<!-- <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Safe Return to Schools Plan (PDF)</a></li> -->
                        <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Plan for the Safe Return to In-Person Instrucon (PDF)</a></li>
                         <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023-Revision_SP.pdf">Plan de regreso seguro a las escuelas (PDF)</a></li>
                        <li><a href="https://ccsd.net/district/grading-reform-initiative/">CCSD Grading Reform Initiative</a></li>

                    </ul>
                    <ul class="sub-nav-group" style="width: 45%;margin-top:-60px;">
                        <li class="section-headline">Additional Information</li>
                        <li><a href="https://menu.ccsd.net" target="_blank">School Lunch Menus</a></li>
                        <li><a href="/departments/food-service/">Food Services</a></li>
                        <li><a href="/schools/contact-information/">School Directory</a></li>
                        <li><a href="/district/info/student-attire">Standard Student Attire</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/concussion-policy/" class="long-link">Concussion Protocol</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="http://transportation.ccsd.net">Transportation</a></li>
                        <li class="extra-space"><a href="http://faces.ccsd.net/" class="long-link">Family and Community Engagement Services (FACES)</a></li>
<!--                         <li class="extra-space"><a href="http://ccsd.net/departments/risk-and-insurance-services/voluntary-student-medical-insurance" class="long-link">Medical &amp; Dental Insurance for Students</a></li> -->
                        <li class="extra-space"><a href="https://sites.google.com/nv.ccsd.net/ccsd-risk-management/insurance-services/voluntary-student-medical-insurance-information" class="long-link">Medical &amp; Dental Insurance for Students</a></li>
                        <li class="extra-space"><a href="https://ccsd.net/district/backtoschool/assets/pdf/PUB-776-CCSD.Code-Conduct-0125-ENG.pdf" class="long-link">Student Code of Conduct (PDF)</a></li>
                        <li class="extra-space"><a href="https://ccsd.net/district/backtoschool/assets/pdf/PUB-776-CCSD.Code-Conduct-0125-SPA.pdf" class="long-link">C&oacute;digo de Conducta Estudiantil (PDF)</a></li>
                        <li><a href="https://ede.ccsd.net/achieving-equity-and-access/">Achieving Equity and Access</a></li>
						<li><a href="/community/mentalhealth/" target="_blank">Mental Health Resources</a></li>
						<li><a href="http://ssd.ccsd.net/shsmedicaid/" target="_blank">CCSD Medicaid School Health Services</a></li>
						<li><a href="https://ccsd.net/district/anti-racism/pdf/FinalLetterSuperintendentStudentEquityAccessAdvisoryCommission.pdf" target="_blank">Superintendent's Student Equity and Access Advisory Commission Letter (PDF)</a></li>
						<li><a href="https://ccsd.net/district/anti-racism/pdf/2023Scorecard-EquityAccess.pdf" target="_blank">2023 Scorecard - Achieving Equity and Access (PDF)</a></li>

                    </ul>
                   
                     </div>
  </div><!--

                 <div class="second=row">
                     <ul class="sub-nav-group" style="width: 31%;">
                        <li class="section-headline">Assembly Bill 195 - English Language Learner Divisio</li>
                        <li><a href="https://ccsd.net/parents/resources/pdf/English-Learner-Pupil-and-Parental-Rights.pdf">English Learner Pupil and Parental Rights (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/Alumno-Aprendiente-del-idioma-Inglés-y-Derechos-de-los-Padres.pdf">Alumno Aprendiente del idioma Inglés y Derechos de los Padres (PDF)</a></li>
                    </ul>
                 </div>
-->
                   
                   
					                    
                      
  
                  
                </div>
            </li>
            
            <li class="nav-item">
                <a href="?employees" class="top-level-link more-options">Employees</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <li class="section-headline" style="width: 300px;">Recruitment Information</li>
                        <li><a href="/employees/prospective">Current Openings</a></li>
                        <li><a href="https://hcm.ccsd.net">Internal Positions</a></li>
                        <li><a href="/employees/prospective/descriptions">Job Descriptions</a></li>
                        <li><a href="https://recruitment.ccsd.net/">Job Application Process</a></li>
                        <li><a href="https://ccsd.taleo.net/careersection/p/profile.ftl?lang=en">Start/Modify Application</a></li>
                        <li><a href="https://recruitment.ccsd.net/licensed/">Connect with a Recruiter</a></li>
                        <li><a href="/employees/prospective/j-1/index.php">J-1 Program Description</a></li>
                    </ul>
                  
                    <ul class="sub-nav-group">
                        <li class="section-headline">Employee Information</li>
                        <li><a href="/employees/">General Information</a></li>
                        <li class="extra-space"><a href="/district/policies-regulations" class="long-link">CCSD Policies &amp; Regulations</a></li>
                        <li><a href="/employees/current/benefits">Employee Benefits</a></li>
                        <li><a href="/employees/current/employment/information">Employment Information</a></li>
                        <li><a href="/employees/current/employment/health">Employee Health & Wellness Benefits</a></li>
                        <li><a href="/employees/prospective">Job Opportunities</a></li>
                        <li><a href="/employees/current/employment/salary">Salary Information</a></li>
                        <li><a href="/employees/current/employment">More Information</a></li>
                        <li class="extra-space"><a href="/resources/legal/unemployment-faq.pdf" class="long-link">Unemployment Services - FAQ (PDF)</a></li>
                        <!-- <li class="extra-space"><a href="/resources/legal/summer-unemployment-faq.pdf" class="long-link">Summer Unemployment FAQs (PDF)</a></li> -->
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
<!--                         <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">CCSD Reorganization</a></li> -->
<!--                         <li><a href="https://ccsd.net/employees/teacher-appreciation-week/">Teacher Appreciation Week</a></li> -->
<!--                         <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Safe Return to Schools Plan (PDF)</a></li> -->
                        <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Plan for the Safe Return to In-Person Instrucon (PDF)</a></li>
                         <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023-Revision_SP.pdf">Plan de regreso seguro a las escuelas (PDF)</a></li>

                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Employee Services</li>
                        <li><a href="/divisions/human-resources-division/">Human Resources Division</a></li>
                        <li class="extra-space"><a href="https://hcm.ccsd.net" class="long-link">Employee Self Service (HCM)</a></li>
                        <li><a href="/employees/current/services/change-of-address">Change of Address</a></li>
                        <li><a href="/employees/current/services/id-badge">I.D. Badge</a></li>
                        <li class="extra-space"><a href="/employees/current/services/substitute-request" class="long-link">Request a Substitute (SmartFind Express)</a></li>
                        <li><a href="/employees/current/services">More Services</a></li>
                    </ul>
                        
               
                    <ul class="sub-nav-group">
                        <li class="section-headline">Employee Resources</li>
                        <li><a href="/employees/current/resources">All Employees</a></li>
                        <li><a href="/employees/current/resources/#admin">Administrators</a></li>
                        <li><a href="/employees/current/resources/#sub">Substitutes</a></li>
                        <li><a href="/employees/current/resources/#support">Support Professionals</a></li>
                        <li><a href="/employees/current/resources/#teacher">Licensed Personnel</a></li>
                        <li><a href="https://erp-portal.ccsd.net/irj/portal/ccsd" >ERP</a></li>
                        <li><a href="https://hcm.ccsd.net">HCM</a></li>
                        <li><a href="http://learn.ccsd.net">ELMS</a></li>
                        <li><a href="https://clarkcountyschooldistrict.agiloft.com/gui2/samlssologin.jsp?project=Clark+County+School+District">Agiloft Contracts</a></li>
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li><a href="https://campus.ccsd.net/">Infinite Campus</a></li>
                        <li><a href="/employees/blended.php">BlendED Initiative</a></li>
                        <li><a href="/employees/ethicspoint">EthicsPoint</a></li>
                        <!-- in active -->
<!--                         <li><a href="/employees/teacher-appreciation-week/">Teacher Appreciation Week</a></li> -->
                         <li><a href="https://engage.ccsd.net/offers/">Teacher Appreciation Week</a></li>
                         <li class="extra-space"><a href="/district/summer/" class="long-link">Summer School Information</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="?trustees" class="top-level-link more-options">Trustees</a>
                <div class="sub-nav">
                	<ul class="sub-nav-group trustees-general">
                  		<li class="section-headline" >Trustees Information</li>
                  		<li class="extra-space" style="width: 270px;"><a href="/trustees/" class="long-link">Trustee General Information</a></li>
                  		<!-- <li class="extra-space"><a href="/trustees/pdf/board_calendars/board-meetings-2018.pdf" class="long-link">2018 Work Sessions and Regular Board Meeting Schedule (PDF)</a></li> 
                  		<li class="extra-space"><a href="/trustees/meeting-agendas/2021" class="long-link">2021 Board Meeting Agendas</a></li>-->
<!-- 					<li class="extra-space"><a href="/trustees/meeting-agendas/2022" class="long-link">2022 Board Meetings, Agendas and Minutes</a></li> -->
						<li class="extra-space"><a href="/trustees/meeting-agendas/2025" class="long-link">2025 Board Meetings, Agendas and Minutes</a></li>
                  		<li class="extra-space"><a href="https://ccsd.eduvision.tv/live.aspx" class="long-link">Board Meeting Live Stream (Eduvision)</a></li>
                  		<li class="extra-space"><a href="https://ccsd.net/trustees/contact/all" class="long-link">Contact A Board Member</a></li>
                  		<li class="extra-space" style="width: 270px;"><a href="https://ccsd.net/trustees/board-committees.php" class="long-link">Board Affiliated Committees</a></li>
                        <li class="extra-space" ><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
<!--                         <li class="extra-space"><a href="https://ccsd.net/trustees/redistricting/" class="long-link">Redistricting</a></li> -->
                    </ul>

                    
            <ul class="sub-nav-group trustees-general" style="width: 268px;">
                   <li class="section-headline" style="width: 250px;">Trustees </li>
                   <li class="extra-space"><a href="/trustees/details/F" class="long-link">Irene Bustamante Adams, President</a></li> 
                   <li class="extra-space"><a href="/trustees/details/D" class="long-link">Brenda Zamora, Vice President</a></li>
                   <li class="extra-space"><a href="/trustees/details/C" class="long-link">Tameka Henry, Clerk</strong></a></li>
                   <li class="extra-space"><a href="/trustees/details/NV" class="long-link">Isaac Barron, Member</a></li>
                   <li class="extra-space"><a href="/trustees/details/E" class="long-link">Lorena Biassotti, Member</a></li>
                   <li class="extra-space"><a href="/trustees/details/G" class="long-link">Linda P. Cavazos, Member</a></li>
				   
				   
<!-- 				   <li class="extra-space"><a href="/trustees/details/C" class="long-link">Evelyn Garcia Morales, President</strong></a></li> -->
				                    				   
<!-- 				   <li class="extra-space"><a href="/trustees/details/A" class="long-link">Lisa Guzm&aacute;n, Clerk</strong></a></li> -->
<!-- 				   <li class="extra-space"><a href="/trustees/details/E" class="long-link">TBD, Member</a></li> -->
                                     
               </ul>
			<ul class="sub-nav-group trustees-general" style="width: 250px;">
                   <li class="section-headline" style="width: 250px;">&nbsp;</li>
                   
                   <li class="extra-space"><a href="/trustees/details/B" class="long-link">Lydia Dominguez, Member</a></li>
				   <li class="extra-space"><a href="/trustees/details/H" class="long-link">Ramona Esparza-Stoffregan, Member</a></li>
                   <li class="extra-space"><a href="/trustees/details/LV" class="long-link">Adam Johnson, Member</a></li>
                   <li class="extra-space"><a href="/trustees/details/CC" class="long-link">Lisa Satory, Member</a></li>
				   <li class="extra-space"><a href="/trustees/details/A" class="long-link">Emily Stevens, Member</strong></a></li>

                  
               </ul>
						


                        <!-- DISTRICT C -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District C</li>
                        <li>
                            <a href="/trustees/details/C" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-c.jpg" alt="Trustee-District C"></span>
                                <span class="trustee-title">President</span><br>
                                <span class="trustee-name">Evelyn<br>Garcia Morales</span>
                            </a>
                        </li>
                    </ul>
-->
                    <!-- DISTRICT F -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District F</li>
                        <li>
                            <a href="/trustees/details/F" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/adams.jpg" alt="Trustee-District F"></span>
                                <span class="trustee-title">Vice President</span><br>
                                <span class="trustee-name">Irene<br>Bustamante Adams</span>

                            </a>
                        </li>
                    </ul>	
-->
                    
                     <!-- DISTRICT A -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District A</li>
                        <li>
                            <a href="/trustees/details/A" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-a.jpg" alt="Trustee-District A"></span>
                                <span class="trustee-title">Clerk</span><br>
                                <span class="trustee-name">Lisa<br>Guzm&aacute;n</span>
                            </a>
                        </li>
                    </ul>
-->
	

					<!-- DISTRICT E -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District E</li>
                        <li>
                            <a href="/trustees/details/E" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-e.jpg" alt="Trustee-District E"></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Lola<br>Brooks</span>
                            </a>
                        </li>
                    </ul>
-->
<!--                    <div class="second-row"> -->

					<!-- DISTRICT G -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District G</li>
                        <li>
                            <a href="/trustees/details/G" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-g.jpg" alt="Trustee-District G"></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Linda P.<br>Cavazos</span>
                            </a>
                        </li>
                    </ul>
-->
     
                              
                    <!-- DISTRICT B -->
<!--
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District B</li>
                        <li>
                            <a href="/trustees/details/B" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-b.jpg" alt="Trustee-District B"></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Katie<br>Williams</span>
                            </a>
                        </li>
                    </ul>    
-->    

  
					<!-- DISTRICT D -->
<!--
                          <ul class="sub-nav-group trustees">
                        <li class="section-headline">District D</li>
                        <li>
                            <a href="/trustees/details/D" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-d-23.jpg" alt="Trustee-District D"></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Brenda<br>Zamora</span>
                            </a>
                        </li>
                    </ul>
-->
<!--                      </div> -->
                </div>
            </li>
            <li class="nav-item">
                <a href="?community" class="top-level-link more-options">Community</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group trustee" style="width:22% !important;">
                        <li class="section-headline">Community Information</li>
                        <li><a href="https://newsroom.ccsd.net/" target="_blank">Newsroom</a></li>
<!--                         <li><a href="https://newsroom.ccsd.net/press-releases/" target="_blank">Press Releases</a></li> -->
                         <li><a href="/community/">General Information</a></li>
                        <li><a href="https://engage.ccsd.net/">Community Engagement</a></li>
                        <li><a href="https://ccsd.net/departments/communications-unit" target="_blank">Communications Unit</a></li>
                        <li><a href="https://ccsd.net/departments/government-affairs" target="_blank">Government Relations</a></li>
                        <li><a href="/departments/school-accounting">Facility Usage</a></li>
                        <li class="extra-space"><a href="/departments/government-affairs/student-enrollment-and-school-capacity" class="long-link">Student Enrollment and School Capacity</a></li>
                        <li class="extra-space"><a href="/parents/volunteer-chaperone-training/volunteer-chaperone-training" class="long-link">Volunteer Chaperone Training</a></li>
                        <li><a href="/community/protect-our-kids">Protect Our Kids</a></li>
                        <li class="extra-space"><a href="https://engage.ccsd.net/family/" class="long-link">Family and Community Engagement Services (FACES)</a></li>
<!--                    <li class="extra-space"><a href="http://faces.ccsd.net/" class="long-link">Family and Community Engagement Services (FACES)</a></li> -->
                        <li><a href="http://facilities.ccsd.net/">Facilities Services Unit</a></li>
<!--                         <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">CCSD Reorganization</a></li> -->
<!-- <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Safe Return to Schools Plan (PDF)</a></li> -->
                        <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023.pdf">Plan for the Safe Return to In-Person Instrucon (PDF)</a></li>
                         <li><a href="https://ccsd.net/students/resources/pdf/PlanSafeReturnIn-PersonInstruction-Continuity-Services-July-2023-Revision_SP.pdf">Plan de regreso seguro a las escuelas (PDF)</a></li>

                    </ul>
                    <ul class="sub-nav-group" style="width:19% !important;">
                        <li class="section-headline">Community Projects</li>
                        <li><a href="https://engage.ccsd.net/community/">Partnership</a></li>
                        <li><a href="/community/get-involved">Get Involved</a></li>
<!--                         <li><a href="/schools/support-a-school/">Support a School</a></li> -->
                    </ul>
                    <ul class="sub-nav-group" >
                        <li class="section-headline">Partnership Programs</li>
                        <li><a href="https://engage.ccsd.net/community/">Partnership</a></li>
<!--                         <li><a href="/community/partnership/about-us/advisory-council">Advisory Council</a></li> -->
						<li><a href="https://engage.ccsd.net/curriculum/">Curriculum Projects</a></li>
<!--                         <li><a href="/community/partnership/programs/curriculum-index.php">Curriculum Projects</a></li> -->
						<li><a href="https://engage.ccsd.net/volunteer/">Focus School Project</a></li>
<!--                         <li><a href="/community/partnership/programs/focus/focus-index">Focus School Project</a></li> -->
                        <li><a href="https://engage.ccsd.net/volunteer/">PAYBAC</a></li>
                         <li><a href="https://engage.ccsd.net/saferoutestoschool"/>Safe Routes to School</a></li>
<!--
						<li><a href="https://sites.google.com/nv.ccsd.net/saferoutestoschool/home">Safe Routes to School</a></li> 
						<li><a href="http://saferoutestoschool.ccsd.net">Safe Routes to School</a></li> 
-->
                        <li><a href="https://engage.ccsd.net/mentorship/">Stay in School Mentoring</a></li>
<!--                         <li><a href="/schools/support-a-school">Support a School</a></li> -->
                    </ul>
                       <ul class="sub-nav-group" style="width:21% !important;">
                        <li class="section-headline">Additional Information</li>
                        <li><a href="/schools/websites/" target="_blank">School Websites</a></li>
<!--                         Broken link -->
<!--                         <li><a href="http://www.ccsdvictoryschools.net/" target="_blank">Victory Schools</a></li> -->
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="/parents/infinite-campus-choice.php">Infinite Campus</a></li>
                        <li><a href="http://ccsdarchives.org/" target="_blank">CCSD Archive Committee</a></li>
                        <li><a href="http://pollen.aaaai.org/nab/index.cfm?p=allergenreport&stationid=223" target="_blank">Pollen and Mold Alert</a></li>
                        <li><a href="/community/gold-card/" target="_blank">Gold Card for Seniors</a></li>
                        <li><a href="/community/mentalhealth/" target="_blank">Mental Health Resources</a></li>
                        <li><a href="  https://cceu.ccsd.net/foster-care/" target="_blank">CCSD Foster Care Department</a></li>
						<li><a href="http://ssd.ccsd.net/shsmedicaid/" target="_blank">CCSD Medicaid School Health Services</a></li>
                        <li><a href="/students/bully/">Say No To Bullying</a></li>
                        <li><a href="/community/public-records-request">Public Records Request</a></li>
                        <li><a href="/community/public-concern">Public Concern</a></li>
                        <li><a href="https://ede.ccsd.net/achieving-equity-and-access/">Achieving Equity and Access</a></li>
                        <li><a href="https://ccsd.net/district/anti-racism/pdf/FinalLetterSuperintendentStudentEquityAccessAdvisoryCommission.pdf" target="_blank">Superintendent's Student Equity and Access Advisory Commission Letter (PDF)</a></li>
						<li><a href="https://ccsd.net/district/anti-racism/pdf/2023Scorecard-EquityAccess.pdf" target="_blank">2023 Scorecard - Achieving Equity and Access (PDF)</a></li>
						<li class="extra-space"><a href="/district/summer/" class="long-link">Summer School Information</a></li>
                    </ul>
                </div>
            </li>
             
            	<!-- Get Hired -->
             <li class="nav-item">
               <a href="https://recruitment.ccsd.net/" class="top-level-link">Get Hired</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <li class="section-headline" style="width: 300px;">Recruitment Information</li>
                        <li><a href="/employees/prospective">Current Openings</a></li>
                        <li><a href="https://hcm.ccsd.net">Internal Positions</a></li>
                        <li><a href="/employees/prospective/descriptions">Job Descriptions</a></li>
                        <li><a href="https://recruitment.ccsd.net/">Job Application Process</a></li>
                        <li><a href="https://ccsd.taleo.net/careersection/p/profile.ftl?lang=en">Start/Modify Application</a></li>
                        <li><a href="https://recruitment.ccsd.net/licensed/">Connect with a Recruiter</a></li>
                        <li><a href="/employees/prospective/j-1/index.php">J-1 Program Description</a></li>
                    </ul>

                    
                   

				
                          <ul class="sub-nav-group">
                        
                        <li style="width: 500px;margin-left: 50px;">
                            <a href="http://teachvegas.ccsd.net/" class="teachvegas-link">
	                              <img class="teachvegas-img" src="/_static/images/CCSD-Sahara-Ext.jpg" alt="Sahara Exterior" >
<!--                                 <img class="teachvegas-img"src="https://ccsd.net/employees/prospective/images/WhenYouGrow-TeachVegas.jpg" alt="Teach Vegas"> -->
                                 <span class="trustee-title">Are you interested in a Teaching or other Licensed Professional position?</span><br>
                                <span class="trustee-name">Connect with our Recruitment Team today to get the process started.</span><br>
<!--                                  <span class="trustee-title">Come Grow with us! </span><br> -->
                            </a>
                        </li>
                    </ul>

            
        </ul>
    </nav>
        
      
	</div>
    <script src="/megamenu/js/jquery-accessibleMegaMenu.js"></script>

    <!-- initialize a selector as an accessibleMegaMenu -->
    <script>
        $("nav:first").accessibleMegaMenu({
            /* prefix for generated unique id attributes, which are required
               to indicate aria-owns, aria-controls and aria-labelledby */
            uuidPrefix: "accessible-megamenu",

            /* css class used to define the megamenu styling */
            menuClass: "nav-menu",

            /* css class for a top-level navigation item in the megamenu */
            topNavItemClass: "nav-item",

            /* css class for a megamenu panel */
            panelClass: "sub-nav",

            /* css class for a group of items within a megamenu panel */
            panelGroupClass: "sub-nav-group",

            /* css class for the hover state */
            hoverClass: "hover",

            /* css class for the focus state */
            focusClass: "focus",

            /* css class for the open state */
            openClass: "open"
        });
    </script>
<script>
      (function(d){
         var s = d.createElement("script");
         /* uncomment the following line to override default position*/
         /* s.setAttribute("data-position", 1);*/
         /* uncomment the following line to override default size (values: small, large)*/
         /* s.setAttribute("data-size", "large");*/
         /* uncomment the following line to override default language (e.g., fr, de, es, he, nl, etc.)*/
         /* s.setAttribute("data-language", "null");*/
         /* uncomment the following line to override color set via widget (e.g., #053f67)*/
         /* s.setAttribute("data-color", "#0048FF");*/
         /* uncomment the following line to override type set via widget (1=person, 2=chair, 3=eye, 4=text)*/
         /* s.setAttribute("data-type", "1");*/
         /* s.setAttribute("data-statement_text:", "Our Accessibility Statement");*/
         /* s.setAttribute("data-statement_url", "http://www.example.com/accessibility";*/
         /* uncomment the following line to override support on mobile devices*/
         /* s.setAttribute("data-mobile", true);*/
         /* uncomment the following line to set custom trigger action for accessibility menu*/
         /* s.setAttribute("data-trigger", "triggerId")*/
         s.setAttribute("data-account", "8oeraXEIqB");
         s.setAttribute("src", "https://cdn.userway.org/widget.js");
         (d.body || d.head).appendChild(s);})(document)
 </script>