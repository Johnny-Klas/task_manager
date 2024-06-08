<?php
// Iclude database connection and start session.
session_start();
include("../database.php");

// Check if the form was submitted using 'POST'.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize.
    $task_name = filter_var($_POST['task_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];

    // Prepare query for INSERT INTO the specified database table.
    $query = $conn->prepare('INSERT INTO tasks (user_id, task_name, description, status) VALUES (?, ?, ?, ?)');
    // Check if the query was prepared without an issue.
    if ($query === false) {
        die('Prepare failed: ' . $conn->error);
    }
    // Bind parameters to avoid injections.
    $query->bind_param('isss', $user_id, $task_name, $description, $status);
    
    // Execute the query and handle successful and unsuccessful case.
    if ($query->execute()) {
        $_SESSION['success'] = "Task added successfully.";
        // Redirect back to the task manager page.
        header('Location: ../pages/task_manager.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to add task.";
        // Redirect back to the task manager page.
        header('Location: ../pages/task_manager.php');
        exit();
    }
}
