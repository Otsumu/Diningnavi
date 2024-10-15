<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
  public function store(BookingRequest $request) {
    if (!Auth::check()) {
        session()->flash('menu2-error', '会員登録、もしくはログインが必要です');
        return view('user.menu2');
    }

        $data = $request->only(['shop_id', 'booking_date', 'booking_time', 'number']);
        $data['user_id'] = Auth::id();
        $booking = Booking::create($data);

        $this->sendConfirmationEmail($booking->id);

        $request->session()->forget(['booking_date', 'booking_time', 'number']);
    
        return redirect()->route('booking.done');
  }

  public function done() {
        return view('booking.done');
  }

  protected function sendConfirmationEmail($bookingId) {
      $url = route('booking.show', ['id' => $bookingId]);
      $qrCode = QrCode::size(300)->generate($url);
  
      Mail::to(Auth::user()->email)->send(new BookingConfirmationMail($qrCode, $url));
  }

  public function showUserBookings() {
      $user = Auth::user();
      $bookings = Booking::where('user_id', $user->id)->with('shop')->get();

      return view('user.users.mypage', compact('bookings'));
  }

  public function generateQRCode($bookingId) {
      $url = route('booking.show', ['id' => $bookingId]);
      $qrCode = QrCode::size(300)->generate($url);

      return view('booking.qrcode', compact('qrCode', 'url'));
  }

  public function showBooking($id) {
      $booking = Booking::find($id);
      if (!$booking) {
      return redirect()->back();
    }
      return view('booking.show', compact('booking'));
  }
}
