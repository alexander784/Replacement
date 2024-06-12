<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $emailDomain = '@zetech.com';

    // Email Must end with @zetech.com
    if (!str_ends_with($email, $emailDomain)) {
        $error = "Invalid password or email";
    } else {
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
            } elseif (!$user) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ss", $email, $hashedPassword);
                    if ($stmt->execute()) {
                        $_SESSION['user_id'] = $mysqli->insert_id;
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Student Login</h2>
        <form method="post" action="">
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Forgot your password? <a href="reset_password.php"><i class="fa fa-user" aria-hidden="true"></i> Reset password</a></p>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
