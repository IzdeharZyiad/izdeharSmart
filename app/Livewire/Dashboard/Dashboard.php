<?php

namespace App\Livewire\Dashboard;

use App\Models\Cheque;
use App\Models\Expense;
use App\Models\InstallmentDetail;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $filter = 'today';
    public $endDate;
    public $firstDate;
    public $purchase;
    public $purchase_mount;

    public $sales_mount;
    public $expense_mount;
    public $sales_totalProfit;
    public $profit;
    public $allMoneySellers;

    public $query;
    public $query_sales;
    public $labels = [];
    public $values = [];
    public $labelsBar = [];
    public $valuesBar = [];
    public $labelsLine = [];
    public $valuesLine = [];
    public $allMoneyCustemers;

    public function mount()
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->endDate = $carbon->format('Y-m-d');
        $this->firstDate = $carbon->format('Y-m-d');

        $this->custemersMoney();
        $this->sellersMoney();

        $this->getDataToday();
        $this->profit = $this->sales_totalProfit - $this->expense_mount;
        $this->renderChartBar();
        $this->dispatch('updateChartBar', [
            'labelsBar' => ['المشتريات', 'المبيعات', 'المصروفات', 'الربح'],
            'valuesBar' => $this->valuesBar,
        ]);

        $this->renderChartLine();
        $this->dispatch('updateChartLine', [
            'labelsline' => $this->labelsLine,
            'valuesline' => $this->valuesLine,
        ]);

        $this->renderChart();
        $this->dispatch('updateChart', [
            'labels' => ['التزماتي', 'ديون الزبائن'],
            'values' => $this->values,
        ]);
    }

    public function updatedFilter($value)
    {
        $this->filter = $value;
        if ($this->filter == 'today') {
            $this->getDataToday();
        }
    }

    public function getDataToday()
    {
        $this->purchase_mount = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalPrice');

        $this->sales_mount = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalPrice');

        $this->sales_totalProfit = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalProfit');

        $this->expense_mount = Expense::where('admin_id', Auth::guard('admin')->user()->id)
        ->whereDate('dateDay', now())->sum('mount');
    }

    public function renderChartBar()
    {
        $this->valuesBar = '';
        $this->valuesBar = [$this->purchase_mount, $this->sales_mount, $this->expense_mount, $this->profit];
    }

    public function renderChartLine()
    {
        $this->labelsline = '';
        $this->valuesline = '';
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $data = Sale::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$start, $end])
       ->get()
        ->groupBy(fn ($sale) => $sale->dateDay);

        $data_expense = Expense::where('admin_id', Auth::guard('admin')->id())
        ->whereBetween('dateDay', [$start, $end])
       ->get()
        ->groupBy(fn ($expense) => $expense->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->valuesLine = $data->map(function ($sale, $date) use ($data_expense) {
            $income = $sale->sum('totalProfit');

            $expense = $data_expense[$date] ?? collect();

            $expenseTotal = $expense->sum('mount');

            return $income - $expenseTotal;
        })->values()->toArray();
    }

    public function renderChart()
    {
        $this->labels = [];
        $this->values = [];

        $sumCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('chequeable_type', Purchase::class)
         ->where('due_date', today())
        ->sum('amount');

        $sumInstallment = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Purchase::class);
        })
    ->where('status', 'غير مدفوع')
     ->where('due_date', today())
    ->sum('amount');

        $sumCheque_sale = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
         ->where('status', 'غير مقبوض')
         ->where('chequeable_type', Sale::class)
          ->where('due_date', today())
         ->sum('amount');

        $sumInstallment_sale = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Sale::class);
        })
    ->where('status', 'غير مدفوع')
      ->where('due_date', today())
    ->sum('amount');

        $this->values = [$sumCheque + $sumInstallment,  $sumCheque_sale + $sumInstallment_sale];
    }

    public function custemersMoney()
    {
        $this->custemersMoneys = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Sale::class);
        })
        ->where('status', 'غير مدفوع')
        ->where('due_date', today())
          ->with('installment.installmentable') // مهم لجلب العميل
        ->get();

        $data = $this->custemersMoneys->map(function ($item) {
            return [
                'type' => 'قسط',
                'name' => $item->installment->installmentable->custemer->name,
                'amount' => $item->amount,
                'date' => $item->due_date,
            ];
        });

        $Cheque_sale = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
         ->where('status', 'غير مقبوض')
         ->where('chequeable_type', Sale::class)
        ->where('due_date', today())
        ->with('chequeable')
         ->get();

        $cheques = $Cheque_sale->map(function ($item) {
            return [
                'type' => 'شيك',
                'name' => $item->chequeable->custemer->name,
                'amount' => $item->amount,
                'date' => $item->due_date,
            ];
        });

        $this->allMoneyCustemers = $data->concat($cheques)->values()->toArray();
    }

    public function sellersMoney()
    {
        $this->sellersMoneys = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Purchase::class);
        })
        ->where('status', 'غير مدفوع')
        ->where('due_date', today())
          ->with('installment.installmentable') // مهم لجلب العميل
        ->get();

        $data = $this->sellersMoneys->map(function ($item) {
            return [
                'type' => 'قسط',
                'name' => $item->installment->installmentable->seller->name,
                'amount' => $item->amount,
                'date' => $item->due_date,
            ];
        });

        $Cheque_purchase = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
         ->where('status', 'غير مقبوض')
         ->where('chequeable_type', Purchase::class)
        ->where('due_date', today())
        ->with('chequeable')
         ->get();

        $cheques = $Cheque_purchase->map(function ($item) {
            return [
                'type' => 'شيك',
                'name' => $item->chequeable->seller->name,
                'amount' => $item->amount,
                'date' => $item->due_date,
            ];
        });

        $this->allMoneySellers = $data->concat($cheques)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard');
    }
}
