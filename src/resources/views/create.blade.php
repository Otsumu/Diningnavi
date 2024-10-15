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
        <div class="p-5">
            <div class="col-6 card" style="margin: 0 auto";>
                <div class="card-header" style="font-size: 20px; font-weight: bold; background-color: white;">Stripe決済</div>
                <div class="card-body">
                    <form id="card-form" action="{{ route('payment.store') }}" method="POST">
                        @csrf
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

                        <button class="mt-3 btn btn-primary" style="padding: 10px 20px;">支払い</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
        const stripe = Stripe(stripe_public_key);
        const elements = stripe.elements();

        var cardNumber = elements.create('cardNumber');
        cardNumber.mount('#card-number');
        cardNumber.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');
        cardExpiry.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');
        cardCvc.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        var form = document.getElementById('card-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = ''; // エラーをリセット

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('card-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
@endsection
