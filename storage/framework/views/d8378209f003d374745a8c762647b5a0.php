<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex bg-gray-100 h-full">

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full">

        <!-- Dashboard Content -->
        <main class="p-6 flex-1 overflow-y-auto h-full">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                <!-- Total Athletes and Alumni -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Total Active Athletes -->
                    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                        <p class="text-gray-500">Total Active Athletes</p>
                        <h2 class="text-3xl font-bold text-green-600">
                            <?php echo e($activeAthletesCount ?? 0); ?>

                        </h2>
                    </div>

                    <!-- Total Alumni -->
                    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                        <p class="text-gray-500">Total Alumni</p>
                        <h2 class="text-3xl font-bold text-blue-600">
                            <?php echo e($alumniCount ?? 0); ?>

                        </h2>
                    </div>
                    
                </div>


                <!-- Total Coaches -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total Coaches</p>
                    <h2 class="text-3xl font-bold text-blue-600">
                        <?php echo e($coachesCount ?? 0); ?>

                    </h2>
                </div>

                <!-- Total Achievements -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Achievements Recorded</p>
                    <h2 class="text-3xl font-bold text-purple-600">
                        <?php echo e($totalAchievements ?? 0); ?>

                    </h2>
                </div>

                <!-- Top Sports Count -->
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                    <p class="text-gray-500">Total of Inactive Athletes and Coach's</p>
                    <h2 class="text-3xl font-bold text-orange-600">
                        <?php echo e($inactive ?? 0); ?>

                    </h2>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Monthly Achievements -->
                <div class="bg-white p-6 rounded-xl shadow h-96">
                    <h3 class="font-semibold text-lg mb-4">Achievements Per Month</h3>
                    <div class="h-[85%]">
                        <canvas id="achievementChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Schedule Calendar -->
                <div class="bg-white p-6 rounded-xl shadow h-96">
                    <h3 class="font-semibold text-lg mb-4">Schedule</h3>
                    <div id="scheduleCalendar" class="h-[85%]"></div>
                </div>

            </div>


        </main>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

<script>
    /* -------------------------------
       Convert PHP → JS safely
    --------------------------------*/

    // Achievements monthly (ensure 12 months)
    let rawAchievements = <?php echo json_encode($achievementsMonthly ?? [], 15, 512) ?>;

    // Build array of 12 months, fill missing with 0
    let monthlyAchievements = Array.from({ length: 12 }, (_, i) => rawAchievements[i + 1] ?? 0);

    // Expense data (renamed from athleteCategories)
    let expensesData = <?php echo json_encode(array_values($athleteCategories ?? []), 15, 512) ?>;
    let expensesLabels = <?php echo json_encode(array_keys($athleteCategories ?? []), 15, 512) ?>;

    // If empty, avoid chart errors
    if (expensesLabels.length === 0) {
        expensesLabels = ["No Data"];
        expensesData = [1];
    }

    const monthlyLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];


    /* -------------------------------
       BAR CHART – Monthly Achievements 
    --------------------------------*/
    new Chart(document.getElementById('achievementChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Achievements',
                data: monthlyAchievements,
                backgroundColor: 'rgba(99,102,241,0.6)',
                borderColor: 'rgba(99,102,241,1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });


    /* -------------------------------
       FullCalendar – Schedule
    --------------------------------*/
    let scheduleEvents = <?php echo json_encode($scheduleEvents ?? [], 15, 512) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('scheduleCalendar');

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
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AthleteX\resources\views/features/dashboard.blade.php ENDPATH**/ ?>