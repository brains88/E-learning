<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\{User,withdrawal};

class WithdrawalSubmittedMail extends Mailable
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
            ->subject('Withdrawal Request Submitted')
            ->view('emails.withdrawals')
            ->with([
                'transactionId' => $this->transactionId,
                'amount' => $this->amount,
            ]);
    }
}
