<form action="namefate.php" method="post">
鑑定名稱 : <input type="test" name="name">
　<input type="submit" value="送出表單">
</form>

<?php
	require '../V3/class/chineseName.php';
    if (isset($_POST)) {
        $chinese_name = new chineseName;
        $name_fate = $chinese_name->fire($_POST['name']);
        print_r($name_fate);
    }
?>