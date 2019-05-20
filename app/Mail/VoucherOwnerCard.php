<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoucherOwnerCard extends Mailable
{
    use Queueable, SerializesModels;

    public $card;
    public $gift;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($card , $gift) 
    {
        $this->card = $card;
        $this->gift = $gift;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.OwnerCard');
    }
}
