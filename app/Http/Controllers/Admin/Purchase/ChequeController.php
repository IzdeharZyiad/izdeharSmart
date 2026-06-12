<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCheque;
use App\Models\Cheque;
use App\Models\Purchase;
use App\Models\Seller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChequeController extends Controller
{
    public function Cheque($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);

        $cheques = $purchase->cheques;

        return view('Cheque.cheques')->with(['purchase' => $purchase, 'cheques' => $cheques]);
    }

    public function AddCheque($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);

        return view('Cheque.addCheque')->with(['purchase' => $purchase]);
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
            $purchase = Purchase::find($request->purchaseId);
            $seller = Seller::find($purchase->seller->id);

            $purchase->cheques()->create([
                'cheque_number' => $request->cheque_number,
                'bank_name' => $request->bank_name,
                'amount' => $request->amount,
                'due_date' => $request->dateToday,
                'status' => 'غير مقبوض',
                'chequeImg' => $path,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $seller->balance += $request->amount;
            $seller->save();

            return redirect()->back()->with('success', 'تم تسجيل الشيك بنجاح');
        } else {
            return redirect()->back()->with('error', 'تم تسجيل الشيك سابقا');
        }
    }

    public function AddChequeMount($chequeId)
    {
        $cheque = Cheque::find($chequeId);

        return view('Cheque.addChequeMount')->with('cheque', $cheque);
    }

    public function StoreChequeMount(Request $request)
    {
        $cheque = Cheque::find($request->chequeId);
        $purchase = Purchase::find($cheque->chequeable->id);
        $seller = Seller::find($purchase->seller->id);

        if ($cheque->status == 'غير مقبوض') {
            Transaction::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'purchase_id' => $purchase->id,
                'amount' => $request->mount,
                'payment_methode' => 'كاش',
                'type' => 'دفع',
                'refrece_id' => $cheque->id,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            $cheque->status = 'مقبوض';
            $cheque->save();

            $seller->balance -= $request->mount;
            $seller->save();

            $sumMount = Transaction::where('purchase_id', $purchase->id)->sum('amount');

            if ($purchase->finalPrice == $sumMount) {
                $purchase->status = 'مدفوع';
                $purchase->save();
            }

            return redirect()->back()->with('success', 'تم تسجيل الدفعه بنجاح');
        } else {
            return redirect()->back()->with('error', 'تم تسجيل الدفعه سابقا');
        }
    }

    public function ChequeImg($chequeId)
    {
        $cheque = Cheque::find($chequeId);

        return view('Cheque.chequeImg')->with('cheque', $cheque);
    }
}
