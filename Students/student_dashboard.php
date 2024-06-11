<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = $mysqli->query("SELECT * FROM id_requests WHERE user_id = $user_id");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $lost_reason = $_POST['lost_reason'];
    $faculty = $_POST['faculty'];
    $place_lost = $_POST['place_lost'];

    $update_stmt = $mysqli->prepare("UPDATE id_requests SET name = ?, student_id = ?, lost_reason = ?, faculty = ?, place_lost = ? WHERE id = ?");
    if ($update_stmt) {
        $update_stmt->bind_param("sssssi", $name, $student_id, $lost_reason, $faculty, $place_lost, $id);
        if ($update_stmt->execute()) {
            header("Location: $_SERVER[PHP_SELF]");
            exit();
        } else {
            $error = "Failed to update information.";
        }
    } else {
        $error = "Prepare failed: " . htmlspecialchars($mysqli->error);
    }
}

?>

<h3>Your Submitted Info</h3>
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
        <th>Edit</th>
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

<?php
$result->free();
?>
