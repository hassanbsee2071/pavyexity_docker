<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteUsers extends Mailable
{
    use Queueable, SerializesModels;
    public $request, $invitation_template;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $invitation_template)
    {
        $this->request = $request;
        $this->invitation_template = $invitation_template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html($this->invitation_template);
    }
}
