<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

        public $qrCode;
        public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($qrCode, $url) {
        $this -> qrCode = $qrCode;
        $this -> url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('booking.qrcode')
                    ->subject('ご予約の確認')
                    ->with([
                        'qrCode' => $this->qrCode,
                        'url' => $this->url,
                    ]);
    }
}
