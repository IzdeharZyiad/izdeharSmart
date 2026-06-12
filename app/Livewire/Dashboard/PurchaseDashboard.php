<?php

namespace App\Livewire\Dashboard;

use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseDashboard extends Component
{
    public $filter = 'today';
    public $endDate;
    public $firstDate;
    public $purchase;
    public $purchase_mount;
    public $purchase_count;
    public $purchaseDay;
    public $avg;
    public $query;
    public $labels = [];
    public $values = [];
    public $labelsBar = [];
    public $valuesBar = [];
    public $labelsLine = [];
    public $valuesLine = [];

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

    public function loadChartData()
    {
        $this->labels = [];
        $this->values = [];

        $query = Purchase::with('details.productDetail.product')
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

        $this->purchase = $query->get();

        $data = $this->purchase
            ->flatMap(fn ($purchase) => $purchase->details)
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
        $data = $this->purchase
               ->flatMap(fn ($purchase) => $purchase->details)
               ->groupBy(fn ($detail) => $detail->productDetail->product->name);

        $this->labelsBar = $data->keys()->values()->toArray();

        $this->valuesBar = $data
            ->map(fn ($group) => $group->sum('subtotal'))
            ->values()
            ->toArray();
    }

    public function mount()
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->endDate = $carbon->format('Y-m-d');
        $this->firstDate = $carbon->format('Y-m-d');
        $this->getDataToday();
        $this->loadChartData();
        $this->renderChartLine();
        $this->renderChartBar();

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

    public function renderChartLine()
    {
        $this->labelsline = '';
        $this->valuesline = '';
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $data = Purchase::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$start, $end])
       ->get()
        ->groupBy(fn ($purchase) => $purchase->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->valuesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();
    }

    public function updateFirstDate($firstDate)
    {
        $this->firstDate = $firstDate;

        $data = Purchase::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$this->firstDate,  $this->endDate])
       ->get()
        ->groupBy(fn ($purchase) => $purchase->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->valuesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();

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
        $data = Purchase::where('admin_id', Auth::guard('admin')->id())
         ->whereBetween('dateDay', [$this->firstDate,  $this->endDate])
       ->get()
        ->groupBy(fn ($purchase) => $purchase->dateDay);

        $this->labelsLine = $data->keys()->values()->toArray();

        $this->valuesLine = $data
            ->map(fn ($group) => $group->sum('totalPrice'))
            ->values()
            ->toArray();

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

    public function getDataSpecified()
    {
        $this->purchase_count = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
          ->whereBetween('dateDay', [$this->firstDate, $this->endDate])->count();
        $this->purchase_mount = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
        ->whereBetween('dateDay', [$this->firstDate, $this->endDate])->sum('totalPrice');
        if ($this->purchase_count != 0) {
            $this->avg = $this->purchase_mount / $this->purchase_count;
        } else {
            $this->avg = '';
        }
    }

    public function getDataToday()
    {
        $this->purchase_count = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
           ->whereDate('dateDay', now())->count();
        $this->purchase_mount = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereDate('dateDay', now())->sum('totalPrice');
        if ($this->purchase_count != 0) {
            $this->avg = $this->purchase_mount / $this->purchase_count;
        } else {
            $this->avg = '';
        }

        $this->loadChartData();
    }

    public function getDataWeek()
    {
        $this->purchase_count = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
              ->whereBetween('dateDay', [
                  now()->startOfWeek(),
                  now()->endOfWeek(),
              ])->count();
        $this->purchase_mount = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
         ->whereBetween('dateDay', [
             now()->startOfWeek(),
             now()->endOfWeek(),
         ])->sum('totalPrice');
        if ($this->purchase_count != 0) {
            $this->avg = $this->purchase_mount / $this->purchase_count;
        } else {
            $this->avg = '';
        }
    }

    public function getDataMonth()
    {
        $this->purchase_count = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
       ->whereMonth('dateDay', now()->month)
      ->whereYear('dateDay', now()->year)->count();
        $this->purchase_mount = Purchase::where('admin_id', Auth::guard('admin')->user()->id)
      ->whereMonth('dateDay', now()->month)
        ->whereYear('dateDay', now()->year)->sum('totalPrice');
        if ($this->purchase_count != 0) {
            $this->avg = $this->purchase_mount / $this->purchase_count;
        } else {
            $this->avg = '';
        }
    }

    public function render()
    {
        return view('livewire.dashboard.purchase-dashboard');
    }
}
