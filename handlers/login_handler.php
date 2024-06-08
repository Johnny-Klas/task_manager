<?php
session_start();
include('../database.php');

// Check if the method used was 'POST'.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Store the input in variables after sanitizing them.
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];

    // Check if both of the fields were filled / if not, redirect.
    if(empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required';
        header('Location: ../pages/login.php');
        exit();
    }

    // Prepare a parametirized SQL statement to avoid injections.
    $query = $conn->prepare('SELECT id, username, password FROM users WHERE username = ?');
    
    // Check if the query was successfuly prepared.
    if($query === false){
        die('Prepare failed: ' . $conn->error);
    }

    // Bind the parameter with the variable and specify the type.
    $query->bind_param('s', $username);

    // Execute the statement.
    if ($query->execute())
    {        
        // Get the result.
        $result = $query->get_result();
        // Fetch a single row of data as an associative array.
        $user = $result->fetch_assoc();

        // Check if an array was fetched && if the password matches.
        if($user && password_verify($password, $user['password']))
        {
            // Store the fetched row in Super Global Assoc Array.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['success'] = "Logged in successfully.";

            header('Location: ../pages/task_manager.php');
            exit();
        }
        else
        {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: ../pages/login.php');
            exit();
        }
    }
    else
    {
        $_SESSION['error'] = "Failed to log in.";
        header('Location: ../pages/login.php');
        exit();
    }
}