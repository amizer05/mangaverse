<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    
    <h3>Message:</h3>
    <p>{{ $contact->message }}</p>
    
    <hr>
    <p><small>Submitted on: {{ $contact->created_at->format('F j, Y g:i A') }}</small></p>
</body>
</html>










