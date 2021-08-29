<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\EmailManagement;

class UserAccountCreatedMail extends Mailable
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
        $mail_template = EmailManagement::where('email_slug','New User')->first();
        ///dd($mail_template); 
        $emailbody= $mail_template->email_body;


        return $this->from('support@vultik.net', 'Payvexity')
            ->subject('Account Alert')
            ->markdown('emails.account-create')
            ->with([
                'name' => $data['user'],
                'sender' => $data['sender'],
                'email' => $data['email'],
                'password' => $data['password'],
                'link' => $data['link'],
                'body' =>  $emailbody,
            ]);
    }
}
