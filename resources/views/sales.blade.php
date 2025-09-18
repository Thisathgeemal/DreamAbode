<x-guest-layout>
    <!-- hero section 1 -->
    <section class="relative h-[550px] flex flex-col md:flex-row items-center mt-6">
        <!-- Text Section -->
        <div
            class="flex flex-col justify-center w-full md:w-[45%] pl-4 md:pl-[7%] h-auto md:h-full mt-10 md:mt-0 order-2 md:order-1">
            <h1 class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left">
                Find Your <br> Dream Home <br> Today!
            </h1>
            <h2
                class="mt-4 md:mt-[6%] text-[4vw] md:text-[1.6vw] font-normal text-black poppins text-center md:text-left">
                Discover exceptional properties tailored to <br class="hidden md:block"> your lifestyle. Explore our
                exclusive listings <br class="hidden md:block"> and make your dream home a reality with <br
                    class="hidden md:block"> Dream Abode.
            </h2>
        </div>

        <!-- Image & Ad Button Section -->
        <div
            class="flex flex-col justify-center items-center md:items-end relative w-full md:w-[55%] h-[250px] md:h-full pr-0 order-1 md:order-2 mt-6 md:mt-0">
            <!-- background image -->
            <div class="flex items-center justify-center w-full h-full">
                <img src="./images/SalesBg.png" alt="Sales Bg"
                    class="w-[90vw] h-[250px] md:w-[90%] md:h-[95%] object-contain">
            </div>

            <!-- Mobile: Only small floating button -->
            <a href="{{ route('member.property.postAd') }}"
                class="absolute bottom-[-35px] right-4 md:hidden flex items-center justify-center z-50">
                <div
                    class="w-12 h-12 bg-[#5CFFAB] border border-black rounded-full flex items-center justify-center transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
                    <img src="./images/ReviewButton.png" alt="Review" class="w-10 h-10 object-contain">
                </div>
            </a>

            <!-- Desktop: Full button -->
            <a href="{{ route('member.property.postAd') }}"
                class="hidden md:flex absolute md:bottom-[-1%] md:right-[18%] w-[16%] h-[7.5%] items-center justify-end z-50">
                <div
                    class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center">
                    <div
                        class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full flex items-center justify-center">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[24%] left-[35%] text-[0.9vw] text-black font-medium">Post Your
                        Ad</span>
                </div>
            </a>
        </div>
    </section>

    <!-- property listings -->
    @livewire('property-card', ['postType' => 'sale'])

</x-guest-layout>
