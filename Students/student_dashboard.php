<?php
session_start();
include('../config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM id_requests WHERE user_id = $user_id";
$result = $mysqli->query($sql);

$notification_sql = "SELECT notification FROM id_requests WHERE user_id = $user_id AND notification IS NOT NULL";
$notification_result = $mysqli->query($notification_sql);
$notification = "";

if ($notification_result && $notification_result->num_rows > 0) {
    $row = $notification_result->fetch_assoc();
    $notification = $row['notification'];

    $clear_sql = "UPDATE id_requests SET notification = NULL WHERE user_id = $user_id";
    $mysqli->query($clear_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Submitted Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topnav {
            background-color: #041E42;
            color: white;
            padding: 10px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .logout-button {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            background-color: #333;
            border-radius: 4px;
        }

        .logout-button:hover {
            background-color: #555;
        }

        .flex {
            display: flex;
            margin-top: 60px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #041E42;
            color: white;
        }

        table tr:hover {
            background-color: #f2f2f2;
        }

        .rejected {
            color: red;
        }
    </style>
    <script>
        function showNotification(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <?php include '../partials/_topnav.php'; ?>

    <div class="flex">
        <?php include '../partials/_sidebar.php'; ?>

        <div class="main-content">
            <h3>Your Submitted Info</h3>

            <?php if ($notification): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showNotification("<?php echo $notification; ?>");
                    });
                </script>
            <?php endif; ?>

            <?php if ($result && $result->num_rows > 0) : ?>
                <table>
                    <thead>
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
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr class="<?php echo $row['status'] == 'Rejected' ? 'rejected' : ''; ?>">
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
                    </tbody>
                </table>
            <?php else : ?>
                <p>No ID replacement requests found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php $result->free(); ?>
</body>
</html>
