<!-- Start session to use the Globals passed on / Include the database connection file / Include the header file -->
<?php
    session_start();
    include("../database.php");
    include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/base/reset.css">
    <link rel="stylesheet" href="../css/base/typography.css">
</head>

<body class="login-body">
    <div class="overlay"></div>

    <h1>Login</h1>
    <!-- Created a div to contain the error messages -->
    <div id="error_box" class="error-box">
        <!-- Create a php script for error or success messages -->
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    elseif(isset($_SESSION['success'])){
        echo '<p style="color:green;">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    ?>
    </div>

    <!-- Form for logging in -->
    <form id="login-form" action="../handlers/login_handler.php" method="post">
        <!-- Username div -->
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" autocomplete="on" required><br>
        </div>

        <br>
        <!-- Password div -->
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>
        </div>

        <br>
        <!-- Button -->
        <button type="submit" value="submit" name="submitBtn">Login</button>

    </form>
    <!-- Include the footer file -->
    <?php include('../includes/footer.html'); ?>
</body>
</html>