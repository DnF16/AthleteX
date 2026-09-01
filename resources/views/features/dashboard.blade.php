@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex bg-gray-100 h-full">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full">

        <!-- Dashboard Content -->
        <main class="p-6 flex-1 overflow-y-auto h-full">

            <!-- KPI Cards Grid (Balanced 4-column layout for rows 1 and 2) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <!-- 1. Total Active Athletes -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Active Athletes</p>
                    <h2 class="text-3xl font-bold text-green-600">
                        {{ $activeAthletesCount ?? 0 }}
                    </h2>
                </div>

                <!-- 2. Total Alumni -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Alumni</p>
                    <h2 class="text-3xl font-bold text-blue-600">
                        {{ $alumniCount ?? 0 }}
                    </h2>
                </div>

                {{-- ROLE-BASED UI: Only Admins can see the Coaches card! --}}
                @if(auth()->user()->role === 'admin')
                <!-- 3. Total Coaches -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Coaches</p>
                    <h2 class="text-3xl font-bold text-blue-600">
                        {{ $coachesCount ?? 0 }}
                    </h2>
                </div>
                @endif

                <!-- 4. Total Achievements (Clickable) -->
                <a href="{{ route('achievements.index') }}" class="block bg-white p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer no-underline group">
                    <p class="text-gray-500 group-hover:text-purple-600 transition">Achievements Recorded</p>
                    <h2 class="text-3xl font-bold text-purple-600">
                        {{ $totalAchievements ?? 0 }}
                    </h2>
                </a>

                <!-- ================= ROW 2 (Filled Out to Cure the Lonely Card!) ================= -->

                <!-- 5. Total Inactive -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total of Inactive Athletes</p>
                    <h2 class="text-3xl font-bold text-orange-600">
                        {{ $inactive ?? 0 }}
                    </h2>
                </div>

                <!-- 6. CLICKABLE Pending Approvals Card (Links directly to approvals) -->
                <a href="{{ route('admin.approvals') }}" class="block bg-white p-5 rounded-xl shadow hover:shadow-lg transition cursor-pointer no-underline group">
                    <p class="text-gray-500 group-hover:text-red-600 transition">Pending Approvals</p>
                    <h2 class="text-3xl font-bold text-red-600">
                        {{ $pendingApprovals ?? 0 }}
                    </h2>
                </a>

                <!-- 8. Active Sports Programs -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Active Sports</p>
                    <h2 class="text-3xl font-bold text-indigo-600">
                        {{ $activeSports ?? 12 }}
                    </h2>
                </div>

            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Monthly Achievements Chart (Restored your exact Chart.js setup) -->
                <div class="bg-white p-6 rounded-xl shadow h-96">
                    <h3 class="font-semibold text-lg mb-4 text-gray-700">Achievements Per Month</h3>
                    <div class="h-[85%] cursor-pointer" title="Click a bar to view achievements">
                        <canvas id="achievementChart" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>

{{-- FullCalendar --}}
<link href="{{ asset('css/fullcalendar/main.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/fullcalendar/main.min.js') }}"></script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    let rawAchievements = @json($achievementsMonthly ?? []);
    let monthlyAchievements = Array.from({ length: 12 }, (_, i) => rawAchievements[i + 1] ?? 0);

    const monthlyLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const ctx = document.getElementById('achievementChart');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Achievements',
                    data: monthlyAchievements,
                    backgroundColor: 'rgba(35, 233, 17, 0.6)',
                    borderColor: 'rgb(33, 177, 52)',
                    borderWidth: 2,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(35, 233, 17, 0.9)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let count = context.parsed.y;
                                return count === 1 
                                    ? count + ' Record (Click to view details)' 
                                    : count + ' Records (Click to view details)';
                            }
                        }
                    }
                },
                onHover: (event, chartElement) => {
                    event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const monthIndex = elements[0].index;
                        const monthNumber = monthIndex + 1;
                        window.location.href = `/achievements?month=${monthNumber}`;
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Months',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        title: {
                            display: true,
                            text: 'Number of Achievements',
                            font: { size: 14, weight: 'bold' }
                        }
                    }
                }
            }
        });
    }

});
</script>

@endsection