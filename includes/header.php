<header class="header-container">
    <nav>
        <div class="logo">
            <a href="index.php"><img src="../images/Task_Man_Logo-removebg-preview(2).png" alt="Logo"></a>
        </div>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="task_manager.php">Task Manager</a></li>
                <li><a href="../handlers/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>