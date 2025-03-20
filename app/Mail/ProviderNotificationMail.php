<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProviderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */


    public function build()
    {
        return $this->view('emails.provider-notification-mail')->with([
            'booking' => $this->booking,
        ]);;
    }
}
