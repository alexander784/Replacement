<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT * FROM id_requests WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
    unset($_SESSION['success_message']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome to the Student Dashboard</h2>
    
    <h3>Your Submitted ID Replacement Requests</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Lost Reason</th>
            <th>Faculty</th>
            <th>Place Lost</th>
            <th>Status</th>
            <th>Request Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['student_id']); ?></td>
            <td><?php echo htmlspecialchars($row['lost_reason']); ?></td>
            <td><?php echo htmlspecialchars($row['faculty']); ?></td>
            <td><?php echo htmlspecialchars($row['place_lost']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['request_date']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
<?php
$stmt->close();
?>
