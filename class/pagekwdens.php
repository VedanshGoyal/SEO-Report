<?php
/**
*pagekwdens.php
*Author: Eric Chen, Email: ericitnz@gmail.com
*Version: 1.0
*/

/*
* Class: PageKwDens API
* Get page's keyword density from external seo tools
*/

class PageKwDens extends PageCore {

	public function __construct($kw,$url){
		//generate API url
		$url="http://tool.chinaz.com/Tools/Density.aspx?kw=".urlencode($kw)."&url=".urlencode($url);
		parent::__construct($url);
	}

	//Get page keywordDensity
	public function keywordDensity(){
		return $keywordDensity = $this->getTextContent('@\<span.*\"\>([\s\S]*)\%@i');
	}
}
?>