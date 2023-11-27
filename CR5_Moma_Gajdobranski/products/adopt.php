<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../includes/db_connect.php';

session_start();

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
} else if (isset($_SESSION['adm'])) {
    header("Location: ../../pages/dashboard.php");
}

$sql = "SELECT * FROM animals
join adopt on animals.id = adopt.fk_animals_id
JOIN users on adopt.fk_user_id = users.id
WHERE users.id = {$_SESSION['user']}";
$output = '';
$result = mysqli_query($connect, $sql);
$qtty = 0;
$total = 0;
if (mysqli_num_rows($result) > 0) {


    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $output .= "<tr>
        <td>{$row['name']}</td>
        <td>{$row['breed']}</td>
        <td>{$row['vaccinated']}</td>
        <td>{$row['adoption_date']}</td>
     

        <td>
      </tr>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../includes/bootstrap.php' ?>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>Document</title>
</head>

<body>

    <h1 class="text-center text-primary my-3">CART</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Breed</th>
                <th scope="col">Vaccinated</th>
                <th scope="col">Adoption Date</th>


            </tr>
        </thead>
        <tbody>
            <?php
            if ($output == '') {
                echo "<tr><td class='text-center' colspan='4'>No Pets adopted</td></tr>";
            } else
                echo $output ?>

        </tbody>
    </table>
    <hr class="text-success">






    <hr class="text-success">
    <div><a class="btn btn-primary my-3" href="../pages/homepage.php">Home</a></div>

</body>

</html>