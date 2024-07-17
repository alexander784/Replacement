<?php
session_start();
include('../config.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $student_id = trim($_POST['student_id']);
    $faculty = trim($_POST['faculty']);
    $lost_reason = trim($_POST['lost_reason']);
    $place_lost = trim($_POST['place_lost']);
    $user_id = $_SESSION['user_id'];

    $stmt = $mysqli->prepare("INSERT INTO id_requests (user_id, name, student_id, lost_reason, faculty, place_lost) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("isssss", $user_id, $name, $student_id, $lost_reason, $faculty, $place_lost);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Details successfully submitted!";
            header("Location: submit_request.php");
            exit();
        } else {
            $error = "Error: " . $mysqli->error;
        }
    } else {
        $error = "Prepare failed: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submit ID Replacement Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include("../partials/_topnav.php"); ?>
    <div class="flex">
    <?php include("../partials/_sidebar.php"); ?>

    <div class="container mx-auto flex justify-center items-center">
        <div class="top-0 right-0 max-w-lg w-full bg-white rounded-lg shadow-md p-6">
            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6' role='alert'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
                unset($_SESSION['success_message']);
            }
            ?>
            <h3 class="text-2xl font-bold mb-6">ID Replacement Form</h3>
            <form class="space-y-4" action="submit_request.php" method="post">
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>" class="px-4 py-2 border border-gray-300 rounded">
                </div>
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">ID:</label>
                    <input type="text" name="student_id" value="<?php echo htmlspecialchars($_SESSION['student_id'] ?? ''); ?>" class="px-4 py-2 border border-gray-300 rounded">
                </div>
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Reason Lost:</label>
                    <textarea name="lost_reason" required class="px-4 py-2 border border-gray-300 rounded"></textarea>
                </div>
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Faculty:</label>
                    <select name="faculty" class="px-4 py-2 border border-gray-300 rounded">
                        <option value="Engineering">Engineering</option>
                        <option value="ICT">ICT</option>
                        <option value="HRM">HRM</option>
                        <option value="HRM">Sciences</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="font-semibold mb-1">Place Lost:</label>
                    <input type="text" name="place_lost" required class="px-4 py-2 border border-gray-300 rounded">
                </div>
                <button type="submit" class="bg-blue-900 text-white py-2 px-4 rounded hover:bg-blue-800">Submit</button>
            </form>

            <div class="mt-4 text-center">
                <a href="student_dashboard.php" class="text-blue-900 hover:text-blue-700">View My Info</a>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
