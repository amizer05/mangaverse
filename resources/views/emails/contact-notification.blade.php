<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
        }
        .field-label {
            font-weight: 600;
            color: #6366f1;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .field-value {
            color: #1f2937;
            font-size: 16px;
        }
        .message-box {
            background-color: #f9fafb;
            border-left: 4px solid #6366f1;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 New Contact Form Submission</h1>
        </div>
        
        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value">{{ $contact->name }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $contact->email }}" style="color: #6366f1; text-decoration: none;">
                    {{ $contact->email }}
                </a>
            </div>
        </div>
        
        <div class="field">
            <div class="field-label">Subject</div>
            <div class="field-value">{{ $contact->subject }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Message</div>
            <div class="message-box">
                {{ nl2br(e($contact->message)) }}
            </div>
        </div>
        
        <div class="field">
            <div class="field-label">Submitted</div>
            <div class="field-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
        
        @if($contact->ip_address)
        <div class="field">
            <div class="field-label">IP Address</div>
            <div class="field-value" style="font-size: 12px; color: #6b7280;">{{ $contact->ip_address }}</div>
        </div>
        @endif
        
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}/admin/contacts/{{ $contact->id }}" class="button">
                View in Admin Panel
            </a>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from {{ config('app.name') }}.</p>
            <p>Please respond to the user at: <a href="mailto:{{ $contact->email }}" style="color: #6366f1;">{{ $contact->email }}</a></p>
        </div>
    </div>
</body>
</html>
