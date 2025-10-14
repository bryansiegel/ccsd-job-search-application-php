<?php
#####
#	@ filesystem.php (2009-12-11 11:24 AM carroll)
#	@ previous  
#	+ handles filesystem related functions
#####

# intializer check
$initialized['functions']['filesystem'] = 'OK';

# converts bytes into user readable file size string
function byte_format($b,$p = null) {
    $units = array("b","kb","mb","gb","tb","pb","eb","zb","yb");
    $c=0;
    if(!$p && $p !== 0) {
        foreach($units as $k => $u) {
            if(($b / pow(1024,$k)) >= 1) {
                $r["bytes"] = $b / pow(1024,$k);
                $r["units"] = $u;
                $c++;
            }
        }
        return number_format($r["bytes"],2) . " " . $r["units"];
    } else {
        return number_format($b / pow(1024,$p)) . " " . $units[$p];
    }
}

function arr_to_dir_structure($arr=array()) {
	// http://stackoverflow.com/questions/4843945/php-tree-structure-for-categories-and-sub-categories-without-looping-a-query
    $childs = array();
	
    foreach($arr as $item)
        $childs[$item->pid][] = $item;

    foreach($arr as $item) if (isset($childs[$item->id]))
        $item->childs = $childs[$item->id];
	
    return $childs[0];
}



# eof