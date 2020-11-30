<?php

require_once './func/validate.php';
// エラーハンドリング
$errors = array();
if (!checkStringCode($_POST)) {
    $errors[] = '文字コードが不正です。';
}

list($err, $msg) = isTodoid($_POST['tid']);
if ($err) {
    $errors[] = $msg;
}
list($err, $msg) = isTitle($_POST['title']);
if ($err) {
    $errors[] = $msg;
}
list($err, $msg) = isDueDate($_POST['due-date']);
if ($err) {
    $errors[] = $msg;
}

if (isEmpty($_POST['done-date'])) {
    $doneDate = NULL;
} else {
    $doneDate = $_POST['done-date'];
}

// データベース
try {
    $db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
    if (isset($_POST['submit'])) {
        $stt = $db -> prepare('UPDATE todos SET title=:title, due_date=:due_date, done_date=:done_date WHERE tid=:tid');
        $stt -> bindValue(':title', $_POST['title']);
        $stt -> bindValue(':due_date', $_POST['due-date']);
        $stt -> bindValue(':done_date', $doneDate);
    } elseif (isset($_POST['delete'])) {
        $stt = $db -> prepare('UPDATE todos SET delete_at=NOW() WHERE tid=:tid');
    }
    $stt -> bindValue(':tid', $_POST['tid']);
    $stt -> execute();
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'todo_read.php');    
} catch(PDOException $e) {
    print('<p>処理に失敗しました。<br />'.$e.'<br />もう一度お願いします。</p>');
    print('<a href="todo_read.php">一覧へ</a>');
    die();
}