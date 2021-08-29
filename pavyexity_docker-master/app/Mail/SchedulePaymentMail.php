<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SchedulePaymentMail extends Mailable
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
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd('gg');
        $data = $this->data; 


        return $this->from('support@vultik.net', 'Payvexity')
            ->subject('Recurring Pyament ALert')
            ->markdown('emails.payment-receive-2-rec') 
            ->with([
                'name' => $data['name'],
                'amount' => $data['amount'],
                'sender' => $data['sender'],
                'type' => $data['type'],
            ]);
    }
}
