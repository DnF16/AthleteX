@extends('layouts.app') 

@section('content')

@include('partials.sidebar')

<div class="bg-light min-vh-100 p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            <i class="fas fa-running me-2"></i> Tryouts Management
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <ul class="nav custom-tabs mb-4" id="tryoutTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active custom-tab-btn" data-bs-target="#schedules" type="button">
                <i class="fas fa-calendar-alt me-1"></i> Tryout Schedules
            </button>
        </li>
        <li class="nav-item ms-2" role="presentation">
            <button class="nav-link custom-tab-btn relative" data-bs-target="#recruits" type="button">
                <i class="fas fa-user-check me-1"></i> Passed Recruits
                @if(isset($recruits) && $recruits->count() > 0)
                    <span class="absolute top-0 right-0 -mt-1 -mr-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $recruits->count() }}</span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="tryoutTabsContent">

        <div class="tab-pane fade show active" id="schedules">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 border-top border-success border-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold text-secondary">Add New Schedule</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tryouts.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Sport Event <span class="text-danger">*</span></label>
                                    <select name="sport_event" class="form-select" required>
                                        <option value="">Select Sport...</option>
                                        <optgroup label="Ball Games">
                                            <option value="Basketball_Men">Basketball (Men)</option>
                                            <option value="Basketball_Women">Basketball (Women)</option>
                                            <option value="Volleyball_Men">Volleyball (Men)</option>
                                            <option value="Volleyball_Women">Volleyball (Women)</option>
                                        </optgroup>
                                        <optgroup label="Racket Sports">
                                            <option value="Badminton_Men">Badminton (Men)</option>
                                            <option value="Badminton_Women">Badminton (Women)</option>
                                        </optgroup>
                                        <optgroup label="Combat Sports & Others">
                                            <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                            <option value="Chess">Chess</option>
                                            <option value="Swimming">Swimming</option>
                                            <option value="Athletics">Athletics</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="tryout_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="tryout_time" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Venue <span class="text-danger">*</span></label>
                                    <input type="text" name="venue" class="form-control" placeholder="e.g. Main Court, Gym" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary">Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Bring own equipment"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Save Schedule
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold text-secondary">Active Tryout Schedules</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 w-100">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="ps-4">Sport Event</th>
                                            <th>Date & Time</th>
                                            <th>Venue & Notes</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($schedules as $schedule)
                                            <tr>
                                                <td class="ps-4 fw-bold text-success">{{ str_replace('_', ' ', $schedule->sport_event) }}</td>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($schedule->tryout_date)->format('M d, Y') }}</span><br>
                                                    <small class="text-muted"><i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A') }}</small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ $schedule->venue }}</span><br>
                                                    <small class="text-muted fst-italic">{{ $schedule->notes ?? 'No notes' }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('tryouts.destroy', $schedule->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Remove schedule?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <p class="text-muted mb-0">No tryout schedules have been posted yet.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 

        <div class="tab-pane fade" id="recruits" style="display: none;">
            <div class="alert alert-info border-info mb-4 flex items-center shadow-sm">
                <i class="fas fa-info-circle me-3 fs-4 text-info"></i>
                <div>
                    <strong>Action Required:</strong> These students passed their tryouts but are still classified as "Recruits." 
                    Update their profile to move them to the Master Roster.
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden border border-yellow-300">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-sm whitespace-nowrap">
                        <thead class="bg-yellow-500 text-gray-900 text-center">
                            <tr>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Applicant Name</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Sport Tryout</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Contact Details</th>
                                <th class="px-4 py-3 font-bold border-r border-yellow-600">Date Passed</th>
                                <th class="px-4 py-3 font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @if(isset($recruits) && $recruits->count() > 0)
                                @foreach ($recruits as $recruit)
                                    <tr class="hover:bg-yellow-50 border-b">
                                        <td class="px-4 py-3 border-r font-bold text-gray-900 uppercase">{{ $recruit->last_name }}, {{ $recruit->first_name }}</td>
                                        <td class="px-4 py-3 border-r text-center"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-semibold">{{ str_replace('_', ' ', $recruit->sport_event) }}</span></td>
                                        <td class="px-4 py-3 border-r text-center">{{ $recruit->contact_number ?? 'No Phone' }} <br><span class="text-xs text-gray-500">{{ $recruit->email }}</span></td>
                                        <td class="px-4 py-3 border-r text-center text-gray-500">{{ $recruit->updated_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-center">
                                            
                                            <div class="flex justify-center gap-2">
                                                <button type="button" class="bg-gray-500 text-white hover:bg-gray-600 px-3 py-2 rounded text-xs font-bold transition flex items-center shadow-sm" data-bs-toggle="modal" data-bs-target="#viewTryoutModal{{ $recruit->id }}">
                                                    <i class="fas fa-eye mr-1"></i> View
                                                </button>
                                                
                                                <a href="{{ route('student.athlete', ['id' => $recruit->id]) }}" class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded text-xs font-bold transition flex items-center shadow-sm">
                                                    Update to Official Athlete
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="text-center py-8 text-gray-500 italic">No recruits waiting for paperwork.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 

    </div> 
</div> 


@if(isset($recruits) && $recruits->count() > 0)
    @foreach($recruits as $recruit)
        <div class="modal fade" id="viewTryoutModal{{ $recruit->id }}" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-yellow-500 text-gray-900 border-0">
                        <h5 class="modal-title font-bold"><i class="fas fa-id-card me-2"></i> Recruit Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div>
                                <h4 class="fw-bold text-dark uppercase mb-1">{{ $recruit->last_name }}, {{ $recruit->first_name }}</h4>
                                <p class="text-muted small mb-0"><i class="fas fa-graduation-cap me-1"></i> {{ $recruit->course ?? 'Course N/A' }} - Year {{ $recruit->year_level ?? 'N/A' }}</p>
                            </div>
                            <span class="badge bg-warning text-dark fs-6 px-4 py-2 shadow-sm rounded-pill">{{ str_replace('_', ' ', $recruit->sport_event) }}</span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="text-muted small fw-bold text-uppercase">Specialization / Role</label>
                                <p class="fw-semibold text-dark fs-5 mb-0">{{ $recruit->specialization ?? 'None specified' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold text-uppercase">School Graduated From</label>
                                <p class="fw-semibold text-dark fs-5 mb-0">{{ $recruit->school_graduated ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-2">Purpose in Joining</label>
                            <div class="bg-light p-3 rounded border text-dark fst-italic">
                                "{{ $recruit->purpose ?? 'No purpose statement provided.' }}"
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="text-muted small fw-bold text-uppercase mb-2">Tournament Achievements</label>
                            <div class="table-responsive border rounded">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="bg-light text-secondary">
                                        <tr>
                                            <th class="ps-3 py-2">Level</th>
                                            <th class="py-2">Event</th>
                                            <th class="py-2">Year</th>
                                            <th class="py-2">Rank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $achievements = is_string($recruit->achievements) ? json_decode($recruit->achievements, true) : $recruit->achievements;
                                            $levels = ['international', 'national', 'regional', 'local'];
                                            $hasAchievements = false;
                                        @endphp

                                        @if($achievements)
                                            @foreach($levels as $level)
                                                @if(!empty($achievements[$level]['event']) || !empty($achievements[$level]['year']) || !empty($achievements[$level]['rank']))
                                                    @php $hasAchievements = true; @endphp
                                                    <tr class="border-bottom">
                                                        <td class="fw-bold text-secondary text-capitalize ps-3">{{ $level }}</td>
                                                        <td class="text-dark">{{ $achievements[$level]['event'] ?? '-' }}</td>
                                                        <td class="text-dark">{{ $achievements[$level]['year'] ?? '-' }}</td>
                                                        <td class="text-dark fw-bold">{{ $achievements[$level]['rank'] ?? '-' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if(!$hasAchievements)
                                            <tr>
                                                <td colspan="4" class="text-center text-muted fst-italic py-4">
                                                    <i class="fas fa-medal text-light fs-3 d-block mb-2"></i>
                                                    No achievements listed.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light border-top-0">
                        <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


<style>
    /* The main bottom border for the entire tab list */
    .custom-tabs {
        border-bottom: 2px solid #198754; /* Bootstrap success green */
        display: flex;
    }

    /* Unclicked Tab State */
    .custom-tab-btn {
        background-color: #ffffff;
        color: #6c757d;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        padding: 10px 24px;
        margin-bottom: -2px; /* Pulls the tab down to overlap the bottom line */
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }

    /* Hover effect for unclicked tabs */
    .custom-tab-btn:hover:not(.active) {
        background-color: #e9ecef;
        color: #198754;
    }

    /* Clicked (Active) Tab State */
    .custom-tab-btn.active {
        background-color: #f8f9fa; /* Matches the bg-light of your main container */
        color: #198754 !important;
        border: 2px solid #198754;
        border-bottom: 2px solid #f8f9fa; /* Erases the bottom line inside the tab */
    }
    
    .uppercase { text-transform: uppercase; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.custom-tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Remove active class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Hide all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.remove('show', 'active');
                    pane.style.display = 'none'; 
                });

                // Show the targeted tab pane
                const targetId = this.getAttribute('data-bs-target');
                const targetPane = document.querySelector(targetId);
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block'; 
            });
        });
    });
</script>
@endsection