<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function TransactionsPurchase($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);

        $transactions = Transaction::where('purchase_id', $purchaseId)->get();

        return view('Purchase.transactionPurchase')->with(['purchase' => $purchase, 'transactions' => $transactions]);
    }

    public function AddTransactionsPurchas($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $transactions = Transaction::where('purchase_id', $purchaseId)->get();
        $finalPrice = $purchase->totalPrice - $transactions->sum('amount');

        return view('Purchase.addTransactionPurchase')->with(['purchase' => $purchase, 'finalPrice' => $finalPrice]);
    }

    public function AddPurchaseMoney($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $purchaseDetail = PurchaseDetail::where('purchase_id', $purchaseId)->get();

        return view('Purchase.addPurchaseMoney')->with(['purchase' => $purchase, 'purchaseDetail' => $purchaseDetail]);
    }

    public function AddPurchaseMoneyDis($purchaseDetailId)
    {
        $purchaseDetail = PurchaseDetail::find($purchaseDetailId);
        $purchase = Purchase::find($purchaseDetail->purchase_id);

        return view('Purchase.addPurchaseMoneyDis')->with(['purchase' => $purchase, 'purchaseDetail' => $purchaseDetail]);
    }

    public function StorePurchaseMoney(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $purchase->totalPrice = $request->totalPrice;
        $purchase->status = 'غير مدفوع';
        $purchase->save();

        return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
    }

    public function StorePurchaseMoneyDis(Request $request)
    {
        if ($request->disCountType == 'الرجاء اختيار طبيعة الخصم') {
            return redirect()->back()->with('error', 'الرجاء اختيار طبيعة الخصم');
        } elseif ($request->disCount < 0) {
            return redirect()->back()->with('error', 'الخصم  يجب ان يكون موجب');
        } elseif ($request->price < 0) {
            return redirect()->back()->with('error', 'السعر الكلي  يجب ان يكون موجب');
        } else {
            if ($request->disCountType == 'لا يوجد') {
                $request->disCount = 0;
            }

            $purchaseDetail = PurchaseDetail::find($request->purchaseDetail_id);
            if ($request->disCountType == 'رقم') {
                $purchaseDetail->typeDisCount = $request->disCountType;
                $purchaseDetail->disCount = $request->disCount;
                $dis = $request->price / $purchaseDetail->quantity;
                $purchaseDetail->unit_cost_after_discount = $dis;
                $purchaseDetail->subtotal -= $request->disCount;
                $purchaseDetail->save();
            } elseif ($request->disCountType == 'نسبة مئوية') {
                $purchaseDetail->typeDisCount = $request->disCountType;
                $purchaseDetail->disCount = $request->disCount;
                $disMount = $request->totalPrice * $request->disCount;
                $mountAfter = $request->totalPrice - $disMount;
                $purchaseDetail->subtotal = $mountAfter;
                $dis = $mountAfter / $purchaseDetail->quantity;
                $purchaseDetail->unit_cost_after_discount = $dis;
                $purchaseDetail->save();
            } else {
                $purchaseDetail->typeDisCount = $request->disCountType;
                $purchaseDetail->disCount = $request->disCount;
                $purchaseDetail->unit_cost_after_discount = $purchaseDetail->price;
                $purchaseDetail->save();
            }

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        }
    }

    public function StoreTransactionsPurchas(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        if ($request->finalPrice == 0) {
            return redirect()->back()->with('error', 'لا يوجد شئ لدفعه');
        }
        if ($request->amount > $request->finalPrice) {
            return redirect()->back()->with('error', 'المبلغ اكبر من المبلغ المطلوب');
        }

        if ($request->amount < 0) {
            return redirect()->back()->with('error', 'المبلغ يجب ان يكون موجب');
        }
        if ($request->payment_type == 'كاش') {
            Transaction::create([
                'dateDay' => $purchase->dateDay,
                'dayName' => $purchase->dayName,
                'purchase_id' => $request->purchase_id,
                'amount' => $request->amount,
                'payment_methode' => 'كاش',
                'type' => 'دفع',
                'refrece_id' => $request->purchase_id,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $purchase->status = 'مدفوع';
            $purchase->save();

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        } elseif ($request->payment_type == 'شيك') {
            Transaction::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'purchase_id' => $request->purchase_id,
                'amount' => $request->amount,
                'payment_methode' => 'شيك',
                'type' => 'دفع',
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $purchase->status = 'غير مدفوع';
            $purchase->save();

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        } elseif ($request->type == 'تقسيط') {
            Transaction::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'purchase_id' => $request->purchase_id,
                'amount' => $request->amount,
                'payment_methode' => 'تقسيط',
                'type' => 'دفع',
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $purchase->status = 'غير مدفوع';
            $purchase->save();

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        } else {
        }
    }
}
