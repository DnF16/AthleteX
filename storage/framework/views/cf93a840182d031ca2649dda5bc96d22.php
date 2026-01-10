<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlete Profile - <?php echo e($athlete->last_name); ?></title>
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
        .label { font-weight: bold; width: 110px; font-size: 9pt; color: #333; }
        .value { flex: 1; font-size: 10pt; font-weight: 500; }

        /* ACHIEVEMENTS BOX (Compact) */
        .achievements-box { border: 1px solid #ccc; padding: 10px; min-height: 40px; font-size: 9pt; }

        /* SIGNATURES (Pulled up to fit) */
        .signatures { margin-top: 30px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .sig-block { width: 40%; text-align: center; }
        .sig-line { border-top: 1px solid #000; margin-top: 30px; margin-bottom: 5px; font-weight: bold; font-size: 8pt; }
        .sig-name { font-weight: bold; text-transform: uppercase; font-size: 10pt; }
        .sig-role { font-size: 9pt; margin: 0; }
        
        /* BUTTONS */
        .toolbar { position: fixed; top: 10px; right: 10px; background: white; padding: 10px; border: 1px solid #ccc; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 5px; z-index: 1000; }
        .btn { background: #2e4e1f; color: white; border: none; padding: 8px 15px; cursor: pointer; font-weight: bold; border-radius: 4px; font-size: 10pt; }
    </style>
</head>
<body>

    <div class="toolbar no-print">
        <button onclick="window.print()" class="btn">🖨️ Print / Save PDF</button>
    </div>

    <div class="header">
        <p class="school-name">University of the Cordilleras</p>
        <p class="office-name">Sports Development Office</p>
        <p class="doc-title">ATHLETE PROFILE REPORT</p>
    </div>

    <div class="profile-header">
        <div class="photo-box">
            <?php if($athlete->picture_path): ?>
                <img src="<?php echo e(asset($athlete->picture_path)); ?>" alt="Photo">
            <?php else: ?>
                <span>NO PHOTO</span>
            <?php endif; ?>
        </div>
        <div class="main-info">
            <h1><?php echo e($athlete->last_name); ?>, <?php echo e($athlete->first_name); ?> <?php echo e(substr($athlete->middle_name, 0, 1)); ?>. <?php echo e($athlete->suffix); ?></h1>
            <div style="margin-top: 5px;"><strong>ID Number:</strong> <?php echo e($athlete->student_id); ?></div>
            <div class="sport-badge"><?php echo e(str_replace('_', ' ', $athlete->sport_event)); ?></div>
            <div style="margin-top: 3px; font-size: 9pt;"><strong>Status:</strong> <?php echo e($athlete->classification); ?> (<?php echo e($athlete->status); ?>)</div>
        </div>
    </div>

    <div class="section-title">Personal Information</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Course/Program:</span> <span class="value"><?php echo e($athlete->course); ?></span></div>
        <div class="info-row"><span class="label">Year Level:</span> <span class="value"><?php echo e($athlete->year_level); ?></span></div>
        <div class="info-row"><span class="label">College:</span> <span class="value"><?php echo e($athlete->college); ?></span></div>
        <div class="info-row"><span class="label">Date of Birth:</span> <span class="value"><?php echo e($athlete->birthdate ? $athlete->birthdate->format('F d, Y') : '-'); ?></span></div>
        <div class="info-row"><span class="label">Age:</span> <span class="value"><?php echo e($athlete->age); ?></span></div>
        <div class="info-row"><span class="label">Gender:</span> <span class="value"><?php echo e($athlete->gender); ?></span></div>
        <div class="info-row"><span class="label">Nationality:</span> <span class="value"><?php echo e($athlete->nationality); ?></span></div>
        <div class="info-row"><span class="label">Civil Status:</span> <span class="value"><?php echo e($athlete->marital_status); ?></span></div>
        <div class="info-row"><span class="label">Email:</span> <span class="value"><?php echo e($athlete->email); ?></span></div>
        <div class="info-row"><span class="label">Contact No:</span> <span class="value"><?php echo e($athlete->contact_number); ?></span></div>
    </div>
    
    <div class="info-row" style="margin-top: 5px;">
        <span class="label">Home Address:</span> 
        <span class="value"><?php echo e($athlete->address); ?>, <?php echo e($athlete->city_municipality); ?>, <?php echo e($athlete->province_state); ?></span>
    </div>

    <div class="section-title">Physical Attributes</div>
    <div class="info-grid" style="grid-template-columns: 1fr 1fr 1fr;">
        <div class="info-row"><span class="label" style="width: 50px;">Height:</span> <span class="value"><?php echo e($athlete->height); ?> cm</span></div>
        <div class="info-row"><span class="label" style="width: 50px;">Weight:</span> <span class="value"><?php echo e($athlete->weight); ?> kg</span></div>
        <div class="info-row"><span class="label" style="width: 70px;">Blood Type:</span> <span class="value"><?php echo e($athlete->blood_type); ?></span></div>
    </div>

    <div class="section-title">Emergency Contact</div>
    <div class="info-grid">
        <div class="info-row"><span class="label">Contact Person:</span> <span class="value"><?php echo e($athlete->emergency_person); ?></span></div>
        <div class="info-row"><span class="label">Relationship:</span> <span class="value"><?php echo e($athlete->emergency_relationship); ?></span></div>
        <div class="info-row" style="grid-column: span 2;"><span class="label">Emergency No:</span> <span class="value"><?php echo e($athlete->emergency_contact); ?></span></div>
    </div>

    <div class="section-title">Sports Achievements</div>
    <div class="achievements-box">
        <?php if(method_exists($athlete, 'achievements') && $athlete->achievements->count() > 0): ?>
            <table width="100%" style="border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #000;">
                    <th align="left" width="20%">Date</th>
                    <th align="left">Event / Competition</th>
                    <th align="left" width="25%">Award</th>
                </tr>
                <?php $__currentLoopData = $athlete->achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><?php echo e($ach->date); ?></td><td><?php echo e($ach->name); ?></td><td><?php echo e($ach->award); ?></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php else: ?>
            <i style="color: #666;">No recorded achievements in the system yet.</i>
        <?php endif; ?>
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
</html><?php /**PATH D:\xampp\htdocs\AthleteX\resources\views/features/print_profile.blade.php ENDPATH**/ ?>