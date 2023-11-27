<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../includes/db_connect.php';

if (isset($_SESSION['user']) != "") {
    header("Location: ../pages/home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../includes/bootstrap.php' ?>
    <title>Add Pet</title>
    <style>
    fieldset {
        margin: auto;
        margin-top: 100px;
        width: 60%;
    }
    </style>
</head>

<body>
    <fieldset>
        <legend class='h2'>Add Pet</legend>
        <form action="../actions/create.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td><input class='form-control' type="text" name="name" placeholder="Pet Name" /></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class='form-control' type="text" name="breed" placeholder="Breed" /></td>
                </tr>
                <tr>
                    <th>Live At</th>
                    <td><input class='form-control' type="text" name="live_at" placeholder="Pets Adress" /></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><textarea class='form-control' type="text" name="description" placeholder="Description"
                            rows="4"></textarea></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><input class='form-control' type="number" name="size" placeholder="Size in cm" /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input class='form-control' type="number" name="age" placeholder="Age" /></td>
                </tr>
                <tr>
                    <th>Vaccinated</th>
                    <td>
                        <select name="vaccinated" class="form-control">
                            <option value="" disabled selected>Select One</option>
                            <optgroup>

                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <select name="status" class="form-control">
                            <option value="" disabled>Select One</option>
                            <optgroup>

                                <option value="adopted">Adopted</option>
                                <option selected value="available">Available</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <th>Picture</th>
                <td><input class='form-control' type="file" name="picture" /></td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td><button class='btn btn-success' type="submit">Insert Product</button></td>
                    <td><a href="../pages/dashboard.php"><button class='btn btn-warning'
                                type="button">Dashboarrd</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>

</html>