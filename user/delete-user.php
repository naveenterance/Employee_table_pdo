<?php

require '../includes/init.php';

Auth::requireLogin();

$db = new Database();
$conn = $db->getConn();

if (isset($_GET['id'])) {

    $users = User::getByID($conn, $_GET['id']);

    if (!$users) {
        die("user not found");
    }

} else {
    die("id not supplied, user not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($users->delete($conn)) {
        unlink("upload/".$_GET['id'].".jpg");
        Url::redirect("/pdo/user");

    }
}