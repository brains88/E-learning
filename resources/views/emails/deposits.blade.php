<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit </title>
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
            max-width: 150px;
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
        <h2>Deposit Request Submitted</h2>
        <p>Dear User,</p>
        <p>Your Deposit request has been successfully submitted.</p>
        <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
        <p><strong>Amount:</strong> ${{ number_format($amount, 2) }}</p>
        <p>We are processing your request and will notify you once it has been completed.</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Equitify Trades. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
