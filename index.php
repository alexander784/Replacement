<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student ID Replacement</title>
    <link rel="stylesheet" href="style.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include 'partials/_topnav.php'; ?>
    
    <div class="flex-center position-ref full-height">
        <div class="content">
            
            <div class="home">
                <p>Replace Your lost or Damaged ID hassle free !!</p>
            </div>
            <br>

            <div class="links">
                <a href="Admin/login.php">Admin Log In</a>
                <a href="Students/login.php">Student Log In</a>
            </div>
        </div>
    </div>

    <section class="services">
        <h2 class="para">Why this method</h2>
        <div class="container">
            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">Easier and Faster</h3>
                    <p>Our method is designed to streamline processes, saving you time and effort.</p>
                </div>
            </div>
            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">Secure Way</h3>
                    <p>Security is our top priority, ensuring your data is protected at all times.</p>
                </div>
            </div>
            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">Convenient</h3>
                    <p>Experience the convenience of our user-friendly and accessible platform.</p>
                </div>
            </div>
        </div>
    </section>
    <?php include 'partials/_footer.php'; ?>
</body>
</html>
