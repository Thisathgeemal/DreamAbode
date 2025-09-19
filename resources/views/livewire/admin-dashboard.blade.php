<div>
    <div wire:poll.10s="loadDashboardData" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Administrators</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalAdmins }}</p>
        </div>

        <!-- Card 2 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Registered Members</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalMembers }}</p>
        </div>

        <!-- Card 3 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Active Agents</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalAgents }}</p>
        </div>

        <!-- Card 4 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Today Revenue</h3>
            <p class="text-2xl font-bold text-gray-900">Rs {{ $todaysRevenue }}</p>
        </div>

        <!-- Card 5 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Approved Properties</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProperties }}</p>
        </div>

        <!-- Card 6 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Approved Projects</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProjects }}</p>
        </div>

        <!-- Card 7 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Pending Approvals</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingApprovals }}</p>
        </div>

        <!-- Card 8 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Completed Deals</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $completedDeals }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Graph 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">Sales & Rentals Overview</h3>
            <canvas id="salesChart" class="w-full h-64"></canvas>
        </div>

        <!-- Graph 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">Revenue Over Time</h3>
            <canvas id="revenueChart" class="w-full h-64"></canvas>
        </div>

        <!-- Graph 3 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-4">Property & Project Status</h3>
            <div class="flex justify-center" wire:ignore>
                <canvas id="statusChart" class="w-full max-w-[500px] h-[375px]"></canvas>
            </div>
        </div>

        <!-- Graph 4 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">Property Types Distribution</h3>
            <div class="flex justify-center" wire:ignore>
                <canvas id="propertyTypeChart" class="w-full max-w-[400px] h-auto"></canvas>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Property Sales',
                        data: @json($propertySalesData),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Property Rentals',
                        data: @json($propertyRentalsData),
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Project Sales',
                        data: @json($projectSalesData),
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Property Types
        const propertyTypeCtx = document.getElementById('propertyTypeChart').getContext('2d');
        new Chart(propertyTypeCtx, {
            type: 'doughnut',
            data: {
                labels: @json($propertyTypes),
                datasets: [{
                    label: 'Approved Properties',
                    data: @json($propertyTypeCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    label: 'Count',
                    data: @json($statusData),
                    backgroundColor: [
                        '#FACC15', '#F59E0B',
                        '#EF4444', '#B91C1C',
                        '#22C55E', '#15803D',
                        '#3B82F6', '#1D4ED8'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
