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

            <!-- Contact Button -->
            <button id="contactAdminButton"
                class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-2 bg-[#5CFFAB] text-black font-semibold rounded-xl shadow-md hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-comments"></i>
                Chat Now
            </button>
        </div>
    </div>



    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            // Load property details
            document.addEventListener("DOMContentLoaded", async function() {
                const propertyId = document.getElementById('propertyContainer')?.dataset.id;
                if (!propertyId) return;

                try {
                    const response = await axios.get(`/api/propertyAd/${propertyId}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    const property = response.data.property;
                    renderImageGallery(property);
                    renderPropertyDetails(property);
                    renderMap(property);

                    // Only handle contact section if status is APPROVE or DONE
                    if (property.status === "approve" || property.status === "done") {
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
                document.getElementById('price').textContent = `RS ${property.price} M`;
                document.getElementById('bedrooms').textContent = `${property.bedrooms} Bedrooms`;
                document.getElementById('bathrooms').textContent = `${property.bathrooms} Bathrooms`;
                document.getElementById('floors').textContent = `${property.floors} Floor(s)`;
                document.getElementById('perches').textContent = `${property.perches} Perches`;
                document.getElementById('measurement').textContent = `${property.measurement} Sq.Ft.`;
                document.getElementById("propertyType").textContent = capitalizeFirstLetter(property.property_type);

                // Handle Buy/Rent button
                const actionButton = document.getElementById("actionButton");
                const actionButtonText = document.getElementById("actionButtonText");

                // Hide button if status is "done"
                if (property.status === "done" || property.status === "pending" || property.status === "reject") {
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
                    showInfo(`Starting chat with ${agent.name}`);
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
                const chatButton = document.getElementById('chatButton');
                chatButton.addEventListener('click', () => {
                    showInfo(`Starting chat with ${agent.name}`);
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
