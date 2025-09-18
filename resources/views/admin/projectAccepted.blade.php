<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Accepted Project</h2>
        <p class="text-sm text-gray-300 mt-1">Review all accepted project listings.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="approved-project"
            class="flex flex-wrap gap-8 justify-center p-6 md:h-[500px] overflow-y-auto custom-scrollbar">
            <!-- Cards will be injected here dynamically -->
        </div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            document.addEventListener('DOMContentLoaded', () => {
                fetchAcceptedProjects();
            });

            // Show approved projects
            async function fetchAcceptedProjects() {
                const container = document.getElementById('approved-project');
                container.innerHTML = `
                <p class="flex justify-center items-center text-center text-gray-500 text-lg mt-10">
                    Loading approved projects, please wait...
                </p>`;

                try {
                    const response = await axios.get('/api/projectAd', {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });

                    const projects = response.data.all_projects.approved;
                    container.innerHTML = '';

                    if (!projects || projects.length === 0) {
                        container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            No approved projects found.
                        </p>`;
                        return;
                    }

                    projects.forEach(proj => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-[#5CFFAB] rounded-2xl shadow-lg hover:shadow-xl overflow-hidden w-[320px] transform transition duration-300 ease-in-out hover:scale-105 cursor-pointer';

                        // Project Image Section
                        const imgSection = document.createElement('div');
                        imgSection.className = 'relative';

                        if (proj.images && proj.images.length > 0) {
                            const firstImage = proj.images[0];
                            const img = document.createElement('img');
                            img.src = `/storage/${firstImage.image_path}`;
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
                        const typeBadge = document.createElement('div');
                        typeBadge.className =
                            'absolute top-3 left-3 bg-white rounded-lg p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer';
                        typeBadge.innerHTML =
                            `<span class="font-semibold text-sm">${proj.property_type || ''}</span>`;
                        imgSection.appendChild(typeBadge);

                        // Hoverable icon with agent tooltip
                        const agentDiv = document.createElement('div');
                        agentDiv.className = 'absolute top-3 right-3 group';

                        const icon = document.createElement('div');
                        icon.className =
                            'bg-white rounded-full p-2 shadow transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 cursor-pointer';
                        const iconImg = document.createElement('img');
                        iconImg.src = '/images/Assign.png';
                        iconImg.alt = 'Assign';
                        iconImg.className = 'h-8 w-8';
                        icon.appendChild(iconImg);

                        const tooltip = document.createElement('div');
                        tooltip.className =
                            'hidden group-hover:block absolute top-15 right-0 bg-white text-black font-semibold text-xs px-2 py-1 rounded shadow-lg z-50';
                        tooltip.textContent = proj.agent?.name || 'Unassigned';

                        agentDiv.appendChild(icon);
                        agentDiv.appendChild(tooltip);
                        imgSection.appendChild(agentDiv);

                        // Project Data Section
                        const dataSection = document.createElement('div');
                        dataSection.className =
                            'p-4 bg-[#5CFFAB] text-black text-center flex-1 flex flex-col justify-between';
                        dataSection.innerHTML = `
                            <h2 class="text-xl font-bold m-1 truncate">${proj.project_name}</h2>
                            <div class="flex justify-center items-center space-x-2 my-3">
                                <img src="/images/Location.png" alt="Location" class="h-6 w-5">
                                <span class="text-sm font-medium truncate">${proj.location}</span>
                            </div>
                            <div class="flex justify-center items-center mt-2 space-x-8">
                                <div class="flex items-center space-x-2">
                                    <img src="/images/money.png" alt="Price" class="h-6 w-6">
                                    <span class="text-sm font-medium">RS ${formatPrice(proj.price)} </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="/images/Status.png" alt="Total Units" class="h-6 w-6">
                                    <span class="text-sm font-medium">${capitalizeFirstLetter(proj.project_status)}</span>
                                </div>
                            </div>
                        `;

                        // Buttons for approved projects
                        if (proj.status === 'approve') {
                            const actions = document.createElement('div');
                            actions.className = 'mt-4 flex justify-center gap-4';
                            actions.innerHTML = `
                                <a href="/admin/project/viewAd/${proj.project_id}" 
                                    class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200 text-center inline-block">
                                    View
                                </a>
                                <button onclick="handleProjectAction('${proj.project_id}', 'Remove')" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg w-24 transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">Remove</button>
                            `;
                            dataSection.appendChild(actions);
                        }

                        card.appendChild(imgSection);
                        card.appendChild(dataSection);
                        container.appendChild(card);
                    });

                } catch (error) {
                    console.error('Error fetching approved projects:', error);
                    showError('Failed to fetch projects. Please try again.');
                }
            }

            // Handle Remove action
            function handleProjectAction(projectId, action) {
                if (action === 'Remove') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This project and its images will be permanently deleted.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`/api/projectAd/${projectId}`, {
                                headers: {
                                    Authorization: `Bearer ${token}`
                                }
                            }).then(res => {
                                showSuccess(res.data.success);
                                fetchAcceptedProjects();
                            }).catch(err => {
                                console.error(err);
                                if (err.response && err.response.data && err.response.data.error) {
                                    showError(err.response.data.error);
                                } else {
                                    showError('Failed to delete project.');
                                }
                            });
                        }
                    });
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
