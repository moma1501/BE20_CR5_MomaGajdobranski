<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
require_once 'includes/file_upload.php';
session_start();
if (isset($_SESSION['user']) != "") {
    header("Location: pages/homepage.php"); 
}
if (isset($_SESSION['adm']) != "") {
    header("Location: pages/dashboard.php"); 
}



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$error = false;
$fname = $lname = $email  = $password  = $picture = $adress = $phone_number = '';
$fnameError = $lnameError = $emailError = $passError = $errorMessage = $picError = $adressError = $errMSG = $phone_numberError = '';
if (isset($_POST['register'])) {
    $fname = cleanHtml($_POST['first_name']);
    $lname = cleanHtml($_POST['last_name']);
    $adress = cleanHtml($_POST['adress']);
    $phone_number = cleanHtml($_POST['phone_number']);
    $email = cleanHtml($_POST['email']);
    $password = cleanHtml($_POST['password']);
    $picture = file_upload($_FILES['picture']);
    $uploadError = '';


    if (empty($fname)) {
        $error = true;
        $fnameError = "Please enter your First name";
    } else if (strlen($fname) < 3) {
        $error = true;
        $fnameError = "First name must have at least 3 characters.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $fname)) {
        $error = true;
        $fnameError = "First name must contain only letters and no spaces.";
    }
    if (empty($adress)) {
        $error = true;
        $usernameError = "Please enter your Adress";
    } else if (strlen($adress) < 5) {
        $error = true;
        $usernameError = "adress must have at least 5 characters.";
    }

    if (empty($phone_number)) {
        $error = true;
        $phone_numberError = "Please enter your phone number";
    } else if (strlen($phone_number) < 5) {
        $error = true;
        $phone_numberError = "phone number must have at least 5 characters.";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "Please enter your Last name";
    } else if (strlen($lname) < 3) {
        $error = true;
        $lnameError = "Last name must have at least 3 characters.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $lnameError = "Last name must contain only letters and no spaces.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    if (empty($password)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($password) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }


    $password = hash('sha256', $password);

    if (!$error) {

        $query = "INSERT INTO users(first_name, last_name, adress, phone_number, password, email, picture)
                  VALUES('$fname', '$lname', '$adress', '$phone_number' ,'$password', '$email', '$picture->fileName')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}


if (isset($_POST['login'])) {
    $email = cleanHtml($_POST['email']);
    $pass = cleanHtml($_POST['password']);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }


    if (!$error) {

        $password = hash('sha256', $pass);

        $sql = "SELECT id, first_name, password, status FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = mysqli_num_rows($result);
        if ($count == 1 && $row['password'] == $password) {
            if ($row['status'] == 'adm') {
                $_SESSION['adm'] = $row['id'];
                header("Location: pages/dashboard.php");
            } else {
                $_SESSION['user'] = $row['id'];
                header("Location: pages/homepage.php");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
            $class = "alert alert-danger";
        }
    }
}

mysqli_close($connect);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/style.css">
    <title>Landing Page</title>
</head>

<body class="index-body">
    <div class="text-center"><?php echo  $errMSG . $emailError . $passError  ?></div>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form class="index-form" method="POST" enctype="multipart/form-data"
                action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 class='index-h1'>Create Account</h1>

                <input class="index-input" name="first_name" require type="text" placeholder="First Name" />
                <input class="index-input" name="last_name" require type="text" placeholder="Last Name" />
                <input class="index-input" name="adress" require type="text" placeholder="Adress" />
                <input class="index-input" name="phone_number" require type="number" placeholder="Phone Number" />
                <input class="index-input" name="email" require type="email" placeholder="Email" />
                <input class="index-input" name="password" require type="password" placeholder="Password" />
                <input class="index-input" name="picture" type="file" />
                <button type="submit" name="register" class="index-button">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="POST" class="index-form" action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h1 class='index-h1'>Sign in</h1>

                <input class="index-input" name="email" type="email" placeholder="Email" />
                <input class="index-input" name="password" type="password" placeholder="Password" />
                <a class="index-a" href="#">Forgot your password?</a>
                <button name="login" type="submit" class="index-button">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class='index-h1'>Welcome Back!</h1>
                    <p class="index-p">To keep connected with us please login with your personal info</p>
                    <button class="index-button ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class='index-h1'>Hi, Visitor!</h1>
                    <p class="index-p">Enter your personal data</p>
                    <button class="index-button ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="index.js"></script>
</body>

</html>