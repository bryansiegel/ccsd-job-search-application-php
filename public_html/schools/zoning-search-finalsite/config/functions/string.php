<?php
#####
#	@ string.php (2012-04-25 1426 carroll)
#	@ previous (2010-07-2 1105 carroll)
#	+ string functions
#	+ manipulation, truncation etc
#####

# intializer check
$initialized['functions']['string'] = 'OK';

# generate random string
function random_str($length,$seeds) {
    # seed types
    $seedings['alpha'] 		= 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] 	= '0123456789';
    $seedings['alphanum'] 	= 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
    $seedings['hexidec'] 	= '0123456789abcdef';
    $seedings['password'] 	= 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789!@#$%^&*()_+-={}\/;:<>';

    # choose a seed
    if (isset($seedings[$seeds]))
        $seeds = $seedings[$seeds];

    # seeder
    mt_srand(crc32(microtime()));

    # seed generator
    $sid = '';
    $seeds_count = strlen($seeds);
    for ($i = 0; $length > $i; ++$i) {
        $sid .= $seeds {
        	mt_rand(0, $seeds_count - 1)
		};
    }
	$sid = ltrim($sid, '0');
    return $sid;
}
# shorten a string to a specific character limit, with a clean last word
function str_shorten_words($str, $limit, $replace=TRUE) {
	# check if the string is longer than the limit
	if(strlen($str)>$limit)
		$trunc = substr($str, 0, $limit); # truncate the string to the limit
	else return $str; # if its not to long, return it now
	# take it apart
	$words = explode(" ", $trunc);
	# get the last word
	$last = end($words);
	# remove the last whole word, so the string does not end in a partial wor...
	foreach($words as $key=>$word)
		if($word==$last) unset($words[$key]);
	# put it all back together
	$newstr = implode(' ', $words);
	# cleanup the last character
	$newstr = rtrim($newstr, ' .,!?:;")');
	$newstr = ($replace)?$newstr.'...':$newstr;

	return $newstr;
}
# shorten phrases to a defined limit
function str_shorten($str, $limit, $replace=TRUE) {
	if (strlen($str) > $limit) {
		if ($replace) return substr($str, 0, ($limit-2)).'...';
		else return substr($str, 0, ($limit-2));
	}
	return $str;
}
# replace all linebreaks with one whitespace.
function strip_crlf($string) {
  return (string)str_replace(array("\r", "\r\n", "\n"), '', $string);
}
# parses content body for links and creates href tags
function parse_links($content){
	$content = preg_replace('/\\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]/i', "<a href=\"\\0\" target=\"_blank\">\\0</a>", $content);
	return $content;
}

# eof