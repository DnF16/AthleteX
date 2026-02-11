@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2 p-0">
        @include('partials.sidebar')
        </div>

        <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #e8f5e9; border-left: 5px solid #2e4e1f;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-success mb-1">
                                <i class="fas fa-share-alt me-2"></i>Registration Form Link
                            </h5>
                            <p class="text-muted small mb-0">
                                Copy this link and send it to students or alumni. They can access the form without logging in.
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
                    // Get the text field
                    var copyText = document.getElementById("regLink");

                    // Select the text field
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); // For mobile devices

                    // Copy the text inside the text field
                    navigator.clipboard.writeText(copyText.value);

                    // Alert the user
                    alert("Link copied! You can now paste it in Messenger or Email.");
                }
            </script>

        <div class="col-md-10 p-4 bg-light">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
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

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">Alumni Registration Requests</h5>
                </div>
                <div class="card-body p-0">
                    
                    @php
                        // Fetch only the 'pending' athletes
                        $pendings = \App\Models\Athlete::where('approval_status', 'pending')->latest()->get();
                    @endphp

                    @if($pendings->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-check text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted fs-5">All caught up! No pending requests.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="ps-4">Student ID</th>
                                        <th>Full Name</th>
                                        <th>Sport Event</th>
                                        <th>Date Submitted</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendings as $p)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $p->student_id }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $p->first_name }} {{ $p->last_name }}</span>
                                                <span class="text-muted small">{{ $p->email }}</span>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-info text-dark">{{ $p->sport_event }}</span></td>
                                        <td class="text-secondary small">
                                            {{ $p->created_at->format('M d, Y') }} <br>
                                            {{ $p->created_at->format('h:i A') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                
                                                <form action="{{ route('admin.approve.athlete', $p->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm px-3" 
                                                            onclick="return confirm('Are you sure you want to verify and approve {{ $p->first_name }}?')">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.reject.athlete', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    {{-- REMOVED @method('DELETE') HERE --}}
                                                    
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3"
                                                            onclick="return confirm('Are you sure you want to reject this request?')">
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
    </div>
</div>
@endsection