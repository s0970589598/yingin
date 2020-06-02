<?php
    set_time_limit(0);
    if (!empty($_POST)) {
        require '../V3/class/matchName.php';
        $match_name = new matchName;
        $nameing = json_decode($match_name->fire($_POST['first_num'], $_POST['count']), true);
    } else {
        header('Location: nameing.php');
        exit;
    }
    //echo $match_name->fire($_POST['first_num'], 1);

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
					<li><a href="namefate.php">姓名鑑定</a></li>
					<li class="active"><a href="nameing.php">姓名配對</a></li>
                    <li><a href="conamefate.php">公司名鑑定</a></li>
                    <li><a href="#skills">公司名配對</a></li>
					<li><a href="numfate.php">靈數鑑定</a></li>
				</ul>
			</nav>
		</header>
	</div>
</div>

<?php foreach ($nameing as $key => $val ) {?>
<!-- Work Experience -->
<div class="work section second" id="experiences" style="margin:20px;">
	<div >
            <h1>
            <?php

            foreach ($val['num'] as $val1) {
                echo '<span style="font-family:標楷體;font-size:48px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-right:14px">' . str_pad((string)$val1,2,'0',STR_PAD_LEFT)  . '</span>';
            }
            ?> &amp; 評價  <?php echo $val['score'];?>

            </h1>
		<ul class="work-list">
        <?php foreach ($val['chain_sum'] as $key => $val1 ) {
                if (isset($val1['article'])) {
        ?>
			<li><?php echo ($key == 0 ? '乾格和數' : ($key == 1 ? '坤格和數' : ''));?></li>
            <li><a href="#"><?php echo $val1['article']['goodorbad'] . '  ';?></a><?php echo $val1['article']['mean'] . '  -  ' . $val1['article']['yingin10000_num'];?></li>
        <?php
                }
            }
        ?>
        <?php
            foreach ($val['matching'] as $key => $val2) {
                if (isset($val2['article'])) {
        ?>
		<ul class="work-list">
			<li><?php echo($key == 0 ? '乾格配數' : ($key == 1 ? '坤格配數' : '')); ?></li>
			<li><a href="#"><?php echo $val2['article']['goodorbad'] . '  '; ?></a><?php echo $val2['article']['mean'] . '  -  ' . $val2['article']['yingin10000_num']; ?></li>
        </ul>
        <?php
                }
            }
        ?>
        	<li>總格和數</li>
			<li><a href="#"><?php echo $val['total']['article']['goodorbad'] . '  ';?></a><?php echo $val['total']['article']['mean'] . '  -  ' .$val['total']['article']['yingin10000_num'];?></php></li>
        </ul>

	</div>
</div>
<hr />
<?php }?>


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
