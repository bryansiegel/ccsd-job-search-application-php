<?php
/***
#	@ file		: index.php
#	@ location	: /www/apache/htdocs/ccsd/employees/prospective/information
#	@ author	: nachti	
#	@ purpose	: useful employee information 
# 	@ created	: 2012-01-20 0920
# 	@ modified	: 2014-05-27 0928 a-to-the-double-l-a-to-the-n 
#	@ previous	: 2014-02-12 1100 a-to-the-double-l-a-to-the-n
#	+ 
#	+ 
***/
include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');


# set the page parameters
$page['ribbon'] = array('employees', $home->url.'/employees/');
$page['title'] = 'Fingerprinting Payment';
$page['description'] = 'Rich, full-featured site offering school, employment, and community education program information.';

# include the site header
include($home->inc['header']);
# include the breadcrumbs
include($home->inc['breadcrumbs']);
?>
<meta name="robots" content="noindex, nofollow">
		<!-- content -->
		<div id="content_wrap" class="content-wrap">

			<div id="main_content_wrap" class="main-content-full-wrap" role="main content">
				<section class="content-holder">
				<h1>Fingerprinting Payment Admin</h1>

                   <h2><?php echo $_SESSION['title']; ?></h2>

                    <form action="list.php" method="post" name="pay" id="pay">
                        <p>Search by first name, last name or last four of social:<br />
                            <input name="search" type="text"  value="<?php echo $_POST['search']; ?>"></p>
                       <p><input name="Submit" type="submit"  value="Search"></p>
                    </form>


				</section>
			</div> <!-- / main_content_wrap -->


		</div> <!-- /content-wrap -->

<?php include($home->inc['footer']); ?>