<?php
// Start session and include database connection.
session_start();
include("../database.php");

// Check if the form was submitted using the 'POST' method.
if($_SERVER["REQUEST_METHOD"] == 'POST'){

    // Get form data.
    $password = $_POST['password'];
    $conf_pass = $_POST['confirm_password'];

    // Check if passwords match to continue with the operations.
    if($conf_pass === $password){
        // Proceed to get the username if the passwords matched.
        $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
    else{
        $_SESSION['error'] = "Passwords don't match";
        header('Location: ../pages/register.php');
        exit();
    }

    // Check if all necessary fields where filled by the user.
    if (empty($username) || empty($password) || empty($conf_pass)) {
        $_SESSION['error'] = 'All fields must be filled';
        header('Location: ../pages/register.php');
        exit();
    }

    // Prepare query to check if a user already exists with that username.
    $query = $conn->prepare('SELECT id FROM users WHERE username = ?');
    // Check if the query was successfuly prepared.
    if($query === false){
        die('Prepare failed: ' . $conn->error);
    }

    // Bind the username parameter.
    $query->bind_param('s', $username);

    $query->execute([$username]);
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Username already exists!';
        header('Location: ../pages/register.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if($query === false){
        die('Prepare failed: ' . $conn->error);
    }
    $query->bind_param('ss', $username, $hashed_password);
    $query->execute();

    $_SESSION['success'] = 'Registration successful! You are now able to log in.';
    header('Location: ../pages/login.php');
    exit();
}