<x-guest-layout>
    <!-- hero section 1 -->
    <section class="relative h-[550px] flex flex-col md:flex-row items-center mt-6">
        <!-- Text Section -->
        <div
            class="flex flex-col justify-center w-full md:w-[45%] pl-4 md:pl-[7%] h-auto md:h-full mt-10 md:mt-0 order-2 md:order-1">
            <h1 class="text-[7vw] md:text-[3.5vw] font-bold text-black leading-[1.15] poppins text-center md:text-left">
                Simplifying <br> Home Loans <br> for You
            </h1>
            <h2
                class="mt-4 md:mt-[6%] text-[4vw] md:text-[1.6vw] font-normal text-black poppins text-center md:text-left">
                Let us guide you through the home loan <br class="hidden md:block"> process with personalized advice and
                <br class="hidden md:block"> solutions to secure the best options for <br class="hidden md:block"> your
                future home.
            </h2>
        </div>

        <!-- Image & Apply Button Section -->
        <div
            class="flex flex-col justify-center items-center md:items-end relative w-full md:w-[55%] h-[250px] md:h-full pr-0 order-1 md:order-2 mt-6 md:mt-0">
            <!-- background image -->
            <div class="flex items-center justify-center w-full h-full">
                <img src="./images/LoanBg.png" alt="Loan Bg"
                    class="w-[90vw] h-[250px] md:w-[90%] md:h-[95%] object-contain">
            </div>

            <!-- Mobile: Small floating button -->
            <a href="./applyLoan"
                class="absolute bottom-[-35px] right-4 md:hidden flex items-center justify-center z-50">
                <div
                    class="w-12 h-12 bg-[#5CFFAB] border border-black rounded-full flex items-center justify-center transition duration-300 ease-in-out hover:scale-105 cursor-pointer">
                    <img src="./images/ReviewButton.png" alt="Apply" class="w-10 h-10 object-contain">
                </div>
            </a>

            <!-- Desktop: Full button -->
            <a href="./applyLoan"
                class="hidden md:flex absolute md:bottom-[-1%] md:right-[18%] w-[16%] h-[7.5%] items-center justify-end z-50">
                <div
                    class="w-full h-full bg-[#5CFFAB] border border-black rounded-full transition duration-300 ease-in-out hover:scale-105 cursor-pointer relative flex items-center">
                    <div
                        class="absolute top-[5%] left-[3.25%] w-[26.5%] h-[90%] bg-white rounded-full flex items-center justify-center">
                        <img src="./images/ReviewButton.png" alt="Apply" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-[23%] left-[35%] text-[0.9vw] text-black font-medium">Apply Now</span>
                </div>
            </a>
        </div>
    </section>

    <!-- hero section 2: Home Loan Calculator -->
    <section class="relative md:mt-5 flex flex-col items-center p-8 space-y-12">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-3xl md:text-5xl font-bold text-center text-gray-900 poppins">
                Home Loan Calculator
            </h1>
            <p class="text-lg md:text-xl text-center text-gray-700 mt-2">
                Estimate your monthly payments and total cost of your home loan.
            </p>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-10 w-full max-w-3xl">
            <!-- Input Card -->
            <div class="flex-1 space-y-6 p-6 bg-white rounded-xl shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
                <h2 class="text-xl font-semibold text-gray-800">Loan Details</h2>

                <div>
                    <label for="propertyValue" class="text-sm font-medium text-gray-700">Property Value</label>
                    <input type="number" id="propertyValue" placeholder="Enter property value"
                        class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        min="0">
                </div>

                <div>
                    <label for="downPaymentPercentage" class="text-sm font-medium text-gray-700">Down Payment
                        (%)</label>
                    <input type="number" id="downPaymentPercentage" placeholder="Enter down payment (%)"
                        class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        min="10">
                    <p id="downPaymentWarning" class="text-red-500 text-xs mt-1 hidden">Down payment must be at least
                        10% of the property value.</p>
                </div>

                <div>
                    <label for="interestRate" class="text-sm font-medium text-gray-700">Interest Rate (%)</label>
                    <input type="number" id="interestRate" placeholder="Enter interest rate (Default: 12%)"
                        class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        min="0">
                </div>

                <div>
                    <label for="loanPeriod" class="text-sm font-medium text-gray-700">Loan Period (Years)</label>
                    <input type="number" id="loanPeriod" placeholder="Enter loan period"
                        class="mt-1 block w-full bg-green-100 border border-gray-300 rounded-md shadow-sm p-2 text-black placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                        min="1">
                </div>
            </div>

            <!-- Output Card -->
            <div
                class="flex-1 space-y-6 p-6 bg-white rounded-xl mt-6 md:mt-0 shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
                <h2 class="text-xl font-semibold text-gray-800">Loan Summary</h2>

                <div>
                    <label class="text-sm font-medium text-gray-700">Loan Amount</label>
                    <input type="text" id="loanAmount" value="Rs: 0.00" disabled
                        class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Estimated Monthly Payment</label>
                    <input type="text" id="estimatedMonthlyPayment" value="Rs: 0.00" disabled
                        class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Total Interest Payable</label>
                    <input type="text" id="totalInterestPayable" value="Rs: 0.00" disabled
                        class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Total Payable (Loan Amount + Interest)</label>
                    <input type="text" id="totalPayable" value="Rs: 0.00" disabled
                        class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md shadow-sm p-2 text-black focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Calculate Button -->
        <div class="w-full flex justify-center">
            <button type="button" id="calculateLoan"
                class="w-[250px] bg-[#5CFFAB] hover:bg-[#4de79a] text-black font-semibold py-3 px-4 rounded-md shadow-md transition duration-200">
                Calculate Now
            </button>
        </div>
    </section>

    <!-- hero section 3: Bank Partnership -->
    <section class="relative flex flex-col justify-center items-center text-center mt-2 md:mt-2 px-4">
        <!-- Heading Section -->
        <div class="w-full max-w-6xl">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 poppins">
                Bank Partnerships
            </h1>
            <p class="text-lg md:text-xl text-gray-700 mt-2 md:mt-4 poppins">
                Explore our trusted banking partners offering competitive home loan options.
            </p>
        </div>

        <!-- Cards Section -->
        <div class="mt-10 flex flex-wrap justify-center items-stretch gap-8 max-w-6xl">
            <!-- Card Item -->
            <div
                class="w-[320px] md:w-[350px] bg-gradient-to-br from-[#5CFFAB] to-[#42e697] rounded-xl p-6 flex flex-col justify-between items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl cursor-pointer">
                <img src="./images/commercialBank.png" alt="Commercial Bank"
                    class="w-40 h-40 md:w-60 md:h-60 object-contain">
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Commercial Bank</h3>
                <p class="text-base text-gray-800 leading-relaxed mb-4">Flexible home loan solutions to suit your needs
                    and goals.</p>
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full justify-center mb-4">
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/money.png" alt="Money" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Up to 10.5M</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/Discount.png" alt="Discount" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Starting from 10.5%</span>
                    </div>
                </div>
                <button
                    class="w-[120px] h-[40px] rounded-md bg-white text-gray-900 font-semibold border border-green-400 hover:bg-gray-200 hover:scale-105 transition duration-300">
                    Inquire
                </button>
            </div>

            <!-- Card 2 -->
            <div
                class="w-[320px] md:w-[350px] bg-gradient-to-br from-[#5CFFAB] to-[#42e697] rounded-xl p-6 flex flex-col justify-between items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl cursor-pointer">
                <img src="./images/BOC.png" alt="BOC Bank" class="w-40 h-40 md:w-60 md:h-60 object-contain">
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Bank of Ceylon (BOC)</h3>
                <p class="text-base text-gray-800 leading-relaxed mb-4">Affordable housing loans with easy repayment
                    options.</p>
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full justify-center mb-4">
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/money.png" alt="Money" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Up to 9.5M</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/Discount.png" alt="Discount" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Starting from 12%</span>
                    </div>
                </div>
                <button
                    class="w-[120px] h-[40px] rounded-md bg-white text-gray-900 font-semibold border border-green-400 hover:bg-gray-200 hover:scale-105 transition duration-300">
                    Inquire
                </button>
            </div>

            <!-- Card 3 -->
            <div
                class="w-[320px] md:w-[350px] bg-gradient-to-br from-[#5CFFAB] to-[#42e697] rounded-xl p-6 flex flex-col justify-between items-center text-center shadow-xl transition duration-300 ease-in-out hover:scale-105 hover:shadow-2xl cursor-pointer">
                <img src="./images/sampath.png" alt="Sampath Bank" class="w-40 h-40 md:w-60 md:h-60 object-contain">
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Sampath Bank</h3>
                <p class="text-base text-gray-800 leading-relaxed mb-4">Home loans with competitive rates and flexible
                    payment plans.</p>
                <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full justify-center mb-4">
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/money.png" alt="Money" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Up to 7.5M</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/40 px-3 py-1 rounded-full">
                        <img src="./images/Discount.png" alt="Discount" class="w-5 h-5">
                        <span class="text-sm font-medium text-gray-900">Starting from 11.5%</span>
                    </div>
                </div>
                <button
                    class="w-[120px] h-[40px] rounded-md bg-white text-gray-900 font-semibold border border-green-400 hover:bg-gray-200 hover:scale-105 transition duration-300">
                    Inquire
                </button>
            </div>
        </div>
    </section>

    <script>
        const propertyValueInput = document.getElementById('propertyValue');
        const downPaymentInput = document.getElementById('downPaymentPercentage');
        const interestRateInput = document.getElementById('interestRate');
        const loanPeriodInput = document.getElementById('loanPeriod');

        const monthlyPaymentOutput = document.getElementById('estimatedMonthlyPayment');
        const loanAmountOutput = document.getElementById('loanAmount');
        const totalInterestOutput = document.getElementById('totalInterestPayable');
        const totalPayableOutput = document.getElementById('totalPayable');
        const downPaymentWarning = document.getElementById('downPaymentWarning');

        const calculateButton = document.getElementById('calculateLoan');

        function formatCurrency(amount) {
            return "Rs: " + parseFloat(amount).toLocaleString();
        }

        function calculateLoan() {
            const propertyValue = parseFloat(propertyValueInput.value);
            const downPaymentPercent = parseFloat(downPaymentInput.value);
            const interestRate = parseFloat(interestRateInput.value) || 12; // default 12%
            const loanPeriod = parseFloat(loanPeriodInput.value);

            // Validate inputs
            if (!propertyValue || !downPaymentPercent || !loanPeriod) {
                alert("Please fill in all required fields.");
                return;
            }

            if (downPaymentPercent < 10) {
                downPaymentWarning.classList.remove('hidden');
                return;
            } else {
                downPaymentWarning.classList.add('hidden');
            }

            const downPaymentAmount = propertyValue * (downPaymentPercent / 100);
            const loanAmount = propertyValue - downPaymentAmount;
            const monthlyInterestRate = (interestRate / 100) / 12;
            const numberOfPayments = loanPeriod * 12;

            // Standard amortization formula for monthly payment
            const monthlyPayment = (loanAmount * monthlyInterestRate) /
                (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));

            const totalPayable = monthlyPayment * numberOfPayments;
            const totalInterest = totalPayable - loanAmount;

            // Output results
            loanAmountOutput.value = formatCurrency(loanAmount.toFixed(2));
            monthlyPaymentOutput.value = formatCurrency(monthlyPayment.toFixed(2));
            totalInterestOutput.value = formatCurrency(totalInterest.toFixed(2));
            totalPayableOutput.value = formatCurrency(totalPayable.toFixed(2));
        }

        calculateButton.addEventListener('click', calculateLoan);
    </script>
</x-guest-layout>
