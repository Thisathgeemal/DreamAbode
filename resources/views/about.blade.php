<x-guest-layout>
    <!-- hero section 1 -->
    <section class="relative h-[550px] flex flex-col md:flex-row items-center mt-6">
        <!-- Text Section -->
        <div
            class="flex flex-col justify-center w-full md:w-[45%] pl-4 md:pl-[7%] h-auto md:h-full mt-10 md:mt-0 order-2 md:order-1 relative">
            <h1 class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left">
                Your Trusted <br> Partner in Real <br> Estate
            </h1>
            <h2
                class="mt-4 md:mt-[6%] text-[4vw] md:text-[1.6vw] font-normal text-black poppins text-center md:text-left">
                We’re your trusted partner in finding the <br class="hidden md:block"> perfect property with integrity,
                innovation, <br class="hidden md:block"> and personalized service.
            </h2>

            <!-- Mobile & Desktop: "Discover Our Story" Button -->
            <div
                class="mt-6 md:mt-[6%] w-[50%] md:w-[38%] h-[40px] md:h-[9.5%] bg-[#5CFFAB] rounded-[2vw] md:rounded-[0.7vw] transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] shadow-md hover:shadow-lg cursor-pointer mx-auto md:mx-0 flex items-center justify-center">
                <span
                    class="text-[4vw] md:text-[1.4vw] text-black font-normal poppins text-center transition-colors duration-300">
                    Discover Our Story
                </span>
            </div>
        </div>

        <!-- Image & Review Button Section -->
        <div
            class="flex flex-col justify-center items-center md:items-end relative w-full md:w-[55%] h-[250px] md:h-full pr-0 order-1 md:order-2 mt-6 md:mt-0">
            <!-- background image -->
            <div class="flex items-center justify-center w-full h-full">
                <img src="./images/AboutOneBg.png" alt="About Bg"
                    class="w-[90vw] h-[250px] md:w-[90%] md:h-[95%] object-contain">
            </div>

            <!-- Mobile: Small floating review button -->
            <a href="./review" class="absolute bottom-[-35px] right-4 md:hidden flex items-center justify-center z-50">
                <div
                    class="w-12 h-12 bg-[#5CFFAB] border border-black rounded-full flex items-center justify-center transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
                    <img src="./images/ReviewButton.png" alt="Review" class="w-10 h-10 object-contain">
                </div>
            </a>

            <!-- Desktop: Full review button -->
            <a href="./review"
                class="hidden md:flex absolute md:bottom-[-1%] md:right-[18%] w-[16%] h-[7.5%] items-center justify-end z-50">
                <div
                    class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center">
                    <div
                        class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full flex items-center justify-center">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[23%] left-[35%] text-[0.9vw] text-black font-medium">Add review</span>
                </div>
            </a>
        </div>
    </section>
</x-guest-layout>
