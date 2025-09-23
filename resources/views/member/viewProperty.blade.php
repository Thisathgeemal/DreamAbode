<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">View Property Information</h2>
                <p class="text-sm text-gray-300 mt-1">Here you can view detailed information about the selected property.
                </p>
            </div>

            <a href="{{ url()->previous() ?? route('member.property.accepted') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-[#5CFFAB] text-black rounded-xl font-medium shadow-md 
                hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-arrow-left inline sm:hidden"></i>
                <span class="hidden sm:inline">Back</span>
            </a>
        </div>
    </div>

    <div id="propertyContainer" data-id="{{ $propertyId }}"></div>

    <!-- Gallery Images -->
    <div class="w-full p-8 bg-white rounded-lg shadow-md mb-6 flex flex-col items-center justify-center">
        <!-- Main Preview Image -->
        <div class="w-full max-w-3xl grid grid-cols-2 gap-6">
            <img id="mainImage1" class="w-full rounded-2xl shadow-lg transition duration-500 ease-in-out">
            <img id="mainImage2" class="w-full rounded-2xl shadow-lg transition duration-500 ease-in-out">
        </div>

        <!-- Thumbnails -->
        <div id="thumbnailsContainer" class="grid grid-cols-6 gap-4 mt-6 place-items-center"></div>
    </div>

    <!-- Property Details -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="text-center space-y-2">
            <h2 id="propertyName" class="text-2xl md:text-3xl font-bold text-gray-800 mt-3 mb-5"></h2>
            <p class="text-gray-600 flex justify-center items-center gap-2 text-md font-semibold">
                <img src="/images/Location.png" alt="Location" class="w-5.5 h-7">
                <span id="location"></span>
            </p>
        </div>

        <!-- Price + Action Button -->
        <div class="flex justify-center mt-6 gap-4">
            <!-- Price -->
            <div
                class="inline-flex items-center md:min-w-[200px] justify-center gap-2 px-6 py-2 border border-gray-300 rounded-lg bg-[#6affb2] text-red-600 hover:bg-[#00ff80] font-semibold shadow-sm transition-transform duration-200 ease-in-out hover:scale-105">
                <img src="/images/money.png" alt="Money" class="w-6 h-6">
                <span id="price"></span>
            </div>

            <!-- Buy/Rent Button -->
            <button id="actionButton"
                class="inline-flex items-center md:min-w-[200px] justify-center gap-2 px-6 py-2 border border-transparent rounded-lg bg-[#5eb9ff] text-white font-semibold shadow-sm transition-transform duration-200 ease-in-out hover:scale-105 hover:bg-[#008ffd]">
                <span id="actionButtonText"></span>
                <img width="35" height="35" src="https://img.icons8.com/comic/50/cash-in-hand.png"
                    alt="cash-in-hand" />
            </button>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-8">
            <!-- Property Type -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Houses.png" alt="House" class="w-5 h-5">
                <span id="propertyType"></span>
            </div>

            <!-- Bedrooms -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Bedrooms.png" alt="Bedroom" class="w-5 h-5">
                <span id="bedrooms"></span>
            </div>

            <!-- Bathrooms -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Bathrooms.png" alt="Bathroom" class="w-5 h-5">
                <span id="bathrooms"></span>
            </div>

            <!-- Measurement -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Perches.png" alt="Measurement" class="w-5 h-5">
                <span id="measurement"></span>
            </div>

            <!-- Floors -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Floor.png" alt="Floor" class="w-5 h-5">
                <span id="floors"></span>
            </div>

            <!-- Perches -->
            <div
                class="flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Perches.png" alt="Perches" class="w-5 h-5">
                <span id="perches"></span>
            </div>
        </div>
    </div>

    <!-- Neighborhood Map -->
    <div id="mapContainer" class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mt-3 mb-5">Explore Neighborhood</h2>
        <iframe id="googleMap" src="" width="100%" height="300"
            class="w-full h-[300px] rounded-lg shadow-md" frameborder="0" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- Contact Section -->
    <div id="contactSection" class="flex flex-col md:flex-row justify-center items-start gap-6 w-full md:px-0">
        <!-- Agent Card -->
        <div
            class="w-full md:flex-1 flex flex-col items-center bg-gray-50 p-6 md:p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-2xl md:text-3xl font-bold mb-4">Contact Agent</h3>

            <!-- Profile Image / Avatar -->
            <div class="w-24 h-24 rounded-full overflow-hidden shadow-md border-2 border-gray-200 mb-4">
                <img id="agentImage" src="/images/default-profile.png" alt="Agent Profile"
                    class="w-full h-full object-cover">
            </div>

            <!-- Agent Info -->
            <div class="text-center space-y-2 mb-4">
                <h4 id="agentName" class="text-lg md:text-xl font-semibold text-gray-800"></h4>
                <p id="agentEmail" class="text-gray-600 text-sm md:text-md"></p>
                <p id="agentMobile" class="text-gray-600 text-sm md:text-md"></p>
            </div>

            <!-- Chat Now Button -->
            <button id="chatButton"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-2 bg-[#5CFFAB] text-black font-semibold rounded-xl shadow-md hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-comments"></i>
                Chat Now
            </button>
        </div>

        <!-- Admin Card -->
        <div
            class="w-full md:flex-1 flex flex-col items-center bg-gray-50 p-6 md:p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-2xl md:text-3xl font-bold mb-4">Contact Admin</h3>

            <!-- Profile Image / Avatar -->
            <div class="w-24 h-24 rounded-full overflow-hidden shadow-md border-2 border-gray-200 mb-4">
                <img id="adminImage" src="/images/default-profile.png" alt="Admin Profile"
                    class="w-full h-full object-cover">
            </div>

            <!-- Admin Info -->
            <div class="text-center space-y-2 mb-4">
                <h4 id="adminName" class="text-lg md:text-xl font-semibold text-gray-800"></h4>
                <p id="adminEmail" class="text-gray-600 text-sm md:text-md"></p>
                <p id="adminMobile" class="text-gray-600 text-sm md:text-md"></p>
            </div>

            <!-- Chat Now Button -->
            <button id="chatAdminButton"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-2 bg-[#5CFFAB] text-black font-semibold rounded-xl shadow-md hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-comments"></i>
                Chat Now
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div id="propertyPaymentModal" role="dialog" aria-modal="true"
        class="fixed inset-0 backdrop-blur-sm bg-white/20 hidden z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <!-- Steps -->
            <div class="flex items-center mb-4 mt-1">
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white step"
                    id="step1">1</div>
                <div class="flex-1 h-1 bg-gray-300" id="line"></div>
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white step"
                    id="step2">2</div>
            </div>

            <!-- Step 1: Info & Agreement -->
            <div id="property-info-section" class="form-section">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-4" id="modalTitle">Buy Property</h2>
                <p id="modalDescription" class="text-gray-700 mb-4">
                    You are about to proceed with the purchase of this property. In accordance with standard policy, a
                    2% down payment is required to secure your interest. Please review the agreement below carefully
                    before continuing.
                </p>

                <!-- Agreement Details -->
                <div class="bg-gray-100 p-3 rounded-md mb-4 text-sm text-gray-700 h-40 overflow-y-auto">
                    <p class="mb-2"><strong>Agreement Terms:</strong></p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li id="modalAgreement">
                            The initial down payment of 2% is <strong>non-refundable</strong> once the transaction
                            is confirmed.
                        </li>
                        <li>Full ownership rights will only be transferred upon settlement of the total purchase price.
                        </li>
                        <li>The buyer affirms that all personal, financial, and identification details provided are
                            accurate and up to date.</li>
                        <li>This payment constitutes a binding financial commitment between the buyer and the seller.
                        </li>
                        <li>All transactions will be processed securely in compliance with industry-standard data
                            protection measures.</li>
                    </ul>
                </div>

                <!-- Accept Terms -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="agreeTerms" class="mr-2">
                    <label for="agreeTerms" class="text-gray-700 text-sm">I agree to the terms and conditions
                        above</label>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                        onclick="closePropertyModal()">Cancel</button>
                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                        onclick="nextPropertyStep()">Next</button>
                </div>
            </div>

            <!-- Step 2: Payment -->
            <div id="property-payment-section" class="form-section hidden">
                <h2 class="text-xl md:text-2xl font-bold text-center mb-4">Complete Payment</h2>
                <form id="propertyPaymentForm">

                    <!-- Payment Amount -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Amount to Pay</label>
                        <input type="text" id="paymentAmount" readonly
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Card Type -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Card Type</label>
                        <select id="cardType" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">Select Card Type</option>
                            <option value="visa">Visa</option>
                            <option value="mastercard">MasterCard</option>
                            <option value="amex">American Express</option>
                            <option value="discover">Discover</option>
                        </select>
                    </div>

                    <!-- Name on Card -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Name on Card</label>
                        <input type="text" id="cardName" required placeholder="Full Name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Card Number -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Card Number</label>
                        <input type="text" id="cardNumber" required maxlength="16"
                            placeholder="1234 5678 9012 3456"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>

                    <!-- Expiry + CVV in one row -->
                    <div class="mb-4 flex gap-2">
                        <div class="flex-1">
                            <label class="block text-sm font-medium">Expiry Date</label>
                            <input type="month" id="expiryDate" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium">CVV</label>
                            <input type="text" id="cvv" required maxlength="3" placeholder="CVV"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                    </div>

                    <input type="hidden" id="numericPaymentAmount" name="amount">

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                            onclick="prevPropertyStep()">Previous</button>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentProperty = null;

            // Load property details
            document.addEventListener("DOMContentLoaded", async function() {
                const propertyId = document.getElementById('propertyContainer')?.dataset.id;
                if (!propertyId) return;

                try {
                    const response = await axios.get(`/api/propertyAd/${propertyId}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        }
                    });

                    const property = response.data.property;
                    currentProperty = property;
                    renderImageGallery(property);
                    renderPropertyDetails(property);
                    renderMap(property);

                    // Only handle contact section if status is APPROVE or complete
                    if (property.status === "approve" || property.status === "complete") {
                        const contactSection = document.getElementById('contactSection');
                        contactSection.style.display = "flex";

                        await fetchAgentDetails(property.agent_id);
                        await fetchAdminDetails(property.admin_id);
                    } else {
                        document.getElementById('contactSection').style.display = "none";
                    }

                } catch (err) {
                    console.error(err);
                    showError("Failed to fetch property details");
                }
            });

            // Image Gallery Section
            function renderImageGallery(property) {
                const mainImage1 = document.getElementById('mainImage1');
                const mainImage2 = document.getElementById('mainImage2');
                const thumbnailsContainer = document.getElementById('thumbnailsContainer');
                thumbnailsContainer.innerHTML = '';

                if (property.images && property.images.length > 0) {
                    // Initial setup
                    mainImage1.src = `/storage/${property.images[0].image_path}`;
                    mainImage2.src = property.images[1] ?
                        `/storage/${property.images[1].image_path}` :
                        `/storage/${property.images[0].image_path}`;

                    property.images.forEach((img, index) => {
                        const thumb = document.createElement('img');
                        thumb.src = `/storage/${img.image_path}`;
                        thumb.className =
                            'thumbnail w-32 h-24 object-cover rounded-lg cursor-pointer hover:scale-105 transition border-2 border-transparent hover:border-green-500';

                        // On click → set main images
                        thumb.addEventListener('click', () => {
                            const nextIndex = (index + 1) % property.images.length;
                            mainImage1.src = `/storage/${property.images[index].image_path}`;
                            mainImage2.src = `/storage/${property.images[nextIndex].image_path}`;
                        });

                        thumbnailsContainer.appendChild(thumb);
                    });
                }
            }

            // Property Details Section
            function renderPropertyDetails(property) {
                document.getElementById('propertyName').textContent = property.property_name || '';
                document.getElementById('location').textContent = property.location || '';
                document.getElementById('price').textContent = `RS ${formatPrice(property.price)}`;
                document.getElementById('bedrooms').textContent = `${property.bedrooms} Bedrooms`;
                document.getElementById('bathrooms').textContent = `${property.bathrooms} Bathrooms`;
                document.getElementById('floors').textContent = `${property.floors} Floor(s)`;
                document.getElementById('perches').textContent = `${property.perches} Perches`;
                document.getElementById('measurement').textContent = `${property.measurement} Sq.Ft.`;
                document.getElementById("propertyType").textContent = capitalizeFirstLetter(property.property_type);

                const propertyTypeValue = document.getElementById("propertyType").innerText;
                updatePropertyFeatures(propertyTypeValue);

                // Handle Buy/Rent button
                const actionButton = document.getElementById("actionButton");
                const actionButtonText = document.getElementById("actionButtonText");

                // Hide button if status is "complete"
                if (property.status === "complete" || property.status === "pending" || property.status === "reject") {
                    actionButton.style.display = "none";
                    return;
                }

                if (property.post_type === "sale") {
                    actionButtonText.textContent = "Buy Now";
                    actionButton.style.display = "inline-flex";
                } else if (property.post_type === "rent") {
                    actionButtonText.textContent = "Rent Now";
                    actionButton.style.display = "inline-flex";
                } else {
                    actionButton.style.display = "none";
                }
            }

            function updatePropertyFeatures(propertyType) {
                const bedrooms = document.getElementById("bedrooms").parentElement;
                const bathrooms = document.getElementById("bathrooms").parentElement;
                const floors = document.getElementById("floors").parentElement;
                const purchase = document.getElementById("perches").parentElement;

                // Reset visibility
                bedrooms.style.display = "flex";
                bathrooms.style.display = "flex";
                floors.style.display = "flex";
                purchase.style.display = "flex";

                // Hide features based on property type
                if (propertyType.toLowerCase() === "commercial") {
                    bedrooms.style.display = "none";
                    bathrooms.style.display = "none";
                    purchase.style.display = "none";
                } else if (propertyType.toLowerCase() === "land") {
                    bedrooms.style.display = "none";
                    bathrooms.style.display = "none";
                    floors.style.display = "none";
                }
            }

            // Map Section
            function renderMap(property) {
                const mapIframe = document.getElementById('googleMap');
                mapIframe.src = `https://www.google.com/maps?q=${encodeURIComponent(property.location)}&output=embed`;
            }

            // Fetch Agent Details
            async function fetchAgentDetails(agentId) {
                try {
                    const response = await axios.get(`/api/agents/${agentId}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        }
                    });

                    const agent = response.data;
                    renderAgent(agent);
                } catch (err) {
                    console.error("Failed to fetch agent:", err);
                    showError("Failed to load agent details");
                }
            }

            // Fetch Admin Details
            async function fetchAdminDetails(adminId) {
                try {
                    const response = await axios.get(`/api/admins/${adminId}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        }
                    });
                    const admin = response.data;
                    renderAdmin(admin);
                } catch (err) {
                    console.error("Failed to fetch admin:", err);
                    showError("Failed to load admin details");
                }
            }

            // Agent Section
            function renderAgent(agent) {
                const agentImage = document.getElementById('agentImage');
                const agentName = document.getElementById('agentName');
                const agentEmail = document.getElementById('agentEmail');
                const agentMobile = document.getElementById('agentMobile');

                // Profile Image or Dynamic Avatar
                if (agent.profile_photo_path) {
                    agentImage.src = `/storage/${agent.profile_photo_path}`;
                } else {
                    const initials = getInitials(agent.name);
                    agentImage.src = generateAvatar(initials);
                }

                agentName.textContent = agent.name || "Unknown Agent";
                agentEmail.textContent = agent.email || "No email provided";
                agentMobile.textContent = agent.mobile_number || "No contact available";

                // Chat Button
                const chatButton = document.getElementById('chatButton');
                chatButton.addEventListener('click', () => {
                    window.location.href = `/member/messages/${agent.id}`;
                });
            }

            // Admin Section
            function renderAdmin(admin) {
                const adminImage = document.getElementById('adminImage');
                const adminName = document.getElementById('adminName');
                const adminEmail = document.getElementById('adminEmail');
                const adminMobile = document.getElementById('adminMobile');

                // Profile or initials
                if (admin.profile_photo_path) {
                    adminImage.src = `/storage/${admin.profile_photo_path}`;
                } else {
                    const initials = getInitials(admin.name);
                    adminImage.src = generateAvatar(initials);
                }

                adminName.textContent = admin.name || "Unknown Admin";
                adminEmail.textContent = admin.email || "No email provided";
                adminMobile.textContent = admin.mobile_number || "No contact available";

                // Chat Button
                const chatAdminButton = document.getElementById('chatAdminButton');
                chatAdminButton.addEventListener('click', () => {
                    window.location.href = `/member/messages/${admin.id}`;
                });
            }

            // Helper to get initials
            function getInitials(name) {
                if (!name) return "NA";
                const words = name.split(' ');
                let initials = words[0].charAt(0);
                if (words.length > 1) {
                    initials += words[1].charAt(0);
                }
                return initials.toUpperCase();
            }

            // Helper to generate avatar as base64
            function generateAvatar(initials) {
                const canvas = document.createElement('canvas');
                const size = 128;
                canvas.width = size;
                canvas.height = size;
                const ctx = canvas.getContext('2d');

                const colors = ["#A8E6CF", "#DCEDC1", "#FFD3B6", "#FFAAA5", "#FF8B94"];
                const bgColor = colors[Math.floor(Math.random() * colors.length)];
                ctx.fillStyle = bgColor;
                ctx.fillRect(0, 0, size, size);

                // Text
                ctx.fillStyle = "#333";
                ctx.font = "bold 48px Arial";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.fillText(initials, size / 2, size / 2);

                return canvas.toDataURL();
            }

            function capitalizeFirstLetter(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            // Attach Buy/Rent button click
            document.getElementById('actionButton').addEventListener('click', function() {
                const actionText = document.getElementById('actionButtonText').textContent.toLowerCase();
                if (actionText.includes('buy')) openPropertyModal('buy');
                else if (actionText.includes('rent')) openPropertyModal('rent');
            });

            // Open modal for Buy or Rent
            function openPropertyModal(type) {
                document.getElementById('propertyPaymentModal').classList.remove('hidden');
                document.getElementById('propertyPaymentModal').classList.add('flex');

                const modalTitle = document.getElementById('modalTitle');
                const modalDesc = document.getElementById('modalDescription');
                const modalAgreement = document.getElementById('modalAgreement');
                const paymentAmountField = document.getElementById('paymentAmount');
                const numericAmountField = document.getElementById("numericPaymentAmount");

                if (type === 'buy') {
                    modalTitle.textContent = 'Buy Property';
                    modalDesc.textContent =
                        `You are about to proceed with the purchase of this property. 
                        As per our policy, a 2% down payment is required to secure your interest. 
                        Please review the agreement terms carefully before continuing.`;
                    modalAgreement.innerHTML =
                        `The initial down payment of 2% is <strong>non-refundable</strong> once the transaction is confirmed.`;

                    const downPayment = (currentProperty.price * 0.02).toFixed(2);
                    paymentAmountField.value = `${downPayment} M`;
                    numericAmountField.value = downPayment;

                } else {
                    modalTitle.textContent = 'Rent Property';
                    modalDesc.textContent =
                        `You are about to proceed with renting this property. 
                        To confirm your reservation, the first month’s payment is required in advance. 
                        Please review the agreement terms carefully before continuing.`;
                    modalAgreement.innerHTML =
                        `The first month’s payment is <strong>non-refundable</strong> once the transaction is confirmed.`;

                    const firstMonth = (currentProperty.price / 12).toFixed(2);
                    paymentAmountField.value = `${firstMonth} M`;
                    numericAmountField.value = firstMonth;
                }

                highlightPropertyStep(1);
            }

            // Close modal
            function closePropertyModal() {
                document.getElementById('propertyPaymentModal').classList.add('hidden');
                document.getElementById('propertyPaymentModal').classList.remove('flex');
                document.getElementById('property-info-section').classList.remove('hidden');
                document.getElementById('property-payment-section').classList.add('hidden');
                document.getElementById('agreeTerms').checked = false;
                document.getElementById('propertyPaymentForm').reset();
                resetPropertySteps();
            }

            // Next step
            function nextPropertyStep() {
                const agree = document.getElementById('agreeTerms').checked;
                if (!agree) {
                    showError("You must agree to the terms before proceeding");
                    return;
                }
                document.getElementById('property-info-section').classList.add('hidden');
                document.getElementById('property-payment-section').classList.remove('hidden');
                highlightPropertyStep(2);
            }

            // Previous step
            function prevPropertyStep() {
                document.getElementById('property-payment-section').classList.add('hidden');
                document.getElementById('property-info-section').classList.remove('hidden');
                highlightPropertyStep(1);
            }

            // Step highlight
            function highlightPropertyStep(step) {
                const step1 = document.getElementById('step1');
                const step2 = document.getElementById('step2');
                const line = document.getElementById('line');

                step1.classList.remove('bg-blue-500');
                step1.classList.add('bg-gray-300');
                step2.classList.remove('bg-blue-500');
                step2.classList.add('bg-gray-300');
                line.classList.remove('bg-blue-500');
                line.classList.add('bg-gray-300');

                if (step === 1) {
                    step1.classList.remove('bg-gray-300');
                    step1.classList.add('bg-blue-500');
                } else if (step === 2) {
                    step1.classList.remove('bg-gray-300');
                    step2.classList.remove('bg-gray-300');
                    line.classList.remove('bg-gray-300');
                    step1.classList.add('bg-blue-500');
                    step2.classList.add('bg-blue-500');
                    line.classList.add('bg-blue-500');
                }
            }

            // Reset steps
            function resetPropertySteps() {
                highlightPropertyStep(0);
            }

            // Handle payment
            document.getElementById("propertyPaymentForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                if (!currentProperty || !currentProperty.property_id) {
                    showError("Property ID not available");
                    return;
                }

                const payload = {
                    property_id: currentProperty.property_id,
                    amount: parseFloat(document.getElementById("paymentAmount").value.replace(/[^0-9.]/g,
                        '')),
                };

                try {
                    const response = await fetch("/api/propertyAd/payment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();
                    console.log("Payment response:", result);

                    if (response.ok) {
                        showSuccess(result.success || "Payment successful and property status updated!");
                        closePropertyModal();

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        console.error("Payment error:", result);
                        showError("Payment failed: " + (result.error || "Unknown error"));
                    }
                } catch (err) {
                    console.error("Request failed:", err);
                    showError("Payment failed: " + err.message);
                }
            });

            // Price formatting
            function formatPrice(price) {
                if (!price) return '0';
                let value = Number(price);
                if (value >= 1000000) {
                    return (value / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
                } else if (value >= 1000) {
                    return (value / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
                } else {
                    return value.toString();
                }
            }

            // Show message
            function showSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg,
                    confirmButtonColor: '#28a745'
                });
            }

            function showInfo(msg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Notice',
                    text: msg,
                    confirmButtonColor: '#ff9800'
                });
            }

            function showError(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#dc3545'
                });
            }
        </script>
    @endpush

</x-app-layout>
