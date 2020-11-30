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
    print(implode('<br />', $errors).'<br />[<a href="login_form.php">戻る</a>]');
    die();
}

try {
    // passwordをハッシュ化(ソルトは使用していない)
    $pw = md5($_POST['password']);
    // データベース
    $db = new PDO('mysql:host=db;dbname=phptodo;charset=utf8', 'root', 'root');
    $stt = $db -> prepare('SELECT * FROM users WHERE username=:username AND password=:password');
    $stt -> bindValue(':username', $_POST['username']);
    $stt -> bindValue(':password', $pw);
    $stt -> execute();
    if ($row = $stt -> fetch()) {
        // セッションスタート
        session_start();
        session_regenerate_id(true);
        $_SESSION['username'] = $row['username'];
        $_SESSION['uid'] = $row['uid'];
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'todo_read.php');
    } else {
        print('<p>ユーザーネームかパスワードが異なります。</p>');
        print('<a href="login_form.php">戻る</a>');
        die();
    }
} catch(PDOException $e) {
    print('<p>処理に失敗しました。'.$e.'もう一度お願いします。</p>');
    print('<a href="login_form.php">戻る</a>');
    die();
}