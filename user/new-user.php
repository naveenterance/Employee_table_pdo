<?php

require '../includes/init.php';

Auth::requireLogin();

$users = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $conn = $db->getConn();

    $users->username = $_POST['username'];
    $users->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $users->name = $_POST['name'];
    $users->age = $_POST['age'];
    $users->role = $_POST['role'];

    if ($users->create($conn)) {

        Url::redirect("/pdo/user");

    }
}

?>
<?php require '../includes/header.php';?>

<div class="center">
    <h3>Add User</h3>
</div>

<?php require 'user-form.php';?>

<?php require '../includes/footer.php';?>