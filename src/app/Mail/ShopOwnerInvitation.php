<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopOwnerInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationUrl;

    /**
     * Create a new message instance.
     *
     * @param string $invitationUrl
     * @return void
     */
    public function __construct($invitationUrl)
    {
        $this->invitationUrl = $invitationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('shop_owner.register')
                    ->with([
                        'invitationUrl' => $this->invitationUrl,
                    ])
                    ->subject('店舗代表者登録のご案内');
    }
}
