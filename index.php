<?php
// index.php - Root landing page
session_start();

// If already logged in, redirect straight to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: portal/index.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - ISProject1</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin: 80px auto; text-align: center; font-family: sans-serif;">
        <h1>Welcome to ISProject1</h1>
        <p>Secure Role-Based Authentication & Management Portal</p>
        
        <div style="margin-top: 30px; display: flex; justify-content: center; gap: 15px;">
            <a href="auth/login.php" style="padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;">Login</a>
            <a href="auth/register.php" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 4px;">Register</a>
        </div>
    </div>
</body>
</html>