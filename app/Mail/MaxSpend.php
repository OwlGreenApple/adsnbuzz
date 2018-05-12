<?php

namespace AdsnBuzz\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MaxSpend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email;
    protected $user;

    public function __construct($email,$user)
    {
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('puspita.celebgramme@gmail.com', 'AdsnBuzz')
                                        ->subject('[AdsnBuzz] Perubahan Max Spend')
                                        ->view('mails.admin_maxspendchange') -> with('user',$this->user)
                                        ->with($this->email);
    }
}