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
        #basic-info-section, #shared-fields, #active-student-fields { display: none; }
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

            <form action="<?php echo e(route('alumni.register.submit')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-4 bg-light p-4 rounded border border-success">
                    <label class="form-label fw-bold h5">Step 1: Registration Type <span class="text-danger">*</span></label>
                    <select name="classification" id="classification" class="form-select form-select-lg border-success" required onchange="toggleFields()">
                        <option value="">-- Select Your Status --</option>
                        <option value="Active" <?php echo e(old('classification') == 'Active' ? 'selected' : ''); ?>>Active Student (New or Renewing)</option>
                        <option value="Alumni" <?php echo e(old('classification') == 'Alumni' ? 'selected' : ''); ?>>Alumni / Graduate</option>
                    </select>
                </div>

                <div id="basic-info-section">
                    <h5 class="section-title">Basic Identification</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" class="form-control" value="<?php echo e(old('student_id')); ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Middle Initial</label>
                            <input type="text" name="middle_initial" class="form-control" value="<?php echo e(old('middle_initial')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>" required>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Suffix</label>
                            <input type="text" name="suffix" class="form-control" value="<?php echo e(old('suffix')); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label fw-bold">ID Picture (2x2 or Passport) <span class="text-danger">*</span></label>
                         <input type="file" name="profile_picture" class="form-control" accept="image/*">
                         <div class="form-text">Accepted formats: JPG, PNG, JPEG</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                        <select name="sport_event" class="form-select" required>
                            <option value="">-- Select Sport --</option>
                            <optgroup label="Ball Games">
                                <option value="Basketball_Men" <?php echo e(old('sport_event') == 'Basketball_Men' ? 'selected' : ''); ?>>Basketball (Men)</option>
                                <option value="Basketball_Women" <?php echo e(old('sport_event') == 'Basketball_Women' ? 'selected' : ''); ?>>Basketball (Women)</option>
                                <option value="Volleyball_Men" <?php echo e(old('sport_event') == 'Volleyball_Men' ? 'selected' : ''); ?>>Volleyball (Men)</option>
                                <option value="Volleyball_Women" <?php echo e(old('sport_event') == 'Volleyball_Women' ? 'selected' : ''); ?>>Volleyball (Women)</option>
                                <option value="Football" <?php echo e(old('sport_event') == 'Football' ? 'selected' : ''); ?>>Football</option>
                                <option value="Softball" <?php echo e(old('sport_event') == 'Softball' ? 'selected' : ''); ?>>Softball</option>
                                <option value="Baseball" <?php echo e(old('sport_event') == 'Baseball' ? 'selected' : ''); ?>>Baseball</option>
                            </optgroup>
                            <optgroup label="Racket Sports">
                                <option value="Badminton_Men" <?php echo e(old('sport_event') == 'Badminton_Men' ? 'selected' : ''); ?>>Badminton (Men)</option>
                                <option value="Badminton_Women" <?php echo e(old('sport_event') == 'Badminton_Women' ? 'selected' : ''); ?>>Badminton (Women)</option>
                                <option value="Table_Tennis_Men" <?php echo e(old('sport_event') == 'Table_Tennis_Men' ? 'selected' : ''); ?>>Table Tennis (Men)</option>
                                <option value="Table_Tennis_Women" <?php echo e(old('sport_event') == 'Table_Tennis_Women' ? 'selected' : ''); ?>>Table Tennis (Women)</option>
                                <option value="Tennis_Men" <?php echo e(old('sport_event') == 'Tennis_Men' ? 'selected' : ''); ?>>Tennis (Men)</option>
                                <option value="Tennis_Women" <?php echo e(old('sport_event') == 'Tennis_Women' ? 'selected' : ''); ?>>Tennis (Women)</option>
                            </optgroup>
                            <optgroup label="Combat Sports & Others">
                                <option value="Taekwondo_Men" <?php echo e(old('sport_event') == 'Taekwondo_Men' ? 'selected' : ''); ?>>Taekwondo (Men)</option>
                                <option value="Taekwondo_Women" <?php echo e(old('sport_event') == 'Taekwondo_Women' ? 'selected' : ''); ?>>Taekwondo (Women)</option>
                                <option value="Arnis_Men" <?php echo e(old('sport_event') == 'Arnis_Men' ? 'selected' : ''); ?>>Arnis (Men)</option>
                                <option value="Arnis_Women" <?php echo e(old('sport_event') == 'Arnis_Women' ? 'selected' : ''); ?>>Arnis (Women)</option>
                                <option value="Boxing" <?php echo e(old('sport_event') == 'Boxing' ? 'selected' : ''); ?>>Boxing</option>
                                <option value="Sepak_Takraw" <?php echo e(old('sport_event') == 'Sepak_Takraw' ? 'selected' : ''); ?>>Sepak Takraw</option>
                                <option value="Chess" <?php echo e(old('sport_event') == 'Chess' ? 'selected' : ''); ?>>Chess</option>
                                <option value="Swimming" <?php echo e(old('sport_event') == 'Swimming' ? 'selected' : ''); ?>>Swimming</option>
                                <option value="Athletics" <?php echo e(old('sport_event') == 'Athletics' ? 'selected' : ''); ?>>Athletics</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div id="shared-fields">
                    <h5 class="section-title">Contact & Address Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact_number" class="form-control" value="<?php echo e(old('contact_number')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Facebook/Social Link</label>
                            <input type="url" name="facebook_link" class="form-control" value="<?php echo e(old('facebook_link')); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Home Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">City / Municipality <span class="text-danger">*</span></label>
                            <input type="text" name="city_municipality" class="form-control" value="<?php echo e(old('city_municipality')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Province</label>
                            <input type="text" name="province_state" class="form-control" value="<?php echo e(old('province_state')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Zip Code</label>
                            <input type="text" name="zip_code" class="form-control" value="<?php echo e(old('zip_code')); ?>">
                        </div>
                    </div>

                    <h5 class="section-title">Academic Information</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">College / Department</label>
                            <input type="text" name="college" class="form-control" placeholder="e.g. CCS" value="<?php echo e(old('college')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                            <input type="text" name="course" class="form-control" placeholder="e.g. BSIT" value="<?php echo e(old('course')); ?>">
                        </div>
                    </div>
                </div>

                <div id="active-student-fields">
                    <h5 class="section-title">Personal Details</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Birthdate <span class="text-danger">*</span></label>
                            <input type="date" name="birthdate" class="form-control" value="<?php echo e(old('birthdate')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control" value="<?php echo e(old('age')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sex <span class="text-danger">*</span></label>
                            <select name="sex" class="form-select">
                                <option value="">Select</option>
                                <option value="Male" <?php echo e(old('sex') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                <option value="Female" <?php echo e(old('sex') == 'Female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Civil Status</label>
                            <select name="civil_status" class="form-select">
                                <option value="Single" <?php echo e(old('civil_status') == 'Single' ? 'selected' : ''); ?>>Single</option>
                                <option value="Married" <?php echo e(old('civil_status') == 'Married' ? 'selected' : ''); ?>>Married</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Place of Birth</label>
                            <input type="text" name="place_of_birth" class="form-control" value="<?php echo e(old('place_of_birth')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="Filipino" value="<?php echo e(old('nationality')); ?>">
                        </div>
                    </div>

                    <h5 class="section-title">Physical Attributes</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" name="height" class="form-control" placeholder="175" value="<?php echo e(old('height')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" class="form-control" placeholder="65" value="<?php echo e(old('weight')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Blood Type</label>
                            <select name="blood_type" class="form-select">
                                <option value="">Unknown</option>
                                <option value="A+" <?php echo e(old('blood_type') == 'A+' ? 'selected' : ''); ?>>A+</option>
                                <option value="A-" <?php echo e(old('blood_type') == 'A-' ? 'selected' : ''); ?>>A-</option>
                                <option value="B+" <?php echo e(old('blood_type') == 'B+' ? 'selected' : ''); ?>>B+</option>
                                <option value="B-" <?php echo e(old('blood_type') == 'B-' ? 'selected' : ''); ?>>B-</option>
                                <option value="O+" <?php echo e(old('blood_type') == 'O+' ? 'selected' : ''); ?>>O+</option>
                                <option value="O-" <?php echo e(old('blood_type') == 'O-' ? 'selected' : ''); ?>>O-</option>
                                <option value="AB+" <?php echo e(old('blood_type') == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                                <option value="AB-" <?php echo e(old('blood_type') == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Year Level</label>
                            <select name="year_level" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="1" <?php echo e(old('year_level') == '1' ? 'selected' : ''); ?>>1st Year</option>
                                <option value="2" <?php echo e(old('year_level') == '2' ? 'selected' : ''); ?>>2nd Year</option>
                                <option value="3" <?php echo e(old('year_level') == '3' ? 'selected' : ''); ?>>3rd Year</option>
                                <option value="4" <?php echo e(old('year_level') == '4' ? 'selected' : ''); ?>>4th Year</option>
                            </select>
                        </div>
                    </div>

                    <h5 class="section-title">In Case of Emergency</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-5">
                            <label class="form-label">Contact Person Name <span class="text-danger">*</span></label>
                            <input type="text" name="emergency_person" class="form-control" value="<?php echo e(old('emergency_person')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Emergency Number <span class="text-danger">*</span></label>
                            <input type="text" name="emergency_contact" class="form-control" value="<?php echo e(old('emergency_contact')); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Relationship</label>
                            <input type="text" name="emergency_relationship" class="form-control" value="<?php echo e(old('emergency_relationship')); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-success btn-lg text-white shadow fw-bold py-3">SUBMIT REGISTRATION</button>
                    <a href="<?php echo e(url('/')); ?>" class="text-center text-secondary mt-2 text-decoration-none">Cancel</a>
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
        var activeFields = document.getElementById("active-student-fields");

        if (status === "") {
            basicInfo.style.display = "none";
            sharedFields.style.display = "none";
            activeFields.style.display = "none";
        } else {
            basicInfo.style.display = "block";
            sharedFields.style.display = "block";
            
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
        // ALWAYS required
        let alwaysRequired = ['student_id', 'email', 'first_name', 'last_name', 'middle_initial', 'sport_event'];
        
        // SHARED required
        let sharedRequired = ['contact_number', 'address', 'city_municipality', 'course'];
        
        // ACTIVE ONLY required
        let activeRequired = ['birthdate', 'gender', 'emergency_person', 'emergency_contact'];

        function setList(names, isRequired) {
            names.forEach(name => {
                let el = document.getElementsByName(name)[0];
                if(el) el.required = isRequired;
            });
        }

        if (mode === 'Active') {
            setList(sharedRequired, true);
            setList(activeRequired, true);
        } else {
            setList(sharedRequired, true);
            setList(activeRequired, false); // Turn off required for hidden fields
        }
    }
</script>

</body>
</html><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/alumni_registration.blade.php ENDPATH**/ ?>