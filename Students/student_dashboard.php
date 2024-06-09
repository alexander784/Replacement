<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = $mysqli->query("SELECT * FROM id_requests WHERE user_id = $user_id");

?>

    <h3>Your Submitted Requests</h3>
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
</body>
</html>
<?php
$result->free();
?>
