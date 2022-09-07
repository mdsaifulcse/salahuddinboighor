<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserFeedBack extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $userFeedBack;

    public function __construct($userFeedBack)
    {
        $this->userFeedBack=$userFeedBack;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $userFeedBack=$this->userFeedBack;
        return $this->view('mail.user-FeedBack',compact('userFeedBack'));
    }
}
