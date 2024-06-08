<?php
// Include database connection.
include("../database.php");
session_start();

// Check if form is submitted.
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $task_name = filter_var($_POST['task_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $status = $_POST['status'];
    $task_id = $_POST['task_id'];

    // Prepare the update statement.
    $query = $conn->prepare('UPDATE tasks SET task_name = ?, description = ?, status = ? WHERE id = ?');
    // Check if the query was prepared without an issue.
    if ($query === false) {
        die('Prepare failed: ' . $conn->error);
    }
    // Bind parameters to avoid injections.
    $query->bind_param('sssi', $task_name, $description, $status, $task_id);
    // Execute the update statement / handle successful and unsuccessful case.
    if($query->execute()) {
        // Update successful
        $_SESSION['success'] = "Task updated successfully.";
        header('Location: ../pages/task_manager.php');
        exit();
    } else {
        // Update failed
        $_SESSION['error'] = "Failed to update task.";
        header('Location: ../pages/task_manager.php');
        exit();
    }
}