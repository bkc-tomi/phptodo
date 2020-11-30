<?php
require_once './func/escape.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'login_form.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作成</title>
    <link rel="stylesheet" type="text/css" href="style/basic.css">
    <link rel="stylesheet" type="text/css" href="style/form.css">
</head>
<body>
    <div class="container">
        <div class="inner-container">
            <h3>TODO作成</h3>
            <form method="POST" action="create.php">
                <div>
                    <label for="title">タイトル</label>
                    <input type="text" id="title" name="title" />
                </div>
                <div>
                    <label for="due-date">期限</label>
                    <input type="date" id="due-date" name="due-date" />
                </div>
                <input type="hidden" id="uid" name="uid" value="<?php print(escape($_SESSION['uid'])); ?>" />
                <input type="submit" value="登録" />
            </form>
            <a href="todo_read.php">TODO一覧へ</a>
        </div>
    </div>

</body>
</html>