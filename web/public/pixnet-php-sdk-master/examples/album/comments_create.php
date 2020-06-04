<?php
require_once(__DIR__ . '/../bootstrap.php');
require_once(__DIR__ . '/../include/checkAuth.php');
$name = $pixapi->getUserName();
$sets = $pixapi->album->sets->search($name)['data'];
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(__DIR__ . '/../include/header.php'); ?>
</head>
<body>
<div class="container">
    <?php require_once(__DIR__ . '/../include/top.php'); ?>
    <h1 class="page-header">新增相簿留言</h1>
    <h3>呼叫方式</h3>
    <pre>$pixapi->album->comments->create($name, $set_id, $comment,$options = array());</pre>
    <div class="well">
        <p>必填參數</p>
        <ul>
            <li><p>set_id</p><p>要留言的相本 id</p></li>
            <li><p>name</p><p>要留言的相本擁有者</p></li>
            <li><p>comment</p><p>留言內容，文字</p></li>
        </ul>
        <p>選填參數</p>
        <ul>
            <li><p>password</p><p>如果指定使用者的相本被密碼保護，則需要指定這個參數以通過授權</p></li>
        </ul>
    </div>
    <h3><a href="#execute" name="execute">實際測試</a></h3>
    <form action="#execute" class="form-horizontal" role="form" method="POST">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="query">請選擇相簿</label>
        <div class="col-sm-5">
            <select class="form-control" id="query" name="set_id">
            <?php if ($sets) { ?>
                <?php foreach ($sets as $set) { ?>
                <option value="<?= $set['id'] ?>"><?= $set['title'] ?></option>
                <?php } ?>
            <?php } else { ?>
                <option disabled selected>無相簿可供測試</option>
            <?php } ?>
            </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="query">留言</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="query" name="comment" placeholder="請輸入留言" value="<?= $_POST['desc']? $_POST['desc'] : '這是 PIXNET_SDK 建立的留言' ?>">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">新增留言</button>
    </form>
    <?php if (!empty($_POST['set_id']) and !empty($_POST['comment'])) { ?>
    <h3>實際執行</h3>
    <pre>
        $pixapi->album->comments->create('<?= $name ?>', <?= htmlspecialchars($_POST['set_id']) ?>, '<?= $_POST['comment'] ?>', $options)
    </pre>
    <h3>執行結果</h3>
    <pre><?php print_r($pixapi->album->comments->create($name, $_POST['set_id'], $_POST['comment'])); ?></pre>
    <?php } ?>
</div>
</body>
</html>
