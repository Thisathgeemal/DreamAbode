<x-agent-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">Assigned Properties</h2>
                <p class="text-sm text-gray-300 mt-1">Review all your approved property assignments.</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="agent-approved-property"
            class="flex flex-wrap gap-8 justify-center p-6 md:h-[500px] overflow-y-auto custom-scrollbar">
            <!-- Cards will be injected here dynamically -->
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                fetchAgentApprovedProperties();
            });

            // Fetch agent approved properties
            async function fetchAgentApprovedProperties() {
                const container = document.getElementById('agent-approved-property');
                container.innerHTML = `
                    <p class="flex justify-center items-center text-center text-gray-500 text-lg mt-10">
                        Loading assigned properties, please wait...
                    </p>`;

                try {
                    const response = await axios.get('/api/propertyAd', {
                        headers: {
                            Authorization: `Bearer {{ session('auth_token') }}`
                        }
                    });

                    // Only agent approved properties
                    const properties = response.data.agent_properties.approved;
                    container.innerHTML = '';

                    if (!properties || properties.length === 0) {
                        container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            No approved assigned properties found.
                        </p>`;
                        return;
                    }

                    properties.forEach(prop => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-[#5CFFAB] rounded-2xl shadow-lg hover:shadow-xl overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer';

                        // Property Image Section
                        const imgSection = document.createElement('div');
                        imgSection.className = 'relative';

                        if (prop.images && prop.images.length > 0) {
                            const firstImage = prop.images[0];
                            const img = document.createElement('img');
                            img.src = `/storage/${firstImage.image_path}`;
                            img.alt = 'Property Image';
                            img.className = 'w-full h-60 object-cover block';
                            imgSection.appendChild(img);
                        } else {
                            const placeholder = document.createElement('div');
                            placeholder.className =
                                'w-full h-60 bg-gray-200 flex items-center justify-center text-gray-400';
                            placeholder.textContent = 'No Image';
                            imgSection.appendChild(placeholder);
                        }

                        // Post Type Badge
                        const postTypeBadge = document.createElement('div');
                        postTypeBadge.className =
                            'absolute top-3 right-3 bg-white rounded-lg p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer';
                        postTypeBadge.innerHTML =
                            `<span class="font-semibold text-sm">${prop.post_type || ''}</span>`;
                        imgSection.appendChild(postTypeBadge);

                        // Property Data Section
                        const dataSection = document.createElement('div');
                        dataSection.className =
                            'p-4 bg-[#5CFFAB] text-black text-center flex-1 flex flex-col justify-between';
                        dataSection.innerHTML = `
                            <h2 class="text-xl font-bold m-1 truncate">${prop.property_name}</h2>
                            <div class="flex justify-center items-center space-x-2 my-3">
                                <img src="/images/Location.png" alt="Location" class="h-6 w-5">
                                <span class="text-sm font-medium truncate">${prop.location}</span>
                            </div>
                            <div class="flex justify-center items-center mt-2 space-x-8">
                                <div class="flex items-center space-x-2">
                                    <img src="/images/money.png" alt="Price" class="h-6 w-6">
                                    <span class="text-sm font-medium">RS ${formatPrice(prop.price)} </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="/images/Bedrooms.png" alt="Bedrooms" class="h-5 w-5">
                                    <span class="text-sm font-medium">${prop.bedrooms} Rooms</span>
                                </div>
                            </div>
                        `;

                        // Actions for approved properties
                        const actions = document.createElement('div');
                        actions.className = 'mt-4 flex justify-center';
                        actions.innerHTML = `
                            <a href="/agent/property/viewAd/${prop.property_id}" 
                                class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 text-center inline-block">
                                View
                            </a>`;
                        dataSection.appendChild(actions);

                        card.appendChild(imgSection);
                        card.appendChild(dataSection);
                        container.appendChild(card);
                    });

                } catch (error) {
                    console.error('Error fetching agent approved properties:', error);
                    showError('Failed to fetch properties. Please try again.');
                }
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

</x-agent-layout>
