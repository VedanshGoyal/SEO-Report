<?php 
include "class/pagecore.php";
include "class/page.php";
include "class/pagekwdens.php";

class PageAnalysis {
	private $pageURL;
	public $pTitle;
	public $titleLen;
	public $pKeywords;
	public $kwCount;
	public $pDescription;
	public $desLen;
	public $kwDens;
	public $textRatio;
	private $h1toh6=array();

	public function __construct($url){
		if(isset($url) && strlen($url)!=0){
		$this->pageURL=$url;
		$page=new Page($url);
			$this->pTitle = $page->getPageTitle();
			$this->titleLen=strlen($this->pTitle);
			$this->pKeywords = $page->getPageKeyword();
			$this->kwCount=count($this->pKeywords);
			$this->pDescription=$page->getPageDescription();
			$this->desLen=strlen($this->pDescription);
			$this->textRatio=$page->getTextRatio();
			$this->h1toh6=array(
				"h1"=>$page->hasPairedTag("h1"),
				"h2"=>$page->hasPairedTag("h2"),
				"h3"=>$page->hasPairedTag("h3"),
				"h4"=>$page->hasPairedTag("h4"),
				"h5"=>$page->hasPairedTag("h5"),
				"h6"=>$page->hasPairedTag("h6")
				);
		}

		if(!empty($this->pKeywords)){
		 $kwApi = new PageKwDens($page->getPageKeyword()[0],$url);
		  $this->kwDens=$kwApi->keywordDensity();
		}
	}

	/* Render google format
	*  Title max length 70, if longer then 70,  cut to 60 and add '...''
  *  Descripiton max length 160, if longer, cut to 150 and add '...'' 
  *  When date is added, Description length: 140
	*/
	public function renderGoogleFormat(){
		$rgHtml='<div><h4 style="color:blue;">';
		
		if($this->titleLen < 70)
			$rgHtml.=$this->pTitle.'</h4><p style="font-size:.8em; color:green;">';
		else
			$rgHtml.=substr($this->pTitle,0,60).' ...</h4><p style="font-size:.8em; color:green;">';
		
		if (strlen($this->pageURL) < 85)
			$rgHtml.=$this->pageURL.'</p><p>';
		else 
			$rgHtml.=substr($this->pageURL,0,75).' ...</p><p>';

    if($this->desLen < 160)
			$rgHtml.=$this->pDescription.'</p></div>';
		else
			$rgHtml.=substr($this->pDescription,0,150).' ...</p></div>';		 
    
    return $rgHtml;
	}

	//输出关键词
	public function printKw(){
		$html="";
			if (strlen($this->pKeywords[0])!=0) {
				foreach ($this->pKeywords as $key => $value) {
					$html.=$value.",";
				}
			}
			else
			$html="未设置";
		return $html;
	}

	// 分析关键词
	public function kwAna(){
		$html="";
		if (strlen($this->pKeywords[0])!=0) {
			if ($this->kwCount == 1)
				$html.="只有一个关键词，但别担心，keyword标签对seo已经没什么用了。但这个报告将用着关键来做分析演示。";
			else if ($this->kwCount >1 &&  $this->kwCount < 4)
				$html.="关键词标签设置正确，但你也可以不设置关键词标签，因为对主流搜索引擎没用了。";
			else 
				$html.="关键词偏多, 不要堆砌关键词";
		}
		else {
		  $this->pKeywords=explode(' ', $this->pTitle);
		  $html.='您没有使用关键词标签，别担心，这对SEO没影响。为了方便演示，我们假设你的关键词是：'.$this->pKeywords[0];
		}
		return $html;
	}

	// 分析标题
	public function titleAna(){
		$html='';
		if (!empty($this->pKeywords)) {
			//标题长度是否合适
			$html.=strlen($this->pTitle) > 32 ? "":"标题偏短，能够覆盖的关键词有限。";

			//标题是否含关键词
			$titleKwCount= substr_count(strtolower($this->pTitle),strtolower($this->pKeywords[0]));
			if ($titleKwCount == 0)
				$html.='<br>1. 错误，您的标题没有包含关键词：'.$this->pKeywords[0];
			else
			  $html.='<br>1. 很好，您的标题出现关键词'.$titleKwCount.'次';

			//分析标题是否堆砌关键词
			if (count(explode(',', $this->pTitle)) > 1 || count(explode('|', $this->pTitle)) > 1)
				$html.='<br> 2. 警告：您使用“关键词,关键词,...”的标题格式，您是否在标题堆砌关键词？我们推荐您最好写成一句有意义的句子。不要堆砌贯关键词。但是如果您目前的标题已经有google排名，请不要做任何修改！';
		}
		return $html;
	}

	// 分析标题
	public function desAna(){
		$html='';
		if(strlen($this->pDescription)!=0){
			$desKwCount= substr_count(strtolower($this->pDescription),strtolower($this->pKeywords[0]));
			if ($desKwCount == 0)
				$html.='错误，您的页面描述（meta descripiton）中没有包含关键词：'.$this->pKeywords[0];
			else
			  $html.='很好，您的页面描述（meta description）中出现关键词'.$desKwCount.'次';
		}
		else
			$html="错误，未设置description, 请按下面的要求设置";
		return $html;
	}

	public function kwDensAna(){
		if(!empty($this->kwDens))
			return '关键词“'.$this->pKeywords[0].'”的密度是 <strong>'.$this->kwDens.'%</strong>';
		else 
			return '错误，密度为0。';
	}	

	public function textRatioAna(){
		if ($this->textRatio <= 0.15)
			return $html="页面文字比率太低，用户和搜索引擎会认为这个页面没啥好看的，建议增加一些文字内容。";
		else if($this->textRatio > 0.15 && $this->textRatio < 0.35)
			return $thml="页面内容文字比率适合，但在不故意的情况下，可以适当增加一些。";
		else
			return $html="页面文字内容占比很好！";
	}

	public function hasH1toH6(){
		$html="";
		$allTagNum=0;
		foreach ($this->h1toh6 as $key => $value) {
			if ($value) {
				$allTagNum++;
				$eachTagNum=0;
				foreach ($value as $key2 => $value2) {
					$html.= "<strong class='text-success'>有".$key."</strong>内容是：".$value2."</br>";
				  $eachTagNum++;
				}
			}
			else {
				$html.="页面<strong class='text-danger'>无".$key."</strong>标签</br>";
			}
		}
		$html.=$allTagNum >1 ? "很好，您页面有使用结构化标签h1,h2..h6。" : "您页面没有很好的使用结固化标签";

		return $html;
	}
}

?>