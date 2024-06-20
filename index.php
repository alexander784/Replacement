<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student ID Replacement</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
    <?php include './partials/_topnav.php'; ?>
    <div class="image-container">
        <img src="./assets/slider.jpg" alt="slider" class="responsive-image"/>
    </div>
      <!-- <div class="replace">
        <p>Student ID Replacement</p>
    </div> -->
    <h1 class="text-4xl font-3 mb-6 text-center">Zetech University Student ID Replacement</h1>
    <section class="services">
        <div class="container">
            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">#Step 1</h3>
                    <p>Initiate Request</p>
                </div>
            </div>
            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">#Step2</h3>
                    <p>Fill in Your Details</p>
                    <p><a href="Students/login.php">Login</a></p>
                    <!-- <a href="submit_request.php"></a> -->
                </div>
            </div>

            <div class="column">
                <div class="service-box">
                    <h3 class="service-title">#Step3</h3>
                    <p>Make Necessary Payments</p>
                    <p>Replacement: 500/= </p>
                </div>
            </div>
            
        </div>
    </section>
    <?php include 'partials/_footer.php'; ?>
</body>
</html>
