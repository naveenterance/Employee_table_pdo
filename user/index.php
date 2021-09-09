<?php

require '../includes/init.php';

Auth::requireLogin();

$db = new Database();
$conn = $db->getConn();
$paginator = new Paginator($_GET['page'] ?? 1, 6, User::getTotal($conn));

$users = User::getPage($conn, $paginator->limit, $paginator->offset);

require '../includes/header.php';?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light  bg-transparent  ">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">

            <li class="nav-item ">
                <a class="nav-link " href="#">
                    <h3><?=htmlspecialchars($_SESSION['name'])?></h3>
                </a>
            </li>
            <li class="nav-item">

                <form action="/pdo/logout.php" method="post"
                    onsubmit="return confirm('Are you sure you want to logout?');"><button type="submit"
                        class="btn btn-link" style="color: #ff726f ;"><i class="fas fa-sign-out-alt fa-2x"
                            data-toggle="tooltip" data-placement="top" title="Logout"></i></button></form>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="new-user.php"><i class="fas fa-user-plus fa-2x " data-toggle="tooltip"
                        data-placement="top" title="Add new user"></i></a>


            </li>
            <li>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-lg"><i
                                class="fa fa-search fa-1x"></i></span>
                    </div>
                    <input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm"
                        id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                </div>
            </li>
            <li>


    </div>



    </ul>
    </div>
</nav>







<?php if (empty($users)): ?>
<p>No Users found.</p>
<?php else: ?>

<table class="table " style="background-color: white" id="myTable">
    <thead style="background-color: #e3f2fd" ;>
        <tr>
            <th scope="col">#</th>
            <th scope="col"></th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Age</th>
            <th scope="col"></th>
            <th scope="col"></th>




        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>

            <th scope="row">
                <h6><?=htmlspecialchars($user['id']);?></h6>
            </th>
            <td><a href="edit-user-image.php?id=<?=$user['id'];?>"> <img
                        style="border-radius: 50%;border-color: black ;  border-style: solid; border-width: thin;"
                        src="upload/<?=$user['id'];?>.jpg" alt=" +" height="50" width="50"
                        onerror=this.src="upload/error.png" data-toggle="tooltip" data-placement="top"
                        title="Change this Profile Picture"> </a>


                <?php if ($_SESSION['name'] == $user['name']) {?>

            <td class="active">
                <h4><u><?=htmlspecialchars($user['name']);?></u></h4>
            </td>

            <?php } else {?>

            <td class=>
                <h5><?=htmlspecialchars($user['name']);?></h5>
            </td>

            <?php }?>

            <td>
                <p><?=htmlspecialchars($user['role']);?></p>
            </td>
            <td>
                <p><?=htmlspecialchars($user['age']);?></p>
            </td>


            <?php
if ($_SESSION['role'] == "Admin") {$p = 3;} elseif ($_SESSION['role'] == "Sr_dev") {$p = 2;} else { $p = 1;}
?>

            <?php
if (htmlspecialchars($user['role']) == "Admin") {$q = 3;} elseif (htmlspecialchars($user['role']) == "Sr_dev") {$q = 2;} else { $q = 1;}
?>

            <?php if ($p > $q || $p == 3) {?>



            <td><a href="edit-user.php?id=<?=$user['id'];?>"><i class="fas fa-user-edit  fa-lg" data-toggle="tooltip"
                        data-placement="top" title="Edit this record"></i></a></td>
            <td>
                <form action="delete-user.php?id=<?=$user['id'];?>" method="post"
                    onsubmit="return confirm('Are you sure you want to delete this?');"><button type="submit"
                        class="btn btn-link" style="color: #ff726f ;"><i class="fas fa-trash-alt  fa-lg"
                            data-toggle="tooltip" data-placement="top" title="Delete this record"></i></button></form>
            </td>

            <?php } else {?>

            <td><i class="far fa-times-circle fa-lg"></i></td>
            <td>&nbsp&nbsp<i class="far fa-times-circle fa-lg"></i></td>


            <?php }?>




        </tr>
        <?php endforeach;?>
    </tbody>
</table>

<?php require '../includes/pagination.php';?>

<?php endif;?>



<script>
function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<?php require '../includes/footer.php';?>