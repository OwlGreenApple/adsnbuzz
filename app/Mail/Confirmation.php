<?php

namespace AdsnBuzz\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('puspita.celebgramme@gmail.com', 'AdsnBuzz')
                                        ->subject('[AdsnBuzz] Konfirmasi Order Deposit')
                                        ->view('mails.user_confirmnotice') 
                                        ->with($this->email);
    }
}
