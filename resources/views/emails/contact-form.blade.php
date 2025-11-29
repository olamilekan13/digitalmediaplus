<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .field-value {
            color: #111827;
            font-size: 16px;
            padding: 10px;
            background: white;
            border-radius: 4px;
            border-left: 3px solid #f97316;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-radius: 4px;
            border-left: 3px solid #f97316;
            white-space: pre-wrap;
            color: #111827;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">New Contact Message</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">You have received a new message from your website</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name</div>
            <div class="field-value">{{ $contactMessage->name }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value">
                <a href="mailto:{{ $contactMessage->email }}" style="color: #f97316; text-decoration: none;">
                    {{ $contactMessage->email }}
                </a>
            </div>
        </div>

        @if($contactMessage->phone)
        <div class="field">
            <div class="field-label">Phone</div>
            <div class="field-value">
                <a href="tel:{{ $contactMessage->phone }}" style="color: #f97316; text-decoration: none;">
                    {{ $contactMessage->phone }}
                </a>
            </div>
        </div>
        @endif

        <div class="field">
            <div class="field-label">Message</div>
            <div class="message-box">{{ $contactMessage->message }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from your website's contact form.</p>
        <p>Please respond to this inquiry as soon as possible.</p>
    </div>
</body>
</html>

