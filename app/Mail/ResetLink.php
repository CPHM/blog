<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetLink extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    public function __construct($token)
    {
        $this->url = route('password.reset', ['token' => $token]);
    }

    public function build()
    {
        return $this->view('emails.reset-link');
    }
}
