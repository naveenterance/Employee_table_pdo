<?php

require '../includes/init.php';

Auth::requireLogin();

$db = new Database();
$conn = $db->getConn();


if (isset($_GET['id'])) {

    $user = User::getByID($conn, $_GET['id']);

    if (!$user) {
        Url::redirect('/pdo/user/new-user.php');
    }

} else {
    die("id not supplied, user not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        if (empty($_FILES)) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;

            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File is too large (from the server settings)');
                break;

            default:
                throw new Exception('An error occurred');
        }

        // Restrict the file size

        $filename = $_FILES["file"]["name"];
        $file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
        $file_ext = substr($filename, strripos($filename, '.')); // get file extension
        $filesize = $_FILES["file"]["size"];
        $allowed_file_types = array('.png', '.jpeg', '.jpg');

        if (in_array($file_ext, $allowed_file_types) && ($filesize < 1000000)) {
            // Rename file
            $newfilename = $user->id . $file_ext;

            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
            Url::redirect('/pdo/user/');

        } elseif (empty($file_basename)) {
            // file selection error
            echo "Please select a file to upload.";
        } elseif ($filesize > 1000000) {
            // file size error
            echo "The file you are trying to upload is too large.";
        } else {
            // file type error
            echo "Only these file typs are allowed for upload: " . implode(', ', $allowed_file_types);
            unlink($_FILES["file"]["tmp_name"]);
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<?php require '../includes/header.php';?>









<div class="container mt-3">
    <h2>Upload Profile Picture</h2>
    <form method="post" enctype="multipart/form-data">


        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="file" name="file">
            <label class="custom-file-label" for="file">Choose file</label>
        </div>


        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>






<?php require '../includes/footer.php';?>