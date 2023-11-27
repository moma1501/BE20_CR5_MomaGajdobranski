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
$res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
$picture = $row['picture'];
$card = "";
$sql = "SELECT * FROM animals";
if (isset($_GET['filter']) && $_GET['filter'] == "seniors") {
    $sql = "SELECT * FROM animals WHERE age > 4";
}



$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result)  > 0) {
    while ($row1 = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if (isset($_SESSION['user']))
            $card .= "<div class='card'>
            <div class='wrap-image'><img
                    src='../pictures/{$row1['picture']}'
                    alt='pet picture' /><svg viewBox='-1.5 529.754 603 71.746' preserveAspectRatio='none'>
                   
                </svg></div>
            <div class='contents'>
                <h3>{$row1['name']}</h3>
                <div class='text'>{$row1['description']} <br> <div class='myFlex'><a href='../pages/details.php?id={$row1['id']}' class='myBtn'>details</a></div> </div>
            </div>
        </div>";
    }
} else {
    $card = "No data available";
}


mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../pages/style.css">
    <title>Home</title>
</head>

<body>
    <header>
        <div class="wrapper">

            <div class="user-details">
                <?php echo "<img class='user-image' src='../pictures/{$picture}'> Welcome " . $row['first_name'] . "! <a href='../actions/logout.php?logout' class='headerBtn'>Logout</a>" ?>
            </div>
            <h1>Fishermen's Friends</h1>
            <h3>Why you should adopt a fish</h3>
            <p>Adopting a fish introduces tranquility to your living space. Low-maintenance and captivating, fish tanks promote relaxation. Observing vibrant fish gracefully navigate their aquatic haven enhances well-being, offering a serene and captivating addition to your home.</p>
            <br>
            <button><a href="../products/adopt.php">Your Adoptions</a></button>
        </div>
    </header>
    <div class="hompage-container">
        <h1 class="home-page-h1">Our Fishes &#128031; </h1>
        <div id="filter">
             <a class="filter-btn" href="./homepage.php?filter=seniors">seniors</a>
             <a class="filter-btn" href="./homepage.php">Show all</a>
        </div>
        <div class="wrap-cards">
            <?php echo $card ?>
        </div>
    </div>
</body>

</html>