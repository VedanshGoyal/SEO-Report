<?php
/**
*PageCore.php
*Author: Eric Chen, Email: ericitnz@gmail.com
*Version: 1.0
*/

/*
* Class: PageCore
*/

class PageCore {
	public $pageURL="";
	private $pageContent="";

	public function __construct($url){
		$this->pageURL=$url;
	}

	// Get page Content
	public function getPageContent(){
		return @$this->pageContent=fopen($this->pageURL, "r");
	}

	// Get age URL
	public function getPageUrl(){
		return $this->pageURL;
	}

	/*
	*Get text content of a signle DOM element
	*Prameter:$reg regular expression
	*Return: text / 
	*2016-6-25
	*/
	public function getTextContent($reg){
		if($file = $this->getPageContent()) {
			while (!feof ($file)) {
    		$line = fgets ($file, 1024);
    		if (preg_match ($reg, $line, $out)) { // preg_match_all
        $text = $out[1];
         	if($text)
        		return $text;
        	else 
        		return false;
    		}
			}
			fclose($file);
		} 
		else 
		return "Cannot connect to the URL." ;
	}

	/*
	*Get text content of mutiple DOM elements
	*Prameter:$reg regular expression
	*Return: $text string 
	*2016-6-25
	*/
	public function getAllContent($reg){
		if($file = file_get_contents($this->pageURL)) {
    		if (preg_match_all($reg, $file, $out)) { // preg_match_all
         	if($out)
        		return $out[1];
        	else 
        		return false;
    		}
		} 
		else 
		return "Cannot connect to the URL." ;
	}
}
?>