<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoucherCard extends Mailable
{
    use Queueable, SerializesModels;

    public $card;
    public $gift;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($card , $gift , $user)
    {
        $this->card = $card;
        $this->gift = $gift;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Card')->subject("Voucher Gift");
    }
}
