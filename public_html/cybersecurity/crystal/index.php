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

<!-- ? Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/*
p {
    margin: 0;
    font-size: 100% !important;
    line-height: 26px;
    height: 100%;
    -webkit-font-smoothing: antialiased;
    }	
*/

h1 {
    font-size: 3em;
    font-family: 'Arial Black', Gadget, sans-serif;
    color: #ffffff !important;
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    padding-bottom: 10px;
}

.header2 {
	background: #1771B7;
/*     background: linear-gradient(to right, #004E92, #000428); */
    color: white;
    padding-top: 12px;
    padding-right: 12px;
    padding-bottom: 20px;
    padding-left: 20px;
/*     padding: 20px; */
    text-align: center;
    margin-bottom: 30px;
}

.header2 p {
    font-size: 1.2em;
    margin-top: 0px !important;
    color: #ffffff;
}

.container {
    max-width: 988px;
}

.py-5 {
 padding-top: 1rem !important;
}

/* Card layout with number + image below text */
.card.custom-style {
    background-color: #fff;
    padding-top: 0px;
    padding-right: 12px;
    padding-bottom: 20px;
    padding-left: 20px;
/*     padding: 20px; */
    border-radius: 8px;
    width: 98%;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 250px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-sizing: border-box;
}

.card-number-display {
    font-size: 3em;
    font-weight: bold;
    color: #004E92;
/*     margin-top: 15px; */
    margin-bottom: -75px;
    margin-left:-185px;
}
.card-spacer {
    flex-grow: 1;
    width: 100%;
}

.card-text {
    margin-bottom: 10px;
}
.card-text h4 {
    text-align: center;
}

.card-text ul {
    text-align: left;
    display: inline-block; /* Ensures the UL doesn't stretch full width */
}


.card-img-container img {
    max-width: 100px;
    height: auto;
}

.dragon-section {
    margin-top: 40px;
margin-right: auto;
margin-bottom: 0px;
margin-left: auto;
    padding-top: 0px;
    padding-right: 12px;
    padding-bottom: 0px;
    padding-left: 20px;
    box-sizing: border-box;
}


.dragon-intro {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  margin-bottom: 40px;
}

.dragon-img {
  max-width: 200px;
  height: auto;
  flex-shrink: 0;
}

.dragon-intro p {
  font-size: .95em;
  line-height: 1.6;
  margin: 0;
  color: #494949;
}


ul {
    list-style-type: square;
    padding-left:  5px;
    font-size: .95em;
    color: #494949;
}

ul li a {
    text-decoration: none;
    color: #333;
    display: block;
    margin: 10px 0;
    transition: color 0.3s;
}

ul li a i {
    margin-right: 8px;
    color: #004E92;
}

ul li a:hover {
    color: #004E92;
}

.contact {
    border-radius: 8px;
    margin: 40px auto;
    width: 60%;
    max-width: 700px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.contact h2 {
    text-align: center;
    color: #004E92;
    margin-bottom: 20px;
}

.cyber-form {
    background-color: #f9f9f9;
    border: 2px solid #004E92;
    border-radius: 10px;
    padding: 20px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-sizing: border-box;
}

.cyber-form label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #333;
}

.cyber-form input,
.cyber-form textarea {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.cyber-form button {
    background-color: #004E92;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
    font-size: 1em;
}

.cyber-form button:hover {
    background-color: #005D99;
}



.faq-section {
    margin: 60px auto;
    padding: 20px;
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
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
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

/* Responsive tweaks */
@media (max-width: 768px) {
    h1 {
        font-size: 2.2em;
    }

    .header2 {
        padding: 15px;
    }

    .card-number-display {
        font-size: 2.2em;
    }

    .card-img-container img {
        max-width: 70px;
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

    .cyber-form button {
        font-size: 1rem;
    }
}
</style>

<div id="content_wrap" class="content-wrap">
    <section class="content-holder">

        <header class="header2" style="margin-top: 0px !important;">
           
            <h1>Cybersecurity <!-- Education --></h1>
            <p>Safe, Smart, and Secure—With Firewall by Your Side</p>
        </header>
        <section class="dragon-section">
	        <div class="container ">
			  <div class="dragon-intro d-flex align-items-start">
			    <img src="images/FireWall-Dragon-transparent-04102025.png" alt="Firewall" class="dragon-img me-3">
					    <p style="margin-top: 40px;">
					      Clark County School District is committed to protecting every student’s digital journey through strong policies, proactive education, and family partnership.
					    </p>
			  </div>
<!--
			 <div class="dragon-intro d-flex align-items-start flex-row-reverse">
				 <img src="images/Sample-Blue-Dragon-unsecured.png" alt="Firewall Emails" class="dragon-img me-3">				    
				  <ul>This includes learning:<br><br>
					    <li>How to browse the internet safely	</li>
						<li>The importance of strong passwords and how to manage them	</li>
						<li>How to recognize suspicious emails, messages, and scams	</li>
						<li>How to avoid malware (harmful software)	</li>
						<li>What to do if they think their personal information has been compromised</li>		  
				    </ul>
			</div>
-->
		
       
<div class="row">
    <div class="col-12 col-lg-4 d-flex justify-content-center">
        <div class="card custom-style text-center">
            <div class="card-spacer"></div>
            <div class="card-text">
                <h4>What Parents Need to Know</h4>
                <ul>
                    <li>Acceptable Use Policy (Regulation 797.2): Key points in plain language.</li>
                    <li>FERPA / COPPA / CIPA Compliance: How CCSD ensures legal compliance.</li>
                    <li>Student Data Protection: Overview of tools and protocols.</li>
                    <li>Resources: Downloadable infographics and PDFs (to be provided).</li>
                </ul>
            </div>
            <div class="card-number-display"><span>1</span></div>
            <div class="card-img-container">
                <img src="images/Sample-Blue-Dragon-2025.png" alt="Stay up to date">
            </div>
        </div>
    </div>

                <div class="col-12 col-lg-4 d-flex justify-content-center">
                    <div class="card custom-style text-center">
                        <div class="card-text">
                            <h4>Install Antivirus</h4>
                            <p>Install an antivirus program on all devices. Run virus scans routinely, at lease once a week.</p>
                        </div>
                        <div class="card-spacer"></div>
                        <div class="card-number-display"><span>2</span></div>
                        <div class="card-img-container">
                            <img src="images/Firewall-new-antivirus.png" alt="Strong Password">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 d-flex justify-content-center">
                    <div class="card custom-style text-center">
                        <div class="card-text">
                            <h4>Secure Email Accounts</h4>
                            <p>Email accounts are a prominent target for phishers, so you have to be particularly careful with them.
						</div>
						<div class="card-spacer"></div>
                        <div class="card-number-display"><span>3</span></div>
                        <div class="card-img-container">
                            <img src="images/Firewall-new-secure-email.png" alt="Cyberbullying Awareness">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <button class="faq-question">
                    <span>What is cybersecurity for students?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Cybersecurity for students involves teaching young learners how to stay safe online, protect personal information, and avoid digital threats like phishing and cyberbullying.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>How can parents support online safety?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Parents can support by using parental controls, modeling good behavior, and having open conversations about online risks and responsible internet use.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    <span>Are there free resources available?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Yes! We provide printable toolkits, external links, and downloadable guides — all free of charge to help educators and families navigate cybersecurity together.</p>
                </div>
            </div>
        </section>

        <section class="contact">
            <h2>Contact & Support</h2>
            <form class="cyber-form" action="submit_form.php" method="post">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" placeholder="Your message..." required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </section>
</div>

<script>
document.querySelector('.cyber-form').addEventListener('submit', function (e) {
    const email = document.querySelector('#email').value;
    const message = document.querySelector('#message').value;
    if (!email || !message) {
        e.preventDefault();
        alert("Please fill in both fields before submitting.");
    }
});

document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const isActive = button.classList.contains('active');
        document.querySelectorAll('.faq-question').forEach(btn => btn.classList.remove('active'));
        if (!isActive) {
            button.classList.add('active');
        }
    });
});
</script>

<?php include($home->inc['footer']); ?>
