<?php
session_start();

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Your HTML head content here -->
</head>
<body>
    <!-- Your HTML body content here -->
    <h1>Welcome, <?php echo $_SESSION["email"]; ?></h1>
    <p>This is your protected page.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
