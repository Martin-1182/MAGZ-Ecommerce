@extends('layout')

@section('title', 'Checkout')

@section('extra-css')
<script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')

<div class="container">

    @if (session()->has('success_message'))
    <div class="spacer"></div>
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if(count($errors) > 0)
    <div class="spacer"></div>
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h1 class="checkout-heading stylish-heading">Pokladňa</h1>
    <div class="checkout-section">
        <div>
            <form action="{{ route('checkout.store')}}" method="POST" id="payment-form">
                @csrf
                <h2>Fakturačné údaje</h2>

                <div class="form-group">
                    <label for="email">Emailová Addresa</label>
                    @if (auth()->user())
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}"
                        readonly>
                    @else
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        required>
                    @endif
                </div>
                <div class="form-group">
                    <label for="name">Meno</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="address">Adresa</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"
                        required>
                </div>

                <div class="half-form">
                    <div class="form-group">
                        <label for="city">Mesto</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="province">Štát</label>
                        <input type="text" class="form-control" id="province" name="province"
                            value="{{ old('province') }}" required>
                    </div>
                </div> <!-- end half-form -->

                <div class="half-form">
                    <div class="form-group">
                        <label for="postalcode">PSČ</label>
                        <input type="text" class="form-control" id="postalcode" name="postalcode"
                            value="{{ old('postalcode') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefón</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}"
                            required>
                    </div>
                </div> <!-- end half-form -->

                <div class="spacer"></div>

                <h2>Platobné údaje</h2>

                <div class="form-group">
                    <label for="name_on_card">Meno na karte</label>
                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
                </div>
                <div class="form-group">
                    <label for="card-element">
                        Kreditná alebo debetná karta
                    </label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <div class="spacer"></div>
                <button type="submit" id="complete-order" class="button-primary full-width">UHRADIŤ OBJEDNÁVKU</button>


            </form>
            <div class="note alert alert-danger">
                <h4>Testovacia karta:</h4>
                <code>4242 4242 4242 4242 04/22 222</code>
            </div>
        </div>


        <div class="checkout-table-container">
            <h2>Vaša objednávka</h2>

            <div class="checkout-table">
                @foreach (Cart::content() as $item)
                <div class="checkout-table-row">
                    <div class="checkout-table-row-left">
                        <img src="{{ asset('storage/'.$item->model->image) }}" alt="item" class="checkout-table-img">
                        <div class="checkout-item-details">
                            <div class="checkout-table-item">{{ $item->model->name }}</div>
                            <div class="checkout-table-description">{{ $item->model->details }}</div>
                            <div class="checkout-table-price">{{ $item->model->presentPrice() }}</div>
                        </div>
                    </div> <!-- end checkout-table -->

                    <div class="checkout-table-row-right">
                        <div class="checkout-table-quantity">{{ $item->qty }}</div>
                    </div>
                </div> <!-- end checkout-table-row -->
                @endforeach
            </div> <!-- end checkout-table -->

            <div class="checkout-totals">
                <div class="checkout-totals-left">
                    Priebežne <br>
                    @if (session()->has('coupon'))
                    Zľava ({{ session()->get('coupon')['name'] }}) :
                    <br>
                    <hr>
                    Po Zľave <br>
                    @endif
                    DPH ({{config('cart.tax')}}%)<br>
                    <span class="checkout-totals-total">Spolu</span>

                </div>

                <div class="checkout-totals-right">
                    {{ presentPrice(Cart::subtotal()) }} <br>
                    @if (session()->has('coupon'))
                    -{{ presentPrice($discount) }} <br>
                    <hr>
                    {{ presentPrice($newSubtotal) }} <br>
                    @endif
                    {{ presentPrice($newTax) }} <br>
                    <span class="checkout-totals-total">{{ presentPrice($newTotal) }}</span>

                </div>
            </div> <!-- end checkout-totals -->

        </div>

    </div> <!-- end checkout-section -->
</div>

@endsection

@section('extra-js')

<script type="application/javascript">
    (function () {
       // Create a Stripe client.
    let stripe =
    Stripe('pk_test_51GxS7bGKFvN7n9kqPedirgv9MD425nS6bNCwVQvcJ6TMY19wNio06VejrnL2DmAaL91QyQU8TfRel4QBnbtGSFgl00I0X0j9FR');

    // Create an instance of Elements.
    let elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    let style = {
    base: {
    color: '#32325d',
    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
    color: '#aab7c4'
    }
    },
    invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
    }
    };

         // Create an instance of the card Element.
        let card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
        displayError.textContent = event.error.message;
        } else {
        displayError.textContent = '';
        }
        });

        // Create a token or display an error when the form is submitted.
        let form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Disabled the submit button to prevent repeater cliks
        document.getElementById('complete-order').disabled = true;

        let options = {
            name: document.getElementById('name_on_card').value,
            address_line1: document.getElementById('address').value,
            address_city: document.getElementById('city').value,
            address_state: document.getElementById('province').value,
            address_zip: document.getElementById('postalcode').value,
        }

        stripe.createToken(card, options).then(function(result) {
        if (result.error) {
        // Inform the customer that there was an error.
        let errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;

        // Enable the submit buttton
        document.getElementById('complete-order').disabled = false;

        } else {
        // Send the token to your server.
        stripeTokenHandler(result.token);
        }
        });
        });

        function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        let form = document.getElementById('payment-form');
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
        }
   })();
</script>
@endsection
