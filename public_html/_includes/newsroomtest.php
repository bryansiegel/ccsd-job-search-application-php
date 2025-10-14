<?php
//I am a cron job.
    $_dB_nr_ccsd = mysql_connect('trmysql.ccsd.net', 'httpd', 'H!2m;Leg+z%ZP7KC');
	# trying to do more with MYSQL here, save on PHP side
    include('/www/apache/htdocs/ccsd/_includes/ccsd-global.php');
    global $_dB_ccsd;

	if ($_dB_ccsd && $_dB_nr_ccsd) {
        $query = 'SELECT *'
            # select the table
            .' FROM newsroom.wp_posts'
            # JOIN terms to search for featured
            .' JOIN newsroom.wp_term_relationships'
            .' ON wp_term_relationships.object_id = wp_posts.ID'
            # 95 is the id for Featured Stories
            # 266 is the id for Main Featured Story
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
        while($row = mysql_fetch_assoc($result)) {
            $initialarray[] = $row;
        }
        
        $queryMain = 'SELECT *'
            # select the table
            .' FROM newsroom.wp_posts'
            # JOIN terms to search for featured
            .' JOIN newsroom.wp_term_relationships'
            .' ON wp_term_relationships.object_id = wp_posts.ID'
            # 95 is the id for Featured Stories
            # 266 is the id for Main Featured Story
            .' WHERE wp_term_relationships.term_taxonomy_id = 266'
            .' AND wp_posts.post_status = \'publish\''
            # Set order from most recently added
            .' ORDER BY wp_posts.post_date DESC'
            # limit the grab
            .' LIMIT 1';
        # execute
        $resultMain = mysql_query($queryMain, $_dB_nr_ccsd);
        
        # storage
        $initialarrayMain = array();
        while($row = mysql_fetch_assoc($resultMain)) {
            $initialarrayMain = $row;
        }  
        
        $retarr = array();
        
        if ($initialarrayMain) {
    
            $queryMain = 'SELECT *'
            # select the table
            .' FROM newsroom.wp_posts'
            .' WHERE wp_posts.post_parent = ' . $initialarrayMain['ID']
            .' AND post_type = \'attachment\'';
            # execute
            $resultMain = mysql_query($queryMain, $_dB_nr_ccsd);
            $resultrowMain = mysql_fetch_assoc($resultMain);
            
            if ($resultrowMain) {
                $initialarrayMain['img'] = $resultrowMain['guid'];
            } else {
                $initialarrayMain['img'] = '';
            }
            
            // pulled from wp_db and we do not use or display this content from the article.
            // unset will keep it from causing warnings on the json_encode as it does not display correctly outside of wordpress.
            unset($initialarrayMain['post_content']);
            
            $retarr[] = $initialarrayMain;
        }

        foreach ($initialarray as $key => $val) {
            
            if ($val['ID'] == $initialarrayMain['ID']) {
                // Do Nothing, Skip
            } else {
        
                $query = 'SELECT *'
                # select the table
                .' FROM newsroom.wp_posts'
                .' WHERE wp_posts.post_parent = ' . $val['ID']
                .' AND post_type = \'attachment\'';
                # execute
                $result = mysql_query($query, $_dB_nr_ccsd);
                $resultrow = mysql_fetch_assoc($result);
                
                if ($resultrow) {
                    $val['img'] = $resultrow['guid'];
                } else {
                    $val['img'] = '';
                }
                
                // pulled from wp_db and we do not use or display this content from the article.
                // unset will keep it from causing warnings on the json_encode as it does not display correctly outside of wordpress.
                unset($val['post_content']);
                
                $retarr[] = $val;
            }
        }
        mysql_close($_dB_nr_ccsd);
        # return data
    }
?>