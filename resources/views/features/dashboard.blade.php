
@extends('layouts.app')

@section('title', 'Dasboard')

@section('content')
    <div class="flex bg-gray-100 min-h-screen">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Dashboard Content -->
        <main class="p-6 flex-1 overflow-y-auto">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Athletes</p>
                    <h2 class="text-3xl font-bold">1,245</h2>
                </div>
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Active Sessions</p>
                    <h2 class="text-3xl font-bold">856</h2>
                </div>
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Completed Workouts</p>
                    <h2 class="text-3xl font-bold">3,412</h2>
                </div>
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">New Signups</p>
                    <h2 class="text-3xl font-bold">78</h2>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Line Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold text-lg mb-4">Weekly Activity</h3>
                    <canvas id="lineChart"></canvas>
                </div>

                <!-- Pie Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold text-lg mb-4">Athletes by Category</h3>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-4">Recent Atttendance</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Athlete</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">John Doe</td>
                                <td class="px-6 py-4">Workout Session</td>
                                <td class="px-6 py-4">Nov 10, 2025</td>
                                <td class="px-6 py-4"><span class="text-green-600 font-semibold">Present</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">Jane Smith</td>
                                <td class="px-6 py-4">Yoga Class</td>
                                <td class="px-6 py-4">Nov 10, 2025</td>
                                <td class="px-6 py-4"><span class="text-green-600 font-semibold">Present</span></td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">Mark Lee</td>
                                <td class="px-6 py-4">Swimming</td>
                                <td class="px-6 py-4">Nov 9, 2025</td>
                                <td class="px-6 py-4"><span class="text-green-600 font-semibold">Present</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Sessions',
                data: [12,19,14,17,20,23,18],
                borderColor: 'rgba(34,197,94,1)',
                backgroundColor: 'rgba(34,197,94,0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true }
    });

    // Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Beginner','Intermediate','Advanced'],
            datasets: [{
                data: [45,35,20],
                backgroundColor: ['#22c55e','#16a34a','#4ade80']
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
