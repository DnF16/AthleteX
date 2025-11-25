@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > CERTIFICATES & AWARDS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header text-center fst-italic fw-bold border-bottom-0" 
                    style="background-color: #C4D79B; border: 1px solid #999; font-family: serif;">
                    CERTIFICATES & AWARDS
                </div>

                <div class="card-body p-0" style="background-color: #EBF1DE; border: 1px solid #999; border-top: none;">
                    
                    <div class="d-flex justify-content-end p-2 bg-light border-bottom">
                        <button class="btn btn-success btn-sm fw-bold shadow-sm">
                            <i class="fas fa-plus-circle"></i> Add Certificate
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary text-center bg-white mb-0 align-middle">
                            <thead style="background-color: #DCE6F1;">
                                <tr>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 15%;">Type</th>
                                    <th style="width: 20%;">File Name</th>
                                    <th style="width: 40%;">Thumbnail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($certs as $cert)
                                <tr style="height: 50px;">
                                    <td>{{ $cert->name }}</td>
                                    <td>{{ $cert->type }}</td>
                                    <td>{{ $cert->file_name }}</td>
                                    <td class="bg-light text-muted">
                                        @if($cert->type == 'Award')
                                            <i class="fas fa-trophy text-warning fa-lg"></i>
                                        @else
                                            <small>No Preview</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr style="height: 50px;"><td></td><td></td><td></td><td class="bg-light"></td></tr>
                                <tr style="height: 50px;"><td></td><td></td><td></td><td class="bg-light"></td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection