<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "BE20_CR5_animal_adoption_Moma_Gajdobranski";

$connect = mysqli_connect($hostname, $username, $password, $dbname);


if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}