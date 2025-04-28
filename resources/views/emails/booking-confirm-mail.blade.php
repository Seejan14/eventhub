<!DOCTYPE html>
<html>

<head>
    <title>Booking Confirmation - Event Hub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }

        h1 {
            color: #1a73e8;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .details p {
            margin: 5px 0;
        }

        .cta-button {
            display: block;
            width: 100%;
            text-align: center;
            background-color: #1a73e8;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #125abd;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>🎉 Ticket Confirmed!</h1>

        <p>Dear <strong>{{ $booking->customerAddress->name }}</strong>,</p>

        <p>We are delighted to confirm your ticket with **Event Hub**! Below are the details of your
            reservation:</p>

        <div class="details">
            <p><strong>📌 Ticket Number:</strong> {{ $booking->booking_number }}</p>
            <p><strong>📅 Booking Date:</strong> {{ $booking->booking_date }}</p>
            <p><strong>🏔 Program Name:</strong> {{ $booking->event->title }}</p>
            <p><strong>👥 Number of People:</strong> {{ $booking->number_of_people }}</p>
            <p><strong>💰 Total Cost:</strong> ${{ number_format($booking->total_amount, 2) }}</p>
            <p><strong>📋 Special Requirements:</strong> {{ $booking->special_requirements ?? 'None' }}</p>
        </div>

        <p>Please ensure to review the information provided above and inform us immediately if there are any
            discrepancies.</p>

        <p>For any questions or concerns, feel free to reach out to us at
            <a href="mailto:info@eventhub.com">info@eventhub.com</a>.
        </p>

        <p>Thank you for choosing Event Hub. We look forward to seeing you soon!</p>

        <p>Visit us at:
            <a href="#">Event Hub</a>
        </p>

        <p>Best regards,<br>

        <p class="footer">🌍 Event Hub | Contact: info@eventhub.com</p>
    </div>

</body>

</html>
