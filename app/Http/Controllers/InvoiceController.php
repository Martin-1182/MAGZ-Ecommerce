<?php

namespace App\Http\Controllers;

use \PDF;
use App\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function downloadPDF($id)
    {
        $order = Order::find($id);
        $products = $order->products;
        $pdf = PDF::loadView('invoice', compact('order', 'products'));

        return $pdf->download('invoice.pdf');
    }

}