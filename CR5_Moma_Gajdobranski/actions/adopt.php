<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db_connect.php';
session_start();
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
} else if (isset($_SESSION['adm'])) {
    header("Location: ../pages/dashboard.php");
}

if (($_GET['Id']) && ($_GET['animallId'])) {
    $userId = $_GET['Id'];
    $animalId = $_GET['animallId'];
    $sql2 = "SELECT * FROM animals WHERE id = {$animalId}";
    $result2 = mysqli_query($connect, $sql2);
    $row = mysqli_fetch_assoc($result2);
    $animalStatus = $row['status'];
    if ($animalStatus == 'available') {
        $sql = "INSERT INTO adopt (fk_user_id, fk_animals_id) VALUES ('$userId', '$animalId')";
        if (mysqli_query($connect, $sql) === true) {
            echo  "<head>
    <link rel='stylesheet' href='<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp' crossorigin='anonymous'>
    </head>
    <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
  <symbol id='check-circle-fill' viewBox='0 0 16 16'>
    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
  </symbol>

</svg>
<div class='alert alert-success d-flex align-items-center' role='alert'>
<svg class='bi flex-shrink-0 me-2' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
<div>
SUCCESS! Pet added for adoption!!
</div>
</div>";
            
            $sql3 = "UPDATE animals SET status = 'adopted' WHERE id = {$animalId}";
            mysqli_query($connect, $sql3);
           
            header("Refresh: 2; url=../pages/homepage.php");
            exit;
        } else {
            echo  "<head>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp' crossorigin='anonymous'>
    </head>
    <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
  
  <symbol id='exclamation-triangle-fill' viewBox='0 0 16 16'>
    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
  </symbol>
</svg>
    <div class='alert alert-danger d-flex align-items-center' role='alert'>
    <svg class='bi flex-shrink-0 me-2' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
<div>
ERROR!! Something went wrong!
</div>
</div>";
            
            header("Refresh: 2; url=../pages/homepage.php");
            exit;
        }
    } else {
        echo  "<head>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp' crossorigin='anonymous'>
        </head>
        <svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
      
      <symbol id='exclamation-triangle-fill' viewBox='0 0 16 16'>
        <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
      </symbol>
    </svg>
        <div class='alert alert-danger d-flex align-items-center' role='alert'>
        <svg class='bi flex-shrink-0 me-2' role='img' aria-label='Danger:'><use xlink:href='#exclamation-triangle-fill'/></svg>
    <div>
   Pet is allready on the way to you!
    </div>
    </div>";
        
        header("Refresh: 2; url= ../pages/homepage.php");
        exit;
    }
}