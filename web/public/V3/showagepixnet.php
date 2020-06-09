<?php
    require '../V3/class/blog.php';
    $blog = new blog;
    if (!isset($_GET['site_category']) && !isset($_GET['category'])) {
        $article = json_decode($blog->postGetArticle(), true);
    } else {
        $article = json_decode($blog->postGetArticle(urldecode($_GET['site_category']), $_GET['category']), true);
    }

    $article_category = json_decode($blog->postGetArticleCategory(),true);


?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Draco is free PSD &amp; HTML template by @afnizarnur">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/blog.css" />
<link rel="stylesheet" href="../css/articlemenu.css" />
<link rel="stylesheet" href="../css/kube.css" />
<link rel="stylesheet" href="../css/font-awesome.min.css" />
<link rel="stylesheet" href="../css/custom.css" />
<link rel="stylesheet" href="../css/tooltips.css" />
<link rel="shortcut icon" href="../img/favicon.png" />
<link href='https://fonts.googleapis.com/css?family=Playfair+Display+SC:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<style>
	.intro h1:before {
		/* Edit this with your name or anything else */
        content: 'NAME';
    }
    .wordTab .Ft d, .wordTab .Ft img  {font-size:48px;width:48px;line-height:55px;margin-bottom:5px;border:1px dashed #ccc;}
</style>
</head>
<body>
<!-- Navigation -->
<div class="main-nav">
	<div class="container">
		<header class="group top-nav">
			<div class="navigation-toggle" data-tools="navigation-toggle" data-target="#navbar-1">
				<span class="logo">DRACO</span>
			</div>
			<nav id="navbar-1" class="navbar item-nav">
				<ul>
					<li><a href="namefate.php">姓名鑑定</a></li>
					<li><a href="nameing.php">姓名配對</a></li>
                    <li><a href="conamefate.php">公司名鑑定</a></li>
                    <li><a href="conameing.php">公司名配對</a></li>
                    <li><a href="numfate.php">靈數鑑定</a></li>
                    <li class="active"><a href="showagepixnet.php">部落格</a></li>
				</ul>
			</nav>
		</header>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
    <div class="col-sm-3">
            <div class="colors">
                <a class="default" href="javascript:void(0)"></a>
                <a class="blue" href="javascript:void(0)"></a>
                <a class="green" href="javascript:void(0)"></a>
                <a class="red" href="javascript:void(0)"></a>
                <a class="white" href="javascript:void(0)"></a>
                <a class="black" href="javascript:void(0)"></a>
            </div>
            <div id="jquery-accordion-menu" class="jquery-accordion-menu">
                <div class="jquery-accordion-menu-header">文章整理 /
                <?php if (isset($_GET['site_category'])) { echo urldecode($_GET['site_category']);} ?> /
                <?php if (isset($_GET['category'])) { echo urldecode($_GET['category']);} ?>
            </div>
                <ul>
                    <li class="active"><a href="showagepixnet.php"><i class="fa fa-home"></i>痞客邦 - 命理東西軍</a></li>
                    <li><a href="#"><i class="fa fa-newspaper-o"></i>文章分類<span class="jquery-accordion-menu-label"><?php echo count($article_category); ?></span></a>
                        <ul class="submenu">
                            <?php foreach($article_category as $category) { ?>
                            <li><a href="showagepixnet.php?site_category=<?php echo urlencode($category['site_category']);?>&category=<?php echo urlencode($category['category']);?>"><?php echo $category['site_category'] . ' / ' . $category['category'];?> </a></li>
                            <?php }?>
                        </ul>
                    </li>
                </ul>
                <div class="jquery-accordion-menu-footer">Eric Lee</div>
            </div>
        </div>
		<div class="col-sm-9">
            <?php foreach($article as $val) { ?>
            <div class="blog-container">
                <div class="blog-header">
                    <div class="blog-cover">
                    <div class="blog-author">
                        <h3>命理東西軍</h3>
                    </div>
                    </div>
                </div>
                <div class="blog-body">
                    <div class="blog-title">
                    <h1><a href="#"><?php echo $val['title'];?></a></h1>
                    </div>
                    <div class="blog-summary">
                    <p>
                    <a href="showagepixnetdetail.php?article_id=<?php echo $val['article_id'];?>">更多內文……</a>.<br/>
                    </p>
                    </div>
                    <div class="blog-tags">
                    <ul>
                        <li><a href="showagepixnet.php?site_category=<?php echo urlencode($val['site_category']);?>&category=<?php echo urlencode($val['category']);?>"><?php echo $val['site_category'];?></a></li>
                        <li><a href="showagepixnet.php?site_category=<?php echo urlencode($val['site_category']);?>&category=<?php echo urlencode($val['category']);?>"><?php echo $val['category'];?></a></li>
                        <li><a href="<?php echo $val['link'];?>">原文網址</a></li>
                    </ul>
                    </div>
                </div>
                <div class="blog-footer">
                    <ul>
                    <li></li>
                    <li class="shares"><a href="#"><svg class="icon-star">
                            <use xlink:href="#icon-star"></use>
                        </svg><span class="numero">人氣：<?php echo $val['hits'];?></span></a></li>
                    </ul>
                </div>
            </div>
            <?php }?>
        </div>

	</div>
</div>

<script type="text/javascript" src="//use.typekit.net/wtt0gtr.js"></script>
<script type="text/javascript">
  try {
    Typekit.load();
  } catch (e) {}
</script>


<!-- Quote -->
<div class="quote">
	<div class="container text-centered">
		<h1>TimeSweet Yingin Number.</h1>
	</div>
</div>

<!-- Javascript -->
<script src="../js/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../js/typed.min.js"></script>
<script src="../js/kube.min.js"></script>
<script src="../js/site.js"></script>
<script src="../js/articlemenu.js"></script>
<script>
	function newTyped(){}$(function(){$("#typed").typed({
	// Change to edit type effect
	strings: ["帝王姓名學", "姓名鑑定、姓名配對、易經靈數", "公司名鑑定、公司名配對"],

	typeSpeed:90,backDelay:700,contentType:"html",loop:!0,resetCallback:function(){newTyped()}}),$(".reset").click(function(){$("#typed").typed("reset")})});
</script>
</body>
</html>
