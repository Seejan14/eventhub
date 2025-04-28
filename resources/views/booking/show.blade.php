@extends('layouts.index', [
    'title' => 'Bookings',
    'activePage' => 'Bookings',
    'subPage' => 'View',
])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header">
                        <h6>Booking Details</h6>
                    </div>
                    <hr class="horizontal dark">

                    <div class="info-data">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Event:</strong> {{ $booking->event->title }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Status:</strong>
                                    @if ($booking->status == 1)
                                        <span class="text-danger">Pending</span>
                                    @elseif($booking->status == 2)
                                        <span class="text-primary">Approved</span>
                                    @elseif($booking->status == 4)
                                        <span class="text-success">Completed</span>
                                    @else
                                        <span class="text-danger">Cancelled</span>
                                    @endif
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Ticket Number:</strong> {{ $booking->booking_number }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Date:</strong> {{ $booking->booking_date }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Number of People:</strong> {{ $booking->number_of_people }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Special Requirements:</strong> {{ $booking->special_requirements }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Total Amount:</strong> ${{ $booking->total_amount }}</h6>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark">
                    <div class="card-header">
                        <h6>Booked By:</h6>
                    </div>
                    <hr class="horizontal dark">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Name:</strong> {{ $booking->customerAddress->name }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Email:</strong> {{ $booking->customerAddress->email }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Phone Number:</strong> {{ $booking->customerAddress->phone }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Country:</strong> {{ $booking->customerAddress->country }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>City:</strong> {{ $booking->customerAddress->city }}</h6>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('bookings') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Bookings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.js_loader')

        <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                var status = '';
                var bookingId = "{{ $booking->id }}";

                $('.change').click(function() {
                    var action = $(this).data('action');
                    status = action === 'cancel' ? 'cancel' : 'accept';

                    $('#staticBackdropLabel').html(`Are you sure to ${status} the booking?`);
                    $('#modal-text').html(
                        `This will ${status === 'cancel' ? 'cancel' : 'approve'} the booking.`);
                });

                $('#confirm-button').click(function() {
                    var url = `bookings/${bookingId}/${status}`;
                    $.ajax({
                        url: `{{ url('${url}') }}`,
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                location.reload();
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
