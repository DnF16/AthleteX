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

            <div class="card shadow-sm border border-secondary rounded-0">
                <div class="card-body p-0">
                    <form action="{{ route('admin.updateUserPermissions') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center mb-0" style="font-size: 0.85rem;">
                                <thead class="align-middle">
                                    <tr>
                                        <th rowspan="2" class="bg-light" style="width: 15%;">USER DETAILS</th>
                                        <th colspan="10" class="text-white" style="background-color: #2e4e1f;">SECURITY RIGHTS</th>
                                    </tr>
                                    <tr style="background-color: #C4D79B;">
                                        <th>Admin</th><th>Athletes</th><th>Coaches</th><th>Sched</th><th>Achieve</th><th>Classes</th><th>Exams</th><th>Trans</th><th>Notifs</th><th>Dash</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="text-start bg-white">
                                            <div class="fw-bold text-dark">{{ $user->username ?? $user->email }}</div>
                                            <div class="text-muted small">{{ $user->lastname }}, {{ $user->name }}</div>
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
                                    @endforeach
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