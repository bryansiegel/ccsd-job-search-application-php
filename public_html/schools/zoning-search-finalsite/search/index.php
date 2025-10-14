<?php include('../includes/head.php') ?>


<body data-logged-in="false" data-pageid="448" data-lazy-load-media="true" data-resource-optimizations="true"
      class="fsLiveMode fsHasHeader fsHasMenu fsHasFooter fsHasOneColumnLayout fsSection447 fsLocation1 fsAccountBarTop fsHasTheme2">

<a id="fsSkipToMainContentLink" href="#fsPageContent">Skip To Main Content</a>

<style>
    label {
        color: #2C5B96;
        font-weight:bold;
    }
</style>

<div id="fsPageWrapper">
<?php include('../includes/menu.php') ?>

    <?php include('../includes/header.php') ?>

<!--    New-->
    <div id="fsPageBodyWrapper" class="fsPageBodyWrapper" style="min-height:500px;">
        <div id="fsPageBody" class="fsStyleAutoclear">

            <main id="fsPageContent" class="fsPageContent">

                <?php //Page Section Start ?>

                <h1 class="fsPageTitle">ZONING SEARCH</h1>

                <div class="fsPageLayout fsLayout fsOneColumnLayout fsStyleAutoclear" id="fsEl_2473" data-use-new="true">
                    <div class="fsDiv fsStyleAutoclear" id="fsEl_2474">
                        <div class="fsElement fsContent" id="fsEl_2475" data-use-new="true">


                        <!-- End New-->


    <!-- content -->
    <div id="content_wrap" class="content-wrap">

        <div id="main_content_wrap" class="main-content-full-wrap" role="main">
            <section class="content-holder">
<!--                <h1>Zoning Search</h1>-->

                <div style="padding-bottom:35px;">
                    <p>To find your zoned school, please enter your address below. The search will return the zoned school for the current school year.</p>
                    <p>For the 2025-2026 school year, the zoned school is based on the address as of <strong>January 1, 2025</strong>.</p>
                </div>
<!--                <h2>Search For Your School Zone</h2>-->

<!--                <h3>Enter Your Address</h3>-->

                <form class="simple-form ajax-search" id="search" name="search" method="get" action="/schools/zoning-search-finalsite/search/search.php">

                    <table class="zoning-search-tbl" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2">
                                <label for="year">Choose A School Year</label><br>
                                <select name="year" id="year">

                                    <!--                                         <option value="2022">2022 - 2023 School Year</option> -->
                                    <!-- 										<option value="2024">2023 - 2024 School Year</option> -->
                                    <!--                                         <option value="2025">2024 - 2025 School Year</option> -->
                                    <option value="2026">2025 - 2026 School Year</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="house">Street Number</label><br />
                                <span class='note'><strong>Example</strong>: 1234</span><br />
                                <input name="house" id="house" type="text" value="<?=isset($_GET['house'])?$_GET['house']:'';?>" style="width: 100px" placeholder="" /><br />
                            </td>
                            <td>
                                <label for="street">Street Name</label><br />
                                <span class='note'><strong>Do Not Enter</strong> street direction (N, S, E, W) or street type (ST, AVE, LN, DR, etc.)</span><br />
                                <input style="width: 100%; margin-bottom: .5em;" name="street" id="street" type="text" value="<?=isset($_GET['street'])?$_GET['street']:'';?>" placeholder="" /><br />

                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="uniqueid" id="uniqueid">
                    <!--<input type="hidden" name="year" id="year">-->
                    <div style="padding-top:25px;border-left:1px solid lightgrey;border-right:1px solid lightgrey;border-bottom:1px solid lightgrey;    box-shadow: 0 4px 6px -2px rgba(0, 0, 0, 0.1);
">
                    <input id="submit" type="submit" value="Search" style="margin-left:20px;margin-bottom:20px;background-color:#2C5B96;color:white;font-weight:bold;padding:10px 20px;border:none;cursor:pointer;" />
                    </div>
                        <!-- <a href="./">Cancel</a>  -->


                </form>


                <div id="search_results" class="ajax-search-results" style="display: none;"></div>

                <div style="padding-top:20px; padding-bottom:20px;">
                <p>If you require assistance identifying the zoned school for your address, please contact<br /><a href="http://dzg.ccsd.net">Demographics, Zoning &amp; GIS Department</a> at <strong>(702) 799-6430</strong>.</p>

                <p>For Registration assistance please call <strong>(702) 799-7678</strong>.</p>

                <p>If you are unable to locate your zoned school, please refer to the <a href="/schools/zoning/resources/address-troubleshooting-guide-13-14.pdf">Address Troubleshooting Guide (PDF)</a>.</p>

                <p>If you have questions regarding bus transportation, please contact <a href="http://ccsd.net/departments/transportation">Transportation Department</a> at 702-799-8100.</p>
                </div>

<!--                <h3>Interactive Google Map</h3>-->
<!---->
<!--                <a class="button-blue-standard" href="https://bit.ly/CCSDZoning">View interactive Google Map</a>-->
<!---->
<!--                <iframe src="https://www.google.com/maps/d/embed?mid=1mtm1L--Oj02r2hORe28syJ3I8wCmGMYw&ehbc=2E312F" width="800" height="800"></iframe>-->
<!---->
<!--                <ul>-->
<!--                    <li>Select the magnifying glass icon to search your address or locate a school.</li>-->
<!--                    <li>Click on the residence for zoned school information.</li>-->
<!--                    <li>Check the various zone layer to turn on attendance boundaries.</li>-->
<!--                </ul>-->
<!---->
<!--                <p>Please note Google does not validate addresses, and new residential addresses may experience delays until Google enters them. Use the search function above for more up-to-date validated residential addresses searches. If you experience errors with the search above try just entering the address number and the first few letters of the street name.</p>-->

                <div class="horiz-rule"></div>


                <div>
                </div>
            </section>
        </div>
    </div> <!-- /main_content_wrap -->
</div> <!-- /content-wrap -->

                    </div>
                </div>
            </div>
    </div>
</div>


<script>

    $('#submit').on('click', function(e) {
        e.preventDefault();

        $('#search').submit();
    });

    function byuniqueid(uniqueid, year) {
        $('#uniqueid').val(uniqueid);
        $('#year').val(year);
        $('#search').submit();
    }
</script>
<script>
    $(document).ready(function() {
        // ajax submit
        $('.ajax-submit').on('submit', function() {
            return $.ajaxsubmit.form(this, function(r){ location.href=r; });
        });

        // ajax search
        $('.ajax-search').on('submit', function() {
            return $.ajaxsearch.form(this);
        });

        // ajax login
        $('.ajax-login').on('submit', function() {
            return $.ajaxlogin.form(this, function(r){ location.href=r; });
        });
    }); // end $(document).ready();

    (function($){


        //****************************************************************************************
        //		AJAX SUBMIT (post)
        // 		client side form validation and serialized ajax submit
        //****************************************************************************************

        // handle IE's lack of implementation!
        String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g,""); }
        String.prototype.ltrim = function() { return this.replace(/^\s+/,""); }
        String.prototype.rtrim = function() { return this.replace(/\s+$/,""); }

        // a declaration
        var ajaxsubmit = {};

        // default values for the plugin
        ajaxsubmit.base = {

            // jQ Ajax Wrapper
            form: function(frm, handle) {

                // form jID and object
                frmid = '#'+frm.id;
                frm = $(frm);


                // vars
                var stop		= false;
                var firstempty	= '';
                // let's build some arrays
                var required	= [];
                var labels		= [];
                var required	= $(frmid+' .required-field');

                // store the text from the labels in the array
                $(frmid+' .required-label').each(function(index) {
                    labels[index] = $(this).text();
                });

                var allfields = "These fields are required:\n";
                required.each(function(index) {

                    // collect each, alert once
                    if(this.value == '' || this.value.length == 0) {

                        // flag and stop submit
                        stop = true;

                        // if not set, get the jID of the first empty required field
                        if(firstempty == '')
                            firstempty = '#'+this.id;

                        // collect the labels
                        allfields += ('    ' + labels[index] + "\n");

                    }
                });
                // stop form submission if we're missing required fields
                if(stop) {

                    // alert the user they missed the fields
                    alert(allfields);

                    // scroll to the first missed field
                    $('html, body').animate({
                        scrollTop: ( $(firstempty).offset().top - 45 )
                    }, 800);


                    // exit
                    return false;

                    // if there are no missing fields, continue submit
                } else {

                    var xhr = $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: frm.serialize()
                    })
                        .success(function(r, textStatus, errorThrown) { $.ajaxsubmit.resHandl(r, handle); /*alert(response +':'+ textStatus +':'+ errorThrown);*/ })
                        //.error(function(r, textStatus, errorThrown) { $.ajaxsubmit.resHandl(r, handle); })
                        .statusCode({
                            302: function() { alert('302 redirection error'); },
                            404: function() { alert('404 page not found'); },
                            500: function() { alert('500 server-side failure'); }
                        });
                    return false;
                }
            },
            resHandl: function(response, handle) {

                var delimiter = '>>>';
                var delimiterPos = null;


                //alert (response); // good debug alert
                delimiterPos = response.indexOf(delimiter);
                if (response == null || $.trim(response).length==0) { // success: blank response (null for Safari, zero length for FireFox)
                    eval(handle)('');
                } else if (delimiterPos>=0) { // success: delimiter exists
                    eval(handle)(response.substr((delimiterPos+delimiter.length), response.length)); // send response after delimiter to handler
                } else {
                    //alert(stripTags(response).trim()); // error: non-blank response and delimiter does not exist
                    alert(response.replace(/<\/?[^>]+>/gi, '').trim());
                    //alert(response);
                }
                return false;
            }
        }
        // extend the properties of the plugin to itself
        $.ajaxsubmit = $.extend({}, ajaxsubmit.base);


        //****************************************************************************************
        //		AJAX SEARCH (get)
        //		serializes search form and handles results
        //****************************************************************************************

        // a declaration
        var ajaxsearch = {};

        // default values for the plugin
        ajaxsearch.base = {

            // jQ Ajax Wrapper
            form: function(frm) {

                // form element id
                frmid = '#'+frm.id;
                // form object
                frm = $(frm);

                $(frm).hide();
                $('.ajax-search-results').show();
                $('.ajax-search-results').html('<div style="color: #999; padding: 20px; text-align: center;"><strong>Searching...</strong><br /><br /><img src="/_static/images/loaders/loader.gif" alt="loader" width="32" height="32" /></div>');

                $.ajax({
                    url: frm.attr('action'),
                    type: 'get',
                    cache: false,
                    data: frm.serialize(),
                    success: function (resp, textStatus, errorThrown) {

                        // regex 'no-matches' class is found in the response, show the form again
                        if(resp.search(/no-matches/i) != -1)
                            $(frm).show();

                        // load the results
                        $('.ajax-search-results').html();
                        $('.ajax-search-results').html(resp);
                        $('.try-again').attr('onclick', "$.ajaxsearch.clear('"+frmid+"')").attr('href', frmid);

                        // rows
                        $('.simple-table-rows tbody tr:odd').addClass('odd');
                        $('.simple-table-rows tbody tr:even').addClass('even');

                    },
                    error: function (resp, textStatus, errorThrown) {
                        // oops!
                        $('.ajax-search-results').html('<div style="color: #999; padding: 20px; text-align: center;"><strong>Unable to complete search...</strong></div>');
                    }
                });
                return false;
            },
            clear: function(frmid) {
                // reset form values
                $(frmid+' input').each(function(index) {
                    if($('#'+this.id).attr('type') != 'submit') {
                        $('#'+this.id).val('');
                    }
                });
                // show
                $(frmid).show();
                $('.ajax-search-results').hide();
            }
        }
        // extend the properties of the plugin to itself
        $.ajaxsearch = $.extend({}, ajaxsearch.base);


    })(jQuery);
</script>


<?php include('../includes/footer.php') ?>

