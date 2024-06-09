<?php

session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($mysqli->error));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        echo "User found: <br>";
        print_r($user);
    } else {
        echo "User not found<br>";
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: submit_request.php");
        exit();
    } else if (!$user) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($mysqli->error));
        }
        $stmt->bind_param("ss", $email, $hashedPassword);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            header("Location: submit_request.php");
            exit();
        } else {
            $error = "Failed to create new user.";
        }
    } else {
        $error = "Invalid email or password.";
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
