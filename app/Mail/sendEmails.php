<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendEmails extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $view;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user = null, $view = null, $subject = "OSC Blog")
    {
        $this->user = $user;
        $this->view = $view;
        $this->subject = $subject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->subject($this->subject)->view($this->view)->with("user", $this->user);

    }
}
