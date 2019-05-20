<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductAvailabilityNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $customer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product, $customer)
    {
        $this->product = $product;
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Product_availability_notification');
    }
}
