@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > GENERAL INFORMATION
            </div>

            <!-- Optional: Global Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <strong>⚠️ Please fix the errors below before saving.</strong>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body" style="background-color: #EBF1DE;"> 
                    <form action="{{ route('admin.saveSettings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-9">
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label form-label-sm fw-bold text-end">School / Company</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror" value="{{ old('school_name', \App\Models\Setting::get('school_name')) }}" placeholder="Enter School Name">
                                        @error('school_name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label form-label-sm fw-bold text-end">Contact Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{ old('contact_name', \App\Models\Setting::get('contact_name')) }}">
                                        @error('contact_name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label form-label-sm fw-bold text-end">Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', \App\Models\Setting::get('email')) }}">
                                        @error('email') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                    
                                    <label class="col-sm-2 col-form-label form-label-sm fw-bold text-end">Phone 1</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="phone_1" class="form-control @error('phone_1') is-invalid @enderror" value="{{ old('phone_1', \App\Models\Setting::get('phone_1')) }}">
                                        @error('phone_1') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label form-label-sm fw-bold text-end">Address</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', \App\Models\Setting::get('address')) }}">
                                        @error('address') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                    
                                    <label class="col-sm-2 col-form-label form-label-sm fw-bold text-end">Phone 2</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="phone_2" class="form-control @error('phone_2') is-invalid @enderror" value="{{ old('phone_2', \App\Models\Setting::get('phone_2')) }}">
                                        @error('phone_2') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header text-center bg-secondary text-white py-1 small fw-bold">Logo</div>
                                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-2 bg-white">
                                        @php $logo = \App\Models\Setting::get('logo'); @endphp
                                        @if($logo)
                                            <img src="{{ asset('storage/' . $logo) }}" class="img-fluid mb-2" style="max-height: 100px; border: 1px solid #ddd;">
                                        @else
                                            <div class="border d-flex align-items-center justify-content-center mb-2 bg-light" style="height: 100px; width: 100%;"> 
                                                <i class="fas fa-image fa-3x text-secondary"></i>
                                            </div>
                                        @endif
                                        <input type="file" name="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror">
                                        <small class="text-muted d-block mt-1">Rec: 200x200px</small>
                                        @error('logo') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text fw-bold bg-light">City / Municipality</span>
                                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', \App\Models\Setting::get('city')) }}">
                                </div>
                                @error('city') <small class="text-danger fw-bold px-2">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text fw-bold bg-light">Province</span>
                                    <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province', \App\Models\Setting::get('province')) }}">
                                </div>
                                @error('province') <small class="text-danger fw-bold px-2">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text fw-bold bg-light">Zip Code</span>
                                    <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ old('zip', \App\Models\Setting::get('zip')) }}">
                                </div>
                                @error('zip') <small class="text-danger fw-bold px-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success fw-bold px-4"><i class="fas fa-save"></i> Save Information</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection