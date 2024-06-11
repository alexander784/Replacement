<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    $stmt = $mysqli->prepare("SELECT user_id FROM reset_tokens WHERE token = ? AND NOW() <= DATE_ADD(created_at, INTERVAL 1 DAY)");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id);
            $stmt->fetch();

            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $updateStmt = $mysqli->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE id = ?");
            if ($updateStmt) {
                $updateStmt->bind_param("si", $hashedPassword, $user_id);
                if ($updateStmt->execute()) {
                    $message = "Password has been reset successfully.";
                    $deleteStmt = $mysqli->prepare("DELETE FROM reset_tokens WHERE token = ?");
                    if ($deleteStmt) {
                        $deleteStmt->bind_param("s", $token);
                        $deleteStmt->execute();
                    } else {
                        $error = "Failed to delete reset token.";
                    }
                } else {
                    $error = "Failed to reset password.";
                }
            } else {
                $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
            }
        } else {
            $error = "Invalid or expired token.";
        }
        $stmt->close();
    } else {
        $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>
        <form method="post" action="">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <button type="submit">Reset Password</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
    </div>
</body>
</html>
