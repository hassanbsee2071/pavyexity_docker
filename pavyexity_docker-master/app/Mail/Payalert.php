<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Payalert extends Mailable
{
    use Queueable, SerializesModels;
    public $request,$payalert_template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request,$payalert_template)
    {
        $this->request = $request;
        $this->payalert_template = $payalert_template;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->html($this->payalert_template);
    }
}
