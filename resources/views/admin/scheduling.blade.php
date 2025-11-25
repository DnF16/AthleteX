@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > SCHEDULING SETTINGS
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body" style="background-color: #EBF1DE;">
                    
                    <form action="{{ route('admin.saveSettings') }}" method="POST">
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-5">
                                <div class="section-box border p-3 h-100" style="background-color: #E4EAD5; border: 1px solid #999;">
                                    <h6 class="fw-bold fst-italic text-center mb-4" style="font-family: serif; letter-spacing: 1px;">SCHEDULE SETTINGS</h6>

                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Weekday Start</label>
                                        <div class="col-sm-6">
                                            <select name="weekday_start" class="form-select form-select-sm border-secondary rounded-0"><option>Monday</option></select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">1st Class Start Time</label>
                                        <div class="col-sm-6"><input type="time" name="class_start_time" class="form-control form-control-sm border-secondary rounded-0" value="08:00"></div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Last Class End Time</label>
                                        <div class="col-sm-6"><input type="time" name="class_end_time" class="form-control form-control-sm border-secondary rounded-0" value="17:00"></div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-sm-6 col-form-label form-label-sm text-end bg-light border border-secondary me-2" style="max-width: 140px;">Schedule Interval</label>
                                        <div class="col-sm-6">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="schedule_interval" class="form-control border-secondary rounded-0" value="60">
                                                <span class="input-group-text border-secondary rounded-0">min</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm w-100 mt-2">Save Schedule Defaults</button>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="card border border-secondary rounded-0">
                                    <div class="card-header text-center fw-bold fst-italic py-1" style="background-color: #C4D79B; border-bottom: 1px solid #999;">
                                        Scheduled Class Days
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-sm mb-0 bg-white border-secondary">
                                            <tbody style="font-size: 0.9rem;">
                                                <tr><td class="ps-3 w-50">Monday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Saturday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                                <tr><td class="ps-3 w-50">Sunday</td><td class="text-center text-muted"></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="border-secondary my-4">

                    <h5 class="text-center fw-bold fst-italic mb-0 pt-2" style="font-family: serif; background-color: #bfbfbf; border: 1px solid #999; border-bottom: none;">Scheduled Holidays</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered border-secondary text-center bg-white mb-0">
                            <thead style="background-color: #C4D79B;">
                                <tr>
                                    <th style="width: 25%;">Holiday Name</th>
                                    <th style="width: 15%;">From Date</th>
                                    <th style="width: 15%;">To Date</th>
                                    <th style="width: 15%;">Term</th>
                                    <th style="width: 15%;">From Date</th>
                                    <th style="width: 15%;">To Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($holidays as $holiday)
                                    <tr style="height: 35px;">
                                        <td>{{ $holiday->name }}</td>
                                        <td>{{ $holiday->from_date }}</td>
                                        <td>{{ $holiday->to_date }}</td>
                                        <td>{{ $holiday->term }}</td>
                                        <td>—</td>
                                        <td>—</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection