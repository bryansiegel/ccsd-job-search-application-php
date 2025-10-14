<?
// connect to db
mysql_connect ("heraclitus.ccsd.net", "httpd", "httpd");
mysql_select_db ("ccsd");

// define variables
if($_GET['category'] == "") {
	$section = "All";
}
else {
	$section = $_GET['category'];
}

// build query
$query = "select * from 2012ccsd.newsevents ";
if($section != "All") {
	$query .= "where category='$section'";
}
$query .= " ORDER BY post_date DESC LIMIT 10";

//echo $query;

// run query
$result = mysql_query($query);

include('/www/apache/htdocs/ccsd/_includes/functions/ccsdnews.php');

$posts = get_ccsd_news_and_events($archive = null, $section=NULL, $start = 0, $limit = 10);

foreach($posts as $key => $article) {
	if(empty($archive)) {
						
		# truncate
		$body = $post['description'];
		# extend
		$body .= strlen(strip_tags($post['description']))?' <a href="/district/news/'.$post['unique_url'].'" class="more-link">More</a>':'';
		
		} else
		$body = $post['description'];
		$body = str_replace('<a ', '<a target="_blank"', $body);
	
}

// build HTML
while($row = mysql_fetch_array($result)) {
	$month = date('M', $row['post_date']);
	$day = date('j', $row['post_date']);
	
	$row['description'] = str_replace('<a ', '<a target="_blank"', $row['description']);
	echo '<article class="news-article">';
	echo '<div class="calendar"><div style="background-color: #eeeecc; border-bottom: 1px solid #fff; text-transform: uppercase; color: #999977;">'.$month.'</div><div style="color: #999977; font-size: 200%; font-weight: bold;">'.$day.'</div></div><div class="news-section">'.$row['category'].'</div>';
	echo '<h1 class="news-headline">'.$row['title'].'</h1>';
	echo '<p class="news-body">'.$row['description'].'</p>';
	echo "</article>";
}
?>