<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PdfMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdfPath = public_path('assets/pdf/test.pdf');

        return $this->view('emails.pdf-mail')
                    ->attach($pdfPath, [
                        'as' => 'test.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
