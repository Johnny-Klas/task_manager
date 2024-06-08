<!-- Start session to use the Globals passed on / Include the database connection file / Include the header file -->
<?php
    session_start();
    include("../database.php");
    include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../css/layout/header.css">
    <link rel="stylesheet" href="../css/layout/footer.css">
    <link rel="stylesheet" href="../css/base/reset.css">
    <link rel="stylesheet" href="../css/base/typography.css">
</head>

<body class="register-body">
    <div class="overlay"></div>
    <h1><u>Registration Form</u></h1>
    <!-- Created a div to contain the error messages -->
    <div id="error_box" class="error-box">

        <!-- Show error message and the remove it from session to stop showing -->
        <?php
            if (isset($_SESSION['error'])) {
                echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
        ?>

    </div>

    <!-- Created a simple registration form to create new users -->
    <form id="register-Form" action="../handlers/register_handler.php" method="post">
        <!-- Username div -->
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <br>
        <!-- Password div -->
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <br>
        <!-- Confirm password div -->
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <br>
        <!-- button -->
        <button type="submit">Register</button>
    </form>
    <!-- Include the footer file -->
    <?php include('../includes/footer.html'); ?>
</body>
</html>