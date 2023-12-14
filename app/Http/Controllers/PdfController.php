<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use App\Models\StorageProduct;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function generatePDF()
    {
        $products = StorageProduct::all();

        $groupedProducts = $products->groupBy(function ($item) {
            return $item->category ?: 'Unsorted';
        });

        $pdf = App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.template', ['data' => $groupedProducts])->download('Atskaite.pdf');
    }
}
