<?php

namespace App\Http\Controllers\Admin\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Custemer;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Transaction;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function CustemerSale($saleId)
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'directionality' => 'rtl',
        ]);

        $sale = Sale::find($saleId);
        $saleDetails = SaleDetail::where('sale_id', $sale->id)->get();

        $html = view('Pdf.custemerSale', [
            'sale' => $sale,
            'saleDetails' => $saleDetails,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('فاتورة.pdf', 'I');
    }

    public function CustemerName()
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'directionality' => 'rtl',
        ]);

        $custemers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $html = view('Pdf.custemerName', [
            'custemers' => $custemers,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('اسماء الزبائن.pdf', 'I');
    }

    public function ProductNamePdf($type_id)
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'directionality' => 'rtl',
        ]);

        $type = Type::find($type_id);
        $items = Item::where('type_id', $type_id)->get();
        $products = Product::whereHas('productDetail', function ($query) {
            $query->where('Quantity', '!=', 0);
        })
     ->whereIn('item_id', $items->pluck('id'))
    ->get();

        $html = view('Pdf.productNamePdf', [
            'products' => $products,
            'type' => $type,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('المنتجات المتوفرة.pdf', 'I');
    }

    public function CustemerReport()
    {
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'directionality' => 'rtl',
        ]);

        $custemers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $html = view('Pdf.custemerReports', [
            'custemers' => $custemers,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('دين الزبائن.pdf', 'I');
    }

    public function AccountStatmentCustemerPdf($custemerId)
    {
        $sales = Sale::where('custemer_id', $custemerId)
           ->orderBy('dateDay', 'asc')->get()->map(function ($sale) {
               return [
                   'date' => $sale->dateDay,
                   'type' => 'فاتورة',
                   'info' => 'فاتورة بيع رقم '.$sale->id,
                   'debit' => $sale->totalPrice,
                   'credit' => 0,
               ];
           });

        $custemer = Custemer::find($custemerId);

        $sumSale = $custemer->sale->sum('totalPrice');

        $sumTransiction = Transaction::whereHas('sale', function ($q) use ($custemerId) {
            $q->where('custemer_id', $custemerId);
        })->sum('amount');

        $reset = $sumSale - $sumTransiction;

        $transictions = Transaction::whereHas('sale', function ($q) use ($custemerId) {
            $q->where('custemer_id', $custemerId);
        })->get()->map(function ($transiction) {
            return [
                'date' => $transiction->dateDay,
                'type' => 'دفعة',
                'info' => 'كاش',
                'debit' => 0,
                'credit' => $transiction->amount,
            ];
        });

        $statements = $sales
         ->concat($transictions)
          ->sortBy('date')
         ->values();

        $balance = 0;
        $statements = $statements->map(function ($item) use (&$balance) {
            $balance += $item['debit'] - $item['credit'];

            $item['balance'] = $balance;

            return $item;
        });
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'directionality' => 'rtl',
        ]);

        $html = view('Pdf.accountStatmentCustemerPdf', [
            'sumSale' => $sumSale,
            'sumTransiction' => $sumTransiction,
            'reset' => $reset,
            'statements' => $statements,
            'cutemer_name' => $custemer->name,
        ])->render();

        $mpdf->WriteHTML($html);

        return $mpdf->Output('كشف حساب.pdf', 'I');
        // return view('Pdf.accountStatmentCustemerPdf');
    }
}
