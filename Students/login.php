<?php
session_start();
include('../config.php'); // Update path to config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: submit_request.php");
            exit();
        } else if (!$user) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $email, $hashedPassword);
                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $stmt->insert_id;
                    header("Location: submit_request.php");
                    exit();
                } else {
                    $error = "Failed to create new user.";
                }
            } else {
                $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        Email: <input type="text" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
