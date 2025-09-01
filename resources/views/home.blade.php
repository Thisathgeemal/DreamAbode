<x-guest-layout>
    <!-- hero section 1 -->
    <section class="relative h-[550px] flex flex-col md:flex-row items-center mt-10">
        <div class="flex flex-col justify-center absolute md:static top-0 left-0 h-full w-full md:w-auto">
            <div class="flex flex-col md:flex-row h-full w-full">
                <!-- Image and Ad Button Section -->
                <div
                    class="flex flex-col justify-center items-center md:items-end relative w-full md:w-[65%] h-[250px] md:h-full pr-0 order-1 md:order-2">
                    <!-- background image  -->
                    <div class="flex items-center justify-center mt-6 md:mt-[4.25%] w-full">
                        <img src="./images/HomeBgOne.png" alt="Home Bg"
                            class="w-[90vw] h-[250px] md:w-[92%] md:h-[92%] object-contain">
                    </div>

                    <!-- Mobile: Only show image in right corner below -->
                    <a href="./postAd"
                        class="absolute bottom-[-25px] right-2 w-12 h-12 md:hidden flex items-center justify-center z-50">
                        <div
                            class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center justify-center">
                            <img src="./images/ReviewButton.png" alt="Review" class="w-10 h-10 object-contain">
                        </div>
                    </a>

                    <!-- Desktop: Show full button -->
                    <a href="./postAd"
                        class="hidden md:flex absolute md:bottom-[2%] md:right-[15%] w-[15%] h-[7.5%] items-center justify-end z-50">
                        <div
                            class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center">
                            <div
                                class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full flex items-center justify-center">
                                <img src="./images/ReviewButton.png" alt="Review"
                                    class="w-full h-full object-contain">
                            </div>
                            <span class="absolute top-[23%] left-[35%] text-[0.9vw] text-black font-medium">Post Your
                                Ad</span>
                        </div>
                    </a>
                </div>

                <!-- Text Section (Below image on mobile, left on desktop) -->
                <div
                    class="flex flex-col justify-center relative w-full md:w-[45%] pl-0 md:pl-[7%] h-auto md:h-full mt-10 md:mt-[3%] order-2 md:order-1">
                    <h1
                        class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left px-12 md:px-0 md:pr-30">
                        Find Your Dream Home with Ease
                    </h1>
                    <h2
                        class="mt-4 md:mt-[6%] text-[4vw] md:text-[1.5vw] font-normal text-black poppins px-6 md:px-0 text-center md:text-left">
                        Explore Our Curated Selection of Modern <br class="hidden md:block"> Homes and Prime Properties
                    </h2>
                    <div
                        class="mx-auto md:mx-0 mt-4 md:mt-[6%] w-[40vw] md:w-[40%] h-[40px] md:h-[9.5%] bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.7vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] shadow-md hover:shadow-lg cursor-pointer z-10 flex items-center justify-center">
                        <span
                            class="text-[4vw] md:text-[1.4vw] text-black font-normal poppins transition-colors duration-300">
                            Explore Now
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- hero section 2 -->
    <section class="relative flex flex-col md:flex-row items-center justify-center h-[700px] md:h-[550px]">
        <!-- background image  -->
        <div
            class="flex-1 flex justify-center mt-20 items-center md:justify-center md:items-center w-full md:w-[50%] h-full">
            <img src="./images/HomeBgTwo.png" alt="Home Bg" class="w-[90vw] md:w-[80%] h-auto object-contain">
        </div>

        <!-- text  -->
        <div
            class="flex-1 flex flex-col justify-center items-center md:items-center w-full md:w-[40%] h-full px-6 md:px-0 mt-8 md:pr-20 md:mt-15">
            <h1
                class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left mb-6 md:mb-6 md:px-30">
                The Perfect Place to Manage Your Property
            </h1>
            <h2
                class="text-[4vw] md:text-[1.5vw] font-normal text-black poppins text-center md:text-left md:mb-0 md:px-30">
                Experience the power of the finest property management tools on the market and take your operations to
                the next level!
            </h2>
            <div
                class="flex flex-col md:flex-row gap-4 md:gap-[1.5vw] mt-8 w-full md:w-auto justify-center items-center md:justify-center md:items-center">
                <div
                    class="bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.8vw] p-4 md:p-[0.6vw] text-center w-[40vw] md:w-[10vw] h-[18vw] md:h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer flex flex-col justify-center items-center">
                    <h3 class="text-[6vw] md:text-[1.6vw] font-medium">2K+</h3>
                    <p class="text-[3vw] md:text-[1vw]">Houses Available</p>
                </div>
                <div
                    class="bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.8vw] p-4 md:p-[0.6vw] text-center w-[40vw] md:w-[10vw] h-[18vw] md:h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer flex flex-col justify-center items-center">
                    <h3 class="text-[6vw] md:text-[1.6vw] font-medium">3K+</h3>
                    <p class="text-[3vw] md:text-[1vw]">Houses Sold</p>
                </div>
                <div
                    class="bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.8vw] p-4 md:p-[0.6vw] text-center w-[40vw] md:w-[10vw] h-[18vw] md:h-[6vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer flex flex-col justify-center items-center">
                    <h3 class="text-[6vw] md:text-[1.6vw] font-medium">1K+</h3>
                    <p class="text-[3vw] md:text-[1vw]">Houses Rented</p>
                </div>
            </div>
        </div>
    </section>

    <!-- hero section 3 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[40%] md:mt-[5%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl px-6">
            <h1 class="text-[7vw] md:text-[3.5vw] font-bold text-black poppins leading-tight">What’s Your Next Move</h1>
            <h2 class="text-[4vw] md:text-[1.5vw] text-black poppins mt-4 leading-snug">
                Elevate your path to success with our premium services designed for growth and efficiency!
            </h2>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-6">
            <!-- Card Item -->
            <div
                class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Sale.png" alt="Sale" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find a Property for Sale</h3>
                <p class="text-sm">Find a House, Apartment or Building for sale</p>
            </div>

            <div
                class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Rental.png" alt="Rental" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find a Property for Rental</h3>
                <p class="text-sm">Find a rented house, annex, apartment or building</p>
            </div>

            <div
                class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Ad.png" alt="Ad" class="w-20 h-20 object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Post Your Ad</h3>
                <p class="text-sm">Post your property advertisement today and reach more buyers and renters</p>
            </div>

            <div
                class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Homeloan.png" alt="Homeloan" class="w-[70px] h-[60px] object-contain mb-4">
                <h3 class="text-lg font-semibold mb-2">Find the best home loan rates</h3>
                <p class="text-sm">Compare and find the best home loans for you</p>
            </div>

            <div
                class="w-[250px] h-[250px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/Invest.png" alt="Invest" class="w-20 h-20 object-contain mb-3">
                <h3 class="text-lg font-semibold mb-2">Invest in Upcoming Projects</h3>
                <p class="text-sm">Explore new projects and secure your investment before they’re completed</p>
            </div>
        </div>
    </section>
</x-guest-layout>
