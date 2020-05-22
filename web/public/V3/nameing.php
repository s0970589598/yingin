<form action="nameing.php" method="post">
姓氏筆劃 : <input type="test" name="name">
名字字數 : <input type="test" name="count">

　<input type="submit" value="送出表單">
</form>

<?php
	require '../V3/class/matchName.php';
    if (isset($_POST)) {
        $match_name = new matchName;
        $nameing = $match_name->fire($_POST['name'], $_POST['count']);
        print_r($nameing);
    }
?>