<?php
session_start();
$error = array();

include('../config.php');


if (!$con = mysqli_connect("localhost", "root", "", "Replacement")) {
    die("Could not connect to the database.");
}

$mode = "enter_email";
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($mode) {
        case 'enter_email':
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Please enter a valid email address.";
            } elseif (!valid_email($email)) {
                $error[] = "That email was not found.";
            } else {
                $_SESSION['forgot']['email'] = $email;
                send_email($email);
                header("Location: forgot.php?mode=enter_code");
                die;
            }
            break;

        case 'enter_code':
            $code = $_POST['code'];
            $result = is_code_correct($code);

            if ($result == "the code is correct") {
                $_SESSION['forgot']['code'] = $code;
                header("Location: forgot.php?mode=enter_password");
                die;
            } else {
                $error[] = $result;
            }
            break;

        case 'enter_password':
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                $error[] = "Passwords do not match.";
            } elseif (!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])) {
                header("Location: forgot.php");
                die;
            } else {
                save_password($password);
                if (isset($_SESSION['forgot'])) {
                    unset($_SESSION['forgot']);
                }
                header("Location: login.php");
                die;
            }
            break;

        default:
            break;
    }
}

function send_email($email) {
    global $con;

    $expire = time() + (60 * 1);
    $code = rand(10000, 99999);
    $email = addslashes($email);
    $subject = "Password Reset";
    $message = "You have requested to reset your password for your Zetech Events System account.<br><br>
        Please find the security code to change your password:<br><br>" . $code . "<br><br>";
    $message .= "<b>Please don't share this with anyone</b>.<br><br>";
    $message .= "If you did not request this, please ignore this message.";

    $query = "INSERT INTO codes (email, code, expire) VALUES ('$email', '$code', '$expire')";
    mysqli_query($con, $query);

    send_mail($email, $subject, $message);
}

function save_password($password) {
    global $con;

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = addslashes($_SESSION['forgot']['email']);

    $query = "UPDATE users SET password = '$password' WHERE email = '$email' LIMIT 1";
    mysqli_query($con, $query);
}

function valid_email($email) {
    global $con;

    $email = addslashes($email);
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}

function is_code_correct($code) {
    global $con;

    $code = addslashes($code);
    $expire = time();
    $email = addslashes($_SESSION['forgot']['email']);

    $query = "SELECT * FROM codes WHERE code = '$code' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row['expire'] > $expire) {
            return "the code is correct";
        } else {
            return "the code has expired";
        }
    }

    return "the code is incorrect";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <style>
        * {
            font-family: Tahoma, sans-serif;
            font-size: 13px;
        }
        form {
            width: 100%;
            max-width: 300px;
            margin: auto;
            border: solid thin #ccc;
            padding: 20px;
        }
        .textbox {
            padding: 5px;
            width: 280px;
        }
        .error {
            font-size: 12px;
            color: red;
        }
    </style>
</head>
<body>
    <?php
    switch ($mode) {
        case 'enter_email':
            ?>
            <form method="post" action="forgot.php?mode=enter_email">
                <h1>Forgot Password</h1>
                <h3>Enter your email below</h3>
                <div class="error">
                    <?php
                    foreach ($error as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                </div>
                <input class="textbox" type="email" name="email" placeholder="Email" required><br>
                <br>
                <input type="submit" value="Next">
                <br><br>
                <div><a href="login.php">Login</a></div>
            </form>
            <?php
            break;

        case 'enter_code':
            ?>
            <form method="post" action="forgot.php?mode=enter_code">
                <h1>Forgot Password</h1>
                <h3>Enter the code sent to your email</h3>
                <div class="error">
                    <?php
                    foreach ($error as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                </div>
                <input class="textbox" type="text" name="code" placeholder="12345" required><br>
                <br>
                <input type="submit" value="Next" style="float: right;">
                <a href="forgot.php">
                    <input type="button" value="Start Over">
                </a>
                <br><br>
                <div><a href="login.php">Login</a></div>
            </form>
            <?php
            break;

        case 'enter_password':
            ?>
            <form method="post" action="forgot.php?mode=enter_password">
                <h1>Forgot Password</h1>
                <h3>Enter your new password</h3>
                <div class="error">
                    <?php
                    foreach ($error as $err) {
                        echo $err . "<br>";
                    }
                    ?>
                </div>
                <input class="textbox" type="password" name="password" placeholder="Password" required><br>
                <input class="textbox" type="password" name="password2" placeholder="Retype Password" required><br>
                <br>
                <input type="submit" value="Next" style="float: right;">
                <a href="forgot.php">
                    <input type="button" value="Start Over">
                </a>
                <br><br>
                <div><a href="login.php">Login</a></div>
            </form>
            <?php
            break;

        default:
            break;
    }
    ?>
</body>
</html>
