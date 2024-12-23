<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 200px;
        }
        .details {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://www.equitifytrades.com/assets/img/logo.png" alt="Company Logo">
        </div>
        <h2>Verification Code</h2>
        <h1>Welcome to Equitify Trades</h1>
            <p>Thank you for signing up. Please use the following code to verify your account:</p>
            <h3>{{ $code }}</h3>
            <p>We look forward to serving you.</p>
    </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Equitify Trades. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
