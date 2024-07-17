<?php
session_start();
include('./config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strpos($email, '@zetech.ac.ke') !== false) {
        if (strpos($email, 'admin') !== false) {
            $role = 'admin';
        } else {
            $role = 'student';
        }
    } else {
        $error = "Invalid email domain.";
    }

    if (!isset($error)) {
        $stmt = $mysqli->prepare("SELECT id, email, password, role, name FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {
               
                if (password_verify($password, $user['password']) && $user['role'] === $role) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];

                    if ($role === 'admin') {
                        header("Location: Admin/admin_dashboard.php");
                        exit();
                    } elseif ($role === 'student') {
                        header("Location: Students/dashboard.php");
                        exit();
                    } else {
                        $error = "Unknown user role.";
                    }
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $name = substr($email, 0, strpos($email, '@'));
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insert_stmt = $mysqli->prepare("INSERT INTO users (email, password, role, name) VALUES (?, ?, ?, ?)");
                if ($insert_stmt) {
                    $insert_stmt->bind_param("ssss", $email, $hashedPassword, $role, $name);
                    if ($insert_stmt->execute()) {
                        $user_id = $mysqli->insert_id;
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['email'] = $email;
                        $_SESSION['role'] = $role;
                        $_SESSION['name'] = $name; 

                        if ($role === 'admin') {
                            header("Location: Admin/admin_dashboard.php");
                            exit();
                        } elseif ($role === 'student') {
                            header("Location: Students/dashboard.php");
                            exit();
                        } else {
                            $error = "Unknown user role.";
                        }
                    } else {
                        $error = "Failed to create new user: " . htmlspecialchars($insert_stmt->error);
                    }
                } else {
                    $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
                }
            }
        } else {
            $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form method="post" action="">
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='text-red-500 mt-4 text-center'>$error</p>"; ?>
    </div>
</body>
</html>
