<?php
require_once './func/escape.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'login_form.php');
    exit;
}

$db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
$stt = $db -> prepare('SELECT * FROM todos WHERE tid=:tid AND uid=:uid');
$stt -> bindValue(':tid', $_GET['tid']);
$stt -> bindValue(':uid', $_SESSION['uid']);
$stt -> execute();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集</title>
    <link rel="stylesheet" type="text/css" href="style/basic.css">
    <link rel="stylesheet" type="text/css" href="style/form.css">
</head>
<body>
    <div class="container">
        <div class="inner-container">
            <h3>TODO編集</h3>
            <?php
            if ($row = $stt -> fetch()) {
            ?>
                <form method="POST" action="edit.php">
                    <div>
                        <label for="title">タイトル</label>
                        <input type="text" id="title" name="title" 
                        value="<?php print(escape($row['title'])) ?>"
                        />
                    </div>
                    <div>
                        <label for="due-date">期限</label>
                        <input type="date" id="due-date" name="due-date" 
                        value="<?php print(escape($row['due_date'])) ?>"
                        />
                    </div>
                    <div>
                        <label for="done-date">完了</label>
                        <input type="date" id="done-date" name="done-date" 
                        value="<?php print(escape($row['done_date'])) ?>"
                        />
                    </div>
                    <input type="hidden" id="tid" name="tid" value="<?php print(escape($row['tid'])); ?>" />
                    <input type="submit" id="submit" name="submit" value="登録" />
                    <br />
                    <input type="submit" id="delete" name="delete" value="削除" onclick="return confirm('本当に削除してもいいですが？')"/>
                </form>
            <?php
            } else {
                print('データを取得出来ませんでした。');
            }
            ?>
            <a href="todo_read.php">TODO一覧へ</a>
        </div>
    </div>

</body>
</html>