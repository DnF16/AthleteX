<?php $__env->startSection('title', 'Sports'); ?>

<?php $__env->startSection('content'); ?>
<div id="tab-content" class="bg-white p-6 rounded w-full">
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Sports</h1>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-col w-64">
            <label class="text-gray-700 font-medium mb-1">Select Sport</label>
            <select id="sportFilter" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                <option value="All">All Sports</option>
                
                <!-- DYNAMICALLY LOADED FROM YOUR 'sports' DATABASE TABLE -->
                <?php $__currentLoopData = \App\Models\Sport::orderBy('name', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $sportValue = str_replace(' ', '_', $sport->name);
                    ?>
                    <option value="<?php echo e($sportValue); ?>"><?php echo e($sport->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Class A</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Class B</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Class C</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Remarks</th>
                    </tr>
                </thead>
                <tbody id="scheduleBody" class="divide-y divide-gray-200">
                    <!-- JavaScript will inject rows here -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sportSelect = document.getElementById('sportFilter');
    const scheduleBody = document.getElementById('scheduleBody');

    // Function to fetch and render the data
    function loadSportsData(sport) {
        scheduleBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">Loading roster data...</td></tr>';

        fetch(`/sports/filter/${sport}`)
            .then(res => res.json())
            .then(coaches => {
                scheduleBody.innerHTML = ''; 

                if(coaches.length === 0) {
                    scheduleBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">No active athletes found for this selection.</td></tr>';
                    return;
                }

                coaches.forEach(coach => {
                    scheduleBody.innerHTML += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800">${coach.name}</td>
                            <td class="px-4 py-3 text-gray-500">${coach.assistant_coach}</td>
                            <td class="px-4 py-3 text-center font-bold text-green-600">${coach.class_a}</td>
                            <td class="px-4 py-3 text-center font-bold text-blue-600">${coach.class_b}</td>
                            <td class="px-4 py-3 text-center font-bold text-purple-600">${coach.class_c}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${coach.remarks}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                scheduleBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-red-500">Failed to load data. Please refresh.</td></tr>';
            });
    }

    // Automatically load 'All Sports' on page open
    loadSportsData('All');

    // Listen for dropdown changes
    sportSelect.addEventListener('change', function() {
        loadSportsData(this.value);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/sports.blade.php ENDPATH**/ ?>