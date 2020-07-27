@component('mail::message')
# Objednavka prijata

Ďakujeme za Vašu objednávku.

**Objednávka ID:** {{ $order->id }}

**Email:** {{ $order->billing_email }}

**Meno:** {{ $order->billing_name }}

**DPH:** {{ presentPrice($order->billing_tax) }}

@if ($order->billing_discount > 0)
**Zľava na objednávku:** {{ presentPrice($order->billing_discount) }}
@endif

**Celková suma objednávky:** {{ presentPrice($order->billing_total) }}

**Objednané položky**

@foreach ($order->products as $product)
Produkt: {{ $product->name }} <br>
Cena: {{ presentPrice($product->price)}} <br>
Množstvo: {{ $product->pivot->quantity }} <br>
@endforeach

Ďalšie podrobnosti o svojej objednávke získate po prihlásení na našu webovú stránku.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Prejdite na webovú stránku
@endcomponent

Ešte raz vám ďakujeme, že ste si nás vybrali.

S pozdravom,<br>
{{ config('app.name') }}
@endcomponent
