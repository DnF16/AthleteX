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
                            <i class="fas fa-external-link-alt"></i>
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

    <ul class="nav nav-tabs mb-4" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-success border-bottom-0" id="regular-tab" data-bs-toggle="tab" data-bs-target="#regular" type="button" role="tab">
                <i class="fas fa-file-signature me-1"></i> Alumni Requests
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary border-bottom-0" id="tryout-tab" data-bs-toggle="tab" data-bs-target="#tryout" type="button" role="tab">
                <i class="fas fa-running me-1"></i> Tryout Applicants
            </button>
        </li>
    </ul>

    <div class="tab-content" id="approvalTabsContent">
        
        @php
            // Fetch Active & Alumni
            $regularPendings = \App\Models\Athlete::where('approval_status', 'pending')
                                ->whereIn('classification', ['Active', 'Alumni'])
                                ->latest()->get();
            
            // Fetch Tryouts ONLY
            $tryoutPendings = \App\Models\Athlete::where('approval_status', 'pending')
                                ->where('classification', 'Tryout')
                                ->latest()->get();
        @endphp

        <div class="tab-pane fade show active" id="regular" role="tabpanel">
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
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="ps-4">Student ID</th>
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
                                            <span class="fw-semibold">{{ $p->first_name }} {{ $p->last_name }}</span><br>
                                            <span class="text-muted small">{{ $p->email }}</span>
                                        </td>
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

        <div class="tab-pane fade" id="tryout" role="tabpanel">
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

    </div> 
</div> 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Tab memory (so if you DO refresh manually, it remembers your tab)
        const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        const activeTabId = localStorage.getItem('activeApprovalTab');
        if (activeTabId) {
            const activeTab = document.getElementById(activeTabId);
            if (activeTab) activeTab.click(); 
        }
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', event => {
                localStorage.setItem('activeApprovalTab', event.target.id);
                tabs.forEach(t => { t.classList.remove('text-success'); t.classList.add('text-secondary'); });
                event.target.classList.remove('text-secondary');
                event.target.classList.add('text-success');
            });
        });

        // The Magic No-Refresh Buttons!
        const actionForms = document.querySelectorAll('form[action*="approve"], form[action*="reject"]');
        
        actionForms.forEach(form => {
            // Remove the default confirm popup from the button
            const btn = form.querySelector('button');
            const confirmMessage = btn.getAttribute('onclick') ? btn.getAttribute('onclick').replace("return confirm('", "").replace("')", "") : "Are you sure?";
            btn.removeAttribute('onclick'); 

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // STOP THE PAGE FROM RELOADING!
                
                if (!confirm(confirmMessage)) return; // Ask for confirmation manually

                const url = form.getAttribute('action');
                const row = form.closest('tr'); // Find the row the button is inside
                const token = form.querySelector('input[name="_token"]').value;

                // Make the button look like it's loading
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>...';
                btn.disabled = true;

                // Send the background request
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Make the row magically fade out!
                        row.style.transition = "opacity 0.5s ease";
                        row.style.opacity = 0;
                        setTimeout(() => row.remove(), 500); 
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.innerHTML = originalText; // Revert button if error
                    btn.disabled = false;
                    alert("Something went wrong.");
                });
            });
        });
    });
</script>
@endsection