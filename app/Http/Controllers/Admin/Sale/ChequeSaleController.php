<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCheque;
use App\Models\Cheque;
use App\Models\Custemer;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeSaleController extends Controller
{
    public function Cheque($saleId)
    {
        $sale = Sale::find($saleId);

        $cheques = $sale->cheques;

        return view('Cheque.chequesSale')->with(['sale' => $sale, 'cheques' => $cheques]);
    }

    public function AddCheque($saleId)
    {
        $sale = Sale::find($saleId);

        return view('Cheque.addChequeSale')->with(['sale' => $sale]);
    }

    public function StoreCheque(AddCheque $request)
    {
        $found = Cheque::where(['admin_id' => Auth::guard('admin')->user()->id,
            'cheque_number' => $request->cheque_number])->get();
        if (blank($found)) {
            if ($request->amount > $request->cheque_remain) {
                return redirect()->back()->with('error', 'مبلغ الشيك اكبر من المبلغ المتبقي');
            }
            $path = null;
            if ($request->chequeImg != null) {
                $path = $request->file('chequeImg')->store('chequeImg', 'public');
            }
            $sale = Sale::find($request->saleId);
            $custemer = Custemer::find($sale->custemer->id);

            $sale->cheques()->create([
                'cheque_number' => $request->cheque_number,
                'bank_name' => $request->bank_name,
                'amount' => $request->amount,
                'due_date' => $request->dateToday,
                'status' => 'غير مقبوض',
                'chequeImg' => $path,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $custemer->balance += $request->amount;
            $custemer->save();

            return redirect()->back()->with('success', 'تم تسجيل الشيك بنجاح');
        } else {
            return redirect()->back()->with('error', 'تم تسجيل الشيك سابقا');
        }
    }

    public function AddChequeMount($chequeId)
    {
        $cheque = Cheque::find($chequeId);

        return view('Cheque.addChequeMountSale')->with('cheque', $cheque);
    }

    public function StoreChequeMount(Request $request)
    {
        $cheque = Cheque::find($request->chequeId);
        $sale = Sale::find($cheque->chequeable->id);
        $custemer = Custemer::find($sale->custemer->id);

        if ($cheque->status == 'غير مقبوض') {
            Transaction::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'sale_id' => $sale->id,
                'amount' => $request->mount,
                'payment_methode' => 'كاش',
                'type' => 'بيع',
                'refrece_id' => $cheque->id,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $cheque->status = 'مقبوض';
            $cheque->save();

            $custemer->balance -= $request->mount;
            $custemer->save();

            $sumMount = Transaction::where('sale_id', $sale->id)->sum('amount');

            if ($sale->totalPrice == $sumMount) {
                $sale->status = 'مدفوع';
                $sale->save();
            }

            return redirect()->back()->with('success', 'تم تسجيل الدفعه بنجاح');
        } else {
            return redirect()->back()->with('error', 'تم تسجيل الدفعه سابقا');
        }
    }

    public function ChequeImg($chequeId)
    {
        $cheque = Cheque::find($chequeId);

        return view('Cheque.chequeSaleImg')->with('cheque', $cheque);
    }
}
