@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div id="tab-content" class="bg-[#c5e0b4] p-6 rounded w-full  min-h-screen">
    <div class="bg-white border-[12px] border-[#d1e9f0] p-1 shadow-sm">

        <!-- Page Header -->
        <div class="bg-[#5bc0de] p-3 flex items-center justify-between mb-6">
            <div class="flex-1 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-0">Attendance</h1>
                @if(isset($today))
                    <p class="text-sm text-gray-600">Today: {{ \Carbon\Carbon::parse($today)->format('l, F j, Y') }}</p>
                @endif
            </div>
            <div>
                <a href="{{ route('attendance.history') }}" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    📊 Attendance History
                </a>
            </div>
        </div>

        <!-- Admin Filter -->
        @if(auth()->user()->role === 'admin')
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <!-- Sport Filter -->
            <select name="sport" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All Sports</option>
                @foreach($sports as $sport)
                    <option value="{{ $sport->name }}" {{ request('sport') == $sport->name ? 'selected' : '' }}>
                        {{ $sport->name }}
                    </option>
                @endforeach
            </select>

            <!-- Month Filter -->
            <select name="month" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">All Months</option>
                @php
                    $months = [
                        '01' => 'January', '02' => 'February', '03' => 'March',
                        '04' => 'April', '05' => 'May', '06' => 'June',
                        '07' => 'July', '08' => 'August', '09' => 'September',
                        '10' => 'October', '11' => 'November', '12' => 'December'
                    ];
                @endphp
                @foreach($months as $num => $name)
                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>

            <!-- Date Filter -->
            <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                class="border rounded px-3 py-2" />
        </form>
        @endif

        <!-- Coach Attendance Checking -->
        @if(auth()->user()->role === 'coach')
        <div class="flex justify-start mt-4 mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                <i class="bi bi-clipboard-check me-1"></i>
                Check Attendance
            </button>
        </div>
        @endif

        <!-- Attendance Table -->
        <div class="bg-[#f8f9fa] rounded shadow p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#d1e9f0]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Athlete</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Remarks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(auth()->user()->role === 'coach' && isset($athletesWithStatus))
                        @forelse($athletesWithStatus as $index => $athlete)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $athlete['first_name'] }} {{ $athlete['last_name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $athlete['sport_event'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($athlete['status'] === 'present')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    @elseif($athlete['status'] === 'absent')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    @elseif($athlete['status'] === 'late')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    @elseif($athlete['status'] === 'excused')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Excused</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Not Marked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $athlete['remarks'] ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $athlete['attendance_date'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($athlete['isEditable'] && $athlete['attendance_date'] === $today)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">✏️ Today</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">📋 History</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No athletes assigned yet.</td>
                            </tr>
                        @endforelse
                    @else
                        @forelse($attendances as $index => $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->athlete->first_name }} {{ $attendance->athlete->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attendance->athlete->sport_event }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->status === 'present')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    @elseif($attendance->status === 'absent')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    @elseif($attendance->status === 'late')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                                    @elseif($attendance->status === 'excused')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Excused</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $attendance->remarks ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ is_string($attendance->date) ? \Carbon\Carbon::parse($attendance->date)->format('Y-m-d') : $attendance->date->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No attendance records found.</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        <!-- attendance modal -->
        <div class="modal fade" id="attendanceModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Mark Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form method="POST" action="{{ route('coach.attendance.store') }}">
                            @csrf

                    <!-- Date Picker -->
                    <div class="mb-3">
                        <label class="form-label font-bold">Date (Today Only)</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ isset($today) ? $today : now()->toDateString() }}" readonly>
                        <small class="text-muted">Attendance can only be recorded for today.</small>
                    </div>

                    <!-- Info Alert -->
                    <div class="alert alert-info mb-3 text-sm" role="alert">
                        <strong>📋 How it works:</strong> Mark attendance today using the status buttons below. Tomorrow, new attendance records for that date will automatically become available. Past records remain in the <strong>Attendance History</strong>.
                    </div>

                            <!-- Athlete Attendance Table -->
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Athlete</th>
                                            <th>Sports</th>
                                            <th>Status</th>
                                            <th>Remarks (Optional)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($athletes as $index => $athlete)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $athlete->first_name }} {{ $athlete->last_name }}</td>
                                            <td>{{ $athlete->sport_event }}</td>
                                            <td>
                                                <input type="hidden" name="attendance[{{ $athlete->id }}][status]" value="present" class="attendance-hidden">
                                                <button type="button" class="btn btn-sm btn-outline-success attendance-toggle" title="Click to cycle through statuses">
                                                    Present
                                                </button>
                                            </td>
                                            <td>
                                                <input type="text" name="attendance[{{ $athlete->id }}][remarks]" class="form-control form-control-sm" placeholder="e.g., Injured, Early dismissal">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statuses = ['present', 'absent', 'late', 'excused'];
    const statusLabels = {
        'present': 'Present',
        'absent': 'Absent',
        'late': 'Late',
        'excused': 'Excused'
    };
    const statusClasses = {
        'present': 'btn-outline-success',
        'absent': 'btn-outline-danger',
        'late': 'btn-outline-warning',
        'excused': 'btn-outline-info'
    };

    document.querySelectorAll('.attendance-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const hiddenInput = this.previousElementSibling; // hidden input
            let currentStatus = hiddenInput.value;
            let currentIndex = statuses.indexOf(currentStatus);
            let nextIndex = (currentIndex + 1) % statuses.length;
            let nextStatus = statuses[nextIndex];

            // Update hidden input
            hiddenInput.value = nextStatus;

            // Update button text
            this.textContent = statusLabels[nextStatus];

            // Update button color
            this.className = 'btn btn-sm ' + statusClasses[nextStatus] + ' attendance-toggle';
        });
    });
});
</script>
@endsection