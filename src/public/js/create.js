const stripe_public_key = "{{ config('stripe.stripe_public_key') }}";
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
    errorElement.textContent = '';

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

    var hiddenInputBooking = document.createElement('input');
    hiddenInputBooking.setAttribute('type', 'hidden');
    hiddenInputBooking.setAttribute('name', 'booking_id');
    hiddenInputBooking.setAttribute('value', document.querySelector('input[name="booking_id"]').value);
    form.appendChild(hiddenInputBooking);

    form.submit();
}
