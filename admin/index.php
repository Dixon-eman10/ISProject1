<?php
// admin/index.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if user is logged in AND is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit;
}

// Fetch recent login logs and total user count
try {
    $stmt = $pdo->query("SELECT l.*, u.full_name FROM login_logs l LEFT JOIN users u ON l.user_id = u.id ORDER BY l.attempted_at DESC LIMIT 10");
    $recent_logs = $stmt->fetchAll();

    $user_count_stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $total_users = $user_count_stmt->fetch()['total'];
} catch (PDOException $e) {
    $recent_logs = [];
    $total_users = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ISProject1</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px; margin: 40px auto; font-family: sans-serif;">
        <h2>Admin Management Dashboard</h2>
        <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong> (Admin)</p>

        <div style="display: flex; gap: 20px; margin: 20px 0;">
            <div style="background: #f4f4f4; padding: 15px; border-radius: 5px; flex: 1;">
                <h4>Total Registered Users</h4>
                <p style="font-size: 24px; font-weight: bold; margin: 5px 0;"><?php echo $total_users; ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0;">

        <h3>Recent Login Activity Logs</h3>
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th>ID</th>
                    <th>User</th>
                    <th>Email Attempted</th>
                    <th>IP Address</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recent_logs)): ?>
                    <?php foreach ($recent_logs as $log): ?>
                        <tr>
                            <td><?php echo $log['id']; ?></td>
                            <td><?php echo htmlspecialchars($log['full_name'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($log['email_attempted']); ?></td>
                            <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                            <td style="color: <?php echo $log['status'] === 'success' ? 'green' : 'red'; ?>;">
                                <?php echo ucfirst($log['status']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($log['attempted_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No login logs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 25px;">
            <a href="../auth/logout.php" style="padding: 8px 12px; background: #d9534f; color: white; text-decoration: none; border-radius: 4px;">Logout</a>
        </div>
    </div>
</body>
</html>