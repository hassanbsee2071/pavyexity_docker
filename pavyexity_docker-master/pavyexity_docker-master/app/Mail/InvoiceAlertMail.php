<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\EmailManagement;

class InvoiceAlertMail extends Mailable
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
        
        $mail_template = EmailManagement::where('email_slug','Invoice Aler')->first();
        $emailbody= $mail_template->email_body;
        //dd($mail_template);
        return $this->from('support@vultik.net', 'Invoice Alert')
            ->subject('Invoice Alert')
            ->attach($data['file_path'])
            ->markdown('emails.invoice')
            ->with([
                'name' => $data['user'],
                'login' => $data['paymentlink'],
                'body' =>  $emailbody,
            ]);
    }

}
