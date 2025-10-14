<?php
/***
#	@ file		: index.php
#	@ location	: /www/apache/htdocs/ccsd/district/cybersecurity
#	@ author	: crystal
#	@ purpose	: directory information
# 	@ created	: 2025-04-02
# 	@ modified	: 2025-04-10
***/
include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

$page['ribbon'] = array('district', $home->url . '/district/');
$page['title'] = 'Cybersecurity Resources for Teachers and Parents | Clark County School District';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

include($home->inc['header']);
include($home->inc['breadcrumbs']);
?>

<!-- Font Awesome + Bootstrap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    --ccsd-blue: #1771B7;
    --ccsd-light-blue: #007acc;
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #333;
  }

  .content-holder {
    padding: 20px;
  }

  .header2 {
    background: #1771B7;
    color: white;
    padding: 12px 20px 20px 20px;
    text-align: center;
    margin: 0;
  }

  .header2 p {
    font-size: 1.2em;
    margin-top: 0;
    color: #ffffff;
  }

  header img {
    max-width: 200px;
    margin-top: 1rem;
  }

h2 {
  color: var(--ccsd-blue);
  text-align: center;
  padding-bottom: 10px !important;
}

  .btn-ccsd {
    background-color: var(--ccsd-light-blue);
    color: white;
    border: none;
    font-weight: bold;
  }

  .btn-ccsd:hover {
    background-color: #005fa3;
  }

  .icon-block {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 1.5rem;
    text-align: center;
  }

  footer {
    background-color: var(--ccsd-blue);
    color: white;
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
  }
</style>

<div id="content_wrap" class="content-wrap">
<!--
  <header class="header2">
    <h1>CCSD Cybersecurity Awareness</h1>
    <p><em>Safe, Smart, and Secure—With Firewall by Your Side</em></p>
    <div class="d-flex justify-content-center align-items-center flex-column flex-md-row gap-3 mt-3">
      <img src="/assets/images/firewall-welcome.png" alt="Firewall the Dragon welcomes you" class="img-fluid" style="max-width: 200px;">
      <a href="#resources" class="btn btn-ccsd">Explore Resources</a>
    </div>
  </header>
-->

<header class="header2">
  <h1>CCSD Cybersecurity Awareness</h1>
  <p><em>Safe, Smart, and Secure—With Firewall by Your Side</em></p>
</header>

<div class="d-flex justify-content-center align-items-center flex-column flex-md-row gap-3 mt-3 pb-3">
  <img src="/assets/images/firewall-welcome.png" alt="Firewall the Dragon welcomes you" class="img-fluid" style="max-width: 200px;">
  <a href="#resources" class="btn btn-ccsd">Explore Resources</a>
</div>


  <section class="content-holder">

    <section class="text-center bg-light py-3">
      <p class="lead mb-0">Clark County School District is committed to protecting every student’s digital journey through strong policies, proactive education, and family partnership.</p>
    </section>

    <section id="resources" class="mt-5">
      <h2>What Parents Need to Know</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="icon-block">
            <img src="/assets/icons/shield.svg" alt="Policy Shield" class="mb-3" width="50">
            <h3>Acceptable Use</h3>
            <p>Key takeaways from Regulation 797.2 in simple terms.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-block">
            <img src="/assets/icons/document.svg" alt="FERPA Document" class="mb-3" width="50">
            <h3>FERPA, COPPA, CIPA</h3>
            <p>How CCSD complies with student data laws.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-block">
            <img src="/assets/icons/lock.svg" alt="Data Lock" class="mb-3" width="50">
            <h3>Student Data Protection</h3>
            <p>Overview of security tools and privacy safeguards.</p>
          </div>
        </div>
      </div>
      <a href="/downloads/resources.pdf" class="btn btn-ccsd mt-4">Download Resources</a>
    </section>

    <section class="mt-5">
      <h2>Cyber Safety at Home</h2>
      <ul class="nav nav-tabs" id="safetyTabs" role="tablist">
    
    
        <li class="nav-item">
          <button class="nav-link active" id="Platform-tab" data-bs-toggle="tab" data-bs-target="#Platform" type="button" role="tab">Platform-Specific Guidance</button>
        </li>
         <li class="nav-item">
          <button class="nav-link" id="internet-tab" data-bs-toggle="tab" data-bs-target="#internet" type="button" role="tab">Internet Safety Basics</button>
        </li>
                 <li class="nav-item">
          <button class="nav-link" id="wifi-tab" data-bs-toggle="tab" data-bs-target="#wifi" type="button" role="tab">Home Wi-Fi Guidance</button>
        </li>
      </ul>
      <div class="tab-content p-3 bg-white border border-top-0" id="safetyTabsContent">
     
        <div class="tab-pane fade" id="discord">
          <p>Review server access, enable filters, and monitor DMs.</p>
        </div>
        <div class="tab-pane fade show active" id="Platform">
          	<ul class="mt-3">
		        <li>TikTok: Enable privacy, monitor screen time, avoid oversharing.</li>
		        <li>Discord: Review server access, enable content filters, monitor DMs.</li>
		        <li>Instagram: Set accounts to private, approve followers, manage screen time.</li>
	      	</ul>
        </div>
        <div class="tab-pane fade" id="internet">
	         <ul class="mt-3">
		        <li>Use parental controls from ISPs or phone providers.</li>
		        <li>Avoid suspicious links and unknown downloads.</li>
		        <li>Protect personal information online.</li>
	      	</ul>
        </div>
         <div class="tab-pane fade" id="wifi">
	         <ul class="mt-3">
		        <li>Secure admin access.</li>
		        <li>Use strong firewall settings.</li>
		        <li>Consider apps like Who’s on My WiFi.</li>
	      	</ul>
        </div>

      </div>

    </section>

    <section class="mt-5">
      <h2>Recommended Tools</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="icon-block">
            <h3>Malwarebytes</h3>
            <p>Free antivirus tool</p>
            <a href="https://www.malwarebytes.com/" class="btn btn-ccsd">Download</a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-block">
            <h3>Who’s on My WiFi</h3>
            <p>Network monitoring for home routers</p>
            <a href="https://www.whoisonmywifi.com/" class="btn btn-ccsd">Download</a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="icon-block">
            <h3>Google Family Link</h3>
            <p>Monitor and guide app usage</p>
            <a href="https://families.google.com/familylink/" class="btn btn-ccsd">Download</a>
          </div>
        </div>
      </div>
    </section>

<section class="mt-5">
  <div class="row g-4">

    <div class="col-md-4">
      <h2>How CCSD Protects Students</h2>
      <ul>
        <li>GoGuardian filters and monitors student devices.</li>
        <li>Endpoint protection across District computers.</li>
        <li>24/7 system monitoring and cybersecurity staff.</li>
      </ul>
      <p>Note: Browsing is only monitored on CCSD-issued devices.</p>
      <a href="/learn-more" class="btn btn-ccsd">Learn More</a>
    </div>

    <div class="col-md-4">
      <h2>Community Involvement</h2>
      <ol class="list-unstyled text-start">
        <li><strong>Back to School Fairs – Summer 2025:</strong> Meet Firewall the Dragon in person!</li>
        <li><strong>Upcoming Events:</strong> Cybersecurity Awareness Month and more.</li>
      </ol>
      <a href="/events" class="btn btn-ccsd">Join Us</a>
    </div>

    <div class="col-md-4">
      <h2>Report a Concern</h2>
      <ol class="list-unstyled text-start">
        <li>Contact your school administration.</li>
        <li>Submit a report through SafeVoice.</li>
        <li>Use the District IT support page.</li>
      </ol>
      <p><strong>Urgent issues:</strong> Response within 24 hours.<br>
         <strong>General concerns:</strong> 3–5 business days.</p>
      <a href="/report" class="btn btn-ccsd">Report an Issue</a>
    </div>

  </div>
</section>


<!--
    <section class="mt-5">
      <div class="row g-4">
        <div class="col-md-6">
          <h2>How CCSD Protects Students</h2>
          <ul>
            <li>GoGuardian filters and monitors student devices.</li>
            <li>Endpoint protection across District computers.</li>
            <li>24/7 system monitoring and cybersecurity staff.</li>
          </ul>
          <p>Note: Browsing is only monitored on CCSD-issued devices.</p>
          <a href="/learn-more" class="btn btn-ccsd">Learn More</a>
        </div>
        <div class="col-md-6">
          <h2>Community Involvement</h2>
        <ol class="list-unstyled d-inline-block text-start">
	        <li><strong>Back to School Fairs – Summer 2025:</strong> Meet Firewall the Dragon in person!</li>
	        <li><strong>Upcoming Events:</strong> Cybersecurity Awareness Month and more.</li>
			<li>&nbsp;</li>
      	</ol>
      	 <p><a href="/events" class="btn btn-ccsd">Join Us</a></p>

        </div>
      </div>
    </section>
-->

<!--
    <section class="mt-5 text-center">
      <h2>Report a Concern</h2>
      <ol class="list-unstyled d-inline-block text-start">
        <li>Contact your school administration.</li>
        <li>Submit a report through SafeVoice.</li>
        <li>Use the District IT support page.</li>
      </ol>
      <p><strong>Urgent issues:</strong> Response within 24 hours. <br><strong>General concerns:</strong> 3–5 business days.</p>
      <a href="/report" class="btn btn-ccsd">Report an Issue</a>
    </section>
-->

  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include($home->inc['footer']); ?>
