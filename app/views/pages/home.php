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
            <div class="absolute top-[60%] left-0 w-[34%] h-[9.5%] bg-[#5CFFAB] rounded-[0.7vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] shadow-md hover:shadow-lg cursor-pointer">
                <span class="absolute top-[20%] w-full text-center text-[1.4vw] text-black font-normal font-['Poppins'] transition-colors duration-300">
                    Explore Now
                </span>
            </div>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[23.25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/HomeBgOne.png" alt="Home Bg">
            </div>

            <!-- ad post button -->
            <a href="./postAd" class="z-50 absolute top-[91%] left-[81%] w-[8.75%] h-[5.5%]">
                <div class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative">
                    <div class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[20%] left-[35%] text-[0.9vw] text-black font-medium">Post Your Ad</span>
                </div>
            </a>
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
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                    <h3 class="text-[1.6vw] font-medium">2K+</h3>
                    <p class="text-[1vw]">Houses Available</p>
                </div>
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                    <h3 class="text-[1.6vw] font-medium">3K+</h3>
                    <p class="text-[1vw]">Houses Sold</p>
                </div>
                <div class="bg-[#5CFFAB] rounded-[0.8vw] p-[0.6vw] text-center w-[10vw] h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                    <h3 class="text-[1.6vw] font-medium">1K+</h3>
                    <p class="text-[1vw]">Houses Rented</p>
                </div>
            </div>
        </div>
    </section>

    <!-- hero section 3 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[7%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-black font-poppins">What’s Your Next Move</h1>
            <h2 class="text-[1.5vw] text-black font-poppins mt-4">
            Elevate your path to success with our premium services designed for growth and efficiency!
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="mt-8 flex flex-wrap justify-center items-center gap-6">
            <!-- Card Item -->
            <div class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Sale.png" alt="Sale" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find a Property for Sale</h3>
                <p class="text-sm">Find a House, Apartment or Building for sale</p>
            </div>

            <div class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Rental.png" alt="Rental" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find a Property for Rental</h3>
                <p class="text-sm">Find a rented house, annex, apartment or building</p>
            </div>

            <div class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Ad.png" alt="Ad" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Post Your Ad</h3>
                <p class="text-sm">Post your property advertisement</p>
            </div>

            <div class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Homeloan.png" alt="Homeloan" class="w-18 h-18 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find the best home loan rates</h3>
                <p class="text-sm">Compare and find the best home loans for you</p>
            </div>

            <div class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Invest.png" alt="Invest" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Invest in Upcoming Projects</h3>
                <p class="text-sm">Explore new projects and secure your investment before they’re completed</p>
            </div>
        </div>
    </section>

    <!-- hero section 4 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[6%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-black font-poppins">Find the Perfect Property for You</h1>
            <h2 class="text-[1.5vw] text-black font-poppins mt-4">
            Discover your ideal space with ease. Whether it’s your first home or a dream investment, we have something for everyone.
            </h2>
        </div>

    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
