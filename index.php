<?php
include 'seoinfo.php';
include 'controller/panalysis.php';
$url = isset($_GET['url'])&&(strlen($_GET['url'])!=0)? $_GET['url']:"http://www.web-sun.cn";
$ptype = isset($_GET['ptype'])? $_GET['ptype']: 0;
$domain=explode('/', $url)[2];
$domain=substr($domain, 4);
//$url='http://www.yf-cosmeticspackaging.com/';
//echo strlen(" http://www.omegaclothes.com/en/90-stretch-mesh-layer-sunblock-2016-monokini-pattern-high-cut-sex-women-swimming-wearvs019.html");
//die();
$websun= new PageAnalysis($url);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php  echo $domain; ?><?php  echo $seoInfo['type'][$ptype]; ?>SEO诊断-宇讯网络</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>
	<div class="container-fluid bg-danger">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
        <h1 >网站页面内容SEO诊断</h1>
        <p>此工具用于检查网站页面内容的制作适合符合SEO的要求。</p>
        </div>
        <div action="index.php" class="col-md-7">
          <form method="get">
          <p><span>输入URL：</span>
            <input type="text" name="url">
            <select name="ptype">
              <option value="0">首页</option>
              <option value="1">产品页</option>
              <option value="2">产品中心</option>
              <option value="3">产品分类</option>
              <option value="4">文章页</option>
            </select>
            <input type="submit" value="提交">
          </p>
          <p>分析页面：<?php echo $url; ?></p>
          <p>页面类型：<?php  echo $seoInfo['type'][$ptype]; ?></p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h2>页面Mete信息</h2>
        <p>页面标题： <?php echo $websun->pTitle; ?></p>
        <p>页面关键词：<?php echo  $websun->printKw(); ?></p>
        <p>页面描述： <?php echo $websun->pDescription; ?></p>
        <h2>在google中的显示效果</h2>
          <?php echo  $websun->renderGoogleFormat(); ?>
      </div>
      <div class="col-md-4 well">
        <h2>SEO提示</h2>
        <p>标题的长度：<?php echo $websun->titleLen; ?> 最大长度：70字符</p>
        <p>描述的长度：<?php echo $websun->desLen; ?> 最大长度：160字符</p>
        <p>URL的长度：<?php echo strlen($url) ?> 最大长度：85字符</p>
        <p>超过部分，Google不显示，建议您在最大长度限定之内书写您的内容。</p>
      </div>
    </div>
      <hr>
  </div>
  <div class="container">
  	<h2>Meta关键词分析</h2>
  	<p>页面关键词： <?php echo  $websun->printKw(); ?></p>
  	<p class="text-danger">诊断：<?php echo  $websun->kwAna(); ?></p>
    <p class="text-success">提醒：本报告使用keywords的第一个关键词来分析关键词密度，并<mark>不是</mark>这是最佳关键词，仅作为说明演示使用方法之用。<p>
    <p>①解决方法：写2-3个首页标题有包含优化的关键词即可,关键词之间用,号隔开。<mark>主流搜索引擎已经抛弃keywords标签，所以，你也可以不写。</mark>
    尤其不需要对齐很多关键词在这里，没任何作用。</p>
    <p>②修改方法：<?php  echo $seoInfo['seoKeyword'][$ptype]; ?>   </p>
    <p>图1：<img src="images/admin_<?php echo $ptype ?>.png"></p>
  </div>

  <div class="container">
    <h2>页面meta title标题内容分析</h2>
    <p>页面标题： <?php echo $websun->pTitle; ?></p>
    <p>我们假设您这个页面要优化的关键词是 <mark><?php echo $websun->pKeywords[0]; ?> （下同）</mark>,那么：</p>
    <p class="text-danger">诊断：<?php echo  $websun->titleAna(); ?> </p>
    <p>①解决方法：SEO重要部分，最好写成一句短语形式，短句包含2-3个关键词。</p>
    <p>②修改方法：<?php  echo $seoInfo['seoTitle'][$ptype]; ?>
    </p>  
  </div>

  <div class="container">
    <h2>页面meta description标签内容分析</h2>
    <p>页面描述内容：<?php echo  $websun->pDescription; ?></p>
    <p class="text-danger">诊断：<?php echo  $websun->desAna(); ?> </p>
    <p>①解决方法：写一段字符数小于160个字符（参考“在google中的显示效果”部分）通顺的页面描述，尽可能把标题优化的关键词都包含进去，每个关键词最多可以出现1-3次。</p>
    <p>②修改方法：<?php  echo $seoInfo['seoDes'][$ptype]; ?>
    </p>
  </div>

  <div  class="container">
  	<h2>页面关键词密度</h2>
  	<p class="text-danger">诊断：<?php  echo $websun->kwDensAna(); ?></p>
    <p>说明，关键词密度是一个模糊的概念，没必要一定故意做高的关键词密度。但一般认为关键词密度不应该高于8%。</p>
    <p>可以适当在页面内容中增加关键词，提高关键词密度，但请注意，不要很生硬的去添加，而是用很自然的方式增加。</p>
  </div>

  <div  class="container">
    <h2><?php  echo $seoInfo['type'][$ptype]; ?>特别说明</h2>
    <p><?php  echo $seoInfo['contentSeo'][$ptype]; ?></p>
  </div>

  <div  class="container">
    <h2>文字内容比率</h2>
    <p>诊断： <br/>文字比率是<?php echo  $websun->textRatio; ?></p>
    <p class="text-danger"><?php echo  $websun->textRatioAna(); ?></p>
  </div>

  <div  class="container">
    <h2>结构化标签</h2>
    <p>诊断： <?php echo  $websun->hasH1toH6(); ?></p>
  </div>

  <div class="container-fluid btn-danger">
    <div class="container">
       <h4>宇讯版权所有</h4>
    </div>  
  </div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
