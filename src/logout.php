<?php

session_start();
$_SESSION= array();
session_destroy();

header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'login_form.php');