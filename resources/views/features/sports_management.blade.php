@extends('layouts.app') 

@section('content')

@include('partials.sidebar')

<div class="bg-light min-vh-100 p-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h2 class="fw-bold text-success">
            Sports Programs Management
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 border-top border-success border-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">Add New Sport Program</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sports.manage.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Sport Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Esports, Archery" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            Save Sport
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">Active Sports List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Sport Name</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sports as $sport)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $sport->name }}</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.sports.manage.destroy', $sport->id) }}" method="POST" class="m-0 p-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Are you sure you want to delete this sport? It will instantly vanish from all system dropdowns.')">
                                                    Delete Program
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">No sports found in the database.</td>
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

@endsection