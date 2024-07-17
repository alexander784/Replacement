<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student ID Replacement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body class="bg-white text-black">
    <?php include './partials/_topnav.php'; ?>
    
    <h1 class="text-3xl mb-6 text-center">Zetech University Student ID Replacement Portal.</h1>
    

    <section class="bg-white shadow-md">
        <div class="bg-gray-200 shadow-xl container mx-auto py-4 px-4">
            <div class="flex flex-wrap justify-center">
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4 mb-8">
                    <div class="bg-gray-100 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-center">#Step 1</h3>
                        <hr class="bold">
                        <p class="text-lg">Visit the Replacement Website</p>
                    </div>
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4 mb-8">
                    <div class="bg-gray-100 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-center">#Step 2</h3>
                        <hr>
                        <p class="text-lg text-center">Upload Your Details</p>
                        <p class="mt-4 text-center"><a href="./login.php" class="text-blue-500 ">Login</a></p>
                    </div>
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 xl:w-1/3 px-4 mb-8">
                    <div class="bg-gray-100 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-center">#Step 3</h3>
                        <hr>
                        <p class="text-lg">Make Necessary Payments</p>
                        <p class="mt-4">Replacement: 500/= </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php include 'partials/_footer.php'; ?>
</body>
</html>
