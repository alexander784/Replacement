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
        
        header("Location: student_dashboard.php");
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
</head>
<body>
    <h2>Student Dashboard</h2>
    <h3>Submit ID Replacement Request</h3>
    <form action="submit_request.php" method="post">
        Name: <input type="text" name="name" required><br>
        Student ID: <input type="text" name="student_id" required><br>
        Lost Reason: <textarea name="lost_reason" required></textarea><br>
        Faculty: <input type="text" name="faculty" required><br>
        Place Lost: <input type="text" name="place_lost" required><br>
        <button type="submit">Submit Request</button>
    </form>
