<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserRequest;

class RequestSimpleTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $userRequest;
    public $subject;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserRequest $userRequest, String $subject, String $body)
    {
        $this->userRequest = $userRequest;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('mails.simple_template');
    }
}
