<?php
require_once(__DIR__ . '/../bootstrap.php');
require_once(__DIR__ . '/../include/checkAuth.php');
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(__DIR__ . '/../include/header.php'); ?>
</head>
<body>
<div class="container">
    <?php require_once(__DIR__ . '/../include/top.php'); ?>
    <h1 class="page-header">新增好友</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->friend->friendships->create($name);</pre>
    <div class="well">
        <p>必填參數</p>
        <ul>
            <li><p>name</p><p>使用者名稱, 文字</p></li>
        </ul>
    </div>
    <h3><a href="#execute" name="execute">實際測試</a></h3>
    <form action="#execute" class="form-inline" role="form" method="POST">
      <div class="form-group">
        <label class="sr-only" for="query">使用者名稱(必填)</label>
        <input type="text" class="form-control" id="query" name="query" placeholder="請輸入使用者名稱">
      </div>
      <button type="submit" class="btn btn-primary">新增</button>
    </form>
    <?php
        $query = $_POST['query'];
        if ('' != $query) {
    ?>
    <h3>執行</h3>
    <pre>$pixapi->friend->friendships->create(<?= htmlspecialchars($query) ?>);</pre>
    <h3>執行結果</h3>
    <pre><?php print_r($pixapi->friend->friendships->create($query)); ?></pre>
    <?php
        }
    ?>
</div>
</body>
</html>
