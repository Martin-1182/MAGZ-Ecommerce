@extends('layout')

@section('title', 'Thank You')

@section('extra-css')

@endsection

@section('body-class', 'sticky-footer')

@section('content')

   <div class="thank-you-section">
       <h1>Ďakujeme Vám za <br> Vašu objednávku!</h1>
       <p>Bol odoslaný potvrdzovací e-mail</p>
       <div class="spacer"></div>
       <div>
           <a href="{{ url('/') }}" class="button">Domovská stránka</a>
       </div>
   </div>




@endsection
