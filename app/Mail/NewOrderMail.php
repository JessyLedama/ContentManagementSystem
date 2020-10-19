<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;

class NewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Order placed.
     * 
     * @var \App\Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $order->load('customer', 'address', 'catalogue');

        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->order->customer->email)
                    ->subject('New Order from Alami Home Fashions')
                    ->markdown('mail.new-order');
    }
}
