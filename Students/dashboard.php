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
    <div class="flex">
        <div class="bg-gray-800 w-64 sticky top-0">
            <?php include '../partials/_sidebar.php'; ?>
            <!-- <a href="logout.php" class="logout-button">Logout</a> -->
        </div>
        <div class="container flex justify-center items-center">
            <div class="p-6">
                <div class="w-full bg-gray-200 p-6 rounded-xl shadow-xl">
                    <p>Welcome to Student ID Replacement!!</p>
                    <p>Replacement your Damaged or Lost School ID Hassle-free!!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
