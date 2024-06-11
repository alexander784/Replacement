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
        $_SESSION['success_message'] = "Details successfully submitted!!";
        header("Location:submit_request.php");
        // header("Location: student_dashboard.php");
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <?php
        session_start();
        if(isset($_SESSION['success_message'])) {
            echo "<div class='success-message'>" . $_SESSION['success_message']. "</div>";
            unset($_SESSION['success_message']);
        }
        ?>
        <!-- <h2>Student Dashboard</h2> -->
        <h3>Submit ID Replacement Form</h3>
        <form action="submit_request.php" method="post">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="text" name="student_id" placeholder="Student ID" required><br>
            <textarea name="lost_reason" placeholder="Lost Reason" required></textarea><br>
            <input type="text" name="faculty" placeholder="Faculty" required><br>
            <input type="text" name="place_lost" placeholder="Place Lost" required><br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
