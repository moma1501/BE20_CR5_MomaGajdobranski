<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../pages/homepage.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../includes/db_connect.php';
require_once '../includes/file_upload.php';

if ($_POST) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $live_at = $_POST['live_at'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $vaccinated = $_POST['vaccinated'];
    $status = $_POST['status'];

    $uploadError = '';
   
    $picture = file_upload($_FILES['picture'], 'pet');

    $sql = "INSERT INTO animals (name, breed, live_at, age, description, size, vaccinated, status, picture) VALUES ('$name', '$breed', '$live_at', '$age', '$description', '$size', '$vaccinated', '$status', '$picture->fileName')";

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'><tr>
            <td> $name </td>
            <td> $breed </td>
            </tr></table><hr>";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br>" . $connect->error;
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
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../pages/dashboard.php'><button class="btn btn-primary"
                    type='button'>Dashboard</button></a>
        </div>
    </div>
</body>

</html>