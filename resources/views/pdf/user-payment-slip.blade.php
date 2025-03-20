@php
    $currentTime = \Carbon\Carbon::now();
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>Malla Treks</title>
    {{-- <style>
        body {
            padding: 2.5rem;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
        }

        .slip {
            justify-content: start;
            display: flex;
        }

        .image-container {
            height: 25px;
            width: 110px;
        }

        .image {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .user-details,
        p {
            padding: 0 0 2rem 2rem;
        }

        table {
            border-spacing: 0 8px;
            border-collapse: separate;
            width: 100%;
        }

        thead>tr>th {
            text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;
        }

        thead>tr,
        tbody>tr {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }


        tbody>tr>td {
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;
        }
    </style> --}}
</head>

<body style="padding: 2.5rem">
    <div style="display: grid; grid-template-columns:1fr 1fr; align-items:center">
        <div class="image-container" style="height: 25px; width:110px">
            <img src="assets/img/logo1.png" alt="logo" class="image"
                style="height: 100%; width:100%; object-fit:cover">
        </div>
        <div class="header-data">
            <h3 class="slip" style="display: flex; justify-content:start">Payment Receipt</h3>
        </div>
    </div>
    {{-- <p> We are delighted to confirm your booking with us! Below are the details of your reservation: </p> --}}
    <p class="user-details" style="padding: 0 0 2rem 0"> Date:{{ $currentTime->format('Y-m-d') }}<br><br>
        Name: {{ $booking->name }}
        <br><br>
        Email: {{ $booking->email }}

    </p>

    <table class="user-details" style="padding: 0 0 2rem 0; border-spacing:0 8px; border-collapse:separate; width:100%">
        <thead>
            <tr style=" box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);">
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    Program Name</th>
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    Payment Type</th>
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    No. of People</th>
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    Booking Date</th>
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    Total Price</th>
                <th
                    style="text-align: center;
            color: #5e5e5e;
            background: aliceblue;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    Received Price</th>
            </tr>
        </thead>
        <tbody>
            <tr style=" box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);">
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    {{ $booking->program_title }} </td>
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    {{ $booking->payment_type == 1 ? 'Full Price' : 'Deposit' }}</td>
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    {{ $booking->num_of_seats }}</td>
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    {{ $booking->date }}</td>
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    ${{ $booking->total }}</td>
                <td
                    style="
            text-align: center;
            color: #5e5e5e;
            font-size: 14px;
            font-style: normal;
            text-transform: capitalize;
            font-weight: 400;
            line-height: 38px;">
                    ${{ $booking->received }}</td>
            </tr>

        </tbody>
    </table>

    <p style=" padding: 0 0 2rem 0;">For any Queries, Please Call at 9811568734 or mail <br><br>
        us at <span style="color: #0000FF"> support@yogsewa.com </span>
    </p>
    <p style=" padding: 0 0 2rem 0;">Regards
        <br><br>
        Yogsewa
    </p>
</body>

</html>
