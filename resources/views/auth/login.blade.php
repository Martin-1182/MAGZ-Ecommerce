@extends('layout')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div class="auth-left">
            @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
            @endif @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h2>Vracajúci sa zákazník</h2>
            <div class="spacer"></div>

            <form action="{{ route('login') }}" method="POST">
                {{ csrf_field() }}

                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required
                    autofocus>
                <input type="password" id="password" name="password" value="{{ old('password') }}"
                    placeholder="Password" required>

                <div class="login-container">
                    <button type="submit" class="auth-button">Prihlásiť sa</button>
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Zapamätať si
                    </label>
                </div>

                <div class="spacer"></div>

                <a href="{{ route('password.request') }}">
                    Zabudli ste heslo?
                </a>

            </form>
        </div>
        <div class="auth-right">
            <h2>Nový zákazník</h2>
            <div class="spacer"></div>
            <p><strong>Ušetrite čas.</strong></p>
            <p>Na zaplatenie nepotrebujete účet.</p>
            <div class="spacer"></div>
            <a href="{{ route('guestCheckout.index') }}" class="auth-button-hollow">Pokračujte ako hosť</a>
            <div class="spacer"></div>
            &nbsp;
            <div class="spacer"></div>
            <p><strong>Ušetrite čas neskôr.</strong></p>
            <p>Vytvorte si účet pre rýchlu objednávku a ľahký prístup k histórii objednávok.</p>
            <div class="spacer"></div>
            <a href="{{ route('register') }}" class="auth-button-hollow">Vytvoriť účet</a>
        </div>
    </div>
</div>
@endsection
