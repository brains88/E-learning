<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DepositSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transactionId;
    public $amount;

    /**
     * Create a new message instance.
     *
     * @param string $transactionId
     * @param float $amount
     */
    public function __construct(string $transactionId, float $amount)
    {
        $this->transactionId = $transactionId;
        $this->amount = $amount;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
        ->subject('Deposit Request Submitted')
        ->view('emails.deposits') // Correct the view name
        ->with([
            'transactionId' => $this->transactionId,
            'amount' => $this->amount,
        ]);
    
    }
}
