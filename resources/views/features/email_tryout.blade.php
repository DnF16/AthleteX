<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; border-top: 5px solid #2e4e1f; }
        .header { font-size: 20px; font-weight: bold; color: #2e4e1f; margin-bottom: 20px; }
        .details { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .details ul { list-style: none; padding: 0; }
        .details li { margin-bottom: 10px; font-size: 16px; }
        .footer { margin-top: 30px; font-size: 14px; color: #777; border-top: 1px solid #ddd; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Sports Development Office - Tryout Schedule</div>
        
        <p>Hello <strong>{{ $athlete->first_name }}</strong>,</p>
        <p>Thank you for registering for the <strong>{{ str_replace('_', ' ', $schedule->sport_event) }}</strong> tryouts. Your application has been received!</p>
        
        <p>Here are the official details for your tryout. Please make sure to be there on time:</p>
        
        <div class="details">
            <ul>
                <li>📅 <strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->tryout_date)->format('F d, Y') }}</li>
                <li>⏰ <strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->tryout_time)->format('h:i A') }}</li>
                <li>📍 <strong>Venue:</strong> {{ $schedule->venue }}</li>
                @if($schedule->notes)
                    <li>📝 <strong>Notes:</strong> {{ $schedule->notes }}</li>
                @endif
            </ul>
        </div>

        <p>Please present this email or your ID to the coaches upon arrival. Good luck!</p>

        <div class="footer">
            This is an automated message from the SDO System. Please do not reply.
        </div>
    </div>
</body>
</html>