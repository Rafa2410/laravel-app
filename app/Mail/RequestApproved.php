<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserRequest;

class RequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $userRequest;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserRequest $userRequest, String $subject)
    {
        $this->userRequest = $userRequest;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('mails.request_approved');
    }
}
