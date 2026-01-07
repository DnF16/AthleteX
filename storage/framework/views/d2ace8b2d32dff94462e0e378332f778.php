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
        #basic-info-section { display: none; }
        #shared-fields { display: none; } /* Address & Academics (For Both) */
        #active-student-fields { display: none; } /* Personal & Physical (Active Only) */

        /* MOBILE RESPONSIVENESS FIX */
        @media (max-width: 768px) {
            .form-header { padding: 20px; }
            .form-section { padding: 20px 15px; }
            .form-container { margin: 10px; }
            .btn-lg { width: 100%; } /* Make submit button full width on phone */
        }
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
            
            <?php if(session('success')): ?>
                <div class="alert alert-success d-flex align-items-center mb-4">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div><?php echo e(session('success')); ?></div>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('alumni.register.submit')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-4 bg-light p-4 rounded border border-success">
                    <label class="form-label fw-bold h5">Step 1: Registration Type <span class="text-danger">*</span></label>
                    <select name="classification" id="classification" class="form-select form-select-lg border-success" required onchange="toggleFields()">
                        <option value="">-- Select Your Status --</option>
                        <option value="Active">Active Student (New or Renewing)</option>
                        <option value="Alumni">Alumni / Graduate</option>
                    </select>
                </div>

                <div id="basic-info-section">
                    
                    <hr class="my-4">

                    <h5 class="section-title">Basic Identification</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" class="form-control" placeholder="e.g. 2023-10001" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="student@university.edu.ph" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Suffix</label>
                            <input type="text" name="suffix" class="form-control" placeholder="Jr.">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                        <select name="sport_event" class="form-select" required>
                            <option value="">-- Select Sport --</option>
                            <option value="Basketball_Men">Basketball Men</option>
                            <option value="Basketball_Women">Basketball Women</option>
                            <option value="Volleyball_Men">Volleyball Men</option>
                            <option value="Volleyball_Women">Volleyball Women</option>
                            <option value="Swimming_Men">Swimming Men</option>
                            <option value="Swimming_Women">Swimming Women</option>
                            <option value="Athletics">Athletics</option>
                            <option value="Badminton_Men">Badminton Men</option>
                            <option value="Badminton_Women">Badminton Women</option>
                            <option value="Sepak_Takraw_Men">Sepak Takraw Men</option>
                            <option value="Sepak_Takraw_Women">Sepak Takraw Women</option>
                            <option value="Table_Tennis_Men">Table Tennis Men</option>
                            <option value="Table_Tennis_Women">Table Tennis Women</option>
                            <option value="Tennis_Men">Tennis Men</option>
                            <option value="Tennis_Women">Tennis Women</option>
                            <option value="Chess">Chess</option>
                            <option value="Taekwondo_Men">Taekwondo Men</option>
                            <option value="Taekwondo_Women">Taekwondo Women</option>
                            <option value="Arnis_Men">Arnis Men</option>
                            <option value="Arnis_Women">Arnis Women</option>
                            <option value="Archery_Men">Archery Men</option>
                            <option value="Archery_Women">Archery Women</option>
                            <option value="Baseball">Baseball</option>
                            <option value="Judo_Men">Judo Men</option>
                            <option value="Judo_Women">Judo Women</option>
                            <option value="Wushu_Sanda">Wushu Sanda</option>
                            <option value="Wushu_Taolu">Wushu Taolu</option>
                            <option value="Football">Football</option>
                            <option value="Softball">Softball</option>
                            <option value="Boxing">Boxing</option>
                        </select>
                    </div>

                    <div id="shared-fields">
                        <h5 class="section-title">Contact & Address Information</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="contact_number" class="form-control" placeholder="09123456789">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Facebook/Social Link</label>
                                <input type="url" name="facebook_link" class="form-control" placeholder="https://facebook.com/yourname">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Home Address (House No, Street, Subd.) <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                                <input type="text" name="city_municipality" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="province_state" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="zip_code" class="form-control">
                            </div>
                        </div>

                        <h5 class="section-title">Academic Information</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">College / Department</label>
                                <input type="text" name="college" class="form-control" placeholder="e.g. CCS">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                                <input type="text" name="course" class="form-control" placeholder="e.g. BSIT">
                            </div>
                        </div>
                    </div>

                    <div id="active-student-fields">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Year Level</label>
                                <select name="year_level" class="form-select">
                                    <option value="">-- Select Year --</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                    <option value="5">5th Year</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="section-title">Personal Details</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Birthdate <span class="text-danger">*</span></label>
                                <input type="date" name="birthdate" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Sex <span class="text-danger">*</span></label>
                                <select name="sex" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Civil Status</label>
                                <select name="civil_status" class="form-select">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Place of Birth</label>
                                <input type="text" name="place_of_birth" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nationality</label>
                                <input type="text" name="nationality" class="form-control" value="Filipino">
                            </div>
                        </div>

                        <h5 class="section-title">Physical Attributes</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" name="height" class="form-control" placeholder="175">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" class="form-control" placeholder="65">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Blood Type</label>
                                <select name="blood_type" class="form-select">
                                    <option value="">Unknown</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>

                        <h5 class="section-title">In Case of Emergency</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-5">
                                <label class="form-label">Contact Person Name <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_person" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Emergency Number <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Relationship</label>
                                <input type="text" name="emergency_relationship" class="form-control" placeholder="Parent/Guardian">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-success btn-lg text-white shadow fw-bold py-3">SUBMIT REGISTRATION</button>
                        <a href="<?php echo e(url('/')); ?>" class="text-center text-secondary mt-2 text-decoration-none">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        var status = document.getElementById("classification").value;
        var basicInfo = document.getElementById("basic-info-section");
        var sharedFields = document.getElementById("shared-fields");
        var activeFields = document.getElementById("active-student-fields");

        // 1. Logic: Show/Hide Basic Info based on if *anything* is selected
        if (status === "") {
            basicInfo.style.display = "none";
            sharedFields.style.display = "none";
            activeFields.style.display = "none";
        } else {
            basicInfo.style.display = "block";
            // Address & Academic (Shared) always show if status is selected
            sharedFields.style.display = "block";
            
            // 2. Logic: Show/Hide Extended Fields only if 'Active'
            if (status === "Active") {
                activeFields.style.display = "block";
                setRequired('Active');
            } else {
                activeFields.style.display = "none";
                setRequired('Alumni');
            }
        }
    }

    function setRequired(mode) {
        // Shared fields are required for BOTH Active and Alumni
        let sharedRequired = ['contact_number', 'address', 'city_municipality', 'course'];
        
        // Active fields are ONLY required for Active students
        let activeRequired = ['birthdate', 'sex', 'emergency_person', 'emergency_contact'];

        // Helper to toggle requirement
        function toggle(list, isRequired) {
            list.forEach(function(name) {
                let element = document.getElementsByName(name)[0];
                if(element) element.required = isRequired;
            });
        }

        if (mode === 'Active') {
            // Active needs EVERYTHING
            toggle(sharedRequired, true);
            toggle(activeRequired, true);
        } else if (mode === 'Alumni') {
            // Alumni only needs Shared
            toggle(sharedRequired, true);
            toggle(activeRequired, false);
        }
    }
</script>

</body>
</html><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/alumni_registration.blade.php ENDPATH**/ ?>