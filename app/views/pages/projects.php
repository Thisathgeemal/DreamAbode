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
        <div class="absolute top-[36%] left-[7%] w-[45%] h-[65%]">
            <h1 class="absolute top-0 left-0 text-[3.5vw] font-bold text-black leading-[1.15] font-['Poppins']">
                Our Journey <br> of Excellence
            </h1>
            <h2 class="relative top-[32%] left-0 text-[1.6vw] font-normal text-black font-['Poppins']">
                Stay updated with our ongoing, upcoming, and <br> completed projects, showcasing innovation, <br> quality, and excellence in every build.
            </h2>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[22%] left-[52%] w-[36%]">
                <img src="./images/ProjectBg.png" alt="Project Bg">
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
                <img src="./images/Status.png" alt="Project Status" class="w-5 mx-3">
                <input type="text" placeholder="Project Status" class="outline-none w-full bg-transparent" />
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

                    <!-- Min SQFT -->
                    <div class="bg-white rounded-lg px-4 py-2 flex items-center space-x-2 w-48">
                        <img src="./images/Perches.png" alt="SQFT" class="w-5 mx-3">
                        <input type="text" placeholder="Min SQFT" class="outline-none w-full bg-transparent" />
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
