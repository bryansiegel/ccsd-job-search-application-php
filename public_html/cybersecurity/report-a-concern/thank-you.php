<?php


$referringSite = $_SERVER['HTTP_REFERER'];

if ($referringSite != "https://ccsd.net/cybersecurity/report-a-concern/") {
    header('Location: https://ccsd.net/cybersecurity/report-a-concern/');
}
?>

<?php

include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');

# set the page parameters
$page['ribbon'] = array('Schools', $home->url . '/schools/');
$page['title'] = 'Thank you';
$page['description'] = 'Thank you.';

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

    /* fix content length */
    .main-content-wrap {
        width: 90% !important;
    }
</style>
<!-- content -->
<div id="content_wrap" class="content-wrap">

    <div id="main_content_wrap" class="main-content-wrap" role="main">
        <!-- MAIN CONTENT -->
        <div id="main_content">
            <section class="content-holder">

                <h1>Thank You Submitting a Cyber Security Concern</h1>
                <p>We sincerely appreciate your recent submission to the Cyber Security Concern System. Your feedback is
                    invaluable in helping us maintain a safe and supportive environment for our community.</p>
                <p>For urgent issues, responses will be provided within 24 hours to ensure timely support and
                    resolution. For general concerns or inquiries, please allow 3–5 business days for a response. We are
                    committed to addressing all matters with care and efficiency, prioritizing according to urgency.</p>
                </p>
                <div style="text-align:center">
            </section>
        </div><!-- /main_content -->
    </div> <!-- /main_content_wrap -->
</div> <!-- /content-wrap -->
<?php include($home->inc['footer']); ?>