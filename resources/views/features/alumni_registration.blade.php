<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Registration - SDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .form-header { background: #2e4e1f; color: white; padding: 40px; border-radius: 10px 10px 0 0; text-align: center; }
        .form-container { max-width: 900px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        .form-section { padding: 40px; }
        .section-title { color: #2e4e1f; border-bottom: 2px solid #c4d79b; padding-bottom: 10px; margin-bottom: 20px; margin-top: 30px; font-weight: bold; }
        
        /* HIDE SECTIONS BY DEFAULT */
        #basic-info-section, #shared-fields, #tryout-alert { display: none; }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="form-container">
        <div class="form-header">
            <h2 class="mb-2 fw-bold"><i class="bi bi-person-vcard-fill me-2"></i>Athlete Registration</h2>
            <p class="mb-0 opacity-75">Sports Development Office • Enrollment & Profiling</p>
        </div>

        <div class="form-section">
            
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('tryout_success'))
                <div class="alert alert-success shadow-lg mb-4" style="background-color: #e8f5e9; border-left: 8px solid #2e4e1f; border-radius: 8px;">
                    <h3 class="fw-bold text-success mb-3">
                        <i class="fas fa-ticket-alt me-2"></i> Registration Confirmed!
                    </h3>
                    <p class="fs-5 mb-3">
                        {!! session('tryout_success') !!}
                    </p>
                    <hr class="border-success">
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-camera text-success fs-2 me-3"></i>
                        <p class="mb-0 text-success fw-bold">
                            Please take a screenshot of this digital pass and present it to the coaches on the day of your tryout. <br>
                            <span class="small fw-normal text-muted fst-italic">(*Note: In the live production version, this schedule will also be sent to your registered email address).</span>
                        </p>
                    </div>
                </div>
            @endif

            <div id="tryout-alert" class="alert alert-info border-info mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Tryout Applicant:</strong> Please fill out your basic details. Your tryout schedule will be shown after submission.
            </div>

            <form action="{{ route('alumni.register.submit') }}" method="POST">
                @csrf

                <div class="mb-4 bg-light p-4 rounded border border-success">
                    <label class="form-label fw-bold h5">Step 1: Registration Type <span class="text-danger">*</span></label>
                    <select name="classification" id="classification" class="form-select form-select-lg border-success" required onchange="toggleFields()">
                        <option value="">-- Select Your Status --</option>
                        <option value="Tryout" {{ old('classification') == 'Tryout' ? 'selected' : '' }}>Tryout Applicant (New Recruit)</option>
                        <option value="Alumni" {{ old('classification') == 'Alumni' ? 'selected' : '' }}>Alumni / Graduate</option>
                    </select>
                </div>

                <div id="basic-info-section">
                    <h5 class="section-title">Basic Identification</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4" id="student_id_container">
                            <label class="form-label fw-bold">Student ID <span class="text-danger" id="id_star">*</span></label>
                            <input type="text" name="student_id" class="form-control" value="{{ old('student_id') }}">
                        </div>
                        <div class="col-md-8" id="email_container">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">M.I.</label>
                            <input type="text" name="middle_initial" class="form-control" maxlength="3" value="{{ old('middle_initial') }}">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                        <select name="sport_event" class="form-select" required>
                            <option value="">-- Select Sport --</option>
                            <optgroup label="Ball Games">
                                <option value="Basketball_Men">Basketball (Men)</option>
                                <option value="Basketball_Women">Basketball (Women)</option>
                                <option value="Volleyball_Men">Volleyball (Men)</option>
                                <option value="Volleyball_Women">Volleyball (Women)</option>
                                <option value="Football">Football</option>
                                <option value="Softball">Softball</option>
                                <option value="Baseball">Baseball</option>
                            </optgroup>
                            <optgroup label="Racket Sports">
                                <option value="Badminton_Men">Badminton (Men)</option>
                                <option value="Badminton_Women">Badminton (Women)</option>
                                <option value="Table_Tennis_Men">Table Tennis (Men)</option>
                                <option value="Table_Tennis_Women">Table Tennis (Women)</option>
                                <option value="Tennis_Men">Tennis (Men)</option>
                                <option value="Tennis_Women">Tennis (Women)</option>
                            </optgroup>
                            <optgroup label="Combat Sports & Others">
                                <option value="Taekwondo_Men">Taekwondo (Men)</option>
                                <option value="Taekwondo_Women">Taekwondo (Women)</option>
                                <option value="Arnis_Men">Arnis (Men)</option>
                                <option value="Arnis_Women">Arnis (Women)</option>
                                <option value="Boxing">Boxing</option>
                                <option value="Sepak_Takraw">Sepak Takraw</option>
                                <option value="Chess">Chess</option>
                                <option value="Swimming">Swimming</option>
                                <option value="Athletics">Athletics</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div id="shared-fields">
                    <h5 class="section-title">Contact & Address Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Facebook/Social Link</label>
                            <input type="url" name="facebook_link" class="form-control" value="{{ old('facebook_link') }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Home Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                            <input type="text" name="city_municipality" class="form-control" value="{{ old('city_municipality') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Province</label>
                            <input type="text" name="province_state" class="form-control" value="{{ old('province_state') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code') }}">
                        </div>
                    </div>

                    <h5 class="section-title">Academic Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                            <input type="text" name="course" class="form-control" placeholder="e.g. BSIT" value="{{ old('course') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Year Level</label>
                            <select name="year_level" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-success btn-lg text-white shadow fw-bold py-3">SUBMIT REGISTRATION</button>
                    <a href="{{ url('/') }}" class="text-center text-secondary mt-2 text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });

    function toggleFields() {
        var status = document.getElementById("classification").value;
        var basicInfo = document.getElementById("basic-info-section");
        var sharedFields = document.getElementById("shared-fields");
        var tryoutAlert = document.getElementById("tryout-alert");
        var studentIdInput = document.getElementsByName("student_id")[0];
        var idStar = document.getElementById("id_star");

        // Reset display
        tryoutAlert.style.display = "none";

        if (status === "") {
            basicInfo.style.display = "none";
            sharedFields.style.display = "none";
        } else {
            basicInfo.style.display = "block";
            
            if (status === "Tryout") {
                sharedFields.style.display = "none"; // Hide course/address for tryouts
                tryoutAlert.style.display = "block"; // Show tryout notice
                idStar.style.display = "none"; // ID not required for recruits
                setRequired('Tryout');
            } else if (status === "Alumni") { 
                sharedFields.style.display = "block";
                idStar.style.display = "inline";
                setRequired('Alumni');
            }
        }
    }

    function setRequired(mode) {
        let studentId = ['student_id'];
        let sharedRequired = ['contact_number', 'address', 'city_municipality', 'course'];

        function setList(names, isRequired) {
            names.forEach(name => {
                let el = document.getElementsByName(name)[0];
                if(el) el.required = isRequired;
            });
        }

        if (mode === 'Tryout') {
            setList(studentId, false); 
            setList(sharedRequired, false);
        } else if (mode === 'Alumni') { 
            setList(studentId, true);
            setList(sharedRequired, true);
        }
    }
</script>

</body>
</html>