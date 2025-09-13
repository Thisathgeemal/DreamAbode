<x-admin-layout>

    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <h2 class="text-2xl text-white font-bold">Payment Management</h2>
        <p class="text-sm text-gray-300 mt-1">Manage all member payments and transactions.</p>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">

        <!-- Top Section: Search + Export -->
        <div class="flex justify-end items-center gap-3 mb-6">

            <!-- Search -->
            <form class="relative" onsubmit="searchPayments(event)">
                <input type="text" id="SearchBar" name="search" placeholder="Search Payments"
                    class="p-1.5 pl-8 h-10 border rounded-full w-full md:w-56 text-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                <button type="submit"
                    class="absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Export -->
            <form target="_blank" class="relative group" onsubmit="exportPayments(event)">
                @csrf
                <button type="submit"
                    class="bg-blue-500 text-white p-1.5 rounded-lg hover:bg-blue-600 flex items-center justify-center w-10 h-10">
                    <i class="fas fa-download text-white text-sm"></i>
                </button>
                <span
                    class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded py-1 px-2 -bottom-6 left-1/2 transform -translate-x-1/2">
                    Export
                </span>
            </form>

        </div>

        <!-- Payment Table -->
        <div class="overflow-auto max-w-[300px] md:max-w-7xl border rounded shadow-md">
            <table class="min-w-full bg-white shadow-md rounded-lg border text-base border-green-400"
                id="payment-table">
                <thead class="bg-green-200 text-gray-800">
                    <tr>
                        <th class="py-3 px-4 text-left border-b">No</th>
                        <th class="py-3 px-4 text-left border-b">User Name</th>
                        <th class="py-3 px-4 text-left border-b">Title</th>
                        <th class="py-3 px-4 text-left border-b">Amount</th>
                        <th class="py-3 px-4 text-left border-b">Description</th>
                        <th class="py-3 px-4 text-left border-b">Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data populated via JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center" id="payment-pagination"></div>

    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";
            let currentPaymentPage = 1;
            let lastPaymentSearch = '';

            document.addEventListener('DOMContentLoaded', () => {
                loadPayments();
            });

            // Load payments
            function loadPayments(page = 1, search = '') {
                currentPaymentPage = page;
                lastPaymentSearch = search;

                axios.get(`/api/payments?page=${page}&search=${search}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        const payments = res.data.all_payments || [];
                        populatePaymentTable(payments.data);
                        renderPaymentPagination(payments);
                    })
                    .catch(err => {
                        console.error('Failed to load payments:', err);
                        showError('Failed to load payments. Please try again.');
                    });
            }

            // Populate the payment table
            function populatePaymentTable(payments) {
                const tbody = document.querySelector("#payment-table tbody");
                if (!payments.length) {
                    tbody.innerHTML =
                        `<tr><td colspan="6" class="py-3 px-4 text-center text-gray-500">No payments found</td></tr>`;
                    return;
                }

                tbody.innerHTML = payments.map((payment, index) => `
                    <tr class="hover:bg-gray-100 transition duration-200">
                        <td class="py-3 px-4 border-b">${(currentPaymentPage - 1) * 5 + (index + 1)}</td>
                        <td class="py-3 px-4 border-b">${payment.member?.name ?? 'N/A'}</td>
                        <td class="py-3 px-4 border-b">${payment.title}</td>
                        <td class="py-3 px-4 border-b">${payment.amount}</td>
                        <td class="py-3 px-4 border-b">${payment.description}</td>
                        <td class="py-3 px-4 border-b">${formatDateTime(payment.created_at)}</td>
                    </tr>
                `).join('');
            }

            // Render pagination 
            function renderPaymentPagination(data) {
                const container = document.getElementById('payment-pagination');
                if (!data.last_page || data.last_page <= 1) {
                    container.innerHTML = '';
                    return;
                }

                let html = '';
                for (let i = 1; i <= data.last_page; i++) {
                    html += `<button onclick="loadPayments(${i}, '${lastPaymentSearch}')"
                        class="px-3 py-1 rounded ${i === currentPaymentPage ? 'bg-green-500 text-white' : 'bg-gray-200'} mr-1">
                        ${i}
                     </button>`;
                }
                container.innerHTML = html;
            }

            // search
            function searchPayments(e) {
                e.preventDefault();
                const search = document.getElementById('SearchBar').value;
                loadPayments(1, search);
            }

            // Export payments
            function exportPayments(e) {
                e.preventDefault();
                axios.post('/api/reports/', {
                        type: 'adminpayment'
                    }, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
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
                        link.setAttribute('download', 'Payments_Report.pdf');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    })
                    .catch(err => {
                        console.error('Failed to export PDF', err);
                        showError('Failed to export payments report. Please try again.');
                    });

            }

            // formatDateTime
            function formatDateTime(datetime) {
                if (!datetime) return 'N/A';
                const date = new Date(datetime);

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');

                return `${year}-${month}-${day} | ${hours}.${minutes}`;
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
