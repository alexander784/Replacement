<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <form method="post" action="send-password-reset.php">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>


<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $emailDomain = '@zetech.com';

    if (!str_ends_with($email, $emailDomain)) {
        echo "Invalid email address.";
        exit();
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $token = bin2hex(random_bytes(16));
            $expires = date("U") + 1800;

            $stmt = $mysqli->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssi", $email, $token, $expires);
                $stmt->execute();

                $resetLink = "http://yourdomain.com/create_new_password.php?token=" . $token;
                $subject = "Password Reset Request";
                $message = "Click the link to reset your password: " . $resetLink;
                $headers = "From: no-reply@yourdomain.com\r\n";

                mail($email, $subject, $message, $headers);

                echo "A reset link has been sent to your email.";
            } else {
                echo "Failed to prepare statement.";
            }
        } else {
            echo "No user found with that email address.";
        }
    } else {
        echo "Failed to prepare statement.";
    }
}
?>
