<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\EmailManagement;

class CompanyAccountCreatedMail extends Mailable
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
        $mail_template = EmailManagement::where('email_slug','Acc Alert')->first();
        ///dd($mail_template); 
        $emailbody= $mail_template->email_body;
        return $this->from('support@vultik.net', 'Payvexity')
            ->subject('Company acc alert')
            ->markdown('emails.company-create')
            ->with([
                'name' => $data['name'],
                'root' => $data['root'],
                'email' => $data['email'],
                'body' =>  $emailbody,

            ]);
    }
}
