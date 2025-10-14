<?php

define( 'DS', '/' );


define ( 'FUNCTIONS', dirname(__FILE__).'/functions' );

# load all functions in the functions directory
$functions = opendir(FUNCTIONS);
while($file = readdir($functions)) {
    # include on .php files (to exclude . and ..)
    if(strstr($file, '.php') && !strstr($file, '.LCK'))
        include( FUNCTIONS.DS.$file );
}
# close the directory
closedir($functions);
