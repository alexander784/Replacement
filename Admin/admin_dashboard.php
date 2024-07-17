<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM id_requests";
$result = $mysqli->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    $notification = "";

    if (isset($_POST['approve'])) {
        $update_sql = "UPDATE id_requests SET status = 'Approved', notification = 'Your details have been approved. Please come collect your ID.' WHERE id = $id";
        $mysqli->query($update_sql);
    } elseif (isset($_POST['reject'])) {
        $update_sql = "UPDATE id_requests SET status = 'Rejected', notification = 'Your details have been rejected. Please re-enter your details.' WHERE id = $id";
        $mysqli->query($update_sql);
    }

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
      <?php include './partials/_topnav.php'; ?>
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
                        <th>Status</th>
                        <th>Action</th>
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
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="approve">Approve</button>
                                    <button type="submit" name="reject">Reject</button>
                                </form>
                            </td>
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
    <?php include 'partials/_footer.php'; ?>
</body>
</html>
