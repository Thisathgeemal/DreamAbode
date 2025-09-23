<x-admin-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Subscription Management</h2>
        <p class="text-sm text-gray-300 mt-1">View and manage active subscriptions.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">

        <!-- Top Section: Cancel + Search + Export -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <!-- Cancel Button -->
            <div class="flex flex-col sm:flex-col md:flex-row gap-3 w-full md:w-auto">
                <button type="button" onclick="cancelSelectedSubscriptions()"
                    class="w-full md:w-32 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                    Cancel
                </button>
            </div>

            <!-- Search & Export -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <form class="relative flex-1" onsubmit="searchSubscriptions(event)">
                    <input type="text" id="searchBar" name="search" placeholder="Search Subscriptions"
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
                        class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 -bottom-6 left-1/2 transform -translate-x-1/2">Export</span>
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
                        <th class="py-3 px-4 text-left border-b">User Name</th>
                        <th class="py-3 px-4 text-left border-b">Plan Type</th>
                        <th class="py-3 px-4 text-left border-b">Start Date</th>
                        <th class="py-3 px-4 text-left border-b">End Date</th>
                        <th class="py-3 px-4 text-left border-b">Status</th>
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

    @push('scripts')
        <script>
            let currentPage = 1;
            let lastSearch = '';

            document.addEventListener('DOMContentLoaded', () => {
                loadSubscriptions();
            });

            // Load Subscriptions
            function loadSubscriptions(page = 1, search = '') {
                currentPage = page;
                lastSearch = search;

                const tbody = document.querySelector("#subscription-table tbody");
                tbody.innerHTML =
                    `<tr><td colspan="6" class="py-3 px-4 text-center text-gray-500">Loading subscription data, please wait...</td></tr>`;

                axios.get(`/api/subscription?page=${page}&search=${search}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        const subsData = res.data.all_subscriptions || {};
                        populateTable(subsData.data || []);
                        renderPagination(subsData);
                    })
                    .catch(err => {
                        tbody.innerHTML =
                            `<tr><td colspan="6" class="py-3 px-4 text-center text-red-500">Failed to load subscriptions. Please try again.</td></tr>`;
                        console.error(err);
                    });
            }

            // Populate table
            function populateTable(subs) {
                const tbody = document.querySelector("#subscription-table tbody");

                if (!subs.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="6" class="py-3 px-4 text-center text-gray-500">No subscriptions found</td></tr>`;
                    return;
                }

                let html = '';
                subs.forEach(sub => {
                    const startDate = sub.start_date ? new Date(sub.start_date).toISOString().split('T')[0] : 'N/A';
                    const endDate = sub.end_date ? new Date(sub.end_date).toISOString().split('T')[0] : 'N/A';

                    let statusColor = '';
                    switch (sub.status.toLowerCase()) {
                        case 'pending':
                            statusColor = 'text-yellow-500 font-semibold';
                            break;
                        case 'active':
                            statusColor = 'text-green-500 font-semibold';
                            break;
                        case 'expired':
                            statusColor = 'text-gray-500 font-semibold';
                            break;
                        case 'canceled':
                            statusColor = 'text-red-500 font-semibold';
                            break;
                        default:
                            statusColor = 'text-black';
                    }

                    html += `
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-4 border-b"><input type="checkbox" name="selector[]" class="h-4 w-4" value="${sub.subscription_id}"></td>
                            <td class="py-3 px-4 border-b">${sub.member?.name || 'N/A'}</td>
                            <td class="py-3 px-4 border-b">${sub.subscription_type?.type_name || 'N/A'}</td>
                            <td class="py-3 px-4 border-b">${startDate}</td>
                            <td class="py-3 px-4 border-b">${endDate}</td>
                            <td class="py-3 px-4 border-b">
                                <span class="${statusColor}">${capitalizeFirstLetter(sub.status)}</span>
                            </td>
                        </tr>
                    `;
                });

                tbody.innerHTML = html;
            }

            // Render pagination
            function renderPagination(data) {
                let html = '';
                for (let i = 1; i <= data.last_page; i++) {
                    html +=
                        `<button onclick="loadSubscriptions(${i}, '${lastSearch}')" class="px-3 py-1 rounded ${i === currentPage ? 'bg-green-500 text-white' : 'bg-gray-200'} mr-1">${i}</button>`;
                }
                document.getElementById('pagination').innerHTML = html;
            }

            // Cancel selected subscriptions
            function cancelSelectedSubscriptions() {
                const selected = Array.from(document.querySelectorAll('input[name="selector[]"]:checked')).map(cb => cb.value);
                if (!selected.length) return showInfo('Please select at least one subscription to cancel.');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to cancel selected subscription(s)?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        for (const id of selected) {
                            try {
                                await axios.put(`/api/subscription/${id}`, {}, {
                                    headers: {
                                        'Authorization': `Bearer {{ session('auth_token') }}`
                                    }
                                });
                            } catch (err) {
                                const msg = err.response?.data?.error || `Failed to cancel subscription ID ${id}`;
                                showError(msg);
                                return;
                            }
                        }
                        loadSubscriptions(currentPage, lastSearch);
                        showSuccess('Selected subscription(s) cancelled successfully!');
                    }
                });
            }

            // Search
            function searchSubscriptions(e) {
                e.preventDefault();
                const search = document.getElementById('searchBar').value;
                loadSubscriptions(1, search);
            }

            // Export
            function exportSubscriptions(e) {
                e.preventDefault();
                axios.post('/api/reports/', {
                        type: 'adminsubscription'
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
                        link.setAttribute('download', 'Subscription_Report.pdf');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    })
                    .catch(err => {
                        showError('Failed to export PDF.');
                        console.error(err);
                    });
            }

            // Capitalize first letter helper
            function capitalizeFirstLetter(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
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
