<?php
require '../includes/init.php';
Auth::requireLogin();

if (!empty($users->errors)): ?>
<ul>
    <?php foreach ($users->errors as $error): ?>
    <li><?=$error?></li>
    <?php endforeach;?>
</ul>
<?php endif;?>




<?php require '../includes/header.php';?>




<div class="col-md-4 edit center">



    <form method="post">
        <div class="form-group">
            <a href="edit-user-image.php?id=<?=htmlspecialchars($users->id);?>"> <img
                    src="upload/<?=htmlspecialchars($users->id);?>.jpg" alt=" " height="100" width="100"
                    onerror=this.src="upload/error.png"> </a>
        </div>
        <div class="form-group">
            <input type="text" name="username" id="username" placeholder="Username"
                value="<?=htmlspecialchars($users->username);?>" />
        </div>
        
        <div class="form-group">
            <input type="password" name="password" id="password" placeholder="Password" value="" required/>
        </div>
        <div class="form-group">
            <input type="text" name="name" id="name" placeholder="Name" value="<?=htmlspecialchars($users->name);?>" />
        </div>
        <div class="form-group">
            <input type="number" name="age" id="age" placeholder="Age" value="<?=htmlspecialchars($users->age);?>" />
        </div>
        <div class="form-group" >

            <?php if (($_SESSION['role']) == "Admin") {?>
            <div class="form-check form-check-inline">

                <input class="form-check-input" type="radio" name="role" id="role" value="Admin"
                    <?php if ($users->role == "Admin") {?>checked<?php }?>>


                <label class="form-check-label" for="role">Admin</label>
            </div>
            <?php }if (($_SESSION['role']) == "Admin" || ($_SESSION['role']) == "Sr_dev") {?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="role" value="Sr_dev"
                    <?php if ($users->role == "Sr_dev") {?>checked<?php }?>>
                <label class="form-check-label" for="role">Sr_dev</label>
            </div><?php }?>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="role" id="role" value="Jr_dev"
                    <?php if ($users->role == "Jr_dev") {?>checked<?php }?>>
                <label class="form-check-label" for="role">Jr_dev</label>
            </div>

        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-light"><i class="far fa-check-circle fa-3x"
                    style="color: green;"></i></button>
            <a href="index.php"> <button type="button" class="btn btn-light"><i class="far fa-times-circle fa-3x"
                        style="color: red;"></i></button></a>
        </div>

    </form>




</div>



<?php require '../includes/footer.php';?>