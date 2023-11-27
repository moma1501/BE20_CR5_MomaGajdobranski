<?php
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

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $breed = $data['breed'];
        $picture = $data['picture'];
        $live_at = $data['live_at'];
        $size = $data['size'];
        $age = $data['age'];
        $vaccinated = $data['vaccinated'];
        $status = $data['status'];
        $description = $data['description'];
    } else {
        echo "error";
    }
    mysqli_close($connect);
} else {
    echo "error";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Pet</title>
    <?php require_once '../includes/bootstrap.php' ?>
    <style type="text/css">
    fieldset {
        margin: auto;
        margin-top: 100px;
        width: 60%;
    }

    .img-thumbnail {
        width: 70px !important;
        height: 70px !important;
    }
    </style>
</head>

<body>
    <fieldset>
        <legend class='h2'>Update Pet Info <img class='img-thumbnail rounded-circle'
                src='../pictures/<?php echo $picture ?>' alt="<?php echo $name ?>"></legend>
        <form action="../actions/update.php" method="POST" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <td><input class="form-control" type="text" name="name" placeholder="Pet Name"
                            value="<?php echo $name ?>" /></td>
                </tr>
                <tr>
                    <th>Breed</th>
                    <td><input class="form-control" type="text" name="breed" placeholder="Breed"
                            value="<?php echo $breed ?>" /></td>
                </tr>
                <tr>
                    <th>Live At</th>
                    <td><input value="<?php echo $live_at ?>" class='form-control' type="text" name="live_at"
                            placeholder="Pets Adress" /></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><textarea class='form-control' type="text" name="description" placeholder="Description"
                            rows="4"><?php echo $description ?></textarea></td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><input value="<?php echo $size ?>" class='form-control' type="number" name="size"
                            placeholder="Size in cm" /></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><input value="<?php echo $age ?>" class='form-control' type="number" name="age"
                            placeholder="Age" /></td>
                </tr>
                <tr>
                    <th>Vaccinated</th>
                    <td>
                        <select name="vaccinated" class="form-control">
                            <option value="" disabled>Select One</option>
                            <optgroup>

                                <option <?php if ($vaccinated == 'yes') {
                                            echo 'selected';
                                        } ?> value="yes">Yes</option>
                                <option <?php if ($vaccinated == 'no') {
                                            echo 'selected';
                                        } ?> value="no">No</option>
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

                                <option <?php if ($status == 'adopted') {
                                            echo 'selected';
                                        } ?> value="adopted">Adopted</option>
                                <option <?php if ($status == 'available') {
                                            echo 'selected';
                                        } ?> value="available">Available</option>
                            </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Picture</th>
                    <td><input class="form-control" type="file" name="picture" /></td>
                </tr>

                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>" />
                    <td><button class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="../pages/dashboard.php"><button class="btn btn-warning"
                                type="button">Back</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>

</html>