<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9WSR4C"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
            padding: .7em .91em;
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
			<div id="have_question"><span class="question-orange">Have A Question? </span><span class="contact-normal">Contact Us At </span><span class="phone-bold">702-799-CCSD</span></div>
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
					<li><a id="about" href="http://newsroom.ccsd.net/about/">About</a></li>
					<li><a id="schools" href="/schools/">Schools</a></li>
					<li><a id="jobs" href="/employees/prospective/">Jobs</a></li>
					<li><a id="infinite-campus" href="/parents/infinite-campus-choice.php">Infinite Campus</a></li>
					<li><a id="calendar" href="/district/calendar">Calendar</a></li>
					<li><a id="safevoice" href="/students/safevoice/">SafeVoice</a></li>
					<li><a id="transportation" href="https://transportation.ccsd.net/">Transportation</a></li>
					<li><a id="open-book" href="/district/open-book/">Open Book</a></li>
					<li><a id="zoning" href="/schools/zoning/">Zoning</a></li>
					<li><a id="directory" href="/district/directory">Directory</a></li>
					<!-- <li><a href="/district/faq">FAQ</a></li> -->
				</ul>
			</div>
        <ul class="nav-menu">
            <li class="nav-item">
               <a href="/" class="top-level-link">Home</a> 
            </li>
            <li class="nav-item">
                <a href="?students" class="top-level-link more-options">Students</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <li class="section-headline">Student Information</li>
                        <li><a href="/students/school-reunion-information/">School Reunion Info</a></li>
                        <li><a href="http://transcripts.ccsd.net">Transcript Request</a></li>
                        <li><a href="/departments/instructional-support-student-activities/athletics">Student Activities</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
                        <li><a href="/students/safevoice/">SafeVoice</a></li>
                        <li class="extra-space"><a href="/students/resources/pdf/K-12-student-code-of-conduct.pdf" class="long-link">K-12 Student Code of Conduct (PDF)</a></li>
                        <li class="extra-space"><a href="/students/resources/pdf/K-12-student-code-of-conduct-spanish.pdf" class="long-link">C&oacute;digo de Conducta Estudiantil K-12 (PDF)</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">School Information</li>
                        <li><a href="/schools/contact-information/">Search for a school</a></li>
                        <li><a href="/schools/websites/">List of school websites</a></li>
                        <li><a href="/schools/zoning/">Zoning search and maps</a></li>
                        <li class="extra-space"><a href="/students/graduation-schedule.php" class="long-link">Student Graduation Schedule</a></li>

                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Student Opportunities</li>
                        <li><a href="/community/partnership/programs/paybac/paybac-index/">PAYBAC Program</a></li>
                        <li><a href="http://www.thepef.org/programs_scholarships.html" target="_blank">Scholarships</a></li>
                        <li><a href="http://www.thepef.org/programs_main.html">Programs and Initiatives</a></li>
                        <li><a href="http://www.thepef.org/programs_grants.html" >Grant Programs</a></li>
                        <li class="extra-space"><a href="http://www.nevadayouth.org" class="long-link">Youth Employment Services</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Additional Information</li>
                        <li class="extra-space"><a href="https://niaa.com/landing/index" target="_blank" class="long-link">Nevada Interscholastic Activities Association (NIAA)</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="http://vegaspbs.org/index.aspx?NID=257">Homework Hotline</a></li>
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li><a href="/students/bully/">Say No To Bullying</a></li>
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
                        <li class="extra-space"><a href="http://ssd.ccsd.net/charter" class="long-link"/>District Sponsored Charter Schools</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Enrollment</li>
                        <li><a href="/parents/enrollment/">Registering For School</a></li>
                        <li><a href="http://itsyourchoice.ccsd.net/open-enrollment/">Open Enrollment</a></li>
                        <li><a href="http://itsyourchoice.ccsd.net">Select Schools</a></li>
                        <li><a href="http://magnet.ccsd.net">Magnet Schools</a></li>
                    </ul>
                    
                    <ul class="sub-nav-group">
                        <li class="section-headline">District Information</li>
                        <li class="extra-space"><a href="/district/directory/office-of-the-superintendent" class="long-link">Office of the Superintendent</a></li>
                        <li class="extra-space"><a href="/departments/cpd/" class="long-link">Curriculum and Professional Development Division</a></li>
                        <li class="extra-space"><a href="https://aarsi.ccsd.net/" class="long-link" >Assessment, Accountability, Research &amp; School Improvement</a></li>
                        <li class="extra-space"><a href="/district/policies-regulations/" class="long-link">CCSD Policies and Regulations</a></li>
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li class="extra-space"><a href="/parents/volunteer-chaperone-training/volunteer-chaperone-training" class="long-link">Volunteer Chaperone Training</a></li>
                        <li><a href="http://ssd.ccsd.net/gifted-education-services/">Gifted Education Services</a></li>
                        <li class="extra-space"><a href="http://ssd.ccsd.net/special-education-resources/" class="long-link">Special Education Services</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
                        <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">Clark County Schools Achieve</a></li>
                        <li><a href="https://newsroom.ccsd.net/ccsd-covid-19-quick-facts/">Covid-19 Information</a></li>
                    <!--     <li><a href="http://faces.ccsd.net/family-toolbox/">Family Toolbox</a></li>
                        <li><a href="http://faces.ccsd.net/navigating-ccsd/">Navigating CCSD</a></li>
                        <li><a href="http://faces.ccsd.net/university-of-family-learning-ufl/">University of Family Learning</a></li> -->
                       <li><a href="https://ccsd.net/parents/resources/pdf/English-Learner-Pupil-and-Parental-Rights.pdf">English Learner Pupil and Parental Rights (PDF)</a></li>
					   <li><a href="https://ccsd.net/parents/resources/pdf/Alumno-Aprendiente-del-idioma-Inglés-y-Derechos-de-los-Padres.pdf">Alumno Aprendiente del idioma Inglés y Derechos de los Padres (PDF)</a></li>
                    </ul>
<!--
					<ul class="sub-nav-group">
                        <li class="section-headline">Assembly Bill 195 - English Language Learner Divisio</li>
                        <li><a href="https://ccsd.net/parents/resources/pdf/English-Learner-Pupil-and-Parental-Rights.pdf">English Learner Pupil and Parental Rights (PDF)</a></li>
						<li><a href="https://ccsd.net/parents/resources/pdf/Alumno-Aprendiente-del-idioma-Inglés-y-Derechos-de-los-Padres.pdf">Alumno Aprendiente del idioma Inglés y Derechos de los Padres (PDF)</a></li>
                     </ul>
-->
                    <ul class="sub-nav-group">
                        <li class="section-headline">Additional Information</li>
                        <li><a href="https://ccsd.nutrislice.com/" target="_blank">School Lunch Menus</a></li>
                        <li><a href="/departments/food-service/">Food Services</a></li>
                        <li><a href="/schools/contact-information/">School Directory</a></li>
                        <li><a href="/district/info/student-attire">Standard Student Attire</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="http://transportation.ccsd.net">Transportation</a></li>
                        <li class="extra-space"><a href="http://faces.ccsd.net/" class="long-link">Family and Community Engagement Services (FACES)</a></li>
                        <li class="extra-space"><a href="http://ccsd.net/departments/risk-and-insurance-services/voluntary-student-medical-insurance" class="long-link">Medical &amp; Dental Insurance for Students</a></li>
                        <li><a href="/students/bully/">Say No To Bullying</a></li>
                        <li class="extra-space"><a href="/students/resources/pdf/K-12-student-code-of-conduct.pdf" class="long-link">K-12 Student Code of Conduct (PDF)</a></li>
                        <li class="extra-space"><a href="/students/resources/pdf/K-12-student-code-of-conduct-spanish.pdf" class="long-link">C&oacute;digo de Conducta Estudiantil K-12 (PDF)</a></li>
                    </ul>
                    
                </div>
                
            </li>
            <li class="nav-item">
                <a href="?employees" class="top-level-link more-options">Employees</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group">
                        <li class="section-headline">Prospective Employee</li>
                        <li><a href="http://teachvegas.ccsd.net/">Job Opportunities</a></li>
                        <li><a href="/employees/prospective/descriptions">Job Descriptions</a></li>
                        <li><a href="/employees/prospective/applications/">Job Application Process</a></li>
                        <li><a href="http://teachvegas.ccsd.net/teaching/why-ccsd/">Recruitment Information</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Employee Information</li>
                        <li class="extra-space"><a href="/district/policies-regulations" class="long-link">CCSD Policies &amp; Regulations</a></li>
                        <li><a href="/employees/current/benefits">Employee Benefits</a></li>
                        <li><a href="/employees/current/employment/information">Employment Information</a></li>
                        <li><a href="/employees/current/employment/health">Health Information</a></li>
                        <li><a href="/employees/prospective">Job Opportunities</a></li>
                        <li><a href="/employees/current/employment/salary">Salary Information</a></li>
                        <li><a href="/employees/current/employment">More Information</a></li>
                        <li class="extra-space"><a href="/resources/legal/unemployment-faq.pdf" class="long-link">Unemployment Services - FAQ (PDF)</a></li>
                        <li class="extra-space"><a href="/resources/legal/summer-unemployment-faq.pdf" class="long-link">Summer Unemployment FAQs (PDF)</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="/community/protect-our-kids/">Protect Our Kids</a></li>
                        <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">Clark County Schools Achieve</a></li>
                        <li><a href="https://newsroom.ccsd.net/ccsd-covid-19-quick-facts/">Covid-19 Information</a></li>
                        <li class="extra-space"><a href="https://reconnect.ccsd.net/wp-content/uploads/2021/03/Hybrid-Implementation-Guide-Release-7-March-19-2021.pdf" class="long-link">Reopening Our Schools Implementation Guide (PDF)</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Employee Services</li>
                        <li><a href="/divisions/human-resources-division/">Human Resources Division</a></li>
                        <li class="extra-space"><a href="https://ess.ccsd.net" class="long-link">Employee Self Service (ESS)</a></li>
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
                        <li><a href="http://erp.ccsd.net/" >ERP</a></li>
                        <li><a href="https://hcm.ccsd.net">HCM</a></li>
                        <li><a href="http://learn.ccsd.net">ELMS</a></li>
                        <li><a href="/employees/canvas/">Canvas LMS</a></li>
                        <li><a href="https://campus.ccsd.net/">Infinite Campus</a></li>
                        <li><a href="/employees/blended.php">BlendED Initiative</a></li>
                        <li><a href="/employees/teacher-appreciation-week/">Teacher Appreciation Week</a>
                        </li>
                        <li><a href="/employees/ethicspoint">EthicsPoint</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="?trustees" class="top-level-link more-options">Trustees</a>
                <div class="sub-nav">
                	<ul class="sub-nav-group trustees-general">
                  		<li class="section-headline">Trustees Information</li>
                  		<li class="extra-space"><a href="/trustees/" class="long-link">Trustee General Information</a></li>
                  		<!-- <li class="extra-space"><a href="/trustees/pdf/board_calendars/board-meetings-2018.pdf" class="long-link">2018 Work Sessions and Regular Board Meeting Schedule (PDF)</a></li> -->
                  		<li class="extra-space"><a href="/trustees/meeting-agendas/2021" class="long-link">2021 Board Meeting Agendas</a></li>
                  		<li class="extra-space"><a href="https://ccsd.eduvision.tv/live.aspx" class="long-link">Board Meeting Live Stream (Eduvision)</a></li>
                  		<li class="extra-space"><a href="https://www.ccsd.net/trustees/contact/all" class="long-link">Contact A Board Member</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                    </ul>

                    
                    <!-- DISTRICT G -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District G</li>
                        <li>
                            <a href="/trustees/details/G" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-g.jpg" alt=""></span>
                                <span class="trustee-title">President</span><br>
                                <span class="trustee-name">Linda P. Cavazos</span>
                            </a>
                        </li>
                    </ul>

					<!-- DISTRICT D -->
                          <ul class="sub-nav-group trustees">
                        <li class="section-headline">District D</li>
                        <li>
                            <a href="/trustees/details/D" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-d-19.jpg" alt=""></span>
                                <span class="trustee-title">Vice President</span><br>
                                <span class="trustee-name">Irene A. Cepeda</span>
                            </a>
                        </li>
                    </ul>
                        <!-- DISTRICT C -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District C</li>
                        <li>
                            <a href="/trustees/details/C" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-c.jpg" alt=""></span>
                                <span class="trustee-title">Clerk</span><br>
                                <span class="trustee-name">Evelyn Garcia Morales</span>
                            </a>
                        </li>
                    </ul>

					<!-- DISTRICT E -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District E</li>
                        <li>
                            <a href="/trustees/details/E" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-e.jpg" alt=""></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Lola Brooks</span>
                            </a>
                        </li>
                    </ul>


     

                    <div class="second-row">


                             <!-- DISTRICT B -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District B</li>
                        <li>
                            <a href="/trustees/details/B" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-b.jpg" alt=""></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Katie Williams</span>
                            </a>
                        </li>
                    </ul>

                

                    <!-- DISTRICT A -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District A</li>
                        <li>
                            <a href="/trustees/details/A" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-a.jpg" alt=""></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Lisa Guzm&aacute;n</span>
                            </a>
                        </li>
                    </ul>
           
                              
                    <!-- DISTRICT F -->
                    <ul class="sub-nav-group trustees">
                        <li class="section-headline">District F</li>
                        <li>
                            <a href="/trustees/details/F" class="long-link">
                                <span class="trustee-img"><img src="/trustees/includes/images/district-f-19.jpg" alt=""></span>
                                <span class="trustee-title">Member</span><br>
                                <span class="trustee-name">Danielle Ford</span>

                            </a>
                        </li>
                    </ul>

  
                     </div>
                </div>
            </li>
            <li class="nav-item">
                <a href="?community" class="top-level-link more-options">Community</a>
                <div class="sub-nav">
                    <ul class="sub-nav-group trustee">
                        <li class="section-headline">Community Information</li>
                        <li><a href="https://newsroom.ccsd.net/" target="_blank">Newsroom</a></li>
                        <li><a href="https://newsroom.ccsd.net/press-releases/" target="_blank">Press Releases</a></li>
                        <li><a href="http://getengaged.ccsd.net">Community Relations</a></li>
                        <li><a href="http://ccsd.net/departments/government-affairs" target="_blank">Government Relations</a></li>
                        <li><a href="/departments/school-accounting">Facility Usage</a></li>
                        <li class="extra-space"><a href="/departments/government-affairs/student-enrollment-and-school-capacity" class="long-link">Student Enrollment and School Capacity</a></li>
                        <li class="extra-space"><a href="/parents/volunteer-chaperone-training/volunteer-chaperone-training" class="long-link">Volunteer Chaperone Training</a></li>
                        <li><a href="/community/protect-our-kids">Protect Our Kids</a></li>
                        <li class="extra-space"><a href="http://faces.ccsd.net/" class="long-link">Family and Community Engagement Services (FACES)</a></li>
                        <li><a href="http://facilities.ccsd.net/">Facilities Services Unit</a></li>
                        <li class="extra-space"><a href="http://reorg.ccsd.net/" class="long-link">Clark County Schools Achieve</a></li>
                        <li><a href="https://newsroom.ccsd.net/ccsd-covid-19-quick-facts/">Covid-19 Information</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Community Projects</li>
                        <li><a href="/community/partnership">Partnership</a></li>
                        <li><a href="/community/get-involved">Get Involved</a></li>
                        <li><a href="/schools/support-a-school/">Support a School</a></li>
                    </ul>
                    <ul class="sub-nav-group">
                        <li class="section-headline">Partnership Programs</li>
                        <li><a href="/community/partnership">Partnership</a></li>
                        <li><a href="/community/partnership/about-us/advisory-council">Advisory Council</a></li>
                        <li><a href="/community/partnership/programs/curriculum-index.php">Curriculum Projects</a></li>
                        <li><a href="/community/partnership/programs/focus/focus-index">Focus School Project</a></li>
                        <li><a href="/community/partnership/programs/paybac/paybac-index">PAYBAC</a></li>
                        <li><a href="https://sites.google.com/nv.ccsd.net/saferoutestoschool/home">Safe Routes to School</a></li>
<!--                    <li><a href="http://saferoutestoschool.ccsd.net">Safe Routes to School</a></li> -->
                        <li><a href="/community/partnership/programs/stay/stay-index">Stay in School Mentoring</a></li>
                        <li><a href="/schools/support-a-school">Support a School</a></li>
                    </ul>
                       <ul class="sub-nav-group">
                        <li class="section-headline">Additional Information</li>
                        <li><a href="/schools/websites/" target="_blank">School Websites</a></li>
                        <li><a href="http://www.ccsdvictoryschools.net/" target="_blank">Victory Schools</a></li>
                        <li class="extra-space"><a href="/district/info/title-ix/" class="long-link">Title IX</a></li>
                        <li class="extra-space"><a href="/district/info/non-discrimination/" class="long-link">Notice of Nondiscrimination</a></li>
                        <li><a href="/parents/infinite-campus-choice.php">Infinite Campus</a></li>
                        <li><a href="http://ccsdarchives.org/" target="_blank">CCSD Archive Committee</a></li>
                        <li><a href="http://pollen.aaaai.org/nab/index.cfm?p=allergenreport&stationid=223" target="_blank">Pollen and Mold Alert</a></li>
                        <li><a href="/community/gold-card/" target="_blank">Gold Card for Seniors</a></li>
                        <li><a href="/community/mentalhealth/" target="_blank">Mental Health Resources</a></li>
                        <li><a href="/students/bully/">Say No To Bullying</a></li>
                        <li><a href="/community/public-records-request">Public Records Request</a></li>
                        <li><a href="/community/public-concern">Public Concern</a></li>
                    </ul>
                </div>
            </li>
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
