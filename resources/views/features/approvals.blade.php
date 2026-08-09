@extends('layouts.app') 

@section('content')

@include('partials.sidebar')

<div class="bg-light min-vh-100 p-4">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body" style="background-color: #e8f5e9; border-left: 5px solid #2e4e1f;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold text-success mb-1">
                        <i class="fas fa-share-alt me-2"></i>Registration Form Link
                    </h5>
                    <p class="text-muted small mb-0">
                        Copy this link and send it to students, alumni, or tryout applicants.
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white" 
                               value="{{ route('alumni.register.show') }}" 
                               id="regLink" readonly>
                        <button class="btn btn-success" onclick="copyToClipboard()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <a href="{{ route('alumni.register.show') }}" target="_blank" class="btn btn-outline-success">
                            <i class="fas fa-external-link-alt"></i> Visit Link
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("regLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            navigator.clipboard.writeText(copyText.value);
            alert("Link copied! You can now paste it in Messenger or Email.");
        }
    </script>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h2 class="fw-bold text-success">
            <i class="fas fa-user-check me-2"></i> Pending Verifications
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        // Moved the queries ABOVE the buttons so we can count them for the notifications!

        // 1. Fetch Students (Everyone NOT Alumni and NOT Tryout)
        $studentPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->whereNotIn('classification', ['Alumni', 'Tryout'])
                            ->latest()->get();

        // 2. Fetch Alumni ONLY
        $alumniPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->where('classification', 'Alumni')
                            ->latest()->get();
        
        // 3. Fetch Tryouts ONLY
        $tryoutPendings = \App\Models\Athlete::where('approval_status', 'pending')
                            ->where('classification', 'Tryout')
                            ->latest()->get();
    @endphp

    <!-- THREE SEPARATE TABS WITH NOTIFICATION BADGES -->
    <div class="d-flex gap-3 mb-4">
        <button id="student-tab-btn" onclick="showSection('student')" class="btn btn-success fw-bold flex-fill">
            Student Requests
            @if($studentPendings->count() > 0)
                <span class="badge bg-danger ms-2 rounded-pill">{{ $studentPendings->count() }}</span>
            @endif
        </button>
        
        <button id="alumni-tab-btn" onclick="showSection('alumni')" class="btn btn-outline-secondary fw-bold flex-fill">
            Alumni Requests
            @if($alumniPendings->count() > 0)
                <span class="badge bg-danger ms-2 rounded-pill">{{ $alumniPendings->count() }}</span>
            @endif
        </button>
        
        <button id="tryout-tab-btn" onclick="showSection('tryout')" class="btn btn-outline-secondary fw-bold flex-fill">
            Tryout Applicants
            @if($tryoutPendings->count() > 0)
                <span class="badge bg-danger ms-2 rounded-pill">{{ $tryoutPendings->count() }}</span>
            @endif
        </button>
    </div>

    <!-- ============================================== -->
    <!-- 1. STUDENT SECTION -->
    <!-- ============================================== -->
    <div id="student-section">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($studentPendings->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">All caught up! No student requests pending.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Classification</th>
                                    <th>Sport Event</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentPendings as $p)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $p->student_id }}</td>
                                    <td><span class="fw-semibold">{{ $p->first_name }} {{ $p->last_name }}</span></td>
                                    <td><span class="text-muted small">{{ $p->email }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $p->classification }}</span></td>
                                    <td><span class="badge bg-info text-dark">{{ str_replace('_', ' ', $p->sport_event) }}</span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Approve {{ $p->first_name }}?')">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Reject this request?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. ALUMNI SECTION -->
    <!-- ============================================== -->
    <div id="alumni-section" style="display:none;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($alumniPendings->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">No alumni requests pending.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Student ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Classification</th>
                                    <th>Sport Event</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumniPendings as $p)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $p->student_id }}</td>
                                    <td><span class="fw-semibold">{{ $p->first_name }} {{ $p->last_name }}</span></td>
                                    <td><span class="text-muted small">{{ $p->email }}</span></td>
                                    <td><span class="badge bg-secondary">{{ $p->classification }}</span></td>
                                    <td><span class="badge bg-info text-dark">{{ str_replace('_', ' ', $p->sport_event) }}</span></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Approve {{ $p->first_name }} as Alumni?')">
                                                    <i class="fas fa-check me-1"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Reject this alumni request?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. TRYOUT SECTION -->
    <!-- ============================================== -->
    <div id="tryout-section" style="display:none;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                @if($tryoutPendings->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted fs-5">No tryout applicants yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Applicant Name</th>
                                    <th>Contact Info</th>
                                    <th>Sport Applying For</th>
                                    <th>Date Applied</th>
                                    <th class="text-center">Tryout Decision</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tryoutPendings as $p)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $p->first_name }} {{ $p->last_name }}</td>
                                    <td>
                                        <span class="text-dark small"><i class="fas fa-envelope me-1"></i> {{ $p->email }}</span><br>
                                        <span class="text-muted small"><i class="fas fa-phone me-1"></i> {{ $p->contact_number ?? 'N/A' }}</span>
                                    </td>
                                    <td><span class="badge bg-warning text-dark px-3 py-2">{{ str_replace('_', ' ', $p->sport_event) }}</span></td>
                                    <td class="text-secondary small">{{ $p->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm px-3" onclick="return confirm('Did {{ $p->first_name }} pass the tryouts? This will make them an Active athlete.')">
                                                    <i class="fas fa-trophy me-1"></i> Passed
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Did they fail/not show up? This will remove their record.')">
                                                    <i class="fas fa-times me-1"></i> Failed
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

<script>
    function showSection(section) {
        // Buttons
        const studentBtn = document.getElementById('student-tab-btn');
        const alumniBtn = document.getElementById('alumni-tab-btn');
        const tryoutBtn = document.getElementById('tryout-tab-btn');

        // Sections
        document.getElementById('student-section').style.display = (section === 'student') ? 'block' : 'none';
        document.getElementById('alumni-section').style.display = (section === 'alumni') ? 'block' : 'none';
        document.getElementById('tryout-section').style.display = (section === 'tryout') ? 'block' : 'none';

        // Toggle Button Styles
        studentBtn.classList.toggle('btn-success', section === 'student');
        studentBtn.classList.toggle('btn-outline-secondary', section !== 'student');
        
        alumniBtn.classList.toggle('btn-success', section === 'alumni');
        alumniBtn.classList.toggle('btn-outline-secondary', section !== 'alumni');

        tryoutBtn.classList.toggle('btn-success', section === 'tryout');
        tryoutBtn.classList.toggle('btn-outline-secondary', section !== 'tryout');

        // Save state so it doesn't reset when they click approve
        localStorage.setItem('activeApprovalTab', section);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const activeSection = localStorage.getItem('activeApprovalTab') || 'student';
        showSection(activeSection);
    });
</script>
    
</div>
        
@endsection