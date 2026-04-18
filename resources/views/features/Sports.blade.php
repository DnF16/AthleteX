@extends('layouts.app')

@section('title', 'Sports')

@section('content')
<div id="tab-content" class="bg-[#c5e0b4] p-6 rounded  w-full">
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Sports</h1>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-col w-64">
            <label for="sportFilter" class="text-sm font-semibold text-gray-700 mb-2">Filter by Category</label>
            <select id="sportFilter" name="sport_id" class="border border-gray-300 rounded-lg px-4 py-2 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition duration-200 shadow-sm cursor-pointer">
                <option value="">All Sports</option>
                @foreach($sports as $sport)
                    <option value="{{ $sport->name }}" {{ ($sportId ?? '') == $sport->name ? 'selected' : '' }}>
                        {{ $sport->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sports Table -->
        <div class="bg-white rounded shadow p-6 overflow-x-auto">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Sports Table</h2>
            <table class="min-w-full divide-y divide-gray-200" id="scheduleTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sport</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Coach</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Assistant Coach</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class A</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class B</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Class C</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>

                    </tr>
                </thead>
                <tbody id="scheduleBody" class="divide-y divide-gray-200">
                    @foreach($sports as $sport)
                        @php
                            $sportCoaches = $coaches->get($sport->name, collect());
                        @endphp

                        @if($sportCoaches->isEmpty())
                            <tr data-sport="{{ $sport->name }}">
                                <td class="px-4 py-3">{{ $sport->name }}</td>
                                <td class="px-4 py-3"></td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">-</td>

                            </tr>
                        @else
                            @foreach($sportCoaches as $coach)
                                <tr data-sport="{{ $sport->name }}">
                                    <td class="px-4 py-3">{{ $sport->name }}</td>
                                    <td class="px-4 py-3">{{ trim($coach->coach_first_name . ' ' . $coach->coach_last_name) }}</td>
                                    <td class="px-4 py-3">{{ $coach->position ?? '-' }}</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">-</td>

                                </tr>
                            @endforeach
                        @endif
                    @endforeach
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
        const rows = scheduleBody.querySelectorAll('tr');

        rows.forEach(row => {
            if (!sport || row.dataset.sport === sport) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
