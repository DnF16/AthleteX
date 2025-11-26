@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0">
        
        <div class="col-md-3 col-lg-2 p-3" style="background-color: #dbead5; min-height: 100vh; border-right: 1px solid #c4d79b;">
            @include('admin.partials.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4" style="background-color: #EBF1DE;">
            
            <div class="card-header fw-bold fst-italic border-bottom border-secondary mb-4 p-2" style="background-color: #bfbfbf; font-family: 'Courier New';">
                ADMIN > GRADES AND SCORING
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body" style="background-color: #EBF1DE;">
                    
                    <form action="{{ route('admin.saveGrades') }}" method="POST">
                        @csrf
                        
                        <div class="text-center fst-italic fw-bold border border-dark mb-3 bg-light py-1" style="font-family: serif;">
                            GRADES AND SCORING SETUP
                        </div>

                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="border border-secondary">
                                    <div class="text-center fw-bold border-bottom border-secondary py-1" style="background-color: #bfbfbf;">
                                        GRADES & SCORES
                                    </div>
                                    <table class="table table-bordered border-secondary mb-0 text-center bg-white table-sm">
                                        <thead style="background-color: #DCE6F1;">
                                            <tr><th>Grade</th><th>Min. %</th><th>Min. Score</th></tr>
                                        </thead>
                                        <tbody>
                                            {{-- Loop existing grades or show empty rows --}}
                                            @for($i = 0; $i < 5; $i++)
                                            <tr>
                                                <td class="p-0"><input type="text" name="grades[{{$i}}][grade]" class="form-control form-control-sm border-0 text-center" value="{{ $grades[$i]->grade ?? '' }}"></td>
                                                <td class="p-0"><input type="text" name="grades[{{$i}}][min_percent]" class="form-control form-control-sm border-0 text-center" value="{{ $grades[$i]->min_percent ?? '' }}"></td>
                                                <td class="p-0"><input type="text" name="grades[{{$i}}][min_score]" class="form-control form-control-sm border-0 text-center" value="{{ $grades[$i]->min_score ?? '' }}"></td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="border border-secondary mb-4">
                                    <div class="text-center fw-bold border-bottom border-secondary py-1 bg-light fst-italic small">Year/Level</div>
                                    <div class="bg-white text-center p-2">
                                        <div class="border-bottom py-1">1st Year</div>
                                        <div class="border-bottom py-1">2nd Year</div>
                                        <div class="border-bottom py-1">3rd Year</div>
                                        <div class="py-1">4th Year</div>
                                    </div>
                                </div>
                                <div class="border border-secondary">
                                    <div class="text-center fw-bold border-bottom border-secondary py-1 bg-light fst-italic small">Exam Types</div>
                                    <div class="bg-white text-center p-2">
                                        <div class="border-bottom py-1">Quiz</div>
                                        <div class="border-bottom py-1">Test</div>
                                        <div class="py-1">Assignment</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="border border-secondary">
                                    <div class="text-center fw-bold border-bottom border-secondary py-1" style="background-color: #bfbfbf;">
                                        SCHOLARSHIP CRITERIA
                                    </div>
                                    <table class="table table-bordered border-secondary mb-0 text-center bg-white table-sm">
                                        <thead style="background-color: #DCE6F1;">
                                            <tr><th>Level</th><th>Criteria (Pts)</th><th>Criteria (%)</th><th>Certificate/Award</th></tr>
                                        </thead>
                                        <tbody>
                                            @for($i = 0; $i < 5; $i++)
                                            <tr>
                                                <td class="p-0"><input type="text" name="scholarships[{{$i}}][level]" class="form-control form-control-sm border-0 text-center" value="{{ $scholarships[$i]->level ?? '' }}"></td>
                                                <td class="p-0"><input type="text" name="scholarships[{{$i}}][criteria_pts]" class="form-control form-control-sm border-0 text-center" value="{{ $scholarships[$i]->criteria_pts ?? '' }}"></td>
                                                <td class="p-0"><input type="text" name="scholarships[{{$i}}][criteria_percent]" class="form-control form-control-sm border-0 text-center" value="{{ $scholarships[$i]->criteria_percent ?? '' }}"></td>
                                                <td class="p-0"><input type="text" name="scholarships[{{$i}}][certificate_award]" class="form-control form-control-sm border-0 text-center" value="{{ $scholarships[$i]->certificate_award ?? '' }}"></td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-success fw-bold shadow-sm"><i class="fas fa-save"></i> Save Grade Criteria</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection