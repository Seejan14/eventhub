<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $pdfContent;
    

    
    public function __construct($booking, $pdfContent)
    {
        $this->booking = $booking;
        $this->pdfContent = $pdfContent;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */


    public function build()
    {
        return $this->view('emails.booking-confirm-mail')->with([
            'booking' => $this->booking,
        ]) ->attachData($this->pdfContent->output(), "invoice.pdf", [
            'mime' => 'application/pdf',
        ]);
    }
}
