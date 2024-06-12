<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM id_requests";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h3>ID Replacement Requests</h3>
        <?php if ($result && $result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Student ID</th>
                        <th>Lost Reason</th>
                        <th>Faculty</th>
                        <th>Place Lost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['student_id']; ?></td>
                            <td><?php echo $row['lost_reason']; ?></td>
                            <td><?php echo $row['faculty']; ?></td>
                            <td><?php echo $row['place_lost']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No ID replacement requests found.</p>
        <?php endif; ?>

        <br>
    </div>

    <a href="logout.php" class="logout-button">Logout</a>

</body>
</html>
