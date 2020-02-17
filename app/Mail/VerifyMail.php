<?php

namespace FDA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $str_pass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $str_pass)
    {
        $this->user = $user;
        $this->str_pass = $str_pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.verify_user');
    }
}
