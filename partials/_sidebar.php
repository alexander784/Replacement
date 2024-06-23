<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>ID Replacement</title>
</head>
<body>
<div class="flex h-screen rounded">
    <div class="bg-gray-800 w-64 flex flex-col justify-between rounded ">
        <div class="py-6 px-4">
            <ul class="mt-6">
                <li class="mb-2"><a href="#" class="text-gray-300 hover:text-white">Dashboard</a></li>
                <li class="mb-2"><a href="student_dashboard.php" class="text-gray-300 hover:text-white">View Info</a></li>
                <li class="mb-2"><a href="submit_request.php" class="text-gray-300 hover:text-white">Replace ID</a></li>
            </ul>
        </div>
        <div class="py-4 px-4">
            <a href="logout.php" class="block text-center bg-blue-900 text-white py-2 rounded">Logout</a>
        </div>
    </div>
    <div class="flex-1">
    </div>
</div>
</body>
</html>
