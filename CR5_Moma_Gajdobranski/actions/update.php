<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db_connect.php';
require_once '../includes/file_upload.php';

if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $live_at = $_POST['live_at'];
    $vaccinated = $_POST['vaccinated'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $uploadError = '';
    $picture = file_upload($_FILES['picture'], 'pet');
    if ($picture->error === 0) {
        ($_POST["picture"] == "pet.png") ?: unlink("../pictures/$_POST[picture]");
        $sql = "UPDATE `animals` SET `name`='$name',`live_at`='$live_at',`description`='$description',`breed`='$breed',`vaccinated`='$vaccinated',`age`=$age,`size`=$size,`status`='$status', `picture` = '$picture->fileName' WHERE `id` = $id";
    } else {
        $sql = "UPDATE `animals` SET `name`='$name',`live_at`='$live_at',`description`='$description',`breed`='$breed',`vaccinated`='$vaccinated',`age`=$age,`size`=$size,`status`='$status' WHERE `id` = $id";
    }
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    }
    mysqli_close($connect);
} else {
    echo "error";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <?php require_once '../includes/bootstrap.php' ?>

</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../products/update.php?id=<?= $id; ?>'><button class="btn btn-warning"
                    type='button'>Back</button></a>
            <a href='../pages/dashboard.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>