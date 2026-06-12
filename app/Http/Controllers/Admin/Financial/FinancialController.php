<?php

namespace App\Http\Controllers\Admin\Financial;

use App\Http\Controllers\Controller;
use App\Models\Cheque;
use App\Models\Expense;
use App\Models\InstallmentDetail;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FinancialController extends Controller
{
    public function Assets()
    {
        $purchases = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
    ->selectRaw('dateDay, SUM(totalPrice) as total_purchases')
    ->groupBy('dateDay')
    ->get();

        /* $cash = Transaction::where('payment_methode', 'كاش')
          ->selectRaw('dateDay, SUM(amount) as total_cash')
          ->groupBy('dateDay')
          ->get();

          $reports = $purchases->map(function ($purchase) use ($cash) {
              $cashForDay = $cash->firstWhere('dateDay', $purchase->dateDay);

              return [
                  'date' => $purchase->dateDay,
                  'total_purchases' => $purchase->total_purchases,
                  'total_cash' => $cashForDay->total_cash ?? 0,
              ];
          });*/

        return view('Financial.assets')->with('purchases', $purchases);
    }

    public function Liabilities()
    {
        $sumCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('chequeable_type', Purchase::class)
        ->sum('amount');

        $today = Carbon::today()->format('Y-m-d');
        $todayCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('due_date', $today)
        ->sum('amount');

        $sumInstallment = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Purchase::class);
        })
    ->where('status', 'غير مدفوع')
    ->sum('amount');

        return view('Financial.liabilities')->with(['sumCheque' => $sumCheque, 'sumInstallment' => $sumInstallment]);
    }

    public function Revenues()
    {
        $sales = Sale::where('admin_id', Auth::guard('admin')->user()->id)
    ->selectRaw('dateDay, SUM(totalPrice) as total_sales')
    ->groupBy('dateDay')
    ->get();

        return view('Financial.revenues')->with('sales', $sales);
    }

    public function Expenses()
    {
        $expenses = Expense::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Financial.expenses')->with('expenses', $expenses);
    }

    public function Receivable()
    {
        $sumCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('chequeable_type', Sale::class)
        ->sum('amount');

        $today = Carbon::today()->format('Y-m-d');
        $todayCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('due_date', $today)
        ->sum('amount');

        $sumInstallment = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Sale::class);
        })
    ->where('status', 'غير مدفوع')
    ->sum('amount');

        return view('Financial.receivable')->with(['sumCheque' => $sumCheque, 'sumInstallment' => $sumInstallment]);
    }
}
