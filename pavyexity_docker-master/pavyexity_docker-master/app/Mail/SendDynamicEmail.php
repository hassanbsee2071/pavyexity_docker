<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\EmailManagement;

class SendDynamicEmail extends Mailable
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
        $data = $this->data;
        
        $template = EmailManagement::where('email_slug',$data['slug'])->first();

        $content = $template->parse($data);
        
        $template_array = $template->toArray();
        $template_array['email_body'] =$content;
        if($data['slug']=="Invoice-A"){
            return $this->subject($template_array['email_subject'])->view('emails.emails',$template_array)->attach($data['file_path'], [
                'mime' => 'application/pdf',
            ]);
        }else{
            return $this->subject($template_array['email_subject'])->view('emails.emails',$template_array);
        }
    }
}
