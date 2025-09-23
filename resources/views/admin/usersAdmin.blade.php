<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Admin Management</h2>
        <p class="text-sm text-gray-300 mt-1">Manage your admins effectively and keep your system secure.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">

        <!-- Top Section: Actions + Search + Export -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-col md:flex-row gap-3 w-full md:w-auto">
                <button type="button" onclick="openModal()"
                    class="w-full sm:w-full md:w-32 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 mb-2 md:mb-0 rounded-lg">
                    Add
                </button>

                <button type="button" onclick="deleteSelectedAdmins()"
                    class="w-full sm:w-full md:w-32 bg-red-500 hover:bg-red-600 text-white py-2 px-4 mb-2 md:mb-0 rounded-lg">
                    Delete
                </button>
            </div>

            <!-- Search & Export -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <form class="relative flex-1" onsubmit="searchAdmins(event)">
                    <input type="text" id="searchBar" name="search" placeholder="Search Users"
                        class="p-1.5 pl-8 h-10 border rounded-full w-full md:w-56 text-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <button type="submit"
                        class="absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <form target="_blank" class="relative group" onsubmit="exportAdmins(event)">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit"
                        class="bg-blue-500 text-white p-1.5 rounded-lg hover:bg-blue-600 flex items-center justify-center w-10 h-10">
                        <i class="fas fa-download text-white text-sm"></i>
                    </button>
                    <span
                        class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 -bottom-6 left-1/2 transform -translate-x-1/2">Export
                    </span>
                </form>
            </div>

        </div>

        <!-- Admin Table -->
        <div class="overflow-auto max-w-[300px] md:max-w-7xl mt-7 border rounded shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg border text-base border-green-400" id="admin-table">
                <thead class="bg-green-200 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 text-left border-b border-gray-300">
                            <input type="checkbox" id="select-all" class="h-4 w-4" onclick="toggleAll(this)">
                        </th>
                        <th class="py-3 text-left px-4 border-b border-gray-300">Name</th>
                        <th class="py-3 text-left px-4 border-b border-gray-300">Email</th>
                        <th class="py-3 text-left px-4 border-b border-gray-300">Mobile</th>
                        <th class="py-3 text-left px-4 border-b border-gray-300">Address</th>
                        <th class="py-3 text-left px-4 border-b border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Admin data will be populated by JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center" id="pagination"></div>

    </div>

    <!-- Modal: Create/Edit Admin -->
    <div id="adminModal" role="dialog" aria-modal="true"
        class="fixed inset-0 items-center justify-center backdrop-blur-sm bg-white/20 hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-md md:text-3xl font-bold text-center mb-4" id="modalHeader">Create Admin Account</h2>

            <form id="adminForm">
                @csrf
                <input type="hidden" id="admin_id" name="admin_id">

                <div>
                    <label for="name" class="block text-left text-sm font-medium text-gray-700 mt-2">Name</label>
                    <input id="name" type="text" name="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="email" class="block text-left text-sm font-medium text-gray-700 mt-2">Email</label>
                    <input id="email" type="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="mobile_number" class="block text-left text-sm font-medium text-gray-700 mt-2">Mobile
                        Number</label>
                    <input id="mobile_number" type="tel" name="mobile_number" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="address" class="block text-left text-sm font-medium text-gray-700 mt-2">Address</label>
                    <input id="address" type="text" name="address" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                        onclick="closeModal()">Cancel</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
                        id="modalSubmitButton">Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentPage = 1;
            let lastSearch = '';

            document.addEventListener('DOMContentLoaded', () => {
                loadAdmins();
            });

            // Load Admins with Pagination
            function loadAdmins(page = 1, search = '') {
                currentPage = page;
                lastSearch = search;

                const tbody = document.querySelector("#admin-table tbody");
                tbody.innerHTML =
                    `<tr><td colspan="6" class="py-3 px-4 text-center text-gray-500">Loading admin data, please wait...</td></tr>`;

                axios.get(`/api/admins?page=${page}&search=${search}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        // let admins = res.data.data ?? res.data;
                        const admins = res.data.data || [];
                        populateTable(admins);
                        renderPagination(res.data);
                    })
                    .catch(err => {
                        console.error(err);
                        tbody.innerHTML =
                            `<tr><td colspan="6" class="py-3 px-4 text-center text-red-500">Failed to load admin data.</td></tr>`;
                    });
            }

            function populateTable(admins) {
                const tbody = document.querySelector("#admin-table tbody");

                if (!admins.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="6" class="py-3 px-4 text-center text-gray-500">No admins found</td></tr>`;
                    return;
                }

                let html = '';
                admins.forEach(admin => {
                    html += `
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-4 border-b"><input type="checkbox" name="selector[]" class="h-4 w-4" value="${admin.id}"></td>
                            <td class="py-3 px-4 border-b">${admin.name}</td>
                            <td class="py-3 px-4 border-b">${admin.email}</td>
                            <td class="py-3 px-4 border-b">${admin.mobile_number ?? ''}</td>
                            <td class="py-3 px-4 border-b">${admin.address ?? ''}</td>
                            <td class="py-3 px-4 border-b border-gray-200">
                                <button onclick="openEditModal(${admin.id})" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-green-100 hover:bg-green-200 transition duration-200 text-green-500 hover:text-green-700" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                tbody.innerHTML = html;
            }

            function renderPagination(data) {
                let html = '';
                for (let i = 1; i <= data.last_page; i++) {
                    html +=
                        `<button onclick="loadAdmins(${i}, '${lastSearch}')" class="px-3 py-1 rounded ${i === currentPage ? 'bg-green-500 text-white' : 'bg-gray-200'} mr-1">${i}</button>`;
                }
                document.getElementById('pagination').innerHTML = html;
            }

            // Modal Handling
            function openModal() {
                document.getElementById('adminForm').reset();
                document.getElementById('admin_id').value = '';
                document.getElementById('modalHeader').textContent = 'Create Admin Account';
                document.getElementById('modalSubmitButton').textContent = 'Create';
                document.getElementById('adminModal').classList.remove('hidden');
                document.getElementById('adminModal').classList.add('flex');
            }

            function openEditModal(id) {
                axios.get(`/api/admins/${id}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        }
                    })
                    .then(res => {
                        const admin = res.data;
                        document.getElementById('admin_id').value = admin.id;
                        document.getElementById('name').value = admin.name ?? '';
                        document.getElementById('email').value = admin.email ?? '';
                        document.getElementById('mobile_number').value = admin.mobile_number ?? '';
                        document.getElementById('address').value = admin.address ?? '';
                        document.getElementById('modalHeader').textContent = 'Edit Admin Account';
                        document.getElementById('modalSubmitButton').textContent = 'Update';
                        document.getElementById('adminModal').classList.remove('hidden');
                        document.getElementById('adminModal').classList.add('flex');
                    });
            }

            function closeModal() {
                document.getElementById('adminModal').classList.add('hidden');
                document.getElementById('adminModal').classList.remove('flex');
            }

            // Create / Update Admin
            document.getElementById('adminForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('admin_id').value;
                const formData = new FormData(this);
                if (id) {
                    formData.append('_method', 'PUT');
                    axios.post(`/api/admins/${id}`, formData, {
                            headers: {
                                'Authorization': `Bearer {{ session('auth_token') }}`,
                                'Accept': 'application/json',
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(res => {
                            console.log('Response:', res.data);
                            closeModal();
                            loadAdmins(currentPage, lastSearch);
                            showSuccess(res.data.success);
                        })
                        .catch(err => {
                            const response = err.response;
                            if (!response) return showError('Network error!');

                            if (response.status === 409 && response.data?.message) {
                                closeModal();
                                showInfo(response.data.message);
                            } else if (response.data?.error) {
                                showError(response.data.error);
                            } else {
                                showError('Something went wrong!');
                            }
                        });
                } else {
                    axios.post('/api/admins', formData, {
                            headers: {
                                'Authorization': `Bearer {{ session('auth_token') }}`,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            closeModal();
                            loadAdmins(currentPage, lastSearch);
                            if (res.data.success) {
                                showSuccess(res.data.success);
                            } else if (res.data.message) {
                                showInfo(res.data.message);
                            }
                        })
                        .catch(err => {
                            const response = err.response;
                            if (!response) return showError('Network error!');

                            if (response.status === 409 && response.data?.message) {
                                closeModal();
                                showInfo(response.data.message);
                            } else if (response.data?.error) {
                                showError(response.data.error);
                            } else {
                                showError('Something went wrong!');
                            }
                        });
                }
            });

            // Delete Admin
            function deleteSelectedAdmins() {
                const selected = Array.from(document.querySelectorAll('input[name="selector[]"]:checked'))
                    .map(cb => cb.value);

                if (!selected.length) return showInfo('Please select at least one admin to delete.');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete selected admin(s)?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // Loop through each selected admin and delete individually
                        for (const id of selected) {
                            try {
                                await axios.delete(`/api/admins/${id}`, {
                                    headers: {
                                        'Authorization': `Bearer {{ session('auth_token') }}`
                                    }
                                });
                            } catch (err) {
                                const msg = err.response?.data?.error || `Failed to delete admin with ID ${id}`;
                                showError(msg);
                                return;
                            }
                        }

                        loadAdmins(currentPage, lastSearch);
                        showSuccess('Selected admin(s) deleted successfully!');
                    }
                });
            }

            // Search & Export
            function searchAdmins(e) {
                e.preventDefault();
                const search = document.getElementById('searchBar').value;
                loadAdmins(1, search);
            }

            function exportAdmins(e) {
                e.preventDefault();
                const role = document.querySelector('input[name="role"]').value;
                const roleCapitalized = role.charAt(0).toUpperCase() + role.slice(1);

                axios.post('/api/reports/', {
                        role: role
                    }, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/pdf'
                        },
                        responseType: 'blob'
                    })
                    .then(res => {
                        const url = window.URL.createObjectURL(new Blob([res.data], {
                            type: 'application/pdf'
                        }));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', `${roleCapitalized}_Report.pdf`);
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    })
                    .catch(err => {
                        console.error(err);
                        showError('Failed to export PDF.');
                    });
            }

            // Utilities
            function toggleAll(checkbox) {
                document.querySelectorAll('input[name="selector[]"]').forEach(cb => cb.checked = checkbox.checked);
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

</x-admin-layout>
