<?php

class breadcrumbs {

	var $convertSpace;
	var $upperCaseWords;
	var $topLevelName;
	var $links;
	
	# find index page in directory
	private function dirIndex($dir) {
		$index = '';
		@$dir_handle = opendir($dir);
		if ($dir_handle) {
			while ($file = readdir($dir_handle)) {
				$query = substr(strtolower($file), 0, 6);
				if ($query == 'index.') {
					$index = $file;
					break;
					}
				}
			}
		return $index;
	}
	
	# make clean array, trim entries and remove blanks
	private function trimArray($array) {
		$clean = array();
		for ($i=0; $i<count($array); $i++) {
			$entry = trim($array[$i]);
			if ($entry != '') $clean[] = $entry;
			}
		return $clean;
	}
	
	# prep folder names if needed
	private function fixNames($string) {
		
		if ($this->convertSpace)
			$string = str_replace('-', ' ', $string);
		if ($this->upperCaseWords)
			$string = ucwords($string);
		
		return $string;
	}
		
	function __construct() {
	
		$this->convertSpace		= true;		# true if script should convert - in folder names to spaces
		$this->upperCaseWords	= false;	# true if script should convert lowercase to initial caps
		$this->topLevelName		= 'home';	# name of home/root directory
		$this->links			= '';		# string carrying returned links for breadcrumbs
		
		$htmlRoot = (isset($_SERVER['DOCUMENT_ROOT'])) ? $_SERVER['DOCUMENT_ROOT'] : '';
		if ($htmlRoot == '') $htmlRoot = (isset($_SERVER['SITE_HTMLROOT'])) ? $_SERVER['SITE_HTMLROOT'] : '';
		
		$pagePath = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : '';
		if ($pagePath == '') $pagePath = (isset($_SERVER['SCRIPT_FILENAME'])) ? $_SERVER['SCRIPT_FILENAME'] : '';
		
		$httpPath = ($htmlRoot != '/') ? str_replace($htmlRoot, '', $pagePath) : $pathPath;
		
		$dirArray = explode('/', $httpPath);
		if (!is_dir($htmlRoot.$httpPath)) $dirArray = array_slice($dirArray, 0, count($dirArray) - 1);
		
		# are we on the index page
		if (strstr($_SERVER['SCRIPT_FILENAME'], 'index.')) $pageCount = (count($dirArray)-1);
		else $pageCount = count($dirArray);
		
		$linkArray = array();
		$thisDir = '';
		$baseDir = ($htmlRoot == '') ? '' : $htmlRoot;
		# link the directories with index files, except the current index (uses $currentPageTitle no link)
		for ($i=0; $i<$pageCount; $i++) {
			$thisDir .= $dirArray[$i].'/';
			$thisIndex = $this->dirIndex($htmlRoot.$thisDir);
			$thisText = ($i == 0) ? $this->topLevelName : $this->fixNames($dirArray[$i]);
			# link the directory/index, if the directory does not have an index. do not output(NULL)
			$thisLink = ($thisIndex != '') ? '<li><a href="'.$thisDir.'">'.$thisText.'</a></li>' : NULL;
			# do not include a link to /directory
			if ($thisLink != '' && !strstr($thisText, 'directory')) $linkArray[] = $thisLink;
		}
		
		return $this->links = (count($linkArray) > 0) ? implode('', $linkArray) : '';
	}
}



//if ($crumbs != '') //echo '<div id="breadcrumbs">'.$crumbs.$separator.$page['title'].'</div>';
//print_r($page['breadcrumbs']);
?>