<?php
require_once './func/validate.php';
// エラーハンドリング
$errors = array();
if (!checkStringCode($_POST)) {
    $errors[] = '文字コードが不正です。';
}

list($err, $msg) = isUid($_POST['uid']);
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

if (count($errors) > 0) {
    print('<p>入力が不正です。</p>');
    print(implode('<br />', $errors).'<br />[<a href="todo_create.php">戻る</a>]');
    die();
}
// データベース処理
try {
    $db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
    $stt = $db -> prepare('INSERT INTO todos (uid, title, due_date, create_at) VALUES (:uid, :title, :due_date, NOW())');
    $stt -> bindValue(':uid', $_POST['uid']);
    $stt -> bindValue(':title', $_POST['title']);
    $stt -> bindValue(':due_date', $_POST['due-date']);
    $stt -> execute();
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'todo_read.php');
} catch(PDOException $e) {
    print('<p>処理に失敗しました。<br />'.$e.'<br />もう一度お願いします。</p>');
    print('<a href="todo_create.php">登録</a>');
    die();
}