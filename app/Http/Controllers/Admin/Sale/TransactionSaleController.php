<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Models\Custemer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionSaleController extends Controller
{
    public function AddSaleMoney($saleId)
    {
        $sale = Sale::find($saleId);
        $saleDetail = SaleDetail::where('sale_id', $saleId)->get();

        return view('Sale.addSaleMoney')->with(['saleId' => $sale->id, 'saleDetail' => $saleDetail]);
    }

    public function AddSaleMoneyDis($saleDetail)
    {
        $saleDetail = SaleDetail::find($saleDetail);

        return view('Sale.addSaleMoneyDis')->with(['saleId' => $saleDetail->sale_id, 'saleDetail' => $saleDetail]);
    }

    public function StoreSaleMoney(Request $request)
    {
        $sale = Sale::find($request->sale_id);
        $sale->totalPrice = $request->totalPrice;
        $sale->totalProfit = $request->totalProfit;
        $sale->status = 'غير مدفوع';
        if ($sale->payment_type == 'مرن') {
            $custemer = Custemer::find($sale->custemer_id);
            $custemer->balance += $sale->totalPrice;
            $custemer->save();
        }
        $sale->save();

        return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
    }

    public function StoreSaleMoneyDis(Request $request)
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

            $saleDetail = SaleDetail::find($request->saleDetailId);

            if ($request->disCountType == 'رقم') {
                $saleDetail->typeDisCount = $request->disCountType;
                $saleDetail->disCount = $request->disCount;
                $saleDetail->profit = $saleDetail->profit - $request->disCount;
                $saleDetail->subtotal -= $request->disCount;
                $saleDetail->save();
            } elseif ($request->disCountType == 'نسبة مئوية') {
                $saleDetail->typeDisCount = $request->disCountType;
                $saleDetail->disCount = $request->disCount;
                $disMount = $request->totalPrice * $request->disCount;
                $mountAfter = $request->totalPrice - $disMount;
                $saleDetail->subtotal = $mountAfter;
                $saleDetail->profit = $saleDetail->profit - $disMount;
                $saleDetail->save();
            } else {
                $saleDetail->typeDisCount = $request->disCountType;
                $saleDetail->disCount = $request->disCount;
                $saleDetail->profit = $saleDetail->profit - $request->disCount;
                $saleDetail->save();
            }

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        }
    }

    public function TransactionsSale($saleId)
    {
        $sale = Sale::find($saleId);
        $transactions = Transaction::where('sale_id', $saleId)->get();

        return view('Sale.transactionSale')->with(['sale' => $sale, 'transactions' => $transactions]);
    }

    public function AddTransactionsSale($saleId)
    {
        $sale = Sale::find($saleId);
        $transactions = Transaction::where('sale_id', $saleId)->get();
        $finalPrice = $sale->totalPrice - $transactions->sum('amount');

        return view('Sale.addTransactionSale')->with(['sale' => $sale, 'finalPrice' => $finalPrice]);
    }

    public function StoreTransactionsSale(Request $request)
    {
        $sale = Sale::find($request->sale_id);

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
                'dateDay' => $sale->dateDay,
                'dayName' => $sale->dayName,
                'sale_id' => $request->sale_id,
                'amount' => $request->amount,
                'payment_methode' => 'كاش',
                'type' => 'بيع',
                'refrece_id' => $request->sale_id,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $sale->status = 'مدفوع';
            $sale->save();

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        }

        if ($request->payment_type == 'مرن') {
            Transaction::create([
                'dateDay' => $request->dateToday,
                'dayName' => $request->dayName,
                'sale_id' => $request->sale_id,
                'amount' => $request->amount,
                'payment_methode' => 'كاش',
                'type' => 'بيع',
                'refrece_id' => $request->sale_id,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);
            $custemer = Custemer::find($sale->custemer_id);
            $custemer->balance -= $request->amount;
            $custemer->save();

            $sumMount = Transaction::where('refrece_id', $request->sale_id)->sum('amount');

            if ($sale->totalPrice == $sumMount) {
                $sale->status = 'مدفوع';
            }
            $sale->save();

            return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
        }
    }
}
