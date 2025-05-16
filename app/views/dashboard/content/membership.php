<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DreamAbode</title>
    <link href="<?php echo BASE_URL . "/public/css/styles.css" ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <section class="p-10 w-full">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-10">Choose Your Plan</h1>
            <div class="flex flex-col md:flex-row gap-6 items-center justify-center">

                <div class="w-[320px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                    <img src="./images/Silver.jpg" alt="Silver" class="w-60 h-60 object-contain">
                    <h3 class="text-lg font-bold mb-2">Silver</h3>
                    <div  class="flex flex-row p-2">
                        <img src="./images/money.png" alt="Money" class="w-5 ">
                        <p class="text-sm text-center font-semibold pl-2">Rs 10750.00/month</p>
                    </div>
                    <p class="text-sm text-center leading-[2]">Elevate your experience with added perks and exclusive member benefits, designed to give you more value and convenience.</p>
                    <button class="w-[100px] h-[40px] text-sm rounded-md bg-white text-black mt-4 border border-green-400 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                        Get Started
                    </button>
                </div>

                <div class="w-[320px] h-[400px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                    <img src="./images/Gold.jpg" alt="Gold" class="w-60 h-60 object-contain">
                    <h3 class="text-lg font-bold mb-2">Gold</h3>
                    <div  class="flex flex-row p-2">
                        <img src="./images/money.png" alt="Money" class="w-5 ">
                        <p class="text-sm text-center font-semibold pl-2">Price on request</p>
                    </div>
                    <p class="text-sm text-center leading-[2]">Unlock the Golden experience with premium privileges, priority access, and exclusive opportunities tailored for top-tier members.</p>
                    <button class="w-[100px] h-[40px] text-sm rounded-md bg-white text-black mt-4 border border-green-400 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                        Get Started
                    </button>
                </div>

            </div>
        </div>
    </section>

</body>
</html>