<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPaymentLinkMail extends Mailable
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


        return $this->from('support@vultik.net', 'Invoice Alert')
            ->subject('Payment Alert')
            ->markdown('emails.payment-receive') 
            ->with([
                'name' => $data['user'],
                'link' => $data['link'],
                'sender' => $data['sender'],
            ]);
    }
}
