<?php
require_once './func/escape.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'login_form.php');
    exit;
}

$db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
$stt = $db -> prepare('SELECT tid, uid, title, due_date, done_date FROM todos WHERE uid=:uid AND delete_at IS NULL ORDER BY done_date ASC');
$stt -> bindValue(':uid', $_SESSION['uid']);
$stt -> execute();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO一覧</title>
    <link rel="stylesheet" type="text/css" href="style/basic.css">
    <link rel="stylesheet" type="text/css" href="style/todo.css">
</head>
<body>
    <div class="container">
        <div>
            <h3><?php print(escape($_SESSION['username'])); ?>さんのTODOリスト</h3>
            <a href="logout.php">ログアウト</a>
            <a href="todo_create.php">TODO作成</a>
        </div>
        <div class="inner-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>期限</th>
                        <th>完了日</th>
                        <th>編集</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($row = $stt -> fetch()) {
                ?>
                <tr>
                    <td><?php print(escape($row['title'])); ?></td>
                    <td><?php print(escape($row['due_date'])); ?></td>
                    <td><?php 
                        if ($row['done_date']) {
                            print(escape($row['done_date']));
                        } else {
                            print('未完了');
                        }
                    ?></td>
                    <td><a href="<?php print('todo_edit.php?tid='.escape($row['tid'])); ?>">編集</a></td>
                </tr>
                <?php
                    }
                ?>
        
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>