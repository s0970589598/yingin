<?php
    set_time_limit(0);
    if (!empty($_POST)) {
        require '../V3/class/matchCoName.php';
        $match_co_name = new matchCoName;
        $nameing = json_decode($match_co_name->fire($_POST['first_num'], $_POST['count']), true);
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
					<li><a href="namefate.php">姓名鑑定</a></li>
					<li class="active"><a href="nameing.php">姓名配對</a></li>
                    <li><a href="conamefate.php">公司名鑑定</a></li>
                    <li><a href="conameing.php">公司名配對</a></li>
					<li><a href="numfate.php">靈數鑑定</a></li>
				</ul>
			</nav>
		</header>
	</div>
</div>

<!-- Introduction -->
<div class="intro section" id="about">
	<div style="text-align:center;">
    <span id="typed"></span>
		<div class="units-row units-split wrap">

                    <h1>
                        <?php

                        for ($i = 0; $i < count($nameing['nameing'][0]['num']); $i++) {
                            echo '<div style="display: inline-block;margin: 0px 5px;">';
                            echo '<d style="font-family:標楷體;font-size:32px;width:48px;line-height:60px;border:1px dashed #ccc;padding:5px 35px 10px 10px;margin-bottom: 5px;"></d>';
                            echo '<span style="display: block;background: #eae9e7;border-radius: 2px;padding: 4;line-height: 100%;font-size: 14px;text-align: center;margin-top :10px;">楷體</span>';
                            echo '</div>';
                        }
                            foreach ($nameing['kind_co'] as $key => $val) {
                                echo '<div style="display: inline-block;margin: 0px 5px;">';
                                echo '<d style="font-family:標楷體;font-size:32px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-bottom: 5px;">' . $val['name'] . '</d>';
                                echo '<span style="display: block;background: #eae9e7;border-radius: 2px;padding: 4;line-height: 100%;font-size: 14px;text-align: center;margin-top :10px;">楷體</span>';
                                echo '</div>';
                            }
                        ?>
                        <br><br>
                        <?php
                            for ($i = 0; $i < count($nameing['nameing'][0]['num']); $i++) {
                                echo '<span style="font-family:標楷體;font-size:32px;width:48px;line-height:60px;border:1px dashed #ccc;padding:8px 35px 8px 10px;margin-right:14px"></span>';
                            }
                            foreach ($nameing['kind_co'] as $key => $val ) {
                                echo '<span style="font-family:標楷體;font-size:32px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-right:14px">' . str_pad($val['strokes'],2,'0',STR_PAD_LEFT)  . '</span>';
                            }
                        ?>
                    </h1>

                <h2>公司名配對</h2>
			</div>
			<p>
			</p>
		</div>
	</div>
</div>


<?php foreach ($nameing['nameing'] as $key => $val) {?>
<!-- Work Experience -->
<div class="work section second" id="experiences" style="margin:20px;">
	<div >
            <h1>
            <?php

            foreach ($val['num'] as $val1) {
                echo '<span style="font-family:標楷體;font-size:48px;width:48px;line-height:55px;border:1px dashed #ccc;padding:8px;margin-right:14px">' . str_pad((string)$val1,2,'0',STR_PAD_LEFT)  . '</span>';
            }
            ?> &amp;<?php //echo '評價' . $val['score'];?>

            </h1>
		<ul class="work-list">
        <?php foreach ($val['chain_sum'] as $key => $val1) {
                if (isset($val1)) {
        ?>
			<li><?php echo ($key == 0 ? '乾格和數' : ($key == 1 ? '坤格和數' : ''));?></li>
            <li><a href="#"><?php echo $val1['article']['goodorbad'] . '  ';?></a><?php echo $val1['article']['mean'] . '  -  ' . $val1['article']['yingin10000_num'];?></li>
        <?php
                }
            }
        ?>
        <?php
            foreach ($val['matching'] as $key => $val2) {
                if (isset($val2)) {
        ?>
		<ul class="work-list">
			<li><?php echo($key == 0 ? '乾格配數' : ($key == 1 ? '坤格配數' : '')); ?></li>
			<li><a href="#"><?php echo $val2['article']['goodorbad'] . '  '; ?></a><?php echo $val2['article']['mean'] . '  -  ' . $val2['article']['yingin10000_num']; ?></li>
        </ul>
        <?php
                }
            }
        ?>
        	<li>小總格和數</li>
			<li><a href="#"><?php echo $val['total']['total_num']['article']['goodorbad'] . '  ';?></a><?php echo $val['total']['total_num']['article']['mean'] . '  -  ' .$val['total']['total_num']['article']['yingin10000_num'];?></php></li>
        	<li>大總格和數</li>
			<li><a href="#"><?php echo $val['total']['big_total_num']['article']['goodorbad'] . '  ';?></a><?php echo $val['total']['big_total_num']['article']['mean'] . '  -  ' .$val['total']['big_total_num']['article']['yingin10000_num'];?></php></li>
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
