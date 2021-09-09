<?php

require 'includes/init.php';

$db = new Database();
$conn = $db->getConn();

$users = User::getAll($conn);

if (Auth::isLoggedIn()) {

    Url::redirect('/pdo/user/');

} else {Url::redirect('/pdo/login.php');}
