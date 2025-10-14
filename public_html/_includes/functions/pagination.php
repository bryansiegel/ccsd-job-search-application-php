<?php
/***
#	@ file		: pagination.php
#	@ location	: /www/apache/htdocs/ccsd/_includes/functions
#	@ author	: carroll
#	@ purpose	: functions to create pagination or alpha links for a table list and query filtering
# 	@ created	: 2012-01-11 2017
# 	@ modified	: 2012-02-09 2025 carroll
#	@ previous	: 2012-01-20 1051 carroll
#	+ 
#	+ 
***/

function pagin8($query, $_dB_conn, $href='') {

	$retarr = array();
	$html = array();
	
	$paginate_q = "SELECT CEIL((COUNT(*) / 25)) pages, COUNT(*) records FROM ($query) a";
	$paginate_res = mysql_query($paginate_q, $_dB_conn);// or die(mysql_error().$paginate_q);
	$paginate = mysql_fetch_assoc($paginate_res);
	
	
	//$file = basename($_SERVER['PHP_SELF']);
	$retarr['records']	= $paginate['records']; //count($list);
	$retarr['limit']	= 25;
	$pages				= $paginate['pages']; //ceil($retarr['records']/$retarr['limit']);
	$retarr['pages']	= $pages > 0 ? $pages : 1;
	//$current			= $this->current;

	$current 			= isset($_GET['page']) ? $_GET['page'] : 1;
	$retarr['page']		= $current;
	//$retarr['start']	= ($retarr['page'] - 1) * $retarr['limit'];
    $retarr['start']	= 25;
	//$retarr['end']		= $retarr['start'] + $retarr['limit'];
    $retarr['end']		= 25*$current - 25 ;
	$retarr['back']		= $retarr['page'] - 1;
	$retarr['next']		= $retarr['page'] + 1;
	
	$is_abc_url			= !empty($_GET['abc']) ? 'abc='.$_GET['abc'].'&' : null ;
	$href				= $href.'?'.$is_abc_url ;
	
	$is_showall			= $current=='all' ? true : false ;

	$top = '<ul id="pagin8_top" class="num-list">';
	$bottom = '<ul id="pagin8_bot" class="num-list">';
	
    if(!$is_showall) {
		
        # define the true end before proceeding
        $end = $retarr['pages'];

        # no more than 6 pages exist, link all 6 and be done
        if ($retarr['pages'] <= 6) {
            $first = 1;
        # show 1-6 if  1-3 are selected
        } elseif ($current <= 3) {
            $first = 1;
            $retarr['pages'] = 6;
        # show all 6 last results if we're nearing the end
        } elseif ($current > ($retarr['pages'] - 3)) {
            $first = ($retarr['pages'] - 5);
        # shift set to cur-3 and cur+2 if we're in the midst of a large set
        } else {
            $first = ($current - 3);
            if ($retarr['pages'] > ($current + 2)) $retarr['pages'] = ($current + 2);
        }
        # show first link, but not on first page
        if ($current > 1)
            $html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'page=1">&laquo;</a></li>';
        # show prev link, but not on first page
        if ($current > 1) 
            $html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'page='.($current-1).'">&#8249;</a></li>';
        else $html[] = '';
        # build the results page link block
        for ($i=$first;$i<=$retarr['pages'];$i++) {
            # link non-current pages
            if ($i != $current)
            	$html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'page='.$i.'">'.$i.'</a></li>';
            else $html[] = '<li class="num-list-item"><a class="num-link num-current" href="#">'.$i.'</a></li>';
        }
        # show next link, but not on last page
        if ($current < $retarr['pages'])
        	$html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'page='.($current+1).'">&#8250;</a></li>';
        # show last link, but not on last page
        if ($current < $retarr['pages'])
            $html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'page='.$end.'">&raquo;</a></li>';
    } else {
		$html[] = '<li class="num-list-item"><a class="num-link" href="'.$href.'">Paging</a></li>';
	}
		
	$html[] = '</ul>';
	

	$retarr['top'] = $top.implode('', array_values($html));
	$retarr['bottom'] = $bottom.implode('', array_values($html));

	
	return $retarr;
}

function linkABC($query, $column, $_dB_conn, $href='') {
	
	$alpha = "SELECT DISTINCT(SUBSTRING(UCASE($column), 1, 1)) alpha FROM ($query) linkABC";
	$alpha_res = mysql_query($alpha, $_dB_conn);// or die(mysql_error().$alpha);
	$alphalinks = array();
	while($alpha = mysql_fetch_assoc($alpha_res))
		$alphalinks[$alpha['alpha']] = $alpha['alpha'];
	

	$top = '<ul id="abc_top" class="alpha-list">';
	$bottom = '<ul id="abc_bot" class="alpha-list">';
	
	$class = '';
	$current = isset($_GET['abc']) ? $_GET['abc'] : NULL;
	$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$html = array();
	foreach($alphabet as $letter) {
		unset($class);
		# set the class per letter
		$class	= $letter==$current	? ' alpha-current': NULL ;
		$class .= $letter == 'A'	? ' round-left-3px': NULL ;
		$class .= $letter == 'Z'	? ' round-right-3px': NULL ;
		# if the letter has a like% result link it
		$html['top'][] = (in_array($letter, $alphalinks)) ? 
			'<li id="abc'.$letter.random_str(1,'alpha').'" class="alpha-list-item abc'.$letter.'"><a class="alpha-link'.$class.'" href="'.$href.'?abc='.$letter.'">'.$letter.'</a></li>'
			:'<li class="alpha-empty'.$class.'">'.$letter.'</li>';
		$html['bottom'][] = (in_array($letter, $alphalinks)) ? 
			'<li id="abc'.$letter.random_str(1,'numeric').'" class="alpha-list-item abc'.$letter.'"><a class="alpha-link'.$class.'" href="'.$href.'?abc='.$letter.'">'.$letter.'</a></li>'
			:'<li class="alpha-empty'.$class.'">'.$letter.'</li>';
	}
	$end = '</ul>';

	$retarr['top'] = $top.implode('', array_values($html['top'])).$end;
	$retarr['bottom'] = $bottom.implode('', array_values($html['bottom'])).$end;

	return $retarr;
}
?>