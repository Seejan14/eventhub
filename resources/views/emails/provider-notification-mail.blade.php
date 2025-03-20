<!DOCTYPE html>
<html>

<head>
    <title>Malla Treks</title>
</head>

<body>
    <h1>Confirmation of Booking</h1>
    <p> I am writing to confirm that the booking for {{ $booking->name }} has been successfully processed. Below
        are the details of the confirmed booking:

        Booking Reference Number: {{ $booking->id }}
        Date of Booking: {{ $booking->date }}
        Event: {{ $booking->program_title }}
        Total:{{ $booking->received }}

    <p> Please ensure that this information is duly noted in your records. Please change the status of booking to
        completed.</p>

    <p>Thank you</p>
</body>

</html>
