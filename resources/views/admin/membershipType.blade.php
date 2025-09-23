<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Subscription Management</h2>
        <p class="text-sm text-gray-300 mt-1">Manage your subscription plans effectively.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">

        <!-- Top Section: Actions + Search + Export -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-col md:flex-row gap-3 w-full md:w-auto">
                <button type="button" onclick="openModal()"
                    class="w-full md:w-32 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                    Add
                </button>

                <button type="button" onclick="deleteSelectedSubscriptions()"
                    class="w-full md:w-32 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                    Delete
                </button>
            </div>

            <!-- Search & Export -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <form class="relative flex-1" onsubmit="searchSubscriptions(event)">
                    <input type="text" id="searchBar" name="search" placeholder="Search Subscription Types"
                        class="p-1.5 pl-8 h-10 border rounded-full w-full md:w-56 text-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    <button type="submit"
                        class="absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <form target="_blank" class="relative group" onsubmit="exportSubscriptions(event)">
                    @csrf
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

        <!-- Subscription Table -->
        <div class="overflow-auto max-w-[300px] md:max-w-7xl mt-7 border rounded shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg border text-base border-green-400"
                id="subscription-table">
                <thead class="bg-green-200 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 text-left border-b">
                            <input type="checkbox" id="select-all" onclick="toggleAll(this)">
                        </th>
                        <th class="py-3 px-4 text-left border-b">Type Name</th>
                        <th class="py-3 px-4 text-left border-b">Duration (Days)</th>
                        <th class="py-3 px-4 text-left border-b">Base Amount</th>
                        <th class="py-3 px-4 text-left border-b">Discount %</th>
                        <th class="py-3 px-4 text-left border-b">Final Price</th>
                        <th class="py-3 px-4 text-left border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data populated via JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center" id="pagination"></div>

    </div>

    <!-- Modal: Create/Edit Subscription -->
    <div id="subscriptionModal"
        class="fixed inset-0 items-center justify-center backdrop-blur-sm bg-white/20 hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-md md:text-3xl font-bold text-center mb-4" id="modalHeader">Create Subscription Plan</h2>

            <form id="subscriptionForm">
                @csrf
                <input type="hidden" id="type_id" name="type_id">

                <div>
                    <label for="type_name" class="block text-sm font-medium text-gray-700 mt-2">Type Nmae</label>
                    <input id="type_name" name="type_name" type="text" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="duration_days" class="block text-sm font-medium text-gray-700 mt-2">Duration
                        (Days)</label>
                    <input id="duration_days" name="duration_days" type="number" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="base_amount" class="block text-sm font-medium text-gray-700 mt-2">Base Amount</label>
                    <input id="base_amount" name="base_amount" type="number" step="0.01" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="discount_percent" class="block text-sm font-medium text-gray-700 mt-2">Discount
                        (%)</label>
                    <input id="discount_percent" name="discount_percent" type="number" step="0.01"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div>
                    <label for="final_price" class="block text-sm font-medium text-gray-700 mt-2">Final Price</label>
                    <input id="final_price" name="final_price" type="number" step="0.01" required readonly
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded">
                        Cancel
                    </button>
                    <button type="submit" id="modalSubmitButton"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentPage = 1;
            let lastSearch = '';

            document.addEventListener('DOMContentLoaded', () => {
                loadSubscriptions();

                // Auto calculate final price
                document.getElementById('base_amount').addEventListener('input', calculateFinalPrice);
                document.getElementById('discount_percent').addEventListener('input', calculateFinalPrice);
            });

            // Load Subscriptions with Pagination
            function loadSubscriptions(page = 1, search = '') {
                currentPage = page;
                lastSearch = search;

                const tbody = document.querySelector("#subscription-table tbody");
                tbody.innerHTML =
                    `<tr><td colspan="7" class="py-3 px-4 text-center text-gray-500">Loading subscription data, please wait...</td></tr>`;

                axios.get(`/api/subscriptionType?page=${page}&search=${search}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        const subscriptions = res.data.data || [];
                        populateTable(subscriptions);
                        renderPagination(res.data);
                    })
                    .catch(err => {
                        tbody.innerHTML =
                            `<tr><td colspan="7" class="py-3 px-4 text-center text-red-500">Failed to load subscription types. Please try again.</td></tr>`;
                        console.error(err);
                    });
            }

            function populateTable(subscriptions) {
                const tbody = document.querySelector("#subscription-table tbody");

                if (!subscriptions.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="7" class="py-3 px-4 text-center text-gray-500">No subscriptions found</td></tr>`;
                    return;
                }

                let html = '';
                subscriptions.forEach(sub => {
                    html += `
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-4 border-b"><input type="checkbox" name="selector[]" class="h-4 w-4" value="${sub.type_id}"></td>
                            <td class="py-3 px-4 border-b">${sub.type_name}</td>
                            <td class="py-3 px-4 border-b">${sub.duration_days}</td>
                            <td class="py-3 px-4 border-b">${sub.base_amount}</td>
                            <td class="py-3 px-4 border-b">${sub.discount_percent ?? 0}</td>
                            <td class="py-3 px-4 border-b">${sub.final_price}</td>
                            <td class="py-3 px-4 border-b">
                                <button onclick="openEditModal(${sub.type_id})" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-green-100 hover:bg-green-200 text-green-500 hover:text-green-700" title="Edit">
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
                        `<button onclick="loadSubscriptions(${i}, '${lastSearch}')" class="px-3 py-1 rounded ${i === currentPage ? 'bg-green-500 text-white' : 'bg-gray-200'} mr-1">${i}</button>`;
                }
                document.getElementById('pagination').innerHTML = html;
            }

            // Auto-calc Final Price
            function calculateFinalPrice() {
                let base = parseFloat(document.getElementById('base_amount').value) || 0;
                let discount = parseFloat(document.getElementById('discount_percent').value) || 0;
                let final = base - (base * (discount / 100));
                document.getElementById('final_price').value = final.toFixed(2);
            }

            // Modal Handling
            function openModal() {
                document.getElementById('subscriptionForm').reset();
                document.getElementById('type_id').value = '';
                document.getElementById('modalHeader').textContent = 'Create Subscription Plan';
                document.getElementById('modalSubmitButton').textContent = 'Create';
                document.getElementById('subscriptionModal').classList.remove('hidden');
                document.getElementById('subscriptionModal').classList.add('flex');
            }

            function openEditModal(id) {
                axios.get(`/api/subscriptionType/${id}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`
                        }
                    })
                    .then(res => {
                        const sub = res.data;
                        document.getElementById('type_id').value = sub.type_id;
                        document.getElementById('type_name').value = sub.type_name ?? '';
                        document.getElementById('duration_days').value = sub.duration_days ?? '';
                        document.getElementById('base_amount').value = sub.base_amount ?? '';
                        document.getElementById('discount_percent').value = sub.discount_percent ?? '';
                        document.getElementById('final_price').value = sub.final_price ?? '';
                        document.getElementById('modalHeader').textContent = 'Edit Subscription Plan';
                        document.getElementById('modalSubmitButton').textContent = 'Update';
                        document.getElementById('subscriptionModal').classList.remove('hidden');
                        document.getElementById('subscriptionModal').classList.add('flex');
                    });
            }

            function closeModal() {
                document.getElementById('subscriptionModal').classList.add('hidden');
                document.getElementById('subscriptionModal').classList.remove('flex');
            }

            // Create / Update Subscriptions
            document.getElementById('subscriptionForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const id = document.getElementById('type_id').value;
                const formData = new FormData(this);

                if (id) {
                    formData.append('_method', 'PUT');
                    axios.post(`/api/subscriptionType/${id}`, formData, {
                            headers: {
                                'Authorization': `Bearer {{ session('auth_token') }}`,
                                'Accept': 'application/json',
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(res => {
                            closeModal();
                            loadSubscriptions(currentPage, lastSearch);
                            showSuccess(res.data.success || 'Subscription updated successfully!');
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
                                showError('Something went wrong! Contact support service');
                            }
                        });
                } else {
                    axios.post('/api/subscriptionType', formData, {
                            headers: {
                                'Authorization': `Bearer {{ session('auth_token') }}`,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            closeModal();
                            loadSubscriptions(currentPage, lastSearch);
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
                                showError('Something went wrong! Contact support service');
                            }
                        });
                }
            });

            // Delete Subscriptions
            function deleteSelectedSubscriptions() {
                const selected = Array.from(document.querySelectorAll('input[name="selector[]"]:checked')).map(cb => cb.value);
                if (!selected.length) return showInfo('Please select at least one subscription to delete.');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete selected subscription(s)?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        for (const id of selected) {
                            try {
                                await axios.delete(`/api/subscriptionType/${id}`, {
                                    headers: {
                                        'Authorization': `Bearer {{ session('auth_token') }}`
                                    }
                                });
                            } catch (err) {
                                const msg = err.response?.data?.error || `Failed to delete subscription ID ${id}`;
                                showError(msg);
                                return;
                            }
                        }
                        loadSubscriptions(currentPage, lastSearch);
                        showSuccess('Selected subscription(s) deleted successfully!');
                    }
                });
            }

            // Search & Export
            function searchSubscriptions(e) {
                e.preventDefault();
                const search = document.getElementById('searchBar').value;
                loadSubscriptions(1, search);
            }

            function exportSubscriptions(e) {
                e.preventDefault();
                axios.post('/api/reports/', {
                        type: 'subscriptionType'
                    }, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/pdf',
                            'Content-Type': 'application/json'
                        },
                        responseType: 'blob'
                    })
                    .then(res => {
                        const url = window.URL.createObjectURL(new Blob([res.data], {
                            type: 'application/pdf'
                        }));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'Subscription_Type_Report.pdf');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    })
                    .catch(err => {
                        showError('Failed to export PDF.');
                        console.error(err);
                    });
            }

            // Utilities
            function toggleAll(checkbox) {
                document.querySelectorAll('input[name="selector[]"]').forEach(cb => cb.checked = checkbox.checked);
            }

            // Alerts
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
