<div>
    <div wire:poll.5s="loadDashboardData" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Member Card 1 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Approved Properties</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $myApprovedProperties }}</p>
        </div>

        <!-- Member Card 2 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Approved Projects</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $myApprovedProjects }}</p>
        </div>

        <!-- Member Card 3 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Pending Approvals</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $myPendingApprovals }}</p>
        </div>

        <!-- Member Card 4 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Completed Deals</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $myCompletedDeals }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Graph 1 -->
        <div wire:ignore class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">My Sales & Rentals Overview</h3>
            <canvas id="memberSalesChart" class="w-full h-64"></canvas>
        </div>

        <!-- Graph 2: Property & Project Status Bar Chart -->
        <div wire:ignore class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">My Property & Project Status</h3>
            <canvas id="statusBarChart" class="w-full" style="height: 256px; max-height: 256px;"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-tasks text-green-500 mr-3"></i>
            Recent Activities
        </h2>

        <div class="space-y-4">
            @forelse($recentActivities as $activity)
                <div class="flex items-start space-x-3 p-3 border-l-4 border-gray-200 bg-gray-50 rounded-r-lg">
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas {{ $activity['icon'] }} text-gray-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-900">{{ $activity['message'] }}</p>
                        <p class="text-sm text-gray-600">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-history text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500">No recent activity</p>
                    <p class="text-sm text-gray-400">Activities will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Member Sales & Rentals (Line Chart)
        const memberSalesCtx = document.getElementById('memberSalesChart').getContext('2d');
        new Chart(memberSalesCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'My Property Sales',
                        data: @json($propertySalesData).map(v => (v && v > 0 ? v : 0)),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'My Property Rentals',
                        data: @json($propertyRentalsData).map(v => (v && v > 0 ? v : 0)),
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'My Project Sales',
                        data: @json($projectSalesData).map(v => (v && v > 0 ? v : 0)),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0
                    }
                }
            }
        });

        // Property & Project Status (Bar Chart)
        const statusBarCtx = document.getElementById('statusBarChart').getContext('2d');
        new Chart(statusBarCtx, {
            type: 'bar',
            data: {
                labels: @json($statusLabels),
                datasets: [{
                    label: 'Count',
                    data: @json($statusData).map(v => (v && v > 0 ? v : 0)),
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
