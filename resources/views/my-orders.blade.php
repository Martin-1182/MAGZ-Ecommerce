@extends('layout')

@section('title', 'My Orders')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>My Orders</span>
@endcomponent

<div class="container">
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
</div>

<div class="products-section my-orders container">
    <div class="sidebar">

        <ul>
            <li><a href="{{ route('users.edit') }}">My Profile</a></li>
            <li class="active"><a href="{{ route('orders.index') }}">Objednávky</a></li>
        </ul>
    </div> <!-- end sidebar -->
    <div class="my-profile">
        <div class="products-header">
            <h1 class="stylish-heading">Objednávky</h1>
        </div>

        <div>
            @foreach ($orders as $order)
            <div class="order-container">
                <div class="order-header">
                    <div class="order-header-items">
                        <div>
                            <div class="uppercase font-bold badge badge-success">Dátum</div>
                            <div class="order-data">{{ presentDate($order->created_at) }}</div>
                        </div>
                        <div>
                            <div class="uppercase font-bold badge badge-success">ID</div>
                            <div class="order-data">ID-{{ $order->id }}</div>
                        </div>
                        <div>
                            <div class="uppercase font-bold badge badge-success">Spolu</div>
                            <div><strong style="font-weight: 500;">{{ presentPrice($order->billing_total) }}</strong></div>
                        </div>
                    </div>
                    <div>
                        <div class="order-header-items order-links">
                            <div class="details"><a href="{{ route('orders.show', $order->id) }}">Detail</a></div>
                            <div class="spc">|</div>
                            <div class="links"><a href="{{action('InvoiceController@downloadPDF', $order->id)}}">Faktúra</a></div>
                        </div>
                    </div>
                </div>
                <div class="order-products">
                    @foreach ($order->products as $product)
                    <div class="order-product-item">
                        <div><img src="{{ productImage($product->image) }}" alt="Product Image"></div>
                        <div>
                            <div>
                                <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                            </div>
                            <div>{{ presentPrice($product->price) }}</div>
                            <div>Množstvo: {{ $product->pivot->quantity }}</span></div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div> <!-- end order-container -->
            @endforeach
        </div>

        <div class="spacer"></div>
    </div>
</div>

@endsection

@section('extra-js')
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>
@endsection
