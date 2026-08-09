<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Profile - {{ $athlete->last_name }}</title>
    <style>
        /* PRINT SETTINGS - Force Single Page */
        @media print {
            @page { margin: 0.3in; size: A4 portrait; }
            html, body { height: 99%; } /* Prevents overflow */
            .no-print { display: none !important; }
        }

        /* COMPACT STYLING */
        body { font-family: 'Times New Roman', serif; line-height: 1.3; color: #000; max-width: 800px; margin: 0 auto; padding: 0; font-size: 10pt; }
        
        /* HEADER */
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #2e4e1f; padding-bottom: 5px; }
        .school-name { font-size: 14pt; font-weight: bold; text-transform: uppercase; color: #2e4e1f; margin: 0; }
        .office-name { font-size: 11pt; font-weight: bold; margin: 0; }
        .doc-title { font-size: 12pt; font-weight: bold; margin-top: 10px; text-decoration: underline; }

        /* PROFILE TOP */
        .profile-header { display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-start; }
        .photo-box { width: 120px; height: 120px; border: 1px solid #000; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #eee; }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .main-info h1 { margin: 0; font-size: 16pt; text-transform: uppercase; line-height: 1.2; }
        .sport-badge { background: #2e4e1f; color: white; padding: 2px 6px; font-size: 9pt; font-weight: bold; display: inline-block; margin-top: 5px; -webkit-print-color-adjust: exact; }

        /* DATA SECTIONS */
        .section-title { background: #f0f0f0; border-top: 1px solid #000; border-bottom: 1px solid #000; font-weight: bold; padding: 3px 5px; margin-top: 10px; text-transform: uppercase; font-size: 9pt; -webkit-print-color-adjust: exact; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5px 15px; margin-top: 5px; }
        .info-row { display: flex; border-bottom: 1px dotted #ccc; padding-bottom: 1px; }
        .label { font-weight: bold; width: 120px; font-size: 9pt; color: #333; }
        .value { flex: 1; font-size: 10pt; font-weight: 500; }

        /* SIGNATURES */
        .signatures { margin-top: 40px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .sig-block { width: 40%; text-align: center; }
        .sig-line { border-top: 1px solid #000; margin-top: 30px; margin-bottom: 5px; font-weight: bold; font-size: 8pt; }
        .sig-name { font-weight: bold; text-transform: uppercase; font-size: 10pt; }
        .sig-role { font-size: 9pt; margin: 0; }
    </style>
</head>
<body>

    <div class="header">
        <p class="school-name">University of the Cordilleras</p>
        <p class="office-name">Sports Development Office</p>
        <p class="doc-title">GENERAL ATHLETE PROFILE</p>
    </div>

    <div class="profile-header">
        <div class="photo-box">
            @if($athlete->picture_path)
                <img src="{{ asset('storage/' . $athlete->picture_path) }}" alt="Photo">
            @else
                <span>NO PHOTO</span>
            @endif
        </div>
        <div class="main-info">
            <h1>{{ $athlete->last_name }}, {{ $athlete->first_name }}</h1>
            <div style="margin-top: 5px;"><strong>ID Number:</strong> {{ $athlete->student_id }}</div>
            <div class="sport-badge">{{ str_replace('_', ' ', $athlete->sport_event) }}</div>
            <div style="margin-top: 3px; font-size: 9pt;"><strong>Status:</strong> {{ str_replace('_', ' ', $athlete->classification) }} ({{ $athlete->status }})</div>
        </div>
    </div>

    <!-- Personal Information exactly matching the General Info Form -->
    <div class="section-title">Personal Information</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Course:</span> <span class="value">{{ $athlete->course ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Year/Level:</span> <span class="value">{{ $athlete->year_level ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Date of Birth:</span> <span class="value">{{ $athlete->birthdate ? \Carbon\Carbon::parse($athlete->birthdate)->format('F d, Y') : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Age:</span> <span class="value">{{ $athlete->age ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Gender:</span> <span class="value">{{ $athlete->gender ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Blood Type:</span> <span class="value">{{ $athlete->blood_type ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Civil Status:</span> <span class="value">{{ $athlete->marital_status ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Facebook Link:</span> <span class="value">{{ $athlete->facebook ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Email:</span> <span class="value">{{ $athlete->email ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Contact No:</span> <span class="value">{{ $athlete->contact_number ?? 'N/A' }}</span></div>
    </div>
    
    <div class="info-row" style="margin-top: 5px;">
        <span class="label">Home Address:</span> 
        <span class="value">
            {{ trim($athlete->address . ', ' . $athlete->city_municipality . ', ' . $athlete->province_state . ' ' . $athlete->zip_code, ', ') ?: 'N/A' }}
        </span>
    </div>

    <div class="section-title">Emergency Contact</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Contact Person:</span> <span class="value">{{ $athlete->emergency_person ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Emergency No:</span> <span class="value">{{ $athlete->emergency_contact ?? 'N/A' }}</span></div>
    </div>

    <!-- Varsity details from the General Info Form -->
    <div class="section-title">Varsity & Academic Details</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Head Coach:</span> <span class="value">{{ $athlete->coach ? $athlete->coach->coach_first_name . ' ' . $athlete->coach->coach_last_name : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Asst. Coach:</span> <span class="value">{{ $athlete->asst_coach ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Date Joined:</span> <span class="value">{{ $athlete->date_joined ? \Carbon\Carbon::parse($athlete->date_joined)->format('F d, Y') : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Total Units:</span> <span class="value">{{ $athlete->total_unit ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Term Graduated:</span> <span class="value">{{ $athlete->term_graduated ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Year Graduated:</span> <span class="value">{{ $athlete->year_graduated ? \Carbon\Carbon::parse($athlete->year_graduated)->format('Y') : 'N/A' }}</span></div>
    </div>

    <!-- Financial details from the General Info Form -->
    <div class="section-title">Financial Assessment</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Tuition Fee:</span> <span class="value">{{ $athlete->tuition_fee ? '₱' . number_format($athlete->tuition_fee, 2) : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Misc. Fee:</span> <span class="value">{{ $athlete->misc_fee ? '₱' . number_format($athlete->misc_fee, 2) : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Other Charges:</span> <span class="value">{{ $athlete->other_charges ? '₱' . number_format($athlete->other_charges, 2) : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Total Assessment:</span> <span class="value">{{ $athlete->total_assessment ? '₱' . number_format($athlete->total_assessment, 2) : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Total Discount:</span> <span class="value">{{ $athlete->total_discount ? '₱' . number_format($athlete->total_discount, 2) : 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Balance:</span> <span class="value">{{ $athlete->balance ? '₱' . number_format($athlete->balance, 2) : 'N/A' }}</span></div>
    </div>

    <!-- Work details from the General Info Form -->
    <div class="section-title">Employment Information</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Current Work:</span> <span class="value">{{ $athlete->current_work ?? 'N/A' }}</span></div>
        <div class="info-row"><span class="label">Company:</span> <span class="value">{{ $athlete->current_company ?? 'N/A' }}</span></div>
    </div>

    <div class="signatures">
        <div class="sig-block">
            <div class="sig-line">Prepared By:</div>
            <p class="sig-name">MS. DAPHNIE S. PELAEZ</p>
            <p class="sig-role">Administrative Staff, SDO</p>
        </div>
        
        <div class="sig-block">
            <div class="sig-line">Noted By:</div>
            <p class="sig-name">DR. DANILO L. CONG-O</p>
            <p class="sig-role">Director, Sports Development Office</p>
        </div>
    </div>

</body>
</html>