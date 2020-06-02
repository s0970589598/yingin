<?php
    if (!empty($_POST)) {
        require '../V3/class/chineseName.php';
        $chinese_name = new chineseName;
        $name_fate = json_decode($chinese_name->fire($_POST['name']), true);
    } else {
        header('Location: namefate.php');
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
<link rel="stylesheet" href="../css/kube.css" />
<link rel="stylesheet" href="../css/font-awesome.min.css" />
<link rel="stylesheet" href="../css/custom.css" />
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
					<li class="active"><a href="namefate.php">姓名鑑定</a></li>
					<li><a href="nameing.php">姓名配對</a></li>
                    <li><a href="conamefate.php">公司名鑑定</a></li>
                    <li><a href="#skills">公司名配對</a></li>
					<li><a href="numfate.php">靈數鑑定</a></li>
				</ul>
			</nav>
		</header>
	</div>
</div>

<!-- Introduction -->
<div class="intro section" id="about">
	<div class="container" style="text-align:center;">
    <span id="typed"></span>
		<div class="units-row units-split wrap">
			<div class="unit-20">
                <img src="../img/ava.jpg" alt="Avatar">
                <br>
                <span style="font-size:30px;padding:1px;margin-top:20px;">評價  <?php echo $name_fate['score'];?></span>
			</div>
			<div class="unit-80">
                    <h1>
                        <?php
                            foreach ($name_fate['disintegration_name'] as $key => $val) {
                                echo '<div style="display: inline-block;margin: 0px 5px;">';
                                echo '<d style="font-family:標楷體;font-size:48px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-bottom: 5px;">' . $val['name'] . '</d>';
                                echo '<span style="display: block;background: #eae9e7;border-radius: 2px;padding: 4;line-height: 100%;font-size: 14px;text-align: center;margin-top :10px;">楷體</span>';
                                echo '</div>';
                            }
                        ?>
                        <br><br>
                        <?php
                            foreach ($name_fate['disintegration_name'] as $key => $val ) {
                                echo '<span style="font-family:標楷體;font-size:48px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-right:14px">' . str_pad($val['strokes'],2,'0',STR_PAD_LEFT)  . '</span>';
                            }
                        ?>
                    </h1>
                <div>
                <h2>姓名鑑定報告</h2>
			</div>
			<p>
			</p>
		</div>
	</div>
</div>

<!-- Work Experience -->
<div class="work section second" id="experiences">
	<div class="container">
        <h1>和數 &amp;</h1>
       <?php foreach ($name_fate['composite_num'] as $key => $val ) {
                if (isset($val['article'])) {
       ?>
		<ul class="work-list">
			<li><?php echo ($key == 0 ? '乾格和數' : ($key == 1 ? '坤格和數' : ''));?></li>
			<li><a href="#"><?php echo $val['article']['goodorbad'] . '  ';?></a><?php echo $val['article']['mean'] . '  -  ' . $val['article']['yingin10000_num'];?></li>
        </ul>
        <?php
                }
            }
        ?>
	</div>
</div>

<!-- Award & Achievements class=award-->
<div class="work section second" id="achievements">
	<div class="container">
        <h1>配數 &amp;</h1>
        <?php
            foreach ($name_fate['matching_num'] as $key => $val) {
                if (isset($val['article'])) {
        ?>
		<ul class="work-list">
			<li><?php echo($key == 0 ? '乾格配數' : ($key == 1 ? '坤格配數' : '')); ?></li>
			<li><a href="#"><?php echo $val['article']['goodorbad'] . '  '; ?></a><?php echo $val['article']['mean'] . '  -  ' . $val['article']['yingin10000_num']; ?></li>
        </ul>
        <?php
                }
            }
        ?>
	</div>
</div>
<!-- Technical Skills -->
<div class="work section second" id="skills">
	<div class="container">
		<h1>總格 &amp;</h1>
		<ul class="work-list">
			<li>總格和數</li>
			<li><a href="#"><?php echo $name_fate['total_num']['article']['goodorbad'] . '  ';?></a><?php echo $name_fate['total_num']['article']['mean'] . '  -  ' .$name_fate['total_num']['article']['yingin10000_num'];?></php></li>
		</ul>
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
<script src="../js/typed.min.js"></script>
<script src="../js/kube.min.js"></script>
<script src="../js/site.js"></script>
<script>
	function newTyped(){}$(function(){$("#typed").typed({
	// Change to edit type effect
	strings: ["帝王姓名學", "姓名鑑定、姓名配對、易經靈數"],

	typeSpeed:90,backDelay:700,contentType:"html",loop:!0,resetCallback:function(){newTyped()}}),$(".reset").click(function(){$("#typed").typed("reset")})});
</script>
</body>
</html>
