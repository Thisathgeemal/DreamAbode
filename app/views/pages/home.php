<!DOCTYPE html>
<html lang="en">
<?php
    define('BASE_URL', '/DreamAbode');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="<?php echo BASE_URL . "/public/css/styles.css" ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php
        require_once __DIR__ . '/../includes/header.php';
    ?>

    <!-- hero section 1 -->
    <section>
        <!-- text  -->
        <div class="absolute top-[33%] left-[7%] w-[45%] h-[75%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] font-['Poppins']">
                Find Your <br> Dream Home <br> with Ease
            </h1>
            <h2 class="relative top-[40%] left-0 text-[1.6vw] font-normal text-black font-['Poppins']">
                Explore Our Curated Selection of Modern <br> Homes and Prime Properties
            </h2>
            <div class="absolute top-[60%] left-0 w-[34%] h-[9.5%] bg-[#5CFFAB] rounded-[0.7vw]">
                <span class="absolute top-[20%] w-[100%] text-center text-[1.4vw] text-black font-normal font-['Poppins']">Explore Now</span>
            </div>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[23.25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/HomeBgOne.png" alt="Home Bg">
            </div>

            <!-- review button  -->
            <div class="absolute top-[91%] left-[81%] w-[8.75%] h-[5.5%] bg-[#5CFFAB] border border-black rounded-full">
                <div class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full">
                    <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                </div>
                <span class="absolute top-[20%] left-[34%] text-[0.9vw] text-black font-medium">Post Your Ad</span>
            </div>
        </div>

    </section>

    <!-- hero section 2 -->
    <section class="relative mt-[30%] h-[100vh]">
        <!-- background image  -->
        <div class="absolute top-[215px] left-[7%] w-[42%]">
            <img src="./images/HomeBgTwo.png" alt="Home Bg">
        </div>

        <!-- text  -->
        <div class="absolute top-[32%] left-[60%] w-[33%] h-[75%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] font-['Poppins']">
                The Perfect Place to Manage Your Property
            </h1>
           <h2 class="relative top-[40%] left-0 text-[1.5vw] font-normal text-black font-['Poppins']">
                Experience the power of the finest property management tools on the market and take your soperations to the next level!
            </h2>

            <div class="flex gap-[1.5vw] relative top-[48%]">
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw]">
                    <h3 class="text-[1.6vw] font-medium">2K+</h3>
                    <p class="text-[1vw]">Houses Available</p>
                </div>
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw]">
                    <h3 class="text-[1.6vw] font-medium">3K+</h3>
                    <p class="text-[1vw]">Houses Sold</p>
                </div>
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw]">
                    <h3 class="text-[1.6vw] font-medium">1K+</h3>
                    <p class="text-[1vw]">Houses Rented</p>
                </div>
            </div>
        </div>
    </section>


</body>
</html>
