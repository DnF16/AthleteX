@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex bg-gray-100 h-full">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full">

        <!-- Dashboard Content -->
        <main class="p-6 flex-1 overflow-y-auto h-full">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <!-- Total Active Athletes -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Active Athletes</p>
                    <h2 class="text-3xl font-bold text-green-600">
                        {{ $activeAthletesCount ?? 0 }}
                    </h2>
                </div>

                <!-- Total Alumni -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Alumni</p>
                    <h2 class="text-3xl font-bold text-blue-600">
                        {{ $alumniCount ?? 0 }}
                    </h2>
                </div>

                {{-- 🚀 ROLE-BASED UI: Only Admins can see the Coaches card! --}}
                @if(auth()->user()->role === 'admin')
                <!-- Total Coaches -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Coaches</p>
                    <h2 class="text-3xl font-bold text-blue-600">
                        {{ $coachesCount ?? 0 }}
                    </h2>
                </div>
                @endif

                <!-- Total Achievements -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Achievements Recorded</p>
                    <h2 class="text-3xl font-bold text-purple-600">
                        {{ $totalAchievements ?? 0 }}
                    </h2>
                </div>

                <!-- Total Inactive -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total of Inactive Athletes</p>
                    <h2 class="text-3xl font-bold text-orange-600">
                        {{ $inactive ?? 0 }}
                    </h2>
                </div>

            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Monthly Achievements -->
                <div class="bg-gray-100 p-6 rounded-xl shadow h-96">
                    <h3 class="font-semibold text-lg mb-4">Achievements Per Month</h3>
                    <div class="h-[85%]">
                        <canvas id="achievementChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Schedule Calendar (Currently commented out) -->
                <!-- <div class="bg-white p-6 rounded-xl shadow h-96">
                    <h3 class="font-semibold text-lg mb-4">Schedule</h3>
                    <div id="scheduleCalendar" class="h-[85%]"></div>
                </div> -->

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

    /* -------------------------------
       Convert PHP → JS safely
    --------------------------------*/

    let rawAchievements = @json($achievementsMonthly ?? []);
    let monthlyAchievements = Array.from({ length: 12 }, (_, i) => rawAchievements[i + 1] ?? 0);

    const monthlyLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    /* -------------------------------
       BAR CHART
    --------------------------------*/
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
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // ✅ IMPORTANT
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    /* -------------------------------
       FullCalendar
    --------------------------------*/
    let scheduleEvents = @json($scheduleEvents ?? []);
    if (scheduleEvents.length === 0) {
        scheduleEvents = [
            { title: 'No Events', start: new Date().toISOString().split('T')[0] }
        ];
    }

    let calendarEl = document.getElementById('scheduleCalendar');
    if (calendarEl && typeof FullCalendar !== 'undefined') {
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: '100%',
            events: scheduleEvents,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventColor: '#6366f1',
            eventTextColor: '#fff'
        });
        calendar.render();
    } else {
        console.error('FullCalendar is not loaded!');
    }

});
</script>

@endsection