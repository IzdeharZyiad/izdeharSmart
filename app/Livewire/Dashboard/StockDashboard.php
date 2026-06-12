<?php

namespace App\Livewire\Dashboard;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StockDashboard extends Component
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
    public $ProductCount;
    public $ProductQuantity;
    public $maxProduct;
    public $lowProducts;

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
        $this->Product = Product::where('admin_id', Auth::guard('admin')->user()->id)->get();

        $this->ProductCount = Product::where('admin_id', Auth::guard('admin')->user()->id)->count();
        $this->ProductQuantity = $this->Product->flatMap->productDetail->sum('Quantity');
        $this->maxProduct = Product::with('productDetail')
      ->get()
      ->map(function ($product) {
          $product->total = $product->productDetail->sum('Quantity');

          return $product;
      })
      ->sortByDesc('total')
       ->first()->name;

        $this->renderChartBar();
        $this->dispatch('updateChartBar', [
            'labelsBar' => $this->labelsBar,
            'valuesBar' => $this->valuesBar,
        ]);

        /* $this->getDataToday();
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
         ]);*/
    }

    public function renderChartBar()
    {
        $this->lowProducts = Product::with('productDetail')
         ->get()
              ->map(function ($product) {
                  $product->total = $product->productDetail->sum('Quantity');

                  return $product;
              })
      ->filter(function ($product) {
          return $product->productDetail->sum('Quantity')
              <= $product->productDetail->min('lessQuantity');
      })
   ->sortBy('total')
    ->take(10);

        $this->labelsBar = $this->lowProducts->pluck('name');

        $this->valuesBar = $this->lowProducts->pluck('total');
    }

    public function render()
    {
        return view('livewire.dashboard.stock-dashboard');
    }
}
