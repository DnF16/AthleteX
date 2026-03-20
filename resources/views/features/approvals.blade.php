@extends('layouts.app') 

@section('content')

@include('partials.sidebar')

<div class="bg-light min-vh-100 p-4">

    <div class="card shadow-sm border-0 mb-4" style="background-color: #f0fdf4; border-left: 5px solid #166534; border-radius: 8px;">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-share-nodes text-success fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-success mb-0">Registration Form Link</h6>
                    <p class="text-muted small mb-0">Copy this link and send it to students, alumni, or tryout applicants.</p>
                </div>
            </div>
            <div class="d-flex gap-2 align-items-center" style="width: 500px;">
                <input type="text" class="form-control form-control-sm bg-white border-light text-muted" 
                       value="{{ route('alumni.register.show') }}" id="regLink" readonly>
                
                <button class="btn btn-success btn-sm d-flex align-items-center px-3 fw-bold" onclick="copyToClipboard()">
                    <i class="fas fa-copy me-2"></i> Copy
                </button>
                
                <a href="{{ route('alumni.register.show') }}" target="_blank" class="btn btn-outline-success btn-sm px-3 fw-bold d-flex align-items-center">
                    Open <i class="fas fa-external-link-alt ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="mb-4 mt-2">
        <h5 class="fw-bold text-success d-flex align-items-center">
            <i class="fas fa-user-check me-2"></i> Pending Verifications
        </h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $regularPendings = \App\Models\Athlete::where('status', 'Pending')
                            ->whereIn('classification', ['Alumni'])
                            ->latest()->get();
        
        $tryoutPendings = \App\Models\Athlete::where('status', 'Pending')
                            ->where('classification', 'Tryout')
                            ->latest()->get();
    @endphp

    <ul class="nav custom-tabs mb-4" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active custom-tab-btn position-relative" data-bs-target="#regular" type="button">
                <i class="fas fa-users me-1"></i> Active & Alumni Requests
                @if($regularPendings->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="font-size: 0.65rem;">
                        {{ $regularPendings->count() }}
                    </span>
                @endif
            </button>
        </li>
        <li class="nav-item ms-3" role="presentation">
            <button class="nav-link custom-tab-btn position-relative" data-bs-target="#tryout" type="button">
                <i class="fas fa-running me-1"></i> Tryout Applicants
                @if($tryoutPendings->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm" style="font-size: 0.65rem;">
                        {{ $tryoutPendings->count() }}
                    </span>
                @endif
            </button>
        </li>
    </ul>

    <div class="tab-content" id="approvalTabsContent">

        <div class="tab-pane fade show active" id="regular">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    @if($regularPendings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-check text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted fs-5">All caught up! No regular requests pending.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 w-100">
                                <thead class="bg-light">
                                    <tr class="text-dark fw-bold small">
                                        <th class="ps-4 py-3">Student ID</th>
                                        <th>Full Name</th>
                                        <th>Type</th>
                                        <th>Sport Event</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regularPendings as $p)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $p->student_id }}</td>
                                        <td>
                                            <span class="fw-bold uppercase">{{ $p->last_name }}, {{ $p->first_name }}</span><br>
                                            <span class="text-muted small">{{ $p->email }}</span>
                                        </td>
                                        <td><span class="badge bg-secondary px-3 py-1 rounded-pill">{{ $p->classification }}</span></td>
                                        <td><span class="badge bg-warning text-dark px-3 py-1 rounded shadow-sm fw-bold">{{ str_replace('_', ' ', $p->sport_event) }}</span></td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST" class="ajax-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-trophy me-2"></i> Passed
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST" class="ajax-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-times me-2"></i> Failed
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

        <div class="tab-pane fade" id="tryout" style="display: none;">
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
                                <thead class="bg-light">
                                    <tr class="text-dark fw-bold small">
                                        <th class="ps-4 py-3">Applicant Name</th>
                                        <th>Contact Info</th>
                                        <th>Sport Applying For</th>
                                        <th>Date Applied</th>
                                        <th class="text-center">Tryout Decision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tryoutPendings as $p)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark uppercase">{{ $p->last_name }}, {{ $p->first_name }}</td>
                                        <td>
                                            <div class="small mb-1"><i class="fas fa-envelope text-muted me-2"></i>{{ $p->email }}</div>
                                            <div class="small text-muted"><i class="fas fa-phone me-2"></i>{{ $p->contact_number ?? 'N/A' }}</div>
                                        </td>
                                        <td><span class="badge bg-warning text-dark px-3 py-1 rounded shadow-sm fw-bold">{{ str_replace('_', ' ', $p->sport_event) }}</span></td>
                                        <td class="text-secondary small">{{ $p->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                
                                                <button type="button" class="btn btn-outline-secondary btn-sm px-3 shadow-sm d-flex align-items-center fw-bold" data-bs-toggle="modal" data-bs-target="#viewTryoutModal{{ $p->id }}">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </button>

                                                <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST" class="ajax-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
                                                        <i class="fas fa-trophy me-1"></i> Passed
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST" class="ajax-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3 shadow-sm d-flex align-items-center fw-bold">
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
                        
                        @foreach($tryoutPendings as $p)
                            <div class="modal fade" id="viewTryoutModal{{ $p->id }}" tabindex="-1" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.6);">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title fw-bold"><i class="fas fa-id-card me-2"></i> Tryout Application Details</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                                <div>
                                                    <h4 class="fw-bold text-dark uppercase mb-1">{{ $p->last_name }}, {{ $p->first_name }}</h4>
                                                    <p class="text-muted small mb-0"><i class="fas fa-graduation-cap me-1"></i> {{ $p->course ?? 'Course N/A' }} - Year {{ $p->year_level ?? 'N/A' }}</p>
                                                </div>
                                                <span class="badge bg-warning text-dark fs-6 px-4 py-2 shadow-sm rounded-pill">{{ str_replace('_', ' ', $p->sport_event) }}</span>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="text-muted small fw-bold uppercase">Specialization / Role</label>
                                                    <p class="fw-semibold text-dark fs-5 mb-0">{{ $p->specialization ?? 'None specified' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted small fw-bold uppercase">School Graduated From</label>
                                                    <p class="fw-semibold text-dark fs-5 mb-0">{{ $p->school_graduated ?? 'Not provided' }}</p>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="text-muted small fw-bold uppercase mb-2">Purpose in Joining</label>
                                                <div class="bg-light p-3 rounded border text-dark fst-italic">
                                                    "{{ $p->purpose ?? 'No purpose statement provided.' }}"
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="text-muted small fw-bold uppercase mb-2">Tournament Achievements</label>
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
                                                                $achievements = is_string($p->achievements) ? json_decode($p->achievements, true) : $p->achievements;
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
                </div>
            </div>
        </div>

    </div> 
</div> 

<style>
    .custom-tabs { border-bottom: 2px solid #198754; display: flex; }
    .custom-tab-btn { background-color: #ffffff; color: #6c757d; border: 1px solid #dee2e6; border-bottom: none; border-radius: 8px 8px 0 0; padding: 10px 24px; margin-bottom: -2px; font-weight: 600; transition: all 0.2s ease-in-out; }
    .custom-tab-btn:hover:not(.active) { background-color: #e9ecef; color: #198754; }
    .custom-tab-btn.active { background-color: #f8f9fa; color: #198754 !important; border: 2px solid #198754; border-bottom: 2px solid #f8f9fa; }
    .badge.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .btn-primary { background-color: #0d6efd !important; border: none; }
    .btn-outline-danger { color: #dc3545; border-color: #dc3545; }
    .btn-outline-danger:hover { background-color: #dc3545; color: white; }
    .uppercase { text-transform: uppercase; }
</style>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("regLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); 
        navigator.clipboard.writeText(copyText.value);
        alert("Link copied! You can now paste it in Messenger or Email.");
    }

    document.addEventListener('DOMContentLoaded', function () {
        
        // Cleaned up Javascript! (Removed the broken DOM modal hack)
        const tabButtons = document.querySelectorAll('.custom-tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        const activeTabId = localStorage.getItem('activeApprovalTab');
        if (activeTabId) {
            const btnToClick = document.querySelector(`[data-bs-target="${activeTabId}"]`);
            if(btnToClick) btnToClick.click();
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-bs-target');
                localStorage.setItem('activeApprovalTab', targetId);

                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                tabPanes.forEach(pane => {
                    pane.classList.remove('show', 'active');
                    pane.style.display = 'none'; 
                });
                
                const targetPane = document.querySelector(targetId);
                targetPane.classList.add('show', 'active');
                targetPane.style.display = 'block'; 
            });
        });

        const actionForms = document.querySelectorAll('.ajax-form');
        
        actionForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 
                
                const isApprove = this.action.includes('approve');
                const confirmMsg = isApprove ? "Are you sure you want to pass this applicant?" : "Are you sure you want to fail this applicant?";
                
                if (!confirm(confirmMsg)) return; 

                const url = this.getAttribute('action');
                const row = this.closest('tr'); 
                const token = this.querySelector('input[name="_token"]').value;
                const btn = this.querySelector('button');

                btn.disabled = true;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        row.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                        row.style.opacity = 0;
                        row.style.transform = "translateX(20px)";
                        
                        const activeModal = document.querySelector('.modal.show');
                        if(activeModal) {
                            const modalInstance = bootstrap.Modal.getInstance(activeModal);
                            if(modalInstance) modalInstance.hide();
                        }

                        setTimeout(() => row.remove(), 500); 
                    }
                })
                .catch(error => {
                    console.error("AJAX Error:", error);
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    alert("Something went wrong. Please try again.");
                });
            });
        });
    });
</script>
@endsection