<?php
require_once './func/validate.php';
$errors = array();
// 文字コードのチェック
if (!checkStringCode($_POST)) {
    $errors[] = '文字コードが不正です。';
}
// 入力値のバリデーション
list($err, $msg) = isUsername($_POST['username']);
if ($err) {
    $errors[] = $msg;
}
list($err, $msg) = isPassword($_POST['password']);
if ($err) {
    $errors[] = $msg;
}
// エラー処理
if (count($errors) > 0) {
    print('<p>入力が不正です。</p>');
    print(implode('<br />', $errors).'<br />[<a href="register_form.php">戻る</a>]');
    die();
}

try {
    $username = $_POST['username'];
    // passwordをハッシュ化(ソルトは使用していない)
    $pw = md5($_POST['password']);
    // データベースに登録
    $db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
    $stt = $db -> prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $stt -> bindValue(':username', $username);
    $stt -> bindValue(':password', $pw);
    $stt -> execute();
    // todoページに移動
    session_start();
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
    $_SESSION['uid'] = $db -> lastInsertId();
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'todo_read.php');
} catch(PDOException $e) {
    print('<p>処理に失敗しました。'.$e.'もう一度お願いします。</p>');
    print('<a href="register_form.php">登録</a>');
    die();
}