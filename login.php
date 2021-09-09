<?php

require 'includes/init.php';

$db = new Database();
$conn = $db->getConn();

$a = false;

$users = User::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($users as $user) {

        /*if ($_POST['username'] == $user['username'] && $_POST['password'] == $user['password']) {*/


if ($_POST['username'] == $user['username'] && password_verify($_POST['password'], $user['password'])){


            Auth::login();

            $a = true;
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];

         
        }
        if ($a) {

            Url::redirect('/pdo/');} else {

            $error = "Incorrect ,try again ";

        }

    }}

?>


<?php require 'includes/header.php';?>







    <div class="col-md-4 login ">
                    <h2>Login</h2>
                    <?php if (!empty($error)): ?>
                    <h5 style="color: red;"><?=$error?></h5>
                    <?php endif;?>

                    <form method="post">
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username " value="" />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password " value="" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-light"><i class="fas fa-sign-out-alt fa-3x" style="color: green;"></i></button>
                        </div>

                    </form>

    </div>

<?php require 'includes/footer.php';?>
