<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailReset extends Mailable
{
    use Queueable, SerializesModels;


    public $captcha;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email_reset')
                    ->text('emails.email_reset_text')
                    ->subject('百步梯修改邮箱验证码');
    }
}
