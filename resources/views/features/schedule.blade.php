@extends('layouts.app')

@section('title', 'Schedule')

@section('content')
    <div class="space-y-6 w-full">

    <!-- Page Header -->
    <div class="bg-white p-6 flex items-center justify-between shadow rounded">
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Schedule</h1>
        </div>
        <div>
            <button id="addScheduleBtn"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Add New Schedule
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white p-6 rounded shadow flex flex-wrap gap-4">
        <form id="filterForm" class="flex flex-wrap gap-4 w-full">
            <div class="flex flex-col">
                <label class="text-gray-700 font-medium mb-1">Month</label>
                <input type="month" name="month" id="monthFilter" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                    value="{{ request('month', date('Y-m')) }}">
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

        @php
    // Get the current month and year, you can replace these with request values
    $month = request('month') ? date('m', strtotime(request('month'))) : date('m');
    $year = request('month') ? date('Y', strtotime(request('month'))) : date('Y');

    $firstDayOfMonth = strtotime("$year-$month-01");
    $daysInMonth = date('t', $firstDayOfMonth);
    $startDayOfWeek = date('w', $firstDayOfMonth); // 0=Sunday, 6=Saturday

    // Array of weekdays
    $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    // Group schedules by date
    $eventsByDate = [];
    foreach($schedules as $schedule) {
        $dateKey = $schedule->event_date->format('Y-m-d');
        if (!isset($eventsByDate[$dateKey])) {
            $eventsByDate[$dateKey] = [];
        }
        $eventsByDate[$dateKey][] = $schedule;
    }
@endphp

<div class="space-y-6 w-full">
    <!-- Calendar Grid -->
    <div class="bg-white rounded shadow p-6 overflow-x-auto">
        <!-- Weekday Headers -->
        <div class="grid grid-cols-7 gap-2 text-center font-medium text-gray-700 mb-2">
            @foreach($weekDays as $day)
                <div>{{ $day }}</div>
            @endforeach
        </div>

        <!-- Calendar Days -->
        <div class="grid grid-cols-7 gap-2">
            {{-- Empty slots before the first day of the month --}}
            @for($i = 0; $i < $startDayOfWeek; $i++)
                <div class="border border-gray-200 rounded p-2 h-32 bg-gray-50"></div>
            @endfor

            {{-- Actual days --}}
            @for($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDate = date('Y-m-d', strtotime("$year-$month-$day"));
                    $dayEvents = $eventsByDate[$currentDate] ?? [];
                @endphp
                <div class="border border-gray-200 rounded p-2 h-32 flex flex-col justify-start">
                    <span class="text-xs font-medium text-gray-500">{{ $day }}</span>

                    @if(count($dayEvents) > 0)
                        @foreach(array_slice($dayEvents, 0, 3) as $event)
                            <div class="mt-1 bg-blue-100 text-blue-800 text-xs rounded px-1 py-0.5 truncate">
                                {{ $event->event_name }}
                            </div>
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Detailed Schedule Table -->
    <div class="bg-white rounded shadow p-6 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Detailed Schedule</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Time</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Event Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Activity</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sport</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Coach</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="scheduleTableBody">
                @forelse($schedules as $schedule)
                <tr data-id="{{ $schedule->id }}">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->event_date->format('M d, Y') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->event_time->format('H:i') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->event_name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->activity }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->sport ?: '-' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $schedule->coach ?: '-' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        <button class="edit-schedule-btn text-blue-600 hover:text-blue-800 mr-2" data-id="{{ $schedule->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-schedule-btn text-red-600 hover:text-red-800" data-id="{{ $schedule->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        No schedules found for this month.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Add/Edit Schedule Modal -->
<div id="scheduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Add New Schedule</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="scheduleForm">
                @csrf
                <input type="hidden" id="scheduleId" name="schedule_id">

                <div class="mb-4">
                    <label for="event_name" class="block text-sm font-medium text-gray-700 mb-1">Event Name *</label>
                    <input type="text" id="event_name" name="event_name" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <div class="mb-4">
                    <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                    <input type="date" id="event_date" name="event_date" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <div class="mb-4">
                    <label for="event_time" class="block text-sm font-medium text-gray-700 mb-1">Time *</label>
                    <input type="time" id="event_time" name="event_time" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <div class="mb-4">
                    <label for="activity" class="block text-sm font-medium text-gray-700 mb-1">Activity *</label>
                    <input type="text" id="activity" name="activity" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600" required>
                </div>

                <div class="mb-4">
                    <label for="sport" class="block text-sm font-medium text-gray-700 mb-1">Sport</label>
                    <select id="sport" name="sport" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="">Select Sport</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Athletics">Athletics</option>
                        <option value="Swimming">Swimming</option>
                        <option value="Taekwondo">Taekwondo</option>
                        <option value="Chess">Chess</option>
                        <option value="Football">Football</option>
                        <option value="Boxing">Boxing</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="coach" class="block text-sm font-medium text-gray-700 mb-1">Coach</label>
                    <input type="text" id="coach" name="coach" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" id="saveBtn" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('scheduleModal');
    const form = document.getElementById('scheduleForm');
    const addBtn = document.getElementById('addScheduleBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const filterForm = document.getElementById('filterForm');

    // Modal controls
    addBtn.addEventListener('click', () => openModal());
    closeBtn.addEventListener('click', () => closeModal());
    cancelBtn.addEventListener('click', () => closeModal());

    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Filter form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams(formData);
        window.location.href = '{{ route("schedule") }}?' + params.toString();
    });

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const scheduleId = formData.get('schedule_id');
        const isEdit = scheduleId && scheduleId !== '';

        const url = isEdit
            ? `{{ url('/schedules') }}/${scheduleId}`
            : '{{ route("schedules.store") }}';

        const method = isEdit ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                closeModal();
                location.reload(); // Refresh to show updated data
            } else {
                alert('Error: ' + JSON.stringify(result.errors));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the schedule.');
        }
    });

    // Edit buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-schedule-btn') || e.target.closest('.edit-schedule-btn')) {
            const btn = e.target.classList.contains('edit-schedule-btn') ? e.target : e.target.closest('.edit-schedule-btn');
            const scheduleId = btn.getAttribute('data-id');
            editSchedule(scheduleId);
        }

        if (e.target.classList.contains('delete-schedule-btn') || e.target.closest('.delete-schedule-btn')) {
            const btn = e.target.classList.contains('delete-schedule-btn') ? e.target : e.target.closest('.delete-schedule-btn');
            const scheduleId = btn.getAttribute('data-id');
            deleteSchedule(scheduleId);
        }
    });

    function openModal(schedule = null) {
        document.getElementById('modalTitle').textContent = schedule ? 'Edit Schedule' : 'Add New Schedule';
        document.getElementById('scheduleId').value = schedule ? schedule.id : '';
        document.getElementById('event_name').value = schedule ? schedule.event_name : '';
        document.getElementById('event_date').value = schedule ? schedule.event_date : '';
        document.getElementById('event_time').value = schedule ? schedule.event_time : '';
        document.getElementById('activity').value = schedule ? schedule.activity : '';
        document.getElementById('sport').value = schedule ? schedule.sport : '';
        document.getElementById('coach').value = schedule ? schedule.coach : '';
        document.getElementById('description').value = schedule ? schedule.description : '';

        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        form.reset();
    }

    async function editSchedule(id) {
        try {
            const response = await fetch(`{{ url('/schedules') }}/${id}`);
            const schedule = await response.json();
            openModal(schedule);
        } catch (error) {
            console.error('Error loading schedule:', error);
            alert('Error loading schedule data.');
        }
    }

    async function deleteSchedule(id) {
        if (!confirm('Are you sure you want to delete this schedule?')) return;

        try {
            const response = await fetch(`{{ url('/schedules') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                location.reload(); // Refresh to show updated data
            } else {
                alert('Error deleting schedule.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the schedule.');
        }
    }
});
</script>

@endsection