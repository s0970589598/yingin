<?php
    if (!empty($_GET)) {
        require '../V3/class/blog.php';
            $blog = new blog;
			$article_detaile = json_decode($blog->postGetArticleDetail($_GET['article_id']),true);
			$article_category = json_decode($blog->postGetArticleCategory(),true);
    } else {
        header('Location: showagepixnet.php');
        exit;
    }

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
<link rel="stylesheet" href="../css/kube.css" />
<link rel="stylesheet" href="../css/articlemenu.css" />
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
					<li class="active"><a href="javascript:history.back()">回上一頁</a></li>
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
					<div class="jquery-accordion-menu-header">命理東西軍 </div>
					<ul>
						<li class="active"><a href="showagepixnet.php"><i class="fa fa-home"></i> AGE 痞客邦</a></li>
						<li><a href="#"><i class="fa fa-newspaper-o"></i>文章分類<span class="jquery-accordion-menu-label"><?php echo count($article_category); ?></span></a>
							<ul class="submenu">
								<?php foreach($article_category as $category) { ?>
									<li><a href="showagepixnet.php?site_category=<?php echo urlencode($category['site_category']);?>&category=<?php echo urlencode($category['category']);?>">
									<?php echo $category['site_category'] . ' / ' . $category['category'];?> </a></li>
								<?php }?>
							</ul>
						</li>
					</ul>
					<div class="jquery-accordion-menu-footer">Eric Lee</div>
				</div>
		</div>

		<div class="col-sm-9">
				<h1><?php echo $article_detaile['title'];?></h1>
				<br/>
				<?php echo $article_detaile['article'];?>
		</div>
	</div>
</div>


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

