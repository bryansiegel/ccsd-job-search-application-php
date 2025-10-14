<?php

if(class_exists('breadcrumbs') && is_object($breadcrumbs)) {

	//mail('rcarroll@interact.ccsd.net', 'breadcrumbs redeclared', arr_to_str($_SERVER));

} else {
	
	include('/www/apache/htdocs/ccsd/_includes/functions/breadcrumbs.php');
	$breadcrumbs = new breadcrumbs();

}
?>

	<!-- level 2 identity -->
	<div id="l2_wrap">
	
		<div class="breadcrumbs-wrap">
			<ul class="breadcrumbs-list">
				<?php echo $breadcrumbs->links; ?>
			</ul>
		</div>

		<section class="ribbon-title-wrap">
			<span class="ribbon-title ribbon-title<?php echo isset($page['ribbon'][0]) ? '-'.strtolower($page['ribbon'][0]) : '';?>">
				<a href="<?=$page['ribbon'][1]?>"><?php echo $page['ribbon'][0]; ?></a>
			</span>
		</section>
		
	</div>