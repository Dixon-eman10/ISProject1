<?php
// auth/register.php
session_start();
require_once __DIR__ . '/../config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($full_name) && !empty($email) && !empty($password)) {
        $check_stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->execute([$email]);
        if ($check_stmt->fetch()) {
            $message = "That email address is already registered.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'user')");
            if ($stmt->execute([$full_name, $email, $password_hash])) {
                header("Location: login.php?registered=success");
                exit;
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ISProject1</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
        <h2>Create an Account</h2>
        <?php if (!empty($message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Full Name:</label><br>
                <input type="text" name="full_name" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Email Address:</label><br>
                <input type="email" name="email" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Password:</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Register</button>
        </form>
        <p style="margin-top: 15px;">Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>