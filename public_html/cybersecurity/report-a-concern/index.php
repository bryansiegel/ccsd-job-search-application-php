<?php

include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

# set the page parameters
$page['ribbon'] = array('Schools', $home->url . '/schools/');
$page['title'] = 'Report A Cyber Security Concern';
$page['description'] = 'For urgent issues, responses will be provided within 24 hours to ensure timely support and resolution. For general concerns or inquiries, please allow 3–5 business days for a response. We are committed to addressing all matters with care and efficiency, prioritizing according to urgency.';

# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>
<style>
    .container {
        line-height: 200px;
        padding-left: 15px;

    }

    .alert {
        width: 92%;
        background-color: #FFFED5;
        border: 1px solid #E3E1AA;
        padding: 30px;
        color: #191919;
        margin-bottom: 30px;

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

    .alert-primary {
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: .25rem;
        color: #004085;
        background-color: #cce5ff;
        border-color: #b8daff;
        /* width: 460px; */
    }

    .alert-warning {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-radius: .25rem;
        /* width: 460px; */
    }

    .required-field {
        color: red;
        padding-right: 5px;
    }

    input:invalid,
    textarea:invalid {
        background-color: white !important;
    }

    .simple-form input[type="date"],
    .simple-form input[type="email"],
    .simple-form input[type="phone"],
    .simple-form select {
        border: 1px solid #ccc;
        padding: 5px;
        width: 295px;
    }

    /* fix content length */
    .main-content-wrap {
        width: 90% !important;
    }
</style>

<!-- Google reCAPTCHA CDN -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- content -->
<div id="content_wrap" class="content-wrap">
    <div id="main_content_wrap" class="main-content-wrap" role="main">
        <!-- MAIN CONTENT -->
        <div id="main_content">
            <section class="content-holder">

                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['acknowledgement'] == 'acknowledgementTrue') {

                    $locationOfIncident = htmlspecialchars($_POST['locationOfIncident']);
                    $date = htmlspecialchars($_POST['date']);
                    $time = htmlspecialchars($_POST['time']);
                    $firstName = htmlspecialchars($_POST['firstName']);
                    $lastName = htmlspecialchars($_POST['lastName']);
                    $phone = htmlspecialchars($_POST['phone']);
                    $email = htmlspecialchars($_POST['email']);
                    $briefSummaryOfComplaint = htmlspecialchars($_POST['briefSummaryOfComplaint']);
                    $acknowledgement = htmlspecialchars($_POST['acknowledgement']);
                    $recaptcha = htmlspecialchars($_POST['g-recaptcha-response']);
                    $secret_key = '6LczrBsqAAAAAIgVJxeuW53vHclOWqeSmHY5FSZc';
                    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
                        . $secret_key . '&response=' . $recaptcha;
                    // Making request to verify captcha
                    $response = file_get_contents($url);
                    $response = json_decode($response);
                    if ($response->success == true) {
                        $time_created = date("h:i:sa");
                        $date_created = date("F j, Y");

                        // Email Goes to CCSPD Internal Affairs
                        $to = 'ccsd-cyber@clarkcountyschooldistrict.samanage.com';
                        $subject = 'CCSD Cyber Security Concern ' . $email;
                        $body = "New CCSD Cyber Security Concern\n\nFirst Name: $firstName\nLast Name: $lastName\nEmail: $email\nPhone Number: $phone\n\nLocation of Incident: $locationOfIncident\nDate of Occurence: $date\nTime of Occurence: $time\n\nBrief Summary of Complaint:\n$briefSummaryOfComplaint";
                        //headers to prevent spam
                        $headers = "From: Cyber Security <$to> \r\n";
                        $headers .= "Reply-To: $to\r\n";
                        $headers .= "Return-Path: $to";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

                        // Send the email
                        // mail($to, $subject, $body, $headers, '-f CCSDPDInternalAffairs@nv.ccsd.net -F CCSDPD') or die();
                        mail($to, $subject, $body, $headers);

                        //Email goes to User
                        // Email Goes to CCSPD Internal Affairs
                        // $to = $email;
                        $subject = 'Your Response to the Cyber Security Concern ' . $email;
                        $body = "For urgent issues, responses will be provided within 24 hours to ensure timely support and resolution. For general concerns or inquiries, please allow 3–5 business days for a response. We are committed to addressing all matters with care and efficiency, prioritizing according to urgency.\n\nFirst Name: $firstName\nLast Name: $lastName\nEmail: $email\nPhone Number: $phone\n\nLocation of Incident: $locationOfIncident\nDate of Occurence: $date\n\nBrief Summary of Complaint:\n$briefSummaryOfComplaint";
                        //headers to prevent spam
                        $headers = "From: Cyber Security <$to> \r\n";
                        $headers .= "Reply-To: $to\r\n";
                        $headers .= "Return-Path: $to";

                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

                        // Send the email
                        // mail($to, $subject, $body, $headers, '-f CCSDPDInternalAffairs@nv.ccsd.net -F CCSDPD') or die(); 
                        mail($email, $subject, $body, $headers) or die();


                        //redirect after success
                        echo '<script>
                        window.location.replace("https://ccsd.net/cybersecurity/report-a-concern/thank-you.php");
                    </script>';
                    } else {
                        //if the user didn't select the captcha.
                        echo '<script>alert("Captcha is Required")</script>';
                        //redirect to the same form
                        echo '<script>
                        window.location.replace("https://ccsd.net/cybersecurity/report-a-concern/thank-you.php");
                    </script>';
                    }

                } else { ?>

                    <h1>Report A Cyber Security Concern</h1>
                    <p>For urgent issues, responses will be provided within 24 hours to ensure timely support and
                        resolution. For general concerns or inquiries, please allow 3–5 business days for a response. We are
                        committed to addressing all matters with care and efficiency, prioritizing according to urgency.</p>


                    <hr>

                    <form class="simple-form" id="ccspdComplaintForm" method="post"
                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <!-- <form id="ccspdComplaintForm" action="https://ccsd.net/departments/police-services/complaint-form/index-captcha.php" class="simple-form" method="post"> -->
                        <div>
                            <label for="locationOfIncident"><span class="required-field">*</span>Location of
                                Incident</label><br>
                            <input type="text" name="locationOfIncident" required
                                oninvalid="this.setCustomValidity('Location of Incident Is Required')"
                                oninput="this.setCustomValidity('')" />
                        </div>
                        <div>
                            <label for="date"><span class="required-field">*</span>Date of
                                Occurrence</label><br>
                            <input type="date" name="date" required oninvalid="this.setCustomValidity('Date Is Required')"
                                oninput="this.setCustomValidity('')" />
                        </div>
                        <div>
                            <label for="time"><span class="required-field">*</span>Time of
                                Occurrence</label><br>
                            <input type="time" name="time" required
                                oninvalid="this.setCustomValidity('Time of Occurrence Is Required')"
                                oninput="this.setCustomValidity('')" />
                        </div>
                        <div>
                            <label for="firstName"><span class="required-field">*</span>First Name</label><br>
                            <input type="text" name="firstName" 
                            required oninvalid="this.setCustomValidity('First Name Is Required')"
                                oninput="this.setCustomValidity('')"
                            />
                        </div>
                        <div>
                            <label for="lastName"><span class="required-field">*</span>Last Name</label><br>
                            <input type="text" name="lastName" 
                                   required oninvalid="this.setCustomValidity('Last Name Is Required')"
                                oninput="this.setCustomValidity('')"

                            />
                        </div>
                        <div>
                            <label for="phone">Phone Number</label><br>
                            <input type="phone" name="phone" />
                        </div>
                        <div>
                            <label for="email"><span class="required-field">*</span>Email</label><br>
                            <input type="email" name="email" required
                                oninvalid="this.setCustomValidity('Email Is Required')"
                                oninput="this.setCustomValidity('')" />
                        </div>
                        <div>
                            <label for="briefSummaryOfComplaint"><span class="required-field">*</span>Brief Summary of
                                Cyber Security Concern</label><br>
                            <textarea type="text" name="briefSummaryOfComplaint" required
                                oninvalid="this.setCustomValidity('Brief Summary of Cyber Security Is Required')"
                                oninput="this.setCustomValidity('')"></textarea>
                        </div>
                     
                        <!-- div to show reCAPTCHA -->
                        <div class="g-recaptcha" data-sitekey="6LczrBsqAAAAAO8f4ybq3cxnIBpmCCzpqpvc7W4u"></div>

                        <div>
                            <p><span class="required-field">*</span>Acknowledgement</p>
                            <div>
                                <input type="checkbox" name="acknowledgement" value="acknowledgementTrue" required
                                    oninvalid="this.setCustomValidity('Acknowledgement Is Required')"
                                    oninput="this.setCustomValidity('')" />
                                I understand and agree to the statement below.**<br>
                                **By submitting this form, I affirm that the information provided is accurate and truthful
                                to the best of my knowledge. I understand that submitting false or misleading information
                                may result in criminal penalties, including those outlined under NRS 207.280, which states
                                that knowingly making a false report to law enforcement or public officials that leads to an
                                investigation is a misdemeanor offense.

                                I further acknowledge that this form is intended for reporting legitimate cyber security
                                concerns or incidents, and I agree not to misuse this system for false claims, personal
                                grievances, or non-cyber security-related matters.
                            </div>
                        </div>
                        <!-- <div class="captcha-field" id="captcha"></div> -->
                        <input type="submit" id="submit" name="Submit" />
                    </form>
                <?php } ?>
                <div style="text-align:center">
            </section>
        </div><!-- /main_content -->
    </div> <!-- /main_content_wrap -->
</div> <!-- /content-wrap -->
<?php include($home->inc['footer']); ?>