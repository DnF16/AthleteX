<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Registration - SDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-header {
            background: linear-gradient(135deg, #198754 0%, #157347 100%); /* Green gradient */
            color: white;
            padding: 30px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .form-container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .form-section {
            padding: 30px;
        }
        .btn-submit {
            background-color: #198754;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: #146c43;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        
        <div class="form-header">
            <h2 class="mb-2"><i class="bi bi-mortarboard-fill me-2"></i>Alumni Tracking Form</h2>
            <p class="mb-0 opacity-75">Sports Development Office</p>
        </div>

        <div class="form-section">
            
            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ url('/') }}" class="btn btn-outline-success">Return to Home</a>
                </div>
            @else

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alumni.register.submit') }}" method="POST">
                @csrf

                <div class="alert alert-info border-0 bg-light text-dark mb-4">
                    <i class="bi bi-info-circle me-1"></i> Please enter your details accurately. Your record will be verified by the SDO Admin.
                </div>

                <h5 class="text-success mb-3 border-bottom pb-2">Personal Information</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                    <input type="text" name="student_id" class="form-control" placeholder="e.g. 2020-10452" value="{{ old('student_id') }}" required>
                    <div class="form-text">Your ID number when you were a student.</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                </div>

                <h5 class="text-success mb-3 border-bottom pb-2 mt-4">Sports Record</h5>

                <div class="mb-4">
                    <label class="form-label fw-bold">Sport Event <span class="text-danger">*</span></label>
                    <select name="sport_event" class="form-select" required>
                        <option value="">-- Select Your Main Sport --</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Swimming">Swimming</option>
                        <option value="Athletics">Athletics</option>
                        <option value="Arnis">Arnis</option>
                        <option value="Archery">Archery</option>
                        <option value="Taekwondo">Taekwondo</option>
                        <option value="Chess">Chess</option>
                        <option value="Football">Football</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Table Tennis">Table Tennis</option>
                        <option value="Judo">Judo</option>
                        <option value="Boxing">Boxing</option>
                        <option value="Baseball">Baseball</option>
                        <option value="Football">Football</option>
                        <option value="Tennis">Tennis</option>
                        <option value="Softball">Softball</option>
                        <option value="Sepak Takraw">Sepak Takraw</option>
                        <option value="Wushu Sanda">Wushu Sanda</option>
                        <option value="Wushu Taolu">Wushu Taolu</option>

                    </select>
                </div>

                <div class="d-grid gap-2 mt-5">
                    <button type="submit" class="btn btn-submit text-white shadow">
                        Submit Registration
                    </button>
                    <a href="{{ url('/') }}" class="btn btn-link text-secondary text-decoration-none text-center">Cancel</a>
                </div>

            </form>
            @endif
        </div>
    </div>
    
    <div class="text-center text-muted mb-5 small">
        &copy; {{ date('Y') }} Sports Development Office System
    </div>
</div>

</body>
</html>