<div>
    <div wire:poll.5s="loadDashboardData" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Agent Card 1 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Assigned Properties</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $assignedProperties }}</p>
        </div>

        <!-- Agent Card 2 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Assigned Projects</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $assignedProjects }}</p>
        </div>

        <!-- Agent Card 3 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Completed Deals</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $completedDeals }}</p>
        </div>

        <!-- Agent Card 4 -->
        <div
            class="bg-white shadow-md rounded-lg p-5 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50">
            <h3 class="text-gray-500 text-sm font-medium">Unread Messages</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $unreadMessages }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Line Chart: Assigned & Completed -->
        <div wire:ignore class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">Assigned & Completed Overview</h3>
            <canvas id="agentLineChart" class="w-full h-full"></canvas>
        </div>

        <!-- Donut Chart: Property Types -->
        <div wire:poll.5s="loadDonutChartData" class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl text-center font-semibold mb-6">Assigned Property Types</h3>
            <div class="flex justify-center" wire:ignore>
                <canvas id="agentDonutChart" class="w-full h-full"
                    style="max-width: 500px; max-height: 300px;"></canvas>
            </div>
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
        // Line Chart: Assigned & Completed
        const agentLineCtx = document.getElementById('agentLineChart').getContext('2d');
        new Chart(agentLineCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                        label: 'Assigned Properties',
                        data: @json($lineChartData['assignedProperties']).map(v => v ?? 0),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Assigned Projects',
                        data: @json($lineChartData['assignedProjects']).map(v => v ?? 0),
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Completed Deals',
                        data: @json($lineChartData['completedDeals']).map(v => v ?? 0),
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

        // Donut Chart: Assigned Property Types
        const agentDonutCtx = document.getElementById('agentDonutChart').getContext('2d');
        new Chart(agentDonutCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($donutChartData)),
                datasets: [{
                    data: @json(array_values($donutChartData)),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
