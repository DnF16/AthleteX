@extends('layouts.app') 

@section('content')

@include('partials.sidebar')

<div class="bg-light min-vh-100 p-4" style="margin-left: 256px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            <i class="fas fa-running me-2"></i> Tryouts Management
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <ul class="nav nav-tabs mb-4" id="tryoutTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-success border-bottom-0" id="schedules-tab" data-bs-toggle="tab" data-bs-target="#schedules" type="button" role="tab">
                <i class="fas fa-calendar-alt me-1"></i> Tryout Schedules
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary border-bottom-0 relative" id="recruits-tab" data-bs-toggle="tab" data-bs-target="#recruits" type="button" role="tab">
                <i class="fas fa-user-check me-1"></i> Passed Recruits
                @if(isset($recruits) && $recruits->count() > 0)
                    <span class="absolute top-0 right-0 -mt-1 -mr-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $recruits->count() }}</span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="tryoutTabsContent">

        <div class="tab-pane fade show active" id="schedules" role="tabpanel">
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
                                            <option value="Football">Football</option>
                                            <option value="Softball">Softball</option>
                                            <option value="Baseball">Baseball</option>
                                        </optgroup>
                                        <optgroup label="Racket Sports">
                                            <option value="Badminton_Men">Badminton (Men)</option>
                                            <option value="Badminton_Women">Badminton (Women)</option>
                                            <option value="Table_Tennis_Men">Table Tennis (Men)</option>
                                            <option value="Table_Tennis_Women">Table Tennis (Women)</option>
                                            <option value="Tennis_Men">Tennis (Men)</option>
                                            <option value="Tennis_Women">Tennis (Women)</option>
                                        </optgroup>
                                        <optgroup label="Combat Sports & Others">
                                            <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                            <option value="Taekwondo_Women">Taekwondo (Women)</option>
                                            <option value="Arnis_Men">Arnis (Men)</option>
                                            <option value="Arnis_Women">Arnis (Women)</option>
                                            <option value="Boxing">Boxing</option>
                                            <option value="Sepak_Takraw">Sepak Takraw</option>
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
                                    <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Bring own equipment or water"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2">
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
                                                <td class="ps-4 fw-bold text-success">
                                                    {{ str_replace('_', ' ', $schedule->sport_event) }}
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark">
                                                        {{ \Carbon\Carbon::parse($schedule->tryout_date)->format('M d, Y') }}
                                                    </span><br>
                                                    <small class="text-muted">
                                                        <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">{{ $schedule->venue }}</span><br>
                                                    @if($schedule->notes)
                                                        <small class="text-muted fst-italic">{{ $schedule->notes }}</small>
                                                    @else
                                                        <small class="text-muted">No notes</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('tryouts.destroy', $schedule->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Are you sure you want to remove this schedule?')">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                                                    <p class="text-muted fs-5 mb-0">No tryout schedules have been posted yet.</p>
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

        <div class="tab-pane fade" id="recruits" role="tabpanel">
            <div class="alert alert-info border-info mb-4 flex items-center">
                <i class="fas fa-info-circle me-3 fs-4 text-info"></i>
                <div>
                    <strong>Action Required:</strong> These students passed their tryouts but are still classified as "Recruits." 
                    Once they submit their paperwork, edit their profile and change their Classification to "Class A, B, or C" to move them to the Master Roster.
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
                                        <td class="px-4 py-3 border-r font-bold text-gray-900">{{ $recruit->last_name }}, {{ $recruit->first_name }}</td>
                                        <td class="px-4 py-3 border-r text-center"><span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-semibold">{{ str_replace('_', ' ', $recruit->sport_event) }}</span></td>
                                        <td class="px-4 py-3 border-r text-center">
                                            {{ $recruit->contact_number ?? 'No Phone' }} <br>
                                            <span class="text-xs text-gray-500">{{ $recruit->email }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-r text-center text-gray-500">{{ $recruit->updated_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('student.athlete', ['id' => $recruit->id]) }}" class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-2 rounded text-xs font-bold transition">
                                                Update to Official Athlete
                                            </a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', event => {
                tabs.forEach(t => { t.classList.remove('text-success'); t.classList.add('text-secondary'); });
                event.target.classList.remove('text-secondary');
                event.target.classList.add('text-success');
            });
        });
    });
</script>
@endsection