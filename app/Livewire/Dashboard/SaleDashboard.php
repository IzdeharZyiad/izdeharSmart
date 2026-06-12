<?php

namespace App\Livewire\Dashboard;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SaleDashboard extends Component
{
    public $filter = 'today';
    public $endDate;
    public $firstDate;
    public $sale;
    public $sales_mount;
    public $sale_count;
    public $sales_profit;
    public $purchaseDay;
    public $profitsLine;
    public $salesLine;

    public $query;
    public $labels = [];
    public $values = [];
    public $labelsBar = [];
    public $valuesBar = [];
    public $labelsLine = [];
    public $valuesLine = [];

    public function mount()
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->endDate = $carbon->format('Y-m-d');
        $this->firstDate = $carbon->format('Y-m-d');
        $this->getDataToday();
        $this->loadChartData();
        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'values' => $this->values,
        ]);

        $this->renderChartLine();

        $this->dispatch('updateChartLine', [
            'labelsline' => $this->labelsLine,
            'valuesline' => $this->valuesLine,
        ]);

        $this->renderChartBar();
        $this->dispatch('updateChartBar', [
            'labelsBar' => $this->labelsBar,
            'valuesBar' => $this->valuesBar,
        ]);
    }

    public function updatedFilter($value)
    {
        $this->filter = $value;
        if ($this->filter == 'today') {
            $this->getDataToday();
            $this->loadChartData();
            $this->renderChartBar();
            $this->renderChartLine();
            $this->dispatch('updateChartLine', [
                'labelsline' => $this->labelsLine,
                'valuesline' => $this->valuesLine,
            ]);
            $this->dispatch('updateChartBar', [
                'labelsBar' => $this->labelsBar,
                'valuesBar' => $this->valuesBar,
            ]);

            $this->dispatch('updateChart', [
                'labels' => $this->labels,
                'values' => $this->values,
            ]);
        } elseif ($this->filter == 'specified') {
            $this->getDataSpecified();
            $this->loadChartData();
            $this->renderChartBar();

            $this->dispatch('updateChartBar', [
                'labelsBar' => $this->labelsBar,
                'valuesBar' => $this->valuesBar,
            ]);

            $this->dispatch('updateChart', [
                'labels' => $this->labels,
                'values' => $this->values,
            ]);
        } elseif ($this->filter == 'week') {
            $this->getDataWeek();
            $this->loadChartData();
            $this->renderChartBar();
            $this->renderChartLine();

            $this->dispatch('updateChartLine', [
                'labelsline' => $this->labelsLine,
                'valuesline' => $this->valuesLine,
            ]);

            $this->dispatch('updateChartBar', [
                'labelsBar' => $this->labelsBar,
                'valuesBar' => $this->valuesBar,
            ]);
            $this->dispatch('updateChart', [
                'labels' => $this->labels,
                'values' => $this->values,
            ]);
        } else {
            $this->getDataMonth();
            $this->loadChartData();
            $this->renderChartBar();
            $this->renderChartLine();

            $this->dispatch('updateChartLine', [
                'labelsline' => $this->labelsLine,
                'valuesline' => $this->valuesLine,
            ]);

            $this->dispatch('updateChartBar', [
                'labelsBar' => $this->labelsBar,
                'valuesBar' => $this->valuesBar,
            ]);

            $this->dispatch('updateChart', [
                'labels' => $this->labels,
                'values' => $this->values,
            ]);
        }
    }

    public function getDataToday()
    {
        $this->sale_count = Sale::where('admin_id', Auth::guard('admin')->user()->id)
           ->whereDate('dateDay', now())->count();
        $this->sales_mount = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalPrice');

        $this->sales_profit = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalProfit');
    }

    public function getDataWeek()
    {
        $this->sale_count = Sale::where('admin_id', Auth::guard('admin')->user()->id)
            ->whereBetween('dateDay', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count();
        $this->sales_mount = Sale::where('admin_id', Auth::guard('admin')->user()->id)
          ->whereBetween('dateDay', [
              now()->startOfWeek(),
              now()->endOfWeek(),
          ])->sum('totalPrice');

        $this->sales_profit = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereBetween('dateDay', [
             now()->startOfWeek(),
             now()->endOfWeek(),
         ])->sum('totalProfit');
    }

    public function getDataMonth()
    {
        $this->sale_count = Sale::where('admin_id', Auth::guard('admin')->user()->id)
       ->whereMonth('dateDay', now()->month)
      ->whereYear('dateDay', now()->year)->count();
        $this->sales_mount = Sale::where('admin_id', Auth::guard('admin')->user()->id)
      ->whereMonth('dateDay', now()->month)
        ->whereYear('dateDay', now()->year)->sum('totalPrice');
        $this->sales_profit = Sale::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereMonth('dateDay', now()->month)
        ->whereYear('dateDay', now()->year)->sum('totalProfit');
    }

    public function getDataSpecified()
    {
        $this->sale_count = Sale::where('admin_id', Auth::guard('admin')->user()->id)
          ->whereBetween('dateDay', [$this->firstDate, $this->endDate])->count();
        $this->sales_mount = Sale::where('admin_id', Auth::guard('admin')->user()->id)
        ->whereBetween('dateDay', [$this->firstDate, $this->endDate])->sum('totalPrice');
        $this->sales_profit = Sale::where('admin_id', Auth::guard('admin')->user()->id)
        ->whereBetween('dateDay', [$this->firstDate, $this->endDate])->sum('totalProfit');
    }

    public function updateFirstDate($firstDate)
    {
        $this->firstDate = $firstDate;

        $data = Sale::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$this->firstDate, $this->endDate])
       ->get()
        ->groupBy(fn ($sale) => $sale->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->salesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();

        $this->profitsLine = $data
    ->map(fn ($group) => $group->sum('totalProfit'))
    ->values()
    ->toArray();

        $this->valuesLine = [$this->salesLine, $this->profitsLine];
        $this->getDataSpecified();
        $this->loadChartData();
        $this->renderChartBar();

        $this->dispatch('updateChartBar', [
            'labelsBar' => $this->labelsBar,
            'valuesBar' => $this->valuesBar,
        ]);

        $this->dispatch('updateChartLine', [
            'labelsline' => $this->labelsLine,
            'valuesline' => $this->valuesLine,
        ]);

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'values' => $this->values,
        ]);
    }

    public function updateEndDate($endDate)
    {
        $this->endDate = $endDate;
        $data = Sale::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$this->firstDate, $this->endDate])
       ->get()
        ->groupBy(fn ($sale) => $sale->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->salesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();

        $this->profitsLine = $data
    ->map(fn ($group) => $group->sum('totalProfit'))
    ->values()
    ->toArray();

        $this->valuesLine = [$this->salesLine, $this->profitsLine];
        $this->dispatch('updateChartLine', [
            'labelsline' => $this->labelsLine,
            'valuesline' => $this->valuesLine,
        ]);

        $this->getDataSpecified();
        $this->loadChartData();
        $this->renderChartBar();

        $this->dispatch('updateChartBar', [
            'labelsBar' => $this->labelsBar,
            'valuesBar' => $this->valuesBar,
        ]);

        $this->dispatch('updateChart', [
            'labels' => $this->labels,
            'values' => $this->values,
        ]);
    }

    public function loadChartData()
    {
        $this->labels = [];
        $this->values = [];

        $query = Sale::with('details.productDetail.product')
            ->where('admin_id', Auth::guard('admin')->id());

        if ($this->filter == 'today') {
            $query->whereDate('dateDay', now());
        } elseif ($this->filter == 'specified') {
            $query->whereBetween('dateDay', [$this->firstDate, $this->endDate]);
        } elseif ($this->filter == 'week') {
            $query->whereBetween('dateDay', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
        } else {
            $query->whereMonth('dateDay', now()->month)
          ->whereYear('dateDay', now()->year);
        }

        $this->sale = $query->get();

        $data = $this->sale
            ->flatMap(fn ($sale) => $sale->details)
            ->groupBy(fn ($detail) => $detail->productDetail->product->item->type->name);

        $this->labels = $data->keys()->values()->toArray();

        $this->values = $data
            ->map(fn ($group) => $group->sum('quantity'))
            ->values()
            ->toArray();
    }

    public function renderChartBar()
    {
        $this->labelsBar = [];
        $this->valuesBar = [];
        $data = $this->sale
               ->flatMap(fn ($sale) => $sale->details)
               ->groupBy(fn ($detail) => $detail->productDetail->product->name);

        $this->labelsBar = $data->keys()->values()->toArray();

        $this->valuesBar = $data
            ->map(fn ($group) => $group->sum('subtotal'))
            ->values()
            ->toArray();
    }

    public function renderChartLine()
    {
        $this->labelsline = '';
        $this->valuesline = '';
        $this->profitsLine = '';
        $this->salesLine = '';
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $data = Sale::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$start, $end])
       ->get()
        ->groupBy(fn ($sale) => $sale->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->salesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();

        $this->profitsLine = $data
    ->map(fn ($group) => $group->sum('totalProfit'))
    ->values()
    ->toArray();

        $this->valuesLine = [$this->salesLine, $this->profitsLine];
    }

    public function render()
    {
        return view('livewire.dashboard.sale-dashboard');
    }
}
