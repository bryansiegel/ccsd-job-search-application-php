<?php
/***
#	@ file		: ccsd-global.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: carroll
#	@ purpose	: global config and values for ccsd home page
# 	@ created	: 2011-12-20 1009
# 	@ modified	: 2012-02-03 1102 carroll
#	@ previous	: 2012-01-06 1958 carroll
#	+ 
#	+ 
***/

function datatable_cntrl($default) {
		
	$cntrl['tableid'] = isset($_GET['dTid']) ? $_GET['dTid'] : 'dT'.rand(0,10000) ;
	
	$cntrl['index']				= isset($_GET['abc']) ? strtolower($_GET['abc']) : NULL ;
		
	$order = array('ASC'=>'&#9650;','DESC'=>'&#9660;');
	$order_switch = array('ASC'=>'DESC','DESC'=>'ASC');
	
	$cntrl['order']['default']	= $default;
	$cntrl['order']['column']	= isset($_GET['sort']) ? $_GET['sort'] : $default ;
	$cntrl['order']['order']	= isset($_GET['order']) ? $_GET['order'] : 'ASC' ;
	$cntrl['order']['switch']	= $order_switch[$cntrl['order']['order']];
	
	$cntrl['limit']['start']	= isset($_GET['page']) ? ($_GET['page'] - 1) * 25 : 0 ;
	$cntrl['limit']['end']		= isset($_GET['page']) ? 25 : 25 ;
	
	return (object) $cntrl;
}