<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/base/reset.css">
    <link rel="stylesheet" href="../css/base/typography.css">
</head>
<!-- Include the header file -->
<?php include '../includes/header.php'; ?>
<body class="landing-body">
    <div class="overlay"></div>
    <main class="landing-container">
        <h1>Welcome to THE <span>Task Manager!</span></h1>
        <h3>Manage your tasks efficiently and stay organized.</h3>
        <!-- Create a conditional where different paragraph is shown if the user is logged in -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a class="btn" href="task_manager.php">Go to your Task Manager</a>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to start managing your tasks.</p>
            <div class="buttons">
                <button class="btn-large login" onclick="window.location.href='login.php'">Login</button>
                <button class="btn-large register" onclick="window.location.href='register.php'">Register</button>
            </div>
        <?php endif; ?>
    </main>
    <!-- Include the footer file -->
    <?php include '../includes/footer.html'; ?>
</body>
</html>