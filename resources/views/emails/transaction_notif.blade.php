<!DOCTYPE html>
<html>
<head>
    <title>Transaction Notification</title>
</head>
<body style="font-family: sans-serif; color: #333;">
    <h2>PayThru Transaction Alert</h2>
    <p>Hello! A successful <strong>{{ $type }}</strong> has been processed.</p>
    <ul>
        <li><strong>Amount:</strong> ₱{{ number_format($amount, 2) }}</li>
        <li><strong>Recipient/Biller:</strong> {{ $receiver }}</li>
        <li><strong>Reference:</strong> {{ $ref }}</li>
    </ul>
    <p>If you did not authorize this, please contact support immediately.</p>
</body>
</html>