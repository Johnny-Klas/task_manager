<!-- Start session / include the header / include the database connection file -->
<?php
session_start();
include('../includes/header.php');
include("../database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../css/edit.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/base/reset.css">
    <link rel="stylesheet" href="../css/base/typography.css">
</head>
<body>
    <main class="wrapper">
    <h1>Edit Task</h1>
    <?php
    // Check if task_id is provided in the URL
    if(isset($_POST['task_id'])) {
        // Get the task_id from the URL 
        $task_id = $_POST['task_id'];

        // Fetch the task details from the database based on the task_id
        $query = $conn->prepare('SELECT task_name, description, status FROM tasks WHERE id = ?');
        $query->bind_param('i', $task_id);
        $query->execute();
        $result = $query->get_result();
        $task = $result->fetch_assoc();

        // Check if the task exists
        if($task) {
            ?>
            <form action="../handlers/edit_handler.php" method="post">
                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">

                <div class="name-div">
                <label for="task_name">Task Name:</label><br>
                <input type="text" id="task_name" name="task_name" value="<?php echo $task['task_name']; ?>"><br>
                </div>

                <div class="desc-div">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"><?php echo $task['description']; ?></textarea><br>
                </div>

                <div class="status-div">
                <label for="status">Status:</label><br>
                <select id="status" name="status">
                    <option value="pending" <?php if($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                    <option value="in-progress" <?php if($task['status'] == 'in-progress') echo 'selected'; ?>>In Progress</option>
                    <option value="completed" <?php if($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                </select><br>
                </div>
                
                <button id="update-btn" type="submit">Update Task</button>
            </form>
            <?php
        } else {
            echo "Task not found.";
        }
    } else {
        echo "Task ID not provided.";
    }
    ?>
    </main>
<?php
    include('../includes/footer.html');
?>
</body>
</html>