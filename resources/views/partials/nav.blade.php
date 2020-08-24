<header>
    <nav>
        <div id="navbar">
            <a href="/">
                <div class="logo" id="logo">
                    <img src="{{ asset('img/WS-logo-blue-edit-v2.svg') }}" height="60" alt="Logo">
                </div>
            </a>
            <div id="links">
                <div class="top-nav-left">
                    @if (! (request()->is('checkout') || request()->is('guestCheckout')))
                    {{ menu('main', 'partials.menus.main') }}
                    @endif
                </div>
                <div class="top-nav-right">
                    @if (! (request()->is('checkout') || request()->is('guestCheckout')))
                    @include('partials.menus.main-right')
                    @endif
                </div>
            </div>




            <div class="mobile-btn">
                <a id="menu-btn" onclick="myFunction()" class="fa fa-bars fa-2x"></a>
            </div>

        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu">
        <div class="top-nav-left">
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
            {{ menu('main', 'partials.menus.main') }}
            @endif
        </div>
        <div class="top-nav-right">
            @if (! (request()->is('checkout') || request()->is('guestCheckout')))
            @include('partials.menus.main-right')
            @endif
        </div>
    </div>
</header>
