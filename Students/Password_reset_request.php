<?php
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $stmt = $mysqli->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
            $stmt->bind_param("ss", $token, $email);
            $stmt->execute();

            $reset_link = "http://localhost/Students/reset_password.php?token=$token";
            mail($email, "Password Reset", "Click this link to reset your password: $reset_link");

            $message = "Password reset link has been sent to your email.";
        } else {
            $error = "No account found with that email.";
        }
    } else {
        $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Password Reset Request</h2>
        <form method="post" action="">
            <input type="text" name="email" placeholder="Email" required><br>
            <button type="submit">Request Reset</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
    </div>
</body>
</html>
