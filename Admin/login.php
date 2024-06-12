<?php
session_start();
include('../config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user already exists
    $stmt = $mysqli->prepare("SELECT * FROM admins WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            // User doesn't exist, insert new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $hashedPassword);
                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $mysqli->insert_id;
                    $_SESSION['username'] = $username;
                    header("Location: admin_dashboard.php");
                    exit();
                } else {
                    $error = "Failed to create new user: " . htmlspecialchars($stmt->error);
                }
            } else {
                $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
            }
        }
    } else {
        $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Forgot your password? <a href="reset_password.php"><i class="fa fa-user" aria-hidden="true"></i> Reset password</a></p>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
