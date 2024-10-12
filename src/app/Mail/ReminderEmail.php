<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;
        protected $booking;
        public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking) {
        $this->booking = $booking;
        $this->subject = 'ご予約当日になりました！';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $bookings = Booking::whereDate('booking_time', now()->toDateString())->distinct('user_id')->get();

        return $this->subject($this->subject)
                    ->view('emails.reminder')
                    ->with([
                        'booking' => $this->booking,
                        'subject' => $this->subject,
                    ]);
    }
}