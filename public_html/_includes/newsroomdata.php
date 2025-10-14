<?php
//I am a cron job.
    include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');
    $_dB_nr_ccsd = mysql_connect('trmysql.ccsd.net', 'httpd', 'H!2m;Leg+z%ZP7KC');
	# trying to do more with MYSQL here, save on PHP side
    global $_dB_ccsd;

	if ($_dB_ccsd && $_dB_nr_ccsd) {
        $query = 'SELECT *'
            # select the table
            .' FROM newsroom.wp_posts'
            # JOIN terms to search for featured
            .' JOIN newsroom.wp_term_relationships'
            .' ON wp_term_relationships.object_id = wp_posts.ID'
            # 95 is the id for Featured Stories
            .' WHERE wp_term_relationships.term_taxonomy_id = 95'
            .' AND wp_posts.post_status = \'publish\''
            # Set order from most recently added
            .' ORDER BY wp_posts.post_date DESC'
            # limit the grab
            .' LIMIT 5';
        # execute
        $result = mysql_query($query, $_dB_nr_ccsd);
        
        # storage
        $initialarray = array();
        while($row = mysql_fetch_assoc($result))
            $initialarray[] = $row;
            
        
        $retarr = array();
        foreach ($initialarray as $row) {
    
            $query = 'SELECT *'
            # select the table
            .' FROM newsroom.wp_posts'
            .' WHERE wp_posts.post_parent = ' . $row['ID']
            .' AND post_type = \'attachment\'';
            # execute
            $result = mysql_query($query, $_dB_nr_ccsd);
            $resultrow = mysql_fetch_assoc($result);
            
            if ($resultrow) {
                $row['img'] = $resultrow['guid'];
            } else {
                $row['img'] = '';
            }
            
            // pulled from wp_db and we do not use or display this content from the article.
            // unset will keep it from causing warnings on the json_encode as it does not display correctly outside of wordpress.
            unset($row['post_content']);
            
            $retarr[] = $row;
        }
        mysql_close($_dB_nr_ccsd);
        # return data
        
        // Final data to be sent to json file /www/apache/htdocs/ccsd/_includes/newsroomdata.json
        if (empty($retarr)) {
            // it will not update json as there was no data grabbed from sql
        } else {
            $newsroomdata = json_encode($retarr);
            file_put_contents('/www/apache/htdocs/ccsd/_includes/newsroomdata.json', $newsroomdata);
        }
        
        
        //CRON now updates trending section to use a cache/json file
        # get the trending cache from mysql
        $trending_q = 'SELECT page, uri FROM 2012ccsd.trending ORDER BY visitors DESC LIMIT 8';
        $trending_r = @mysql_query($trending_q, $_dB_ccsd);
        
        $pages = array();
        while($row = mysql_fetch_assoc($trending_r)) {
            $pages[] = $row;
        }
        
        if (empty($pages)) {
            // it will not update json as there was no data grabbed from sql
        } else {
            $trendingdata = json_encode($pages);
            file_put_contents('/www/apache/htdocs/ccsd/_includes/trending.json', $trendingdata);
        }
        
        // replacing get_pat() function with json cache again
        $article = null;
        $start = 0;
        $limit = 3;
  
        // trying to do more with MYSQL here, save on PHP side
        $query = "SELECT *, FROM_UNIXTIME(post_date, '%W, %M %e, %Y') date"
            # select the table
            .' FROM 2012ccsd.pat_personally'
            # only posts from today and before
            .' WHERE post_date <= UNIX_TIMESTAMP()'
            .($article!=NULL ? " AND unique_url = '$article'" : '' )
            .' ORDER BY post_date DESC'
            ." LIMIT $start, $limit";
            
        # execute
        $result = mysql_query($query, $_dB_ccsd); // or die(handle_error('runtime-level1'));
        
        # storage
        $supearr = array();
        while($release = mysql_fetch_assoc($result)) {
            $supearr[] = $release;
        }
        
        if (empty($supearr)) {
            // it will not update json as there was no data grabbed from sql
        } else {
            $supedata = json_encode($supearr);
            file_put_contents('/www/apache/htdocs/ccsd/_includes/supeintdata.json', $supedata);
        }
    }
?>
