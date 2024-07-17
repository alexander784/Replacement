<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>NavBar</title>
    <style>
        #navbar-main {
            background-color: #041E42;
            height: 10vh;
        }
        #navbar-main img {
            height: 30px;
            margin-right: 10px;
        }
        #navbar-main .navbar-text {
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="../index.php" class="navbar-brand d-flex align-items-center">
                <img src="../assets/logo.png" alt="">
            </a>
            <div class="mx-auto text-center text-white navbar-text">
                Student ID Replacement
            </div>
            <div class="navbar-text">
                <?php if (isset($_SESSION['name'])): ?>
                    <a href="../user_info.php" class="text-white"><?php echo htmlspecialchars($_SESSION['name']); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
