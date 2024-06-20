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
        }

        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topnav {
            background-color: #041E42;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 25px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #555;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .main-content {
            flex: 1;
            background-color: #f0f0f0;
            padding: 20px;
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

        form {
            display: flex;
            gap: 10px;
        }

        form input[type="text"], form button {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #041E42;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include '../partials/_topnav.php'; ?>

        <div class="flex">
            <div class="sidebar">
                <?php include '../partials/_sidebar.php'; ?>
                <a href="logout.php" class="logout-button">Logout</a>
            </div>
            <div class="main-content">
                <h3>Your Submitted Info</h3>
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
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No ID replacement requests found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$result->free();
?>
