@extends('layouts.app')

@section('content')
    <div class="container" style=" text-align: center; font-size: 16px;">
        @if (session('flash_alert'))
            <div class="alert alert-danger">{{ session('flash_alert') }}</div>
        @elseif(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="p-5">
            <div class="col-6 card" style="margin: 0 auto";>
                <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: white;">Stripe決済</div>
                <div class="card-body">
                    <form id="card-form" action="{{ route('payment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <div>
                            <label for="card_number" style="margin-top: 5px;">カード番号</label>
                            <div id="card-number" class="form-control"
                                style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div>
                            <label for="card_expiry" style="margin-top: 5px;">有効期限</label>
                            <div id="card-expiry" class="form-control"
                                style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div>
                            <label for="card-cvc" style="margin-top: 5px;">セキュリティコード</label>
                            <div id="card-cvc" class="form-control"
                                style="padding: 10px; margin-top: 5px; height: 40px;"></div>
                        </div>

                        <div id="card-errors" class="text-danger"></div>

                        <a href="{{ route('user.users.mypage') }}" class="mt-3 btn btn-secondary" style="padding: 10px 20px;">戻る</a>
                        <button class="mt-3 btn btn-primary" type="submit" style="padding: 10px 20px;">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/create.js') }}"></script>
@endsection
