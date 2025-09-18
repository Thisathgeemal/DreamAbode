<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">View Project Information</h2>
                <p class="text-sm text-gray-300 mt-1">Here you can view detailed information about the selected project.
                </p>
            </div>

            <a href="{{ url()->previous() ?? route('member.project.accepted') }}"
                class="flex items-center gap-2 px-5 py-2.5 bg-[#5CFFAB] text-black rounded-xl font-medium shadow-md 
                hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-arrow-left inline sm:hidden"></i>
                <span class="hidden sm:inline">Back</span>
            </a>
        </div>
    </div>

    <div id="projectContainer" data-id="{{ $projectId }}"></div>

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

    <!-- Project Details -->
    <div class="w-full p-8 bg-white rounded-lg shadow-md mb-6">
        <!-- Project Name & Location -->
        <div class="text-center space-y-2">
            <h2 id="projectName" class="text-2xl md:text-3xl font-bold text-gray-800 mt-3 mb-2"></h2>
            <p class="text-gray-600 flex justify-center items-center gap-2 text-md font-semibold">
                <img src="/images/Location.png" alt="Location" class="w-5 h-7">
                <span id="projectLocation"></span>
            </p>
        </div>

        <!-- Price + Buy Button -->
        <div class="flex justify-center mt-6 gap-4">
            <!-- Price -->
            <div
                class="inline-flex items-center md:min-w-[200px] justify-center gap-2 px-6 py-2 border border-gray-300 rounded-lg bg-[#6affb2] text-red-600 hover:bg-[#00ff80] font-semibold shadow-sm transition-transform duration-200 ease-in-out hover:scale-105">
                <img src="/images/money.png" alt="Money" class="w-6 h-6">
                <span id="price"></span>
            </div>

            <button id="buyProjectButton"
                class="inline-flex items-center md:min-w-[200px] justify-center gap-2 px-6 py-2 border border-transparent rounded-lg bg-[#5eb9ff] text-white font-semibold shadow-sm transition-transform duration-200 ease-in-out hover:scale-105 hover:bg-[#008ffd]">
                <span>Buy Now</span>
                <img width="35" height="35" src="https://img.icons8.com/comic/50/cash-in-hand.png"
                    alt="cash-in-hand" />
            </button>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mt-8">
            <!-- Property Type -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Apartments.png" alt="Property Type" class="w-5 h-6">
                <span id="projectType"></span>
            </div>

            <!-- Total Units -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Units.png" alt="Total Units" class="w-6 h-6">
                <span id="totalUnits"></span>
            </div>

            <!-- Available Units -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Units.png" alt="Available Units" class="w-6 h-6">
                <span id="availableUnits"></span>
            </div>

            <!-- Measurement -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Perches.png" alt="Measurement" class="w-5 h-5">
                <span id="measurement"></span>
            </div>

            <!-- Parking Spaces -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Parking.png" alt="Parking Spaces" class="w-6 h-6">
                <span id="parkingSpaces"></span>
            </div>

            <!-- Bedrooms (only for apartments) -->
            <div class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200"
                id="bedroomContainer">
                <img src="/images/Bedrooms.png" alt="Bedrooms" class="w-5 h-5">
                <span id="bedrooms"></span>
            </div>

            <!-- Bathrooms (only for apartments) -->
            <div class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200"
                id="bathroomContainer">
                <img src="/images/Bathrooms.png" alt="Bathrooms" class="w-5 h-5">
                <span id="bathrooms"></span>
            </div>

            <!-- Project Status -->
            <div
                class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200">
                <img src="/images/Status.png" alt="Project Status" class="w-6 h-6">
                <span id="projectStatus"></span>
            </div>

            <!-- Completion Date (only for ongoing/upcoming projects) -->
            <div class="feature-item flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-900 font-medium shadow-sm hover:shadow-md hover:bg-[#5CFFAB] transition duration-200"
                id="completionContainer">
                <img src="/images/Accept.png" alt="Completion Date" class="w-5 h-5">
                <span id="completionDate"></span>
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

    <!-- Project Payment Modal -->
    <div id="projectPaymentModal" role="dialog" aria-modal="true"
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

            <!-- Step 1: Agreement -->
            <div id="project-info-section" class="form-section">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-4" id="modalTitle">Buy Project</h2>
                <p id="modalDescription" class="text-gray-700 mb-4">
                    You are about to proceed with the purchase one of the unit in this project. A 2% down payment is
                    required to secure
                    your interest. Please review the agreement below carefully before continuing.
                </p>

                <!-- Agreement Details -->
                <div class="bg-gray-100 p-3 rounded-md mb-4 text-sm text-gray-700 h-40 overflow-y-auto">
                    <p class="mb-2"><strong>Agreement Terms:</strong></p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li id="modalAgreement">
                            The initial down payment of 2% is <strong>non-refundable</strong> once the transaction is
                            confirmed.
                        </li>
                        <li>Full ownership rights will only be transferred upon settlement of the total purchase price.
                        </li>
                        <li>The buyer affirms that all personal, financial, and identification details provided are
                            accurate.</li>
                        <li>All transactions are processed securely with industry-standard data protection.</li>
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
                        onclick="closeProjectModal()">Cancel</button>
                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                        onclick="nextProjectStep()">Next</button>
                </div>
            </div>

            <!-- Step 2: Payment -->
            <div id="project-payment-section" class="form-section hidden">
                <h2 class="text-xl md:text-2xl font-bold text-center mb-4">Complete Payment</h2>
                <form id="projectPaymentForm">

                    <!-- Payment Amount -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Amount to Pay</label>
                        <input type="text" id="paymentAmount" readonly
                            class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
                    </div>

                    <!-- Card Type -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Card Type</label>
                        <select id="cardType" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
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
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
                    </div>

                    <!-- Card Number -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Card Number</label>
                        <input type="text" id="cardNumber" required maxlength="16"
                            placeholder="1234 5678 9012 3456"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
                    </div>

                    <!-- Expiry + CVV -->
                    <div class="mb-4 flex gap-2">
                        <div class="flex-1">
                            <label class="block text-sm font-medium">Expiry Date</label>
                            <input type="month" id="expiryDate" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium">CVV</label>
                            <input type="text" id="cvv" required maxlength="3" placeholder="CVV"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-sm">
                        </div>
                    </div>

                    <input type="hidden" id="numericPaymentAmount" name="amount">

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                            onclick="prevProjectStep()">Previous</button>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Pay Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";
            let currentProject = null;

            // Load project details
            document.addEventListener("DOMContentLoaded", async function() {
                const projectId = document.getElementById('projectContainer')?.dataset.id;
                if (!projectId) return;

                try {
                    const response = await axios.get(`/api/projectAd/${projectId}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    const project = response.data.project;
                    currentProject = project;
                    renderImageGallery(project);
                    renderProjectDetails(project);
                    renderMap(project);

                    // Only handle contact section if status is APPROVE or complete
                    if (project.status === "approve" || project.status === "complete") {
                        const contactSection = document.getElementById('contactSection');
                        contactSection.style.display = "flex";

                        await fetchAgentDetails(project.agent_id);
                        await fetchAdminDetails(project.admin_id);
                    } else {
                        document.getElementById('contactSection').style.display = "none";
                    }

                } catch (err) {
                    console.error(err);
                    showError("Failed to fetch project details");
                }
            });

            // Image Gallery Section
            function renderImageGallery(project) {
                const mainImage1 = document.getElementById('mainImage1');
                const mainImage2 = document.getElementById('mainImage2');
                const thumbnailsContainer = document.getElementById('thumbnailsContainer');
                thumbnailsContainer.innerHTML = '';

                if (project.images && project.images.length > 0) {
                    // Initial setup
                    mainImage1.src = `/storage/${project.images[0].image_path}`;
                    mainImage2.src = project.images[1] ?
                        `/storage/${project.images[1].image_path}` :
                        `/storage/${project.images[0].image_path}`;

                    project.images.forEach((img, index) => {
                        const thumb = document.createElement('img');
                        thumb.src = `/storage/${img.image_path}`;
                        thumb.className =
                            'thumbnail w-32 h-24 object-cover rounded-lg cursor-pointer hover:scale-105 transition border-2 border-transparent hover:border-green-500';

                        // On click → set main images
                        thumb.addEventListener('click', () => {
                            const nextIndex = (index + 1) % project.images.length;
                            mainImage1.src = `/storage/${project.images[index].image_path}`;
                            mainImage2.src = `/storage/${project.images[nextIndex].image_path}`;
                        });

                        thumbnailsContainer.appendChild(thumb);
                    });
                }
            }

            // Project details 
            function renderProjectDetails(project) {
                const actionButton = document.getElementById('buyProjectButton');

                document.getElementById('projectName').textContent = project.project_name;
                document.getElementById('projectLocation').textContent = project.location;
                document.getElementById('price').textContent = `RS ${formatPrice(project.price)}`;
                document.getElementById('projectType').textContent = capitalizeFirstLetter(project.property_type);
                document.getElementById('totalUnits').textContent = `Total Units: ${project.total_units}`;
                document.getElementById('availableUnits').textContent = `Available Units: ${project.available_units}`;
                document.getElementById('measurement').textContent = `${project.measurement} Sq.Ft.`;
                document.getElementById('parkingSpaces').textContent = `Parking Spaces: ${project.parking_spaces}`;
                document.getElementById('projectStatus').textContent = capitalizeFirstLetter(
                    project.project_status
                );

                // Show/hide action button
                if (["complete", "pending", "reject"].includes(project.status.toLowerCase())) {
                    actionButton.style.display = "none";
                } else {
                    actionButton.style.display = "inline-flex";
                }

                // Update feature visibility
                updateProjectFeatures(project.property_type, project.project_status);

                // Set bedrooms, bathrooms, and completion date
                document.getElementById('bedrooms').textContent = `${project.bedrooms || 'N/A'} Bedrooms`;
                document.getElementById('bathrooms').textContent = `${project.bathrooms || 'N/A'} Bathrooms`;
                document.getElementById('completionDate').textContent = `${project.completion_date || 'N/A'}`;
            }

            // Show/hide bedrooms, bathrooms, and completion date based on project type and status
            function updateProjectFeatures(propertyType, status) {
                const bedroomContainer = document.getElementById('bedroomContainer');
                const bathroomContainer = document.getElementById('bathroomContainer');
                const completionContainer = document.getElementById('completionContainer');

                // Bedrooms & bathrooms visible only for apartments
                if (propertyType.toLowerCase() === "apartment") {
                    bedroomContainer.style.display = "flex";
                    bathroomContainer.style.display = "flex";
                } else {
                    bedroomContainer.style.display = "none";
                    bathroomContainer.style.display = "none";
                }

                // Completion date visible only for ongoing or upcoming projects
                if (["ongoing", "upcoming"].includes(status.toLowerCase())) {
                    completionContainer.style.display = "flex";
                } else {
                    completionContainer.style.display = "none";
                }
            }

            // Map Section
            function renderMap(project) {
                const mapIframe = document.getElementById('googleMap');
                mapIframe.src = `https://www.google.com/maps?q=${encodeURIComponent(project.location)}&output=embed`;
            }

            // Fetch Agent Details
            async function fetchAgentDetails(agentId) {
                try {
                    const response = await axios.get(`/api/agents/${agentId}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`
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
                            'Authorization': `Bearer ${token}`
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
                    window.location.href = `/admin/messages/${agent.id}`;
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
                    window.location.href = `/admin/messages/${admin.id}`;
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

            document.getElementById('buyProjectButton').addEventListener('click', () => {
                openProjectModal(currentProject);
            });

            // Open modal
            function openProjectModal(project) {
                currentProject = project;
                document.getElementById('projectPaymentModal').classList.remove('hidden');
                document.getElementById('projectPaymentModal').classList.add('flex');

                // Set down payment
                const downPayment = (project.price * 0.02).toFixed(2);
                document.getElementById('paymentAmount').value = formatPrice(downPayment);
                document.getElementById('numericPaymentAmount').value = downPayment;

                highlightProjectStep(1);
            }

            // Close modal
            function closeProjectModal() {
                document.getElementById('projectPaymentModal').classList.add('hidden');
                document.getElementById('projectPaymentModal').classList.remove('flex');
                document.getElementById('project-info-section').classList.remove('hidden');
                document.getElementById('project-payment-section').classList.add('hidden');
                document.getElementById('agreeTerms').checked = false;
                document.getElementById('projectPaymentForm').reset();
                resetProjectSteps();
            }

            // Next & Previous steps
            function nextProjectStep() {
                if (!document.getElementById('agreeTerms').checked) {
                    showError("You must agree to the terms before proceeding");
                    return;
                }
                document.getElementById('project-info-section').classList.add('hidden');
                document.getElementById('project-payment-section').classList.remove('hidden');
                highlightProjectStep(2);
            }

            function prevProjectStep() {
                document.getElementById('project-payment-section').classList.add('hidden');
                document.getElementById('project-info-section').classList.remove('hidden');
                highlightProjectStep(1);
            }

            // Step highlighting
            function highlightProjectStep(step) {
                const step1 = document.getElementById('step1');
                const step2 = document.getElementById('step2');
                const line = document.getElementById('line');

                step1.className = 'w-10 h-10 rounded-full flex items-center justify-center text-white step bg-gray-300';
                step2.className = 'w-10 h-10 rounded-full flex items-center justify-center text-white step bg-gray-300';
                line.className = 'flex-1 h-1 bg-gray-300';

                if (step === 1) step1.classList.replace('bg-gray-300', 'bg-blue-500');
                if (step === 2) {
                    step1.classList.replace('bg-gray-300', 'bg-blue-500');
                    step2.classList.replace('bg-gray-300', 'bg-blue-500');
                    line.classList.replace('bg-gray-300', 'bg-blue-500');
                }
            }

            function resetProjectSteps() {
                highlightProjectStep(0);
            }

            // Handle payment
            document.getElementById("projectPaymentForm").addEventListener("submit", async function(e) {
                e.preventDefault();

                if (!currentProject || !currentProject.project_id) {
                    showError("Project ID not available");
                    return;
                }

                const payload = {
                    project_id: currentProject.project_id,
                    amount: parseFloat(document.getElementById("paymentAmount").value.replace(/[^0-9.]/g,
                        '')),
                };

                try {
                    const response = await fetch("/api/projectAd/payment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            'Authorization': `Bearer ${token}`
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();
                    console.log("Payment response:", result);

                    if (response.ok) {
                        showSuccess(result.success || "Payment successful and Project status updated!");
                        closeProjectModal();

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

            function capitalizeFirstLetter(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

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
