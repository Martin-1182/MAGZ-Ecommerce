<header>
    <div class="top-nav container">
        <div class="top-nav-left">
            <a href="/">
                <div class="logo"><img src="{{ asset('img/WS-logo-blue-edit-v2.svg') }}" height="70" alt=""></div>
            </a>
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
            {{ menu('main', 'partials.menus.main') }}
            @endif
        </div>
        <div class="top-nav-right">
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
            @include('partials.menus.main-right')
            @endif
        </div>
    </div> <!-- end top-nav -->
</header>
