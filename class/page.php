<?php
class Page extends PageCore {

//Get page title
	public function getPageTitle(){
		return $pageTitle = $this->getTextContent('#\<title\>(.*)\<\/title\>#ims');
	}

	//Get page keywords
	public function getPageKeyword(){
		$pageDescription = $this->getTextContent('@\<meta\s.*name\=\"keywords\"\s*.*content\=\"([\s\S]*)\"\s*>*\/\>@i');
		return $pageDescription = explode(',', $pageDescription);
	}

	//Get page description
	public function getPageDescription(){
		return $pageDescription = $this->getTextContent('@\<meta\s.*name\=\"description\"\s*.*content\=\"([\s\S]*)\"\s*>*\/\>@i');	
	}

	//Get the text ratio of the page
	public function getTextRatio(){
		$pageAll=file_get_contents($this->pageURL); // content including html
		$pageText=strip_tags($pageAll); // text content
		return strlen($pageText)/strlen($pageAll);
	}

	//是否有$h的html标签
	//@prama $h string htm 标签，如h1
	public function hasPairedTag($h){
		$hasH1=parent::getAllContent('@\<'.$h.'[\s\w\=\-\"\']*\>(.*?)\<\/'.$h.'\>@is');
		return isset($hasH1) ?  $hasH1 : false;
	}

	// Get the density of a keyword
	// parameter: string $kw, keyword
	/*public function keywordDensity($kw='外贸网站建设'){
		if($kw) {
			$pageText=file_get_contents($this->pageURL);
			$keywordCount=substr_count($pageText,$kw);
			$pageLength=strlen(strip_tags($pageText));
			return $keywordDensity=((strlen($kw)*$keywordCount)/$pageLength)*100;
		}
	}*/
}

?>

