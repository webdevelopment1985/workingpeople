<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Query</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd;
        }
        .header {
            background: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }
        .content .highlight {
            background: #f1f9ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-style: italic;
            color: #333;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            font-size: 16px;
            margin: 5px 0;
            color: #333;
        }
        .footer {
            background: #f9f9f9;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #ddd;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>New Query from a User</h1>
        </div>
        <!-- Content -->
        <div class="content">
            <p>Hello Admin,</p>
            <p>You have received a new query from a user. Here are the details:</p>
            <div class="details">
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
            </div>
            <div class="highlight">
                <strong>Message:</strong>
                <p>{{ $userMessage }}</p>
            </div>
            <!-- <p>Please address this query at your earliest convenience.</p> -->
        </div>
        <!-- Footer -->
        <!-- <div class="footer">
            <p>Thank you for using our platform!</p>
            <p><a href="mailto:{{ $email }}">Reply to User</a></p>
        </div> -->
    </div>
</body>
</html>
