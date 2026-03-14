

<?php $__env->startSection('title', 'Sports'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-white p-6 rounded  w-full">
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Sports</h1>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-col w-48">
            <label class="text-gray-700 font-medium mb-1">Select Sport</label>
            <select id="sportFilter" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option value="">All Sports</option>
                <option value="Basketball">Basketball</option>
                <option value="Volleyball">Volleyball</option>
                <option value="Swimming">Swimming</option>
            </select>
        </div>

        <!-- Detailed Schedule Table -->
        <div class="bg-white rounded shadow p-6 overflow-x-auto">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Detailed Schedule</h2>
            <table class="min-w-full divide-y divide-gray-200" id="scheduleTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Coach</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Assistant Coach</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class A</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class B</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class C</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr data-sport="Basketball">
                        
                    </tr>
                    <!-- Add more rows here, each with a data-sport attribute -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    // Live filter for sports
    const sportSelect = document.getElementById('sportFilter');
const scheduleBody = document.getElementById('scheduleBody');

sportSelect.addEventListener('change', function() {
    const sport = this.value;

    fetch(`/sports/filter/${sport}`)
        .then(res => res.json())
        .then(coaches => {
            scheduleBody.innerHTML = '';

            coaches.forEach(coach => {
                coach.athletes.forEach(athlete => {
                    scheduleBody.innerHTML += `
                        <tr>
                            <td>${coach.name}</td>
                            <td>${coach.assistant_coach || ''}</td>
                            <td>${athlete.class_a || ''}</td>
                            <td>${athlete.class_b || ''}</td>
                            <td>${athlete.class_c || ''}</td>
                            <td>${athlete.remarks || ''}</td>
                        </tr>
                    `;
                });
            });
        });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AthleteX\resources\views/features/sports.blade.php ENDPATH**/ ?>