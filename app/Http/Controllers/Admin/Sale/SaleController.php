<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Models\Custemer;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function AddSale()
    {
        $custemers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Sale.addSale')->with('custemers', $custemers);
    }

    public function StoreSale(Request $request)
    {
        $payment_type = '';
        if ($request->payment_type == null) {
            return redirect()->back()->with('error', 'يرجى اختيار طريقه الدفع ');
        } elseif ($request->payment_type != 0 && $request->custemer_id == 0) {
            return redirect()->back()->with('error', 'يرجى اختيار اسم الزبون ');
        } else {
            if ($request->payment_type == 0) {
                $payment_type = 'كاش';
                if ($request->custemer_id == 0) {
                    $request->custemer_id = null;
                }
            } elseif ($request->payment_type == 1) {
                $payment_type = 'شيك';
            } elseif ($request->payment_type == 2) {
                $payment_type = 'تقسيط';
            } else {
                $payment_type = 'مرن';
            }
            $sale = Sale::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'custemer_id' => $request->custemer_id,
                'payment_type' => $payment_type,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
        }

        return redirect()->route('sales.saleDetails', ['saleId' => $sale->id]);
    }

    public function UpdateSale($saleId)
    {
        $sale = Sale::find($saleId);
        $custemers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Sale.updateSale')->with(['sale' => $sale, 'custemers' => $custemers]);
    }

    public function EditeSale(Request $request)
    {
        $sale = Sale::find($request->sale_id);

        try {
            DB::transaction(function () use ($request, $sale) {
                $sale->dateDay = $request->dateToday;
                $sale->dayName = $request->dayName;
                $sale->custemer_id = $request->custemer_id;
                $sale->save();
                if ($sale->payment_type == 'كاش') {
                    $transiction = Transaction::where('refrece_id', $sale->id)->first();
                    if (!$transiction) {
                        throw new \Exception('الرجاء التأكد من المعاملة المالية');
                    }
                    $transiction->dateDay = $request->dateToday;
                    $transiction->dayName = $request->dayName;
                    $transiction->save();
                }
            });

            return redirect()->back()->with('success', 'تمت التعديل بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
