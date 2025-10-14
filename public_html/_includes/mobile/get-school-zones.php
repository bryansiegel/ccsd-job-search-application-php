<?
// connect to db
mysql_connect ("heraclitus.ccsd.net", "httpd", "httpd");
mysql_select_db ("master");

// define variables
$table_name = "zoning2013";

// prod
if(!$_GET['dev']) {
	$street_num 		= explode('-',$_GET['street_number']);
	$street_name 		= substr(preg_replace("/^[NnSsEeWw]\s/i","",$_GET['street_name']),0,5);		// omit N,S,E,W then use only 5 chars
	$postal_code 		= $_GET['postal_code'];
	$formatted_address	= $_GET['formatted_address'];
} else {
	// test
	$street_num[0] 		= "4727";
	$street_name 		= substr(preg_replace("/^[NESW]\s/i","","W Montara Cir"),0,5);
	$postal_code 		= "89121";
	$formatted_address	= $_GET['formatted_address'];
}

if ($street_num[0] == "undefined") {
	echo "non number";
	exit;
}

// build school names array
$schoolQuery = "select distinct loccode,descript from location where loccode!=0 AND descript!='X' ORDER BY loccode";
$schoolResult = mysql_query($schoolQuery);
while($schoolRow = mysql_fetch_array($schoolResult)) {
	$schoolArray[$schoolRow['loccode']] = $schoolRow['descript'];
}

// build query
$query = "select * from $table_name where street LIKE '%$street_name%' AND $street_num[0] between lowaddress and hiaddress ";
if ($street_num[0] % 2 == 0) {
	$query .= "AND even=1 ";
} else {
	$query .= "AND even=0 ";
}
$query .= "LIMIT 1";

echo $query;

// run query
$result = mysql_query($query);

// build HTML
while($row = mysql_fetch_array($result)) {
	echo '<h2>You\'re in the vicinity of:</h2><h3>'.$formatted_address.'</h3>';
	echo "<table><tr><th>Grade</th><th>School</th></tr>";
	for($i=1;$i<=12;$i++) {
		$grade = 'g'.$i;
		$schoolLoc = $row[$grade];
		echo '<tr><td style="text-align: center;">'.$i.'</td><td style="text-align: center;">'.$schoolArray[$schoolLoc].'</td></tr>';
	}
	echo "</table>";
}
?>