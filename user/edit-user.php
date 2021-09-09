<?php

require '../includes/init.php';

Auth::requireLogin();

$db = new Database();
$conn = $db->getConn();

if (isset($_GET['id'])) {

    $users = User::getByID($conn, $_GET['id']);

    if (!$users) {
        die("User not found");
    }

} else {
    die("id not supplied, user not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $users->username = $_POST['username'];
    $users->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $users->name = $_POST['name'];
    $users->age = $_POST['age'];
    $users->role = $_POST['role'];

    if ($users->update($conn)) {

        Url::redirect("/pdo/user");

    }
}

?>
<?php require '../includes/header.php';?>

<div class="center">
    <h3>Edit Details</h3>
</div>

<?php require 'user-form.php';?>




<?php require '../includes/footer.php';?>