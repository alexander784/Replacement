<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
    <script>
        function loadContent(page) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('main_content').innerHTML = xhr.responseText;
                }
            }
            xhr.send();
        }

        window.onload = function() {
            loadContent('default_content.php');
        }
    </script>
</head>
<body>
    <?php include '../partials/_topnav.php'; ?>
    <div class="flex h-screen">
        <div class="bg-gray-800 w-64">
            <?php include '../partials/_sidebar.php'; ?>
            <!-- <a href="logout.php" class="logout-button">Logout</a> -->
        </div>
        <div class="flex-1 bg-gray-200">
            <div class="p-6">
                <div id="main_content">
                    Welcome to Student ID Replacement!!
                </div>
            </div>
        </div>
    </div>
</body>
</html>
