<?php
// auth/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Log successful login attempt
            $log_stmt = $pdo->prepare("INSERT INTO login_logs (user_id, email_attempted, ip_address, status) VALUES (?, ?, ?, 'success')");
            $log_stmt->execute([$user['id'], $email, $ip_address]);

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Route based on role
            if ($user['role'] === 'admin') {
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../portal/index.php");
            }
            exit;
        } else {
            // Log failed login attempt
            $user_id = $user ? $user['id'] : null;
            $log_stmt = $pdo->prepare("INSERT INTO login_logs (user_id, email_attempted, ip_address, status) VALUES (?, ?, ?, 'failed')");
            $log_stmt->execute([$user_id, $email, $ip_address]);

            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - ISProject1</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 400px; margin: 50px auto; font-family: sans-serif;">
        <h2>Login to ISProject1</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['registered']) && $_GET['registered'] === 'success'): ?>
            <p style="color: green;">Registration successful! Please log in.</p>
        <?php endif; ?>
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Email Address:</label><br>
                <input type="email" name="email" required style="width: 100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Password:</label><br>
                <input type="password" name="password" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" style="padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Login</button>
        </form>
        <p style="margin-top: 15px;">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>