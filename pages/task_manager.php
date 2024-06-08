<!-- Start session to use the Globals passed on / Include the database connection file / Include the header file -->
<?php
session_start();
include("../database.php");
include("../includes/header.php");

// Initialize a variable with the user's id from the Session super globals.
$user_id = $_SESSION['user_id'];
// Prepare a query to get everything from the task table of the current user.
$query = $conn->prepare('SELECT * FROM tasks WHERE user_id = ?');
// Parametirize the query to avoid injections.
$query->bind_param('i', $user_id);
// Execute query and get the results.
$query->execute();
$result = $query->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../css/task_manager.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/base/reset.css">
    <link rel="stylesheet" href="../css/base/typography.css">
</head>

<body class="task-body">
    <main class="wrapper">   
    <h1>Task Manager</h1>
    <!-- Show success message and then remove it from session -->
    <?php if (isset($_SESSION['success'])): ?>
        
        <div class="success">
            <?php
                echo '<p style="color:darkgreen;">' . $_SESSION['success'] . '</p>';
                unset($_SESSION['success']);
            ?>
        </div>

    <?php endif; ?>

<section class="task-table">
    <!-- Created a table to display the tasks -->
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Created a foreach loop to show all the tasks of the current user -->
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <!-- Specify how the content of each table will be displayed -->
                    <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($task['description'])); ?></td>
                    <td><?php echo htmlspecialchars($task['status']); ?></td>
                    <!-- Button for edit and delete in a cell -->
                    <td id="buttons">
                        <form action="edit_task.php" method="post" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" id="edit" data-icon="&#x270E;" data-text="Edit"></button>
                        </form>
                        <form action="../handlers/delete_task.php" method="post" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" id="delete" data-icon="&#x1F5D1;" data-text="Delete" onclick="return confirm('Are you sure you want to delete this task?')"></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </section>
    <!-- Created add-task section to split the page into two separate parts -->
    <section class="add-task">
        <button id="showFormButton">Add New Task</button>
        <form class="task-form" id="task-form" action="../handlers/add_handler.php" method="post">
            <div class="task-name">
            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required>
            </div>
            <div class="task-desc">
            <label for="description">Task Description:</label>
            <textarea id="description" name="description" required></textarea>
            </div>
            <div class="task-status">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="pending">Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            </div>
            <button class="button" type="submit" data-icon="&#x002B;" data-text="Add New"></button>
        </form>
    </section>
    </main>
    <!-- Created a JS script to dynamically hide or show the add-task form with a press of a button -->
    <script>
        // Get references to the button and the form
        const showFormButton = document.getElementById('showFormButton');
        const taskForm = document.getElementById('task-form');

        // Add event listener to the button
        showFormButton.addEventListener('click', function() {
        // Toggle the visibility of the form
        if (taskForm.style.display === 'none') {
                taskForm.style.display = 'block';
        } else {
                taskForm.style.display = 'none';
            }
        });

    </script>
    <!-- Include the footer file -->
    <?php include('../includes/footer.html'); ?>
</body>
</html>