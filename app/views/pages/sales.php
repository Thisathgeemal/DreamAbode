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
        <div class="absolute top-[30%] left-[7%] w-[45%] h-[65%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] font-['Poppins']">
                Find Your <br> Dream Home <br> Today!
            </h1>
            <h2 class="relative top-[43%] left-0 text-[1.6vw] font-normal text-black font-['Poppins']">
                Discover exceptional properties tailored to <br> your lifestyleExplore our exclusive listings <br> and make your dream home a reality with <br> Dream Abode.
            </h2>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/SalesBg.png" alt="Sales Bg">
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
    <section class="relative mt-[40%] flex flex-col items-center p-8 space-y-12">
        <!-- Search Bar -->
        <div class="w-full flex justify-center mt-10">
            <!-- Search Bar Container -->
            <div class="bg-green-200 p-4 rounded-full shadow-md flex flex-wrap gap-3 items-center justify-center w-[70%] max-w-4xl" id="searchBar">

                <!-- Location -->
                <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                <img src="./images/Location.png" alt="Location" class="w-3 mx-3">
                <input type="text" placeholder="Location" class="outline-none w-full bg-transparent" />
                </div>

                <!-- Property Type -->
                <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                <img src="./images/Houses.png" alt="PropertyType" class="w-4 mx-3">
                <input type="text" placeholder="Property Type" class="outline-none w-full bg-transparent" />
                </div>

                <!-- Max Price -->
                <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                <img src="./images/Price.png" alt="Price" class="w-5 mx-3">
                <input type="text" placeholder="Max Price" class="outline-none w-full bg-transparent" />
                </div>

                <!-- More Button -->
                <div id="moreBtn" class="bg-white rounded-lg px-1 py-2 flex items-center justify-center w-10 h-10 cursor-pointer">
                <img src="./images/More.png" alt="More" class="w-5 mx-4">
                </div>

                <!-- Search Button -->
                <button id="searchBtn" class="bg-[#42e697] transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black font-bold py-2 px-6 rounded-full">
                Search
                </button>

                <!-- Extra Inputs (Hidden Initially) -->
                <div id="moreInputs" class="hidden flex-wrap gap-3 justify-center w-full mt-3">

                    <!-- Min Perches -->
                    <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                        <img src="./images/Perches.png" alt="Perches" class="w-5 mx-3">
                        <input type="text" placeholder="Min Perches" class="outline-none w-full bg-transparent" />
                    </div>

                    <!-- Min Bedrooms -->
                    <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                        <img src="./images/Bedrooms.png" alt="Bedrooms" class="w-4 mx-3">
                        <input type="text" placeholder="Min Bedrooms" class="outline-none w-full bg-transparent" />
                    </div>

                    <!-- Min Bathrooms -->
                    <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                        <img src="./images/Bathrooms.png" alt="Bathrooms" class="w-5 mx-3">
                        <input type="text" placeholder="Min Bathrooms" class="outline-none w-full bg-transparent" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Categories -->
        <div class="text-center space-y-6">
            <h2 class="text-4xl font-bold py-3">Find Exactly What You Need</h2>
            <div class="grid grid-cols-3 gap-4 max-w-3xl mx-auto">
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Houses</span>
                    <img src="./images/Houses.png" alt="Houses" class="w-5 mx-3">
                </div>
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Apartments</span>
                    <img src="./images/Apartments.png" alt="Apartments" class="w-5 mx-3">
                </div>
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Commercial</span>
                    <img src="./images/Commercial.png" alt="Commercial" class="w-5 mx-3">
                </div>
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Villas</span>
                    <img src="./images/Villas.png" alt="Villas" class="w-6 mx-3">
                </div>
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Bungalows</span>
                    <img src="./images/Bungalows.png" alt="Bungalows" class="w-6 mx-3">
                </div>
                <div class="bg-green-300 transition duration-300 ease-in-out hover:scale-105 hover:bg-green-400 cursor-pointer text-black px-6 py-4 rounded-lg shadow-md flex justify-between items-center">
                    <span class="font-semibold">Lands</span>
                    <img src="./images/Lands.png" alt="Lands" class="w-7 mx-3">
                </div>
            </div>
        </div>
    </section>

    <!-- hero section 3 -->
    <section>

    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

    <script>
    const moreBtn = document.getElementById('moreBtn');
    const moreInputs = document.getElementById('moreInputs');
    const searchButton = document.getElementById('searchBtn');

    moreBtn.addEventListener('click', () => {
        moreInputs.classList.remove('hidden');
        moreInputs.classList.add('flex');
        moreBtn.classList.add('hidden');
    });

    searchButton.addEventListener('click', () => {
        moreInputs.classList.add('hidden');
        moreInputs.classList.remove('flex');
        moreBtn.classList.remove('hidden');
    });
    </script>

</body>
</html>
