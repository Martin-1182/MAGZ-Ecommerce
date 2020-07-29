@extends('layout')

@section('title', $product->name)

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<style>
    .breadcrumbs {
        font-family: 'Roboto', Arial, sans-serif !important;
        font-size: 18px !important;
        font-weight: 300;
    }

    header .top-nav ul {
        font-family: 'Roboto', Arial, sans-serif !important;
        font-weight: 400;
        font-size: 18px;
    }
    .container {
    margin: auto;
    max-width: 1200px!important;
    }
    dl, ol, ul {
    margin-top: 0;
    margin-bottom: 0;
    }
    a:hover {
    color: #878787;
    }

</style>
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/"><i class="fa fa-home"></i> Domov</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>
    <a href="{{ route('shop.index') }}">Obchod</a>
</span>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>{{ $product->name }}</span>
@endcomponent
<!-- end breadcrumbs -->

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
<div class="product-section container">
    <div>
        <div class="product-section-image">
            <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
        </div>
        <div class="product-section-images">
            <div class="product-section-thumbnail selected">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            </div>

            @if ($product->images)
            @foreach (json_decode($product->images, true) as $image)
            <div class="product-section-thumbnail">
                <img src="{{ productImage($image) }}" alt="product">
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="product-section-information">
        <h1 class="product-section-title">{{ $product->name }}</h1>
        <div class="product-section-subtitle">{{ $product->details }}</div>
        <div>{!! $stockLevel !!}</div>
        <div class="product-section-price">{{ $product->presentPrice() }}</div>

        <p>
            {!! $product->description !!}
        </p>


        <p>&nbsp;</p>

        @if ($product->quantity > 0)
        <form method="POST" action="{{ route('cart.store') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="name" value="{{ $product->name }}">
            <input type="hidden" name="price" value="{{ $product->price }}">
            <button type="submit" class="button button-plain">Pridať do košíka</button>
        </form>
        @endif
    </div>
</div> <!-- end product-section -->


<!-- comments section -->
<div class="container comments-container">
    @comments([
        'model' => $product,
        'approved' => true
        ])
</div>

@include('partials.might-like')


@endsection
@section('extra-js')
<script>
    (function(){
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');
            images.forEach((element) => element.addEventListener('click', thumbnailClick));
            function thumbnailClick(e) {
                currentImage.classList.remove('active');
                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })
                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }
        })();
</script>
<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
<script src="{{ asset('js/algolia.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
@endsection
