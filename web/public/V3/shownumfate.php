<?php
    if (!empty($_POST)) {
        require '../V3/class/tenOfThousands.php';
            $ten_of_thousands = new tenOfthousands;
            $num_fate = $ten_of_thousands->fire($_POST['num']);
    } else {
        header('Location: nameing.php');
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
					<li class="active"><a href="numfate.php">靈數鑑定</a></li>
                    <li><a href="showagepixnet.php">部落格</a></li>
				</ul>
			</nav>
		</header>
	</div>
</div>

<!-- Award & Achievements class=award-->
<div class="work section second" id="achievements" style="margin:100px;">
	<div class="container">
        <h1>鑑定數字 : <?php echo $num_fate['tear_down']['num'];?> &amp;</h1>
		<ul class="work-list">
			<li></li>
			<li style="font-size:24px;" data-tooltip="<?php echo $num_fate['gua']['point'] . '  ';?>"><a href="#"><?php echo $num_fate['gua']['goodorbad'];?>  </a><?php echo $num_fate['gua']['mean'];?> <br/></li>
			<li><hr></li>
			<li>【諸葛神算 : 第 <?php echo $num_fate['gua']['yingin192_id'];?> 條 , 萬數歸宗 : 第 <?php echo $num_fate['gua']['thousand_num'];?> 條】</li>
            <li>【前數】: <?php echo $num_fate['tear_down']['before_num'];?>  【後數】: <?php echo $num_fate['tear_down']['after_num'];?>  【總數】: <?php echo $num_fate['tear_down']['sum_num'];?> </li>
            <li>【上卦】: <?php echo $num_fate['tear_down']['up_gua'];?> 【下卦】:  <?php echo $num_fate['tear_down']['down_gua'];?>【變爻】: <?php echo $num_fate['tear_down']['variety_gua'];?></li>
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
	strings: ["帝王姓名學", "姓名鑑定、姓名配對、易經靈數", "公司名鑑定、公司名配對"],

	typeSpeed:90,backDelay:700,contentType:"html",loop:!0,resetCallback:function(){newTyped()}}),$(".reset").click(function(){$("#typed").typed("reset")})});
</script>
</body>
</html>
