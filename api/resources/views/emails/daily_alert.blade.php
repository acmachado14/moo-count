<!DOCTYPE html>
<html>
<head>
    <title>Daily Alert Notification</title>
</head>
<body>
<h1>Daily Alert Notification</h1>
<p>Dear {{ $alert->user->name }},</p>
<p>Your daily alert condition has been met.</p>
<p>Total quantity of cattle: {{ $totalQuantity }}</p>
<p>Thank you for using our service!</p>
</body>
</html>
