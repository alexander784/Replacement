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
    </style>
</head>
<body>
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid f-flex justify-content-between align-items-center">
            <a href="../index.php">
            <img src="../assets/Zetech.png" alt="" style="height: 30px; margin-right: 10px;">
            </a>
            <div class="mx-auto text-center text-white">
                Student ID Replacement 
            </div>
            <div class="text-white">
                <?php if (isset($_SESSION['name'])): ?>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>
