<table width="100%" cellpadding="0" cellspacing="0" border="0" class="trustee-nav-table">
	<tr>
    <?
    # query Trustees
	$query = "SELECT * FROM ccsd.boardTrustees WHERE position IN ('President', 'Vice President', 'Clerk', 'Member')"
		." ORDER BY find_in_set(position, 'President,Vice President,Clerk,Member'), lastname ASC LIMIT 0,7";
	$results = mysql_query($query,$_dB_ccsd) or die(mail('huskiab@nv.ccsd.net', 'header-nav error', $_SERVER['REQUEST_URI']));
	
	while($row = mysql_fetch_assoc($results)) {
	?>
    <td width="120">
    	<div>
    		<a style="display: block;" href="/trustees/details/<?=$row['district']?>">
    			<strong><?=$row['position']?></strong><br />
    			<span><?=$row['prefix']." ".$row['firstname']." ".$row['lastname']?></span><br />
    			<span class="trustee-nav-district">District <?=$row['district']?></span><br />
    			<img class="trustee-nav-img" style="background: #fff url(/trustees/includes/images/nav/<?=strtolower($row['lastname'])?>.png) center center no-repeat;" src="/_static/images/transparent.gif" alt="<?=$row['firstname']." ".$row['lastname']?>" />
    		</a>
    	</div>
    </td>
    <? } ?>
	</tr>
</table>