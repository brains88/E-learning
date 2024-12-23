<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; 
    public $verificationCode;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param int $verificationCode
     */
    public function __construct($user, $verificationCode)
    {
        $this->user = $user;
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->view('emails.welcome')
                    ->with([
                        'name' => $this->user->name, // Pass the user's name
                        'code' => $this->verificationCode, // Pass the verification code
                    ]);
    }
}
