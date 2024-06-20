<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $lost_reason = $_POST['lost_reason'];
    $faculty = $_POST['faculty'];
    $place_lost = $_POST['place_lost'];
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO id_requests (user_id, name, student_id, lost_reason, faculty, place_lost) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("isssss", $user_id, $name, $student_id, $lost_reason, $faculty, $place_lost);
        $stmt->execute();
        $stmt->close();
        $_SESSION['success_message'] = "Details successfully submitted!";
        header("Location: submit_request.php");
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit ID Replacement Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .topnav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .container {
            display: flex;
            flex: 1;
            margin-top: 50px;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 15px;
            height: calc(100vh - 50px);
            position: fixed;
            top: 50px;
            left: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #575757;
            padding-left: 10px;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            box-sizing: border-box;
        }

        .dashboard-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        .compact-form {
            display: flex;
            flex-direction: column;
        }

        .compact-form label {
            margin-top: 10px;
        }

        .compact-form input,
        .compact-form textarea,
        .compact-form select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        .compact-form button {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 15px;
            cursor: pointer;
        }

        .compact-form button:hover {
            background-color: #555;
        }

        .success-message {
            color: green;
            margin-bottom: 15px;
        }

        .view-details-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .view-details-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php include ("../partials/_topnav.php");?>
    <div class="container">
        <?php include ("../partials/_sidebar.php");?>
        <div class="main-content">
            <div class="dashboard-container">
                <?php
                if(isset($_SESSION['success_message'])) {
                    echo "<div class='success-message'>" . htmlspecialchars($_SESSION['success_message']). "</div>";
                    unset($_SESSION['success_message']);
                }
                ?>
                <h3>Submit ID Replacement Form</h3>
                <form class="compact-form" action="submit_request.php" method="post">
                    <label>Name:</label>
                    <input type="text" name="name" required><br>
                    <label>Student ID:</label>
                    <input type="text" name="student_id" required><br>
                    <label>Reason Lost:</label>
                    <textarea name="lost_reason" required></textarea><br>
                    <label for="faculty">Faculty:</label>
                    <select name="faculty" id="faculty" required>
                        <option value="engineering">Engineering</option>
                        <option value="hrm">HRM</option>
                        <option value="ict">ICT</option>
                        <option value="media">Media</option>
                    </select><br>
                    <label>Place Lost:</label>
                    <input type="text" name="place_lost" required><br>
                    <button type="submit">Submit</button>
                </form>

                <br>
                <a href="student_dashboard.php" class="view-details-button">View My Info</a>
            </div>
        </div>
    </div>
</body>
</html>
