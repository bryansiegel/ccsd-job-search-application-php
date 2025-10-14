<section>
<!-- 	<h3 class="section-title-lined">Social</h3> -->
	
	<!-- LINKEDIN -->
	<div style="margin: 1em 0;">
	    <div class="sidebar-banner">
            <div><img src="/_static/images/icons/circle-question.png" alt="" class="sidebar-icon"></div>
            <div class="sidebar-question">Have A Question?</div>
            <div class="sidebar-help">Need help? Can't find what you're looking for?</div>
            <div class="sidebar-contact">Contact us at</div>
            <div class="sidebar-phone">702-799-CCSD</div>
        </div>	
	<?php
/*
	if($social[$dept]['linkedin']) {
		echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
		<script type="IN/JYMBII" data-companyid="'.$social[$dept]['linkedin'].'" data-format="inline"></script>';
	}
*/
	?>
	</div>
	
	<!-- TWITTER -->
<!--
	<div style="margin: 1em 0;">
		<a class="twitter-timeline" href="https://twitter.com/<?php echo $social[$dept]['twitter'] ?>" width="260" height="350" data-widget-id="<?php echo $social[$dept]['twitter_id'] ?>">Tweets by <?php echo $social[$dept]['twitter'] ?></a>
	</div>
-->
	
	<!-- FACEBOOK RECOMMENDATIONS -->
<!--
	<div style="margin: 1em 0;">
		<div class="fb-recommendations" data-site="<?php echo $social[$dept]['facebook'] ?>" data-width="260" data-height="300" data-header="false" data-border-color="#ffffff"></div>
	</div>
-->
	
</section>

<?php
/***
#	@ file		: trending-sidebar.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: vendivel
#	@ purpose	: requests data from chart beat for trending sidebar
# 	@ created	: 2012-01-26 1930
# 	@ modified	: 2012-03-22 1006 carroll
#	@ previous	: 2012-02-02 1333 carroll
#	+ 
#	+ 
***/

# include trending api function
//include('/www/apache/htdocs/ccsd/_api/trending/trending.php');

?>
<!-- trending-wrap -->
<!--
<section class="trending-wrap">
	<h3 class="section-title-lined">Quick Links</h3>
-->
	<!--<div style="position: relative; top: -11px; height: 1px; width: 260px; background-color: #ffa333;" id="trend_timer"></div>-->
<!-- 	<ul id="trending_list" class="trending-list"> -->
		
		<!--<p style="color: #999; text-align: center; margin: 1em auto;">Trending will be back soon!</p>-->


        <?php
        /*
         $trending = array();
        $trending_sql = get_trending();

        echo $trending_sql;
        */
        ?>

        <? //trending(); ?>
		<? //include('/www/apache/htdocs/ccsd/_api/trending/index_sub.php'); ?>
<!--
	</ul>
</section>
-->
<!-- /trending-wrap -->