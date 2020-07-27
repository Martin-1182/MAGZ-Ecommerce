@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/"><i class="fa fa-home"></i> Domov</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Obchod</span>
@endcomponent <!-- end breadcrumbs -->

<div class="cart-section container">
    <div>
        @if (session()->has('success_message'))
        <div class="alert alert-success">
            {{ session()->get('success_message') }}
        </div>
        @endif

        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (Cart::count() > 0)
        <h2>{{ Cart::count() }} produkt(y) v košíku</h2>

        <div class="cart-table">
            @foreach (Cart::content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href="{{ route('shop.show', $item->model->slug) }}">
                        <img src="{{ asset('storage/'.$item->model->image) }}" alt="item"
                            class="cart-table-img">
                    </a>
                    <div class="cart-item-details">
                        <div class="cart-table-item">
                            <a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a>
                        </div>
                        <div class="cart-table-description">{{ $item->model->details }}</div>
                    </div>
                </div>
                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <!-- <br><a href="#">Remove</a> -->
                        <form method="POST" action="{{ route('cart.destroy', $item->rowId) }}">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="cart-options">Odstrániť</button>
                        </form>
                        <!-- <a href="#">Save for Later</a> -->
                        <form method="POST" action="{{ route('cart.switchToSaveForLater', $item->rowId) }}">
                            @csrf
                            <button type="submit" class="cart-options">Odložiť</button>
                        </form><br>
                    </div>
                    <div>
                        <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->quantity }}">
                            @for ($i = 1; $i < 5 + 1 ; $i++) <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                                @endfor
                        </select><br>
                    </div>
                    <div class="d-flex-cart">{{ presentPrice($item->subtotal) }}</div>
                </div>
            </div> <!-- end cart-table-row -->
            @endforeach
        </div> <!-- end cart-table -->

        @if (! session()->has('coupon'))

        <a href="#" class="have-code">Máte kupón?</a>

        <div class="have-code-container">
            <form action="{{ route('coupon.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" name="coupon_code" id="coupon_code">
                <button type="submit" class="button button-plain">Použiť</button>
            </form>
        </div> <!-- end have-code-container -->
        @endif

        <div class="cart-totals">
            <div class="cart-totals-left">
                Doprava je zadarmo, pretože sme takí úžasní.
            </div>

            <div class="cart-totals-right">
                <div>
                    Priebežne <br>
                    @if (session()->has('coupon'))
                    Kupón ({{ session()->get('coupon')['name'] }})
                    <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <button type="submit" style="font-size:14px;">Odstrániť</button>
                    </form>
                    <hr>
                    Po zľave <br>
                    @endif
                    DPH ({{config('cart.tax')}}%)<br>
                    <span class="cart-totals-total">Spolu</span>
                </div>
                <div class="cart-totals-subtotal">
                    {{ presentPrice(Cart::subtotal()) }} <br>
                    @if (session()->has('coupon'))
                    -{{ presentPrice($discount) }} <br>&nbsp;<br>
                    <hr>
                    {{ presentPrice($newSubtotal) }} <br>
                    @endif
                    {{ presentPrice($newTax) }} <br>
                    <span class="cart-totals-total">{{ presentPrice($newTotal) }}</span>
                </div>
            </div>
            </div> <!-- end cart-totals -->

        <div class="cart-buttons">
            <a href="{{ route('shop.index') }}" class="button">Pokračovať v nákupe</a>
            <a href="{{ route('checkout.index') }}" class="button-primary">Pokračujte k pokladni</a>
        </div>
        @else
        <h3>Žiadne položky v košíku!</h3>
        <div class="spacer"></div>
        <a href="{{ route('shop.index') }}" class="button">Pokračovať v nákupe</a>
        <div class="spacer"></div>
        @endif
        @if (Cart::instance('saveForLater')->count() > 0)

        <h2>{{ Cart::instance('saveForLater')->count() }} produkt(y) uložené na neskôr</h2>

        <div class="saved-for-later cart-table">
            @foreach (Cart::instance('saveForLater')->content() as $item)
            <div class="cart-table-row">
                <div class="cart-table-row-left">
                    <a href="{{ route('shop.show', $item->model->slug) }}">
                        <img src="{{ asset('storage/'.$item->model->image) }}" alt="item"
                            class="cart-table-img">
                    </a>
                    <div class="cart-item-details">
                        <div class="cart-table-item">
                            <a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a>
                        </div>
                        <div class="cart-table-description">{{ $item->model->details }}</div>
                    </div>
                </div>
                <div class="cart-table-row-right">
                    <div class="cart-table-actions">
                        <form method="POST" action="{{ route('saveForLater.destroy', $item->rowId) }}">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="cart-options">Odstrániť</button>
                        </form>
                        <!-- <a href="#">Save for Later</a> -->
                        <form method="POST" action="{{ route('saveForLater.switchToCart', $item->rowId) }}">
                            @csrf
                            <button type="submit" class="cart-options">Presunúť do košíka</button>
                        </form>

                    </div>
                    <div>{{ $item->model->presentPrice() }}</div>
                </div>
            </div> <!-- end cart-table-row -->
            @endforeach

        </div> <!-- end saved-for-later -->
        @else
        <h3>Nemáte uložené žiadne položky na neskôr</h3>
        @endif

    </div>

</div> <!-- end cart-section -->

@include('partials.might-like')


@endsection
@section('extra-js')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    (function(){
            const classname = document.querySelectorAll('.quantity')
            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')
                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                    .then(function (response) {
                        // console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error) {
                        // console.log(error);
                        window.location.href = '{{ route('cart.index') }}'
                    });
                })
            })
        })();
</script>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection
