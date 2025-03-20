<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #f4f4f4;
        }

        .content {
            padding: 20px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f4f4f4;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Reset Your Password</h2>
        </div>

        <div class="content">
            <p>Hello {{ $user->name }},</p>

            <p>You are receiving this email because we received a password reset request for your account.</p>

            <p style="text-align: center;">
                <a href={{ $resetUrl }} class="button" style="color: white;">Reset Password</a>
            </p>

            <p>This password reset link will expire in 60 minutes.</p>

            <p>If you did not request a password reset, no further action is required.</p>
        </div>

        <div class="footer">
            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
                browser:</p>
            <p style="word-break: break-all;">{{ $resetUrl }}</p>
        </div>
    </div>
</body>

</html>
