<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceivePayment extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data; 


        return $this->from('support@vultik.net', 'Payment Alert')
            ->subject('Payment Alert')
            ->markdown('emails.payment-receive-2') 
            ->with([
                'name' => $data['name'],
                'amount' => $data['amount'],
                'sender' => $data['sender'],
            ]);
    }
}
