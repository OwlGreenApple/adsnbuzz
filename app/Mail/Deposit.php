<?php

namespace AdsnBuzz\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Deposit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email;
    protected $balance;

    public function __construct($email, $balance)
    {
        $this->email = $email;
        $this->balance = $balance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('puspita.celebgramme@gmail.com', 'AdsnBuzz')
                                        ->subject('[AdsnBuzz] Deposit')
                                        ->view('mails.user_depositnotice') ->with('balance',$this->balance)
                                        ->with($this->email);
    }
}
