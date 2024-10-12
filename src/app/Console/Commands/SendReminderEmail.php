<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Mail\ReminderEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to customers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $bookings = Booking::whereDate('booking_date', $today)->get();
        foreach($bookings as $booking) {
            Mail::to($booking->user->email)->send(new \App\Mail\ReminderEmail($booking));
            $this->info('Reminder sent to: '. $booking->user->email);
        }
        return 0;
    }
}
