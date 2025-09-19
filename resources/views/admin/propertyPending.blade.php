<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Pending Property</h2>
        <p class="text-sm text-gray-300 mt-1">Manage and review pending property listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="pending-property"
            class="flex flex-wrap gap-8 justify-center p-6 md:h-[500px] overflow-y-auto custom-scrollbar">
            <!-- Dynamic property cards will appear here -->
        </div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            document.addEventListener('DOMContentLoaded', () => {
                fetchPendingProperties();
            });

            async function fetchPendingProperties() {
                const container = document.getElementById('pending-property');
                // Show loading message while data is being fetched
                container.innerHTML = `
                <p class="flex justify-center items-center text-center text-gray-500 text-lg mt-10">
                    Loading pending properties, please wait...
                </p>`;

                try {
                    const response = await axios.get('/api/propertyAd', {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });

                    const properties = response.data.all_properties.pending;
                    container.innerHTML = '';

                    if (!properties || properties.length === 0) {
                        container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            No pending properties found.
                        </p>`;
                        return;
                    }

                    properties.forEach(prop => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-[#5CFFAB] rounded-2xl shadow-lg hover:shadow-xl overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer';

                        // Image Section
                        const imgSection = document.createElement('div');
                        imgSection.className = 'relative';

                        // Show only first image if exists
                        if (prop.images && prop.images.length > 0) {
                            const img = document.createElement('img');
                            img.src = `/storage/${prop.images[0].image_path}`;
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
                        const badge = document.createElement('div');
                        badge.className =
                            'absolute top-3 right-3 bg-white rounded-lg p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer';
                        badge.innerHTML = `<span class="font-semibold text-sm">${prop.post_type || ''}</span>`;
                        imgSection.appendChild(badge);

                        // Data Section
                        const dataSection = document.createElement('div');
                        dataSection.className = 'p-4 bg-[#5CFFAB] text-black text-center';
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

                        // Action Buttons
                        if (prop.status === 'pending') {
                            const actions = document.createElement('div');
                            actions.className = 'mt-4 flex justify-center gap-2';
                            actions.innerHTML = `
                                <a href="/admin/property/viewAd/${prop.property_id}" 
                                    class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">
                                    View
                                </a>
                                <button onclick="handlePropertyAction('${prop.property_id}', 'Accept')" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">Accept</button>
                                <button onclick="handlePropertyAction('${prop.property_id}', 'Reject')" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">Reject</button>
                            `;
                            dataSection.appendChild(actions);
                        }

                        card.appendChild(imgSection);
                        card.appendChild(dataSection);
                        container.appendChild(card);
                    });

                } catch (error) {
                    console.error('Error fetching pending properties:', error);
                    showError('Failed to fetch properties. Please try again.');
                }
            }

            // Handle Accept/Reject action
            async function handlePropertyAction(propertyId, action) {
                try {
                    const url = action === 'Accept' ?
                        `/api/propertyAd/accept/${propertyId}` :
                        `/api/propertyAd/reject/${propertyId}`;

                    const response = await axios.put(url, {}, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });

                    showSuccess(response.data.success);
                    fetchPendingProperties();
                } catch (error) {
                    console.log(error);
                    showError(error.response?.data?.error || 'Action failed.');
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

            // Show messages
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

</x-admin-layout>
