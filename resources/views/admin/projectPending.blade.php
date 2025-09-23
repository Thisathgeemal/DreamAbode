<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Pending Project</h2>
        <p class="text-sm text-gray-300 mt-1">Manage and review pending project listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="pending-project"
            class="flex flex-wrap gap-8 justify-center p-6 md:h-[500px] overflow-y-auto custom-scrollbar">
            <!-- Dynamic project cards will appear here -->
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                fetchPendingProjects();
            });

            async function fetchPendingProjects() {
                const container = document.getElementById('pending-project');
                container.innerHTML = `
                    <p class="flex justify-center items-center text-center text-gray-500 text-lg mt-10">
                        Loading pending projects, please wait...
                    </p>`;

                try {
                    const response = await axios.get('/api/projectAd', {
                        headers: {
                            Authorization: `Bearer {{ session('auth_token') }}`
                        }
                    });

                    const projects = response.data.all_projects.pending;
                    container.innerHTML = '';

                    if (!projects || projects.length === 0) {
                        container.innerHTML = `
                            <p class="flex justify-center items-center text-center text-green-500 text-lg">
                                No pending projects found.
                            </p>`;
                        return;
                    }

                    projects.forEach(project => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-[#5CFFAB] rounded-2xl shadow-lg hover:shadow-xl overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer';

                        // Image Section
                        const imgSection = document.createElement('div');
                        imgSection.className = 'relative';

                        if (project.images && project.images.length > 0) {
                            const img = document.createElement('img');
                            img.src = `/storage/${project.images[0].image_path}`;
                            img.alt = 'Project Image';
                            img.className = 'w-full h-60 object-cover block';
                            imgSection.appendChild(img);
                        } else {
                            const placeholder = document.createElement('div');
                            placeholder.className =
                                'w-full h-60 bg-gray-200 flex items-center justify-center text-gray-400';
                            placeholder.textContent = 'No Image';
                            imgSection.appendChild(placeholder);
                        }

                        // Property Type Badge
                        const badge = document.createElement('div');
                        badge.className =
                            'absolute top-3 right-3 bg-white rounded-lg p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer';
                        badge.innerHTML =
                            `<span class="font-semibold text-sm">${project.property_type || ''}</span>`;
                        imgSection.appendChild(badge);

                        // Data Section
                        const dataSection = document.createElement('div');
                        dataSection.className = 'p-4 bg-[#5CFFAB] text-black text-center';
                        dataSection.innerHTML = `
                            <h2 class="text-xl font-bold m-1 truncate">${project.project_name}</h2>
                            <div class="flex justify-center items-center space-x-2 my-3">
                                <img src="/images/Location.png" alt="Location" class="h-6 w-5">
                                <span class="text-sm font-medium truncate">${project.location}</span>
                            </div>
                            <div class="flex justify-center items-center mt-2 space-x-8">
                                <div class="flex items-center space-x-2">
                                    <img src="/images/money.png" alt="Price" class="h-6 w-6">
                                    <span class="text-sm font-medium">RS ${formatPrice(project.price)}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="/images/Status.png" alt="Total Units" class="h-6 w-6">
                                    <span class="text-sm font-medium">${capitalizeFirstLetter(project.project_status)}</span>
                                </div>
                            </div>
                        `;

                        // Action Buttons
                        if (project.status === 'pending') {
                            const actions = document.createElement('div');
                            actions.className = 'mt-4 flex justify-center gap-2';
                            actions.innerHTML = `
                                <a href="/admin/project/viewAd/${project.project_id}" 
                                    class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">
                                    View
                                </a>
                                <button onclick="handleProjectAction('${project.project_id}', 'Accept')" 
                                    class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">
                                    Accept
                                </button>
                                <button onclick="handleProjectAction('${project.project_id}', 'Reject')" 
                                    class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">
                                    Reject
                                </button>
                            `;
                            dataSection.appendChild(actions);
                        }

                        card.appendChild(imgSection);
                        card.appendChild(dataSection);
                        container.appendChild(card);
                    });

                } catch (error) {
                    console.error('Error fetching pending projects:', error);
                    showError('Failed to fetch projects. Please try again.');
                }
            }

            // Handle Accept/Reject action
            async function handleProjectAction(projectId, action) {
                try {
                    const url = action === 'Accept' ?
                        `/api/projectAd/accept/${projectId}` :
                        `/api/projectAd/reject/${projectId}`;

                    const response = await axios.put(url, {}, {
                        headers: {
                            Authorization: `Bearer {{ session('auth_token') }}`
                        }
                    });

                    showSuccess(response.data.success);
                    fetchPendingProjects();
                } catch (error) {
                    console.error(error);
                    showError(error.response?.data?.error || 'Action failed.');
                }
            }

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

            // Show messages
            function showSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg,
                    confirmButtonColor: '#28a745'
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
