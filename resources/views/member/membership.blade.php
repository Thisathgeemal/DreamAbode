<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Subscription Management</h2>
        <p class="text-sm text-gray-300 mt-1">View and manage your subscriptions.</p>
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

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Upgrade Your Subscription</h2>
        <p class="text-sm text-gray-300 mt-1">Choose a plan that best fits your needs and enjoy premium benefits.</p>
    </div>

    <!-- Second Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md">
        <div id="subscription-cards" class="flex flex-wrap justify-center gap-8"></div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" role="dialog" aria-modal="true"
        class="fixed inset-0 backdrop-blur-sm bg-black/30 hidden z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h2 class="text-2xl font-bold text-center mb-4">Complete Payment</h2>

            <form id="paymentForm">
                <input type="hidden" id="type_id" name="type_id">

                <!-- Payment Amount -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">Amount to Pay</label>
                    <input type="text" name="amount" id="paymentAmount" readonly
                        class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Card Type -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">Card Type</label>
                    <select id="card_type" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">Select Card Type</option>
                        <option value="visa">Visa</option>
                        <option value="mastercard">MasterCard</option>
                        <option value="amex">American Express</option>
                        <option value="discover">Discover</option>
                    </select>
                </div>

                <!-- Name on Card -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">Name on Card</label>
                    <input type="text" id="card_name" required placeholder="Full Name"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Card Number -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">Card Number</label>
                    <input type="text" id="card_number" required maxlength="16" placeholder="1234 5678 9012 3456"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Expiry -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">CVV</label>
                    <input type="text" id="cvv" required maxlength="3" placeholder="CVV"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- CVV -->
                <div class="mb-4">
                    <label class="block text-sm font-medium">Expiry Date</label>
                    <input type="month" id="expiry_date" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
                        onclick="closePaymentModal()">Cancel</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Pay
                        Now</button>
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
                loadSubscriptionTypes();
            });

            // Load Subscriptions
            function loadSubscriptions(page = 1, search = '') {
                currentPage = page;
                lastSearch = search;

                const tbody = document.querySelector("#subscription-table tbody");
                tbody.innerHTML =
                    `<tr><td colspan="5" class="py-3 px-4 text-center text-gray-500">Loading subscription data, please wait...</td></tr>`;

                axios.get(`/api/subscription?page=${page}&search=${search}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        const subsData = res.data.user_subscriptions || {};
                        populateTable(subsData.data || []);
                        renderPagination(subsData);
                    })
                    .catch(err => {
                        tbody.innerHTML =
                            `<tr><td colspan="5" class="py-3 px-4 text-center text-red-500">Failed to load subscriptions. Please try again.</td></tr>`;
                        console.error(err);
                    });
            }

            // Populate table
            function populateTable(subs) {
                const tbody = document.querySelector("#subscription-table tbody");

                if (!subs.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="5" class="py-3 px-4 text-center text-gray-500">No subscriptions found</td></tr>`;
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

            // Load Subscription Types
            function loadSubscriptionTypes(page = 1) {
                currentPage = page;

                const container = document.getElementById('subscription-cards');
                container.innerHTML =
                    `<p class="text-gray-500 text-center w-full">Loading subscription types, please wait...</p>`;

                axios.get(`/api/subscriptionType?page=${page}`, {
                        headers: {
                            'Authorization': `Bearer {{ session('auth_token') }}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        const subscriptions = res.data.data || [];
                        populateCards(subscriptions);
                    })
                    .catch(err => {
                        container.innerHTML =
                            `<p class="text-red-500 text-center w-full">Failed to load subscription types. Please try again.</p>`;
                        console.error(err);
                    });
            }


            // Populate cards
            function populateCards(subscriptions) {
                const container = document.getElementById('subscription-cards');
                container.innerHTML = '';

                subscriptions.forEach(sub => {
                    const duration = sub.duration_days ?? 0;
                    const finalPrice = sub.final_price ?? 'Price on request';
                    const discount = sub.discount_percent ? `(${sub.discount_percent}% off)` : '';

                    let imgSrc = '/images/plan.jpg';
                    if (duration <= 30) {
                        imgSrc = '/images/silver.jpg';
                    } else if (duration <= 90) {
                        imgSrc = '/images/gold.jpg';
                    } else if (duration <= 180) {
                        imgSrc = '/images/platinum.jpg';
                    } else {
                        imgSrc = '/images/diamond.jpg';
                    }

                    const card = document.createElement('div');
                    card.className =
                        `w-[300px] h-auto bg-gradient-to-b from-green-100 to-green-200 rounded-xl p-4 flex flex-col justify-between items-center text-center shadow-lg transition duration-300 ease-in-out hover:shadow-2xl hover:scale-105`;

                    card.innerHTML = `
                                <!-- Badge -->
                                <div class="w-full flex justify-end mb-2">
                                    <span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">${sub.type_name}</span>
                                </div>

                                <!-- Image -->
                                <img src="${imgSrc}" alt="${sub.type_name}" class="w-36 h-36 object-contain mb-3 rounded-xl shadow-md">

                                <!-- Duration -->
                                <p class="text-sm font-semibold mb-1">Duration: ${sub.duration_days} days</p>

                                <!-- Price -->
                                <div class="flex items-center mb-3">
                                    <img src="/images/money.png" alt="Price" class="w-5">
                                    <p class="text-sm font-semibold pl-2">Rs ${finalPrice} ${discount}</p>
                                </div>

                                <!-- Description placeholder -->
                                <p class="text-xs text-gray-700 mb-3">Enjoy premium membership benefits and exclusive features tailored for you.</p>

                                <!-- Button -->
                                <button onclick="openPaymentModal(${sub.type_id}, ${sub.final_price ?? 0})"
                                    class="w-[120px] h-[40px] text-sm rounded-md bg-white text-black border border-green-500 font-semibold transition duration-300 ease-in-out hover:scale-105 hover:bg-gray-200">
                                    Get Started
                                </button>
                            `;

                    container.appendChild(card);
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
                        type: 'membersubscription'
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

            // Create subscriptions
            document.getElementById('paymentForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                const form = e.target;
                const typeId = form.type_id.value;
                const amount = form.amount.value;
                const card_type = form.card_type.value;
                const card_name = form.card_name.value;
                const card_number = form.card_number.value;
                const cvv = form.cvv.value;
                const expiry_date = form.expiry_date.value;

                const headers = {
                    'Accept': 'application/json',
                    'Authorization': `Bearer {{ session('auth_token') }}`
                };

                const payload = {
                    type_id: typeId,
                    amount,
                    card_type,
                    card_name,
                    card_number,
                    cvv,
                    expiry_date
                };

                try {
                    const response = await axios.post('/api/subscription', payload, {
                        headers
                    });
                    closePaymentModal();
                    loadSubscriptions(currentPage, lastSearch);
                    showSuccess('Subscription created successfully!');

                } catch (error) {
                    // Check for active subscription conflict
                    if (error.response && error.response.status === 409) {
                        const active = error.response.data.active_subscription;
                        const endDate = active?.end_date ? new Date(active.end_date).toLocaleDateString() : 'N/A';

                        const result = await Swal.fire({
                            title: 'Active Subscription Exists!',
                            text: `You already have an active subscription ending on ${endDate}.`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Wait Until It Ends',
                            cancelButtonText: 'Cancel Subscription',
                            reverseButtons: true,
                            confirmButtonColor: '#16a34a',
                            cancelButtonColor: '#dc2626',
                        });

                        let action = null;
                        if (result.isConfirmed) action = 'wait_old';
                        if (result.dismiss === Swal.DismissReason.cancel) action = 'cancel_old';
                        if (!action) return;

                        try {
                            const retryPayload = {
                                ...payload,
                                action
                            };
                            const response2 = await axios.post('/api/subscription', retryPayload, {
                                headers
                            });

                            closePaymentModal();
                            loadSubscriptions(currentPage, lastSearch);
                            showSuccess('Subscription created successfully!');

                        } catch (err) {
                            console.error('Failed on retrying subscription:', err.response?.data || err);
                            showError(err.response?.data?.error || 'Failed to create subscription after action.');
                        }
                    } else {
                        if (error.response?.status === 422 && error.response?.data?.errors) {
                            let messages = [];
                            for (const field in error.response.data.errors) {
                                messages.push(error.response.data.errors[field].join(", "));
                            }
                            showError(messages.join("\n"));
                        } else {
                            showError(
                                error.response?.data?.error ||
                                error.response?.data?.message ||
                                'Something went wrong while creating subscription check your input are valid.'
                            );
                        }
                    }

                }
            });

            // Open Modal
            function openPaymentModal(subId, amount = '') {
                document.getElementById('type_id').value = subId;
                document.getElementById('paymentAmount').value = amount;
                document.getElementById('paymentModal').classList.add('flex');
                document.getElementById('paymentModal').classList.remove('hidden');
            }

            // Close Modal
            function closePaymentModal() {
                document.getElementById('paymentModal').classList.add('hidden');
                document.getElementById('paymentModal').classList.remove('flex');

                const form = document.getElementById('paymentForm');
                form.reset();
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

</x-app-layout>
