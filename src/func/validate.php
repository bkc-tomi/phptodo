<?php

function checkStringCode($var) {
    foreach ($var as $key => $value) {
        if (is_array($value)) {
            $value = implode('', $value);
        }
        if (!mb_check_encoding($value)) {
            return false;
        }
    }
    return true;
}

function isEmpty(string $var) {
    if (trim($var) == '') {
        return true;
    }
    return false;
}

function isUsername(string $username) {
    if (isEmpty($username)) {
        return [true, 'ユーザーネームが入力されていません。'];
    }
    if (mb_strlen($username) > 30) {
        return [true, 'ユーザーネームは30文字以内でお願いします。'];
    }
    return [false, ''];
}

function isPassword(string $password) {
    if (isEmpty($password)) {
        return [true, 'パスワードが入力されていません。'];
    }
    $reg = '/^[0-9a-zA-Z]*$/';
    if (!preg_match($reg, $password)) {
        return [true, 'パスワードは半角英数字でお願いします。'];
    }
    if (mb_strlen($password) < 4) {
        return [true, 'パスワードは4文字以上でお願いします。'];
    }
    return [false, ''];
}

function isUid($uid) {
    if (isEmpty($uid)) {
        return [true, 'ユーザーが指定されていません。'];
    }
    if ((int)$uid <= 0) {
        return [true, 'ユーザー指定が不適切です。'];
    }
    return [false, ''];
}
function isTodoid($todoid) {
    if (isEmpty($todoid)) {
        return [true, 'TODOが指定されていません。'];
    }
    if ((int)$todoid <= 0) {
        return [true, 'TODO指定が不適切です。'];
    }
    return [false, ''];
}

function isTitle($title) {
    if (isEmpty($title)) {
        return [true, 'タイトルが入力されていません。'];
    }
    if (mb_strlen($title) > 100) {
        return [true, 'タイトルは100文字以内でお願いします。'];
    }
    return [false, ''];
}

function isDueDate($dueDate) {
    if (isEmpty($dueDate)) {
        return [true, '期限が設定されていません。'];
    }
    $date = strtotime($dueDate);
    if (!$date) {
        return [true, '無効な日付です。'];
    }
    $today = strtotime(date('Y-m-d'));
    if ($date < $today) {
        return [true, '期限は今日以降を選択してください。'];
    }
    return [false, ''];
}
