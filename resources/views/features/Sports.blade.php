@extends('layouts.app')

@section('title', 'Sports')

@section('content')
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
                <option value="Archery">Archery</option>
                <option value="Arnis">Arnis</option>
                <option value="Athletics">Athletics</option>
                <option value="Badminton">Badminton</option>
                <option value="Baseball">Baseball</option>
                <option value="Basketball_Men">Basketball Men</option>
                <option value="Basketball_Women">Basketball Women</option>
                <option value="Boxing">Boxing</option>
                <option value="Chess">Chess</option>
                <option value="Football">Football</option>
                <option value="Judo">Judo</option>
                <option value="Lawn Tennis">Lawn Tennis</option>
                <option value="Sepak Takraw">Sepak Takraw</option>
                <option value="Softball">Softball</option>
                <option value="Swimming">Swimming</option>
                <option value="Table Tennis">Table Tennis</option>
                <option value="Taekwondo">Taekwondo</option>
                <option value="Volleyball_Men">Volleyball Men</option>
                <option value="Volleyball_Women">Volleyball Women</option>
                <option value="Wrestling">Wushu Taolu</option>
                <option value="Wushu">Wushu Sanda</option>
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
                <!-- Added the missing ID right here! -->
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
        // Show a loading indicator while fetching data
        scheduleBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">Loading roster data...</td></tr>';

        fetch(`/sports/filter/${sport}`)
            .then(res => res.json())
            .then(coaches => {
                scheduleBody.innerHTML = ''; // Clear loading message

                if(coaches.length === 0) {
                    scheduleBody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-gray-500">No active athletes found for this selection.</td></tr>';
                    return;
                }

                // Build the table rows using the aggregated data from the controller
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

    // 🚀 BOOM: Automatically load 'All Sports' the second the page opens!
    loadSportsData('All');

    // Listen for dropdown changes to reload specific data
    sportSelect.addEventListener('change', function() {
        loadSportsData(this.value);
    });
});
</script>
@endsection