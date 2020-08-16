<!DOCTYPE html>
<html lang="sk">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">


    <title>Faktúra</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        .text-right {
            text-align: right;
        }
    </style>

</head>

<body class="login-page" style="background: white">

    <div>
        <div class="row">
            <div class="col-xs-7">
                <h4>Pre:</h4>
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->billing_address }}, {{ $order->billing_city }} <br>
                TEL: {{ $order->billing_phone }} <br>
                EMAIL: {{ $order->billing_email }} <br>

                <br>
            </div>

            <div class="col-xs-4">
                <h4>
                    WebSystem s.r.o.
                </h4>
            </div>
        </div>

        <div style="margin-bottom: 0px">&nbsp;</div>

        <div class="row">
            <div class="col-xs-6">
                <h4>Od:</h4>
                <address>
                    <strong>WebSystem s.r.o.</strong><br>
                    <span>info@websistem.sk</span> <br>
                    <span>Jesenského 18 Zvolen</span>
                </address>
            </div>

            <div class="col-xs-5">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <th>Objednávka:</th>
                            <td class="text-right">{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th> Dátum: </th>
                            <td class="text-right">{{ presentDate($order->created_at) }}</td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-bottom: 0px">&nbsp;</div>

                <table style="width: 100%; margin-bottom: 20px">
                    <tbody>
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px">
                                <div> Celkom: </div>
                            </th>
                            <td style="padding: 5px" class="text-right"><strong>
                                    {{ presentPrice($order->billing_total) }} </strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table class="table" style="width: 100%">

            <thead style="background: #F5F5F5;">
                <tr>
                    <th>Zoznam položiek</th>
                    <th></th>
                    <th class="text-right">Množstvo</th>
                    <th class="text-right">Cena</th>
                </tr>
            </thead>
            @foreach ($products as $product)
            <tbody>
                <tr>
                    <td>
                        <div><strong>{{ $product->name }}</strong></div>
                        <p>{{ $product->details }}</p>
                    </td>
                    <td></td>
                    <td class="text-right">{{ $product->pivot->quantity }}</td>
                    <td class="text-right">{{ presentPrice($product->price) }}</td>

                </tr>
            </tbody>
            @endforeach
        </table>

        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-5">
                <table style="width: 100%">
                    <tbody>
                        @if ($order->billing_discount > 0)
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px">
                                <div> Zlava </div>
                            </th>
                            <td style="padding: 5px" class="text-right"><strong>
                                    {{ presentPrice($order->billing_discount) }} </strong>
                            </td>
                        </tr>
                        @endif
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px">
                                <div> Spolu </div>
                            </th>
                            <td style="padding: 5px" class="text-right"><strong>
                                    {{ presentPrice($order->billing_subtotal) }} </strong></td>
                        </tr>
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px">
                                <div> DPH 20% </div>
                            </th>
                            <td style="padding: 5px" class="text-right"><strong>
                                    {{ presentPrice($order->billing_tax) }} </strong></td>
                        </tr>
                        <tr class="well" style="padding: 5px">
                            <th style="padding: 5px">
                                <div> Spolu na úhradu </div>
                            </th>
                            <td style="padding: 5px;" class="text-right"><strong>
                                    {{ presentPrice($order->billing_total) }} </strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-bottom: 0px">&nbsp;</div>

        <div class="row">
            <div class="col-xs-8 invbody-terms">
                Dakujeme Vám za Vašu objednávku. <br>
                <br>
                <h4>Platobné podmienky</h4>
                <p>Táto faktúra je neplatná!!! V žiadnom prípade FA neuhrádzajte!!! Táto aplikácia je demo verzia
                    elektronického obchodu!</p>
                <br>
                <p><strong>WebSystem s.r.o.</strong></p>
            </div>
        </div>
    </div>

</body>

</html>
