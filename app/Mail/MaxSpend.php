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
    protected $maxspendnew;

    public function __construct($email,$user,$maxspendnew)
    {
        $this->email = $email;
        $this->user = $user;
        $this->maxspendnew = $maxspendnew;
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
                                        ->view('mails.admin_maxspendchange') 
                                        ->with('user',$this->user)
                                        ->with('maxspendnew',$this->maxspendnew)
                                        ->with($this->email);
    }
}