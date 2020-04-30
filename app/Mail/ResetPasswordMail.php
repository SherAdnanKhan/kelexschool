<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $reset_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset_details)
    {
        $this->reset_details = $reset_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account Details Recovery')->markdown('emails.reset_password');
    }
}
