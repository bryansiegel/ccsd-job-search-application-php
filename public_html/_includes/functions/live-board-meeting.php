<?php
/***
#	@ file		: live-board-meeting.php
#	@ location	: /www/apache/htdocs/ccsd/_includes
#	@ author	: vendivel
#	@ purpose	: check if board meeting has been activated
# 	@ created	: 2011-03-08 1009
# 	@ modified	: 2012-03-08 1102 vendivel
#	@ previous	: 2012-03-08 1958 vendivel
#	+ 
#	+ 
***/

global $_dB_ccsd;
$trusteeConnect = mysql_connect('trmysql.ccsd.net', 'httpd', 'H!2m;Leg+z%ZP7KC');

    if (!$trusteeConnect) {
        die('Could not connect: db1' . mysql_error());
    }
if ($_dB_ccsd) {
    $query = "SELECT flash
              FROM ccsd.streaming
             ";
    $result = mysql_query($query,$_dB_ccsd);
    $row = mysql_fetch_array($result);
   //echo '='.$row['flash']; 
    return($row['flash']);
} else {
    return false;
}
if ($_dB_ccsd) {
    $query = "SELECT flash
              FROM ccsd.streaming2
             ";
    $result = mysql_query($query,$_dB_ccsd);
    $row = mysql_fetch_array($result);
   //echo '='.$row['flash']; 
    return($row['flash']);
} else {
    return false;
}
?>
