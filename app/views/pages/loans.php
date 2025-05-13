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
                Simplifying <br> Home Loans <br> for You
            </h1>
            <h2 class="relative top-[39%] left-0 text-[1.6vw] font-normal text-black font-['Poppins']">
                Let us guide you through the home loan <br> process with personalized advice and <br> solutions to secure the best options for <br> your future home.
            </h2>
        </div>

        <div>
            <!-- background image  -->
            <div class="absolute top-[23.25%] left-[46%] w-[48%] h-[58%]">
                <img src="./images/LoanBg.png" alt="Loan Bg">
            </div>

            <!-- ad post button -->
            <a href="./applyLoan" class="z-50 absolute top-[91%] left-[81%] w-[8.75%] h-[5.5%]">
                <div class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative">
                    <div class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full">
                        <img src="./images/ReviewButton.png" alt="Review" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[20%] left-[35%] text-[0.9vw] text-black font-medium">Apply Now</span>
                </div>
            </a>
        </div>

    </section>

    <!-- hero section 2 -->
    <section class="relative mt-[40%] flex flex-col items-center p-8 space-y-12">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-center text-black font-poppins">Home Loan Calculator</h1>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-10 w-full max-w-2xl">
            <div class="flex-1 space-y-6">
                <!-- Property Value -->
                <div>
                    <label for="propertyValue" class="text-lg font-medium text-gray-700">Property Value</label>
                    <input type="number" id="propertyValue" placeholder="Enter property value"
                        class="mt-1 block w-[300px] bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <!-- Down Payment Percentage -->
                <div>
                    <label for="downPaymentPercentage" class="text-lg font-medium text-gray-700">Down Payment (e.g., 10%)</label>
                    <input type="number" id="downPaymentPercentage" placeholder="Enter percentage"
                        class="mt-1 block w-[300px] bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <!-- Interest Rate -->
                <div>
                    <label for="interestRate" class="text-lg font-medium text-gray-700">Interest Rate (%)</label>
                    <input type="number" id="interestRate" placeholder="Enter interest rate"
                        class="mt-1 block w-[300px] bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <!-- Loan Period -->
                <div>
                    <label for="loanPeriod" class="text-lg font-medium text-gray-700">Loan Period (Years)</label>
                    <input type="number" id="loanPeriod" placeholder="Enter loan period"
                        class="mt-2 block w-[300px] bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <!-- Monthly Payment -->
                <div>
                    <label for="estimatedMonthlyPayment" class="text-lg font-medium text-gray-700">Estimated Monthly Payment</label>
                    <input type="text" id="estimatedMonthlyPayment" value="Rs: 0.00" disabled
                        class="mt-1 block w-[300px] bg-green-50 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none" />
                </div>

                <!-- Loan Amount -->
                <div>
                    <label for="loanAmount" class="text-lg font-medium text-gray-700">Loan Amount</label>
                    <input type="text" id="loanAmount" value="Rs: 0.00" disabled
                        class="mt-1 block w-[300px] bg-green-50 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none" />
                </div>

                <!-- Total Interest Payable -->
                <div>
                    <label for="totalInterestPayable" class="text-lg font-medium text-gray-700">Total Interest Payable</label>
                    <input type="text" id="totalInterestPayable" value="Rs: 0.00" disabled
                        class="mt-1 block w-[300px] bg-green-50 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none" />
                </div>
                <!-- Total Payable (Capital + Interest) -->
                <div>
                    <label for="totalPayable" class="text-lg font-medium text-gray-700">Total Payable (Capital + Interest)</label>
                    <input type="text" id="totalPayable" value="Rs: 0.00" disabled
                        class="mt-1 block w-[300px] bg-green-50 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none" />
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="w-full flex justify-center">
            <button type="submit" class="w-[300px] bg-green-400  hover:bg-green-200 text-black font-semibold py-2 px-4 rounded-md border border-green-300 shadow-sm transition-colors duration-200">Calculate Now</button>
        </div>
    </section>

    <!-- hero section 3 -->
    <section class="relative flex flex-col justify-center items-center text-center mt-[2%]">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-[3.5vw] font-bold text-black font-poppins">Bank Partnership</h1>
        </div>

        <!-- Cards Section -->
        <div class="mt-12 flex flex-wrap justify-center items-center gap-10">
            <!-- Card Item -->
            <div class="w-[350px] h-[450px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/commercialBank.png" alt="Commercial Bank" class="w-60 h-60 object-contain">
                <h3 class="text-lg font-semibold mb-2">Commercial Bank</h3>
                <p class="text-sm text-center leading-[2]">Flexible home loan solutions to suit your needs and goals.</p>
                <div  class="flex flex-row p-2">
                    <img src="./images/money.png" alt="Money" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Up to 10.5M</p>
                </div>
                <div  class="flex flex-row p-2">
                    <img src="./images/Discount.png" alt="Discount" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Starting from 10.5%.</p>
                </div>
                <button class="w-[100px] h-[40px] rounded-md bg-white text-black mt-4 border border-green-400 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                    Inquire
                </button>
            </div>

            <div class="w-[350px] h-[450px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/BOC.png" alt="boc bANK" class="w-60 h-60 object-contain">
                <h3 class="text-lg font-semibold mb-2">Bank of Ceylon (BOC)</h3>
                <p class="text-sm text-center leading-[2]">Affordable housing loans with easy repayment options.</p>
                <div  class="flex flex-row p-2">
                    <img src="./images/money.png" alt="Money" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Up to 9.5M</p>
                </div>
                <div  class="flex flex-row p-2">
                    <img src="./images/Discount.png" alt="Discount" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Starting from 10.5%.</p>
                </div>
                <button class="w-[100px] h-[40px] rounded-md bg-white text-black mt-4 border border-green-400 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                    Inquire
                </button>
            </div>

            <div class="w-[350px] h-[450px] bg-[#5CFFAB] rounded-xl p-4 flex flex-col justify-center items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-md cursor-pointer">
                <img src="./images/sampath.png" alt="Sampath bANK" class="w-60 h-60 object-contain">
                <h3 class="text-lg font-semibold mb-2">Sampath Bank</h3>
                <p class="text-sm text-center leading-[2]">Home loans with competitive rates and flexible payment plans.</p>
                <div  class="flex flex-row p-2">
                    <img src="./images/money.png" alt="Money" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Up to 7.5M</p>
                </div>
                <div  class="flex flex-row p-2">
                    <img src="./images/Discount.png" alt="Discount" class="w-5 ">
                    <p class="text-sm text-center font-semibold pl-2">Starting from 10.5%.</p>
                </div>
                <button class="w-[100px] h-[40px] rounded-md bg-white text-black mt-4 border border-green-400 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer">
                    Inquire
                </button>
            </div>
        </div>
    </section>

    <?php
        require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>
</html>
