<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/db_connect.php';
session_start();

if (isset($_SESSION['user']) == "" && isset($_SESSION['adm']) == "") {
    header("Location: ../index.php"); 
}
if (isset($_SESSION['adm']) != "") {
    header("Location: ../dashboard.php"); 
}
$sql2 = "SELECT * FROM users WHERE id = {$_SESSION['user']}";
$result2 = mysqli_query($connect, $sql2);
$row = mysqli_fetch_assoc($result2);
$userpicture = $row['picture'];
$id = $_GET['id'];
$sql = "SELECT * FROM animals WHERE id = {$id}";
$result = mysqli_query($connect, $sql);
$output = '';
if (mysqli_num_rows($result) == 1) {
    $data = mysqli_fetch_assoc($result);
    $id = $data['id'];
    $name = $data['name'];
    $breed = $data['breed'];
    $picture = $data['picture'];
    $live_at = $data['live_at'];
    $size = $data['size'];
    $age = $data['age'];
    $vaccinated = $data['vaccinated'];
    $status = $data['status'];
    $description = $data['description'];

    $output .= "<h1 class='mt-5'> Hi, i'm {$name}, {$breed}</h1>
    <h3>i am {$status}!</h3>
    <p> {$description}</p>
    <p>{$name} lives currently at {$live_at}</p>
    <p>also, {$size} cm tall</p>
    <p>{$name} is {$age} year(s) old</p>
    <p> is {$name} vaccinated? {$vaccinated}</p>
    <img class='details-pic' width='400' src='..//pictures/{$picture}' alt=''>
    <br>
    <a href='../actions/adopt.php?animallId={$id}&Id={$_SESSION['user']}'><button
            class='my-3 btn btn-primary'>Take me home!</button></a>";
} else {
    echo "error";
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <?php echo "<title>{$name}</title>" ?>
    <?php require_once '../includes/bootstrap.php' ?>
    <title>Details</title>
</head>

<body>
    <header>
        <div class="wrapper">

            <div class="user-details">
                <?php echo "<img class='user-image' src='../pictures/{$userpicture}'> Welcome " . $row['first_name'] . "! <a href='../actions/logout.php?logout' class='headerBtn'>Logout</a>" ?>
            </div>

            <?php echo $output; ?>

        </div>
    </header>