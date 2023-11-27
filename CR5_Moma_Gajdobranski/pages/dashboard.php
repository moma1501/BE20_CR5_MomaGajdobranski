<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../includes/db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}


if (isset($_SESSION["user"])) {
    header("Location: ../pages/homepage.php");
    exit;
}
$sql2 = "SELECT * FROM users WHERE id = {$_SESSION['adm']}";
$result2 = mysqli_query($connect, $sql2);
$row1 = mysqli_fetch_assoc($result2);
$username = $row1['first_name'];
$userpicture = $row1['picture'];
$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM animals";
$result = mysqli_query($connect, $sql);

$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail rounded-circle' src='../pictures/" . $row['picture'] . "' alt=animal picture></td>
            <td>" . $row['name'] . " " . $row['breed'] . "</td>
            <td>" . $row['size'] . "</td>
            <td>" . $row['age'] . "</td>
            <td>" . $row['vaccinated'] . "</td>
            <td>" . $row['status'] . "</td>
            <td><a href='../products/update.php?id=" . $row['id'] . "'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a class='btn btn-danger btn-sm' onclick='deleteFunc({$row['id']})'" . "'>Delete</a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-Dashboard</title>
    <?php require_once '../includes/bootstrap.php' ?>
    <style type="text/css">
    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }

    td {
        text-align: left;
        vertical-align: middle;
    }

    tr {
        text-align: center;
    }

    .userImage {
        width: 100px;
        height: auto;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <img class="userImage" src="../pictures/avatar.png<?= $userpicture ?>" alt="Adm avatar">
                <p class="">Administrator</p>
                <p class=""><?= $username ?></p>
                <a class="btn btn-danger" href="../actions/logout.php?logout">Sign Out</a><br>
                <a class="btn btn-primary my-3" href="../products/create.php?">Add Pet</a>
            </div>
            <div class="col-8 mt-2">
                <p class='h2'>Users</p>

                <table class='table table-striped'>
                    <thead class='table-success'>
                        <tr>
                            <th>Picture</th>
                            <th>Name and Breed</th>
                            <th>Size</th>
                            <th>Age</th>
                            <th>Vaccinated</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $tbody ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../func.js"></script>
</body>

</html>