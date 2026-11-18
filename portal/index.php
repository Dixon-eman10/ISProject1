<?php
// portal/index.php
session_start();

// Check if user is logged in; if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Portal - ISProject1</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 600px; margin: 50px auto; font-family: sans-serif;">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></p>
        
        <hr style="margin: 20px 0;">
        
        <h3>User Portal Dashboard</h3>
        <p>You are successfully logged into the user portal area.</p>
        
        <div style="margin-top: 20px;">
            <a href="../auth/logout.php" style="padding: 8px 12px; background: #d9534f; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
        </div>
    </div>
</body>
</html>