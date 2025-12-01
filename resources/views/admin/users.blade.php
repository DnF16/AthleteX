@extends('layouts.app') 

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > USERS & SECURITY
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Create New Coach User Section -->
            <div class="card shadow-sm border border-secondary rounded-0 mb-4">
                <div class="card-header bg-info text-white fw-bold p-3">
                    <i class="fas fa-user-plus"></i> Create New Coach User Account
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.createCoachUser') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Coach Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="e.g., John Doe" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="coach@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Min. 8 characters" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" 
                                    placeholder="Confirm password" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="coach_sport" class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                                <select id="coach_sport" name="coach_sport" class="form-select @error('coach_sport') is-invalid @enderror" required>
                                    <option value="">-- Select a Sport --</option>
                                    <option value="Basketball" {{ old('coach_sport') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                                    <option value="Volleyball" {{ old('coach_sport') == 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                                    <option value="Athletics" {{ old('coach_sport') == 'Athletics' ? 'selected' : '' }}>Athletics</option>
                                    <option value="Swimming" {{ old('coach_sport') == 'Swimming' ? 'selected' : '' }}>Swimming</option>
                                    <option value="Taekwondo" {{ old('coach_sport') == 'Taekwondo' ? 'selected' : '' }}>Taekwondo</option>
                                    <option value="Chess" {{ old('coach_sport') == 'Chess' ? 'selected' : '' }}>Chess</option>
                                    <option value="Football" {{ old('coach_sport') == 'Football' ? 'selected' : '' }}>Football</option>
                                    <option value="Boxing" {{ old('coach_sport') == 'Boxing' ? 'selected' : '' }}>Boxing</option>
                                </select>
                                @error('coach_sport')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success fw-bold">
                                <i class="fas fa-plus"></i> Create Coach User Account
                            </button>
                        </div>
                    </form>

                    @if($errors->any())
                        <div class="alert alert-danger mt-3" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <strong>Error creating user:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Existing Users Table -->
            <div class="card shadow-sm border border-secondary rounded-0">
                <div class="card-header bg-secondary text-white fw-bold p-3">
                    <i class="fas fa-users"></i> Manage User Security Rights
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('admin.updateUserPermissions') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center mb-0" style="font-size: 0.85rem;">
                                <thead class="align-middle">
                                    <tr>
                                        <th rowspan="2" class="bg-light" style="width: 15%;">USER DETAILS</th>
                                        <th colspan="10" class="text-white" style="background-color: #4F6228;">SECURITY RIGHTS</th>
                                    </tr>
                                    <tr style="background-color: #C4D79B;">
                                        <th>Admin</th><th>Athletes</th><th>Coaches</th><th>Sched</th><th>Achieve</th><th>Classes</th><th>Exams</th><th>Trans</th><th>Notifs</th><th>Dash</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td class="text-start bg-white">
                                            <div class="fw-bold text-dark">{{ $user->email }}</div>
                                            <div class="text-muted small">{{ $user->name }}</div>
                                            @if($user->role === 'coach')
                                                <span class="badge bg-info">Coach</span>
                                            @elseif($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @endif
                                        </td>
                                        @php $modules = ['admin', 'athletes', 'coaches', 'scheduling', 'achievements', 'classes', 'exams', 'transactions', 'notifications', 'dashboard']; @endphp
                                        @foreach($modules as $module)
                                        <td class="p-1">
                                            <select name="permissions[{{ $user->id }}][{{ $module }}]" class="form-select form-select-sm border-0 text-center" style="cursor: pointer; {{ ($user->permissions[$module] ?? '') == 'Edit' ? 'color:green; font-weight:bold;' : '' }}">
                                                <option value="Hidden" {{ ($user->permissions[$module] ?? '') == 'Hidden' ? 'selected' : '' }}>Hidden</option>
                                                <option value="View" {{ ($user->permissions[$module] ?? '') == 'View' ? 'selected' : '' }}>View</option>
                                                <option value="Edit" {{ ($user->permissions[$module] ?? '') == 'Edit' ? 'selected' : '' }}>Edit</option>
                                            </select>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted p-3">No users found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 bg-light border-top text-end">
                            <button type="submit" class="btn btn-success fw-bold"><i class="fas fa-save"></i> Update Security Rights</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-muted small"><i class="fas fa-info-circle"></i> <b>Edit:</b> Can add/modify data. <b>View:</b> Read-only access. <b>Hidden:</b> Module disappears from menu.</div>
        </div>
    </div>
</div>
@endsection