<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reply to Your Contact Form</title>
</head>
<body>
    <h2>Reply to Your Contact Form</h2>
    
    <p>Hello {{ $contact->name }},</p>
    
    <p>Thank you for contacting us. We have received your message regarding:</p>
    <p><strong>{{ $contact->subject }}</strong></p>
    
    <h3>Your Original Message:</h3>
    <p>{{ $contact->message }}</p>
    
    <h3>Our Reply:</h3>
    <p>{{ $contact->admin_reply }}</p>
    
    <hr>
    <p><small>This is an automated reply from MangaVerse.</small></p>
</body>
</html>






