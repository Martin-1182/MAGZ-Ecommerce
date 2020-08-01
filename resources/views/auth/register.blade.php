@extends('layout')

@section('title', 'Sign Up for an Account')

@section('content')
<div class="container">
    <div class="auth-pages">
        <div>
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
            <h2>Vytvoriť účet</h2>
            <div class="spacer"></div>

            <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                    placeholder="Meno" required autofocus>

                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                    placeholder="Email" required>

                <input id="password" type="password" class="form-control" name="password"
                    placeholder="Heslo" required>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    placeholder="Potvrďte heslo" required>

                <div class="login-container">
                    <button type="submit" class="auth-button">Vytvoriť účet</button>
                    <div class="spacer"></div>
                    <div class="already-have-container">
                        <p><strong>Máte už účet?</strong></p>

                        <a class="auth-button" href="{{ route('login') }}">Prihlásiť sa</a>
                    </div>
                </div>

            </form>
        </div>

        <div class="auth-right">
            <h2>Nový zákazník</h2>
            <div class="spacer"></div>
            <p><strong>Ušetrite čas.</strong></p>
            <p>Vytvorenie účtu vám umožní v budúcnosti rýchlejšie platby, ľahký prístup k histórii objednávok
            a prispôsobte si svoje skúsenosti tak, aby vyhovovali vašim preferenciám.</p>

            &nbsp;
            <div class="spacer"></div>
            <p><strong>Vernostný program.</strong></p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt debitis, amet magnam accusamus nisi
                distinctio eveniet ullam. Facere, cumque architecto.</p>
        </div>
    </div> <!-- end auth-pages -->
</div>
@endsection
