@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
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
                                    <h6 class="fw-bold fst-italic text-center mb-4">SCHEDULE SETTINGS</h6>
                                    <div class="mb-3 row align-items-center"><label class="col-sm-6 form-label-sm text-end bg-light border me-2">Weekday Start</label><div class="col-sm-6"><select name="weekday_start" class="form-select form-select-sm border-secondary rounded-0"><option value="Monday">Monday</option></select></div></div>
                                    <div class="mb-3 row align-items-center"><label class="col-sm-6 form-label-sm text-end bg-light border me-2">1st Class Start</label><div class="col-sm-6"><input type="time" name="class_start_time" class="form-control form-control-sm border-secondary rounded-0" value="{{ \App\Models\Setting::get('class_start_time', '08:00') }}"></div></div>
                                    <div class="mb-3 row align-items-center"><label class="col-sm-6 form-label-sm text-end bg-light border me-2">Last Class End</label><div class="col-sm-6"><input type="time" name="class_end_time" class="form-control form-control-sm border-secondary rounded-0" value="{{ \App\Models\Setting::get('class_end_time', '17:00') }}"></div></div>
                                    <div class="mb-3 row align-items-center"><label class="col-sm-6 form-label-sm text-end bg-light border me-2">Interval (min)</label><div class="col-sm-6"><input type="number" name="schedule_interval" class="form-control border-secondary rounded-0" value="{{ \App\Models\Setting::get('schedule_interval', 60) }}"></div></div>
                                    <button type="submit" class="btn btn-success btn-sm w-100 mt-2">Save Configuration</button>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card border border-secondary rounded-0">
                                    <div class="card-header text-center fw-bold fst-italic py-1" style="background-color: #C4D79B; border-bottom: 1px solid #999;">Scheduled Class Days</div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-sm mb-0 bg-white border-secondary"><tbody>
                                            <tr><td class="ps-3 w-50">Monday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                            <tr><td class="ps-3 w-50">Friday</td><td class="text-center fw-bold"><i class="fas fa-check text-success"></i></td></tr>
                                            <tr><td class="ps-3 w-50">Sunday</td><td class="text-center text-muted"></td></tr>
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="border-secondary my-4">

                    <div class="section-box border p-3 mb-3" style="background-color: #DCE6F1; border: 1px solid #999;">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Add New Holiday</h6>
                        <form action="{{ route('admin.addHoliday') }}" method="POST" class="row g-2">
                            @csrf
                            <div class="col-md-3"><label class="form-label-sm">Holiday Name</label><input type="text" name="name" class="form-control form-control-sm" required></div>
                            <div class="col-md-2"><label class="form-label-sm">From</label><input type="date" name="from_date" class="form-control form-control-sm" required></div>
                            <div class="col-md-2"><label class="form-label-sm">To</label><input type="date" name="to_date" class="form-control form-control-sm" required></div>
                            <div class="col-md-2"><label class="form-label-sm">Term</label><input type="text" name="term" class="form-control form-control-sm"></div>
                            <div class="col-md-3"><button type="submit" class="btn btn-primary btn-sm w-100">Save Holiday</button></div>
                        </form>
                    </div>

                    <h5 class="text-center fw-bold fst-italic mb-0 pt-2" style="font-family: serif; background-color: #bfbfbf; border: 1px solid #999; border-bottom: none;">Scheduled Holidays</h5>
                    <div class="table-responsive"><table class="table table-bordered border-secondary text-center bg-white mb-0"><thead style="background-color: #C4D79B;"><tr><th>Holiday Name</th><th>From Date</th><th>To Date</th><th>Term</th></tr></thead><tbody>
                        @foreach($holidays as $holiday)<tr><td>{{ $holiday->name }}</td><td>{{ $holiday->from_date }}</td><td>{{ $holiday->to_date }}</td><td>{{ $holiday->term }}</td></tr>@endforeach
                    </tbody></table></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection