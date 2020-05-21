<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<form action="excel_write_me2_post.php" method="post" name="sa" target="_blank">
選擇年份	
<select name="year">
<?php for ($y=2017;$y<=2030;$y++){?>
	<option value="<?php echo $y; ?>"><?php echo $y ?>年</option>
<?php } ?>
</select>

選擇月份	
<select name="month">
<?php for ($a=1;$a<=12;$a++){?>
	<option value="<?php echo $a; ?>"><?php echo $a ?>月</option>
<?php } ?>
</select>
當月天數
<select name="date1">
	<option value="30">30日</option>
	<option value="31">31日</option>
	<option value="28">28日</option>
	<option value="29">29日</option>
</select>
<br><br>	
輸入項目<br>
<?php for ($c=0;$c<=99;$c++){
	if($c<9){$zero='0';}else{ $zero='';}
		
		echo $zero.($c+1).'.';
	
?>
<input   type="text" name="eitem[<?php echo $c ;?>]" value="">
<br><br/>
<?php } ?>
<br/><hr/>

<input type="submit" value="ok">

</form>

</body>
</html>