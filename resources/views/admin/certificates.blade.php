@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > CERTIFICATES & AWARDS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #EBF1DE;">
                    <div class="section-box border p-3" style="background-color: #DCE6F1; border: 1px solid #999;">
                        <h6 class="fw-bold fst-italic border-bottom border-secondary pb-1 mb-3">ADD NEW CERTIFICATE / AWARD</h6>
                        <form action="{{ route('admin.addCertificate') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row align-items-end">
                                <div class="col-md-4 mb-2"><label class="form-label-sm fw-bold">Name</label><input type="text" name="name" class="form-control form-control-sm" required></div>
                                <div class="col-md-3 mb-2"><label class="form-label-sm fw-bold">Type</label><select name="type" class="form-select form-select-sm"><option>Certificate</option><option>Award</option></select></div>
                                <div class="col-md-3 mb-2"><label class="form-label-sm fw-bold">Upload</label><input type="file" name="file" class="form-control form-control-sm" required></div>
                                <div class="col-md-2 mb-2"><button class="btn btn-success btn-sm w-100 fw-bold shadow-sm"><i class="fas fa-upload"></i> Upload</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header text-center fst-italic fw-bold border-bottom-0" style="background-color: #C4D79B; border: 1px solid #999; font-family: serif;">CERTIFICATES & AWARDS LIST</div>
                <div class="card-body p-0" style="background-color: #EBF1DE; border: 1px solid #999; border-top: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary text-center bg-white mb-0 align-middle">
                            <thead style="background-color: #DCE6F1;"><tr><th>Name</th><th>Type</th><th>File Path</th><th>Thumbnail</th></tr></thead>
                            <tbody>
                                @forelse($certs as $cert)
                                <tr><td class="fw-bold">{{ $cert->name }}</td><td><span class="badge bg-secondary">{{ $cert->type }}</span></td><td>{{ basename($cert->filename) }}</td><td class="bg-light p-2"><small>Preview Available</small></td></tr>
                                @empty<tr><td colspan="4" class="text-muted py-4">No certificates uploaded.</td></tr>@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection