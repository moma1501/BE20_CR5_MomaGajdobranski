<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
} else if (isset($_SESSION['user']) != "") {
    header("Location: ../homepage.php");
} else if (isset($_SESSION['adm']) != "") {
    header("Location: ../dashboard.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['adm']);
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}