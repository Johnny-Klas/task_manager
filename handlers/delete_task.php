<?php
session_start();
include ("../database.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header('Location: ../pages/login.php');
    exit();
}

// Check if the task_id is provided and is a valid integer
if (isset($_POST['task_id']) && filter_var($_POST['task_id'], FILTER_VALIDATE_INT)) {
    // Get the task_id from the form data
    $task_id = $_POST['task_id'];
    
    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Prepare the delete query
    $query = $conn->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
    $query->bind_param('ii', $task_id, $user_id);

    // Execute the query
    $query->execute();

    // Check if the deletion was successful
    if ($query->affected_rows > 0) {
        // Deletion successful
        $_SESSION['success'] = "Task deleted successfully.";
    }
    else
    {
        // No rows affected, deletion failed
        $_SESSION['error'] = "Failed to delete task.";
    }
    // Close the prepared statement
    $query->close();
    header('Location: ../pages/task_manager.php');
}
else
{
    header('Location: ../pages/task_manager.php');
    exit();
}