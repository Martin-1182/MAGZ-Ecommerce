<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

</head>

<body>
    <div id="app">
        <header class="with-background">
            <div class="top-nav container">
                <div class="top-nav-left">
                    <a href="/">
                        <div class="logo">
                            <img src="{{ asset('img/WS-logo-blue-edit.png') }}" height="70" alt="Logo">
                        </div>
                    </a>
                    {{ menu('main', 'partials.menus.main') }}
                </div>
                <div class="top-nav-right">
                    @include('partials.menus.main-right')
                </div>
            </div> <!-- end top-nav -->
            <div class="hero container">
                <div class="hero-copy">
                    <h1 class="hero-name anim-1">{{ config('app.name') }}</h1>
                    <p class="anim-1">Demo ecommerce aplikácia. Zahŕňa viac produktov, kategórií, nákupný košík a pokladničný systém s
                        integráciou Stripe.</p>
                    <div class="hero-buttons anim-1">
                        <a href="{{ url('/admin') }}" class="button">Admin</a>
                        <a href="#" class="button">GitHub</a>
                    </div>
                </div> <!-- end hero-copy -->

                <div class="hero-image">
                    <img src="img/test-img.png" alt="hero image">
                </div> <!-- end hero-image -->
            </div> <!-- end hero -->
        </header>

        <div class="featured-section">

            <div class="container">
                <h1 class="text-center">{{ config('app.name') }}</h1>

                <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae
                    nisi,
                    consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est
                    reprehenderit
                    sunt aliquid possimus temporibus enim eum hic.</p>

                <div class="text-center button-container">
                    <a href="#" class="button">Novinky</a>
                    <a href="#" class="button">Výpredaj</a>
                </div>
                <div class="products text-center">
                    @foreach ($products as $product)
                    <div class="product box">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img class="product-anime" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"></a>
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <div class="product-name product-anime">{{ $product->name }}</div>
                        </a>
                        <div class="product-price product-anime">{{ $product->presentPrice() }}</div>
                    </div>
                    @endforeach
                </div> <!-- end products -->

                <div class="text-center button-container">
                    <a href="{{ route('shop.index') }}" class="button">Zobraziť ďalšie produkty</a>
                </div>

            </div> <!-- end container -->

        </div> <!-- end featured-section -->

        <blog-posts></blog-posts>

        @include('partials.footer')

        <!-- end #app -->
    </div>

    <script src="js/app.js"></script>
    <script src="{{ asset('js/anime.js') }}"></script>
</body>

</html>
