<?php

// start session
session_start();
include_once 'validate.php';
$endUser = test_input($_POST['user']);
$endUserPassword = test_input($_POST['pwd']);

// w3 sql connect
// login to the softball database
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "softball";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username = '$endUser'";
$result = $conn->query($sql);

// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
        // password_verify(password from form, password from db)
        $verified = password_verify($endUserPassword, trim($row['password']));
        // if good, put username in session, otherwise send back to login
        if ($verified) {
            $_SESSION['username'] = $endUser;
            $_SESSION['error'] = '';
            header("location: games.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid username or password';
            // I'm not sure I did the error logs right
            error_log("Login error for $endUser: Invalid password");
            header("location: index.php");
        }
    }
} else {
    $_SESSION['error'] = 'Invalid username or password';
    error_log("Error: Username $endUser not found");
    header("location: index.php");
}

