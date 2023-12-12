<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Alert Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #3498db;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .thank-you {
            font-weight: bold;
            color: #27ae60;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Daily Alert Notification</h1>
    <p>Dear <strong>{{ $alert->user->name }}</strong>,</p>
    <p>Your daily alert condition has been met.</p>
    <p>The max quantity of cattle found was: <strong>{{ $totalQuantity }}</strong>. We recommend that you visit the location to avoid losses.</p>
    <p class="thank-you">Thank you for using our service!</p>
</div>
</body>
</html>
