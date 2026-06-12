<?php

namespace App\Livewire\Reports;

use App\Models\Custemer;
use App\Models\Sale;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class AccountStatmentCustemer extends Component
{
    public $filter;
    public $custmers;
    public $custemer_id;
    public $sales = [];
    public $transictions = [];
    public $statements = [];
    public $sumSale;
    public $custemer;
    public $sumTransiction;
    public $reset;
    public $endDate;
    public $firstDate;

    public function mount($custmers)
    {
        Carbon::setLocale('ar');
        $carbon = Carbon::now('Asia/Gaza');
        $this->endDate = $carbon->format('Y-m-d');
        $this->firstDate = $carbon->format('Y-m-d');
        $this->custmers = $custmers;
        $this->filter = 'all';
    }

    public function updatCustemer_id($custemer_id)
    {
        $this->custemer_id = $custemer_id;
        $this->getAllInfo();
        $this->dispatch('refreshTable');
    }

    public function getAllInfo()
    {
        $this->sales = Sale::where('custemer_id', $this->custemer_id)
            ->orderBy('dateDay', 'asc')->get()->map(function ($sale) {
                return [
                    'date' => $sale->dateDay,
                    'type' => 'فاتورة',
                    'info' => 'فاتورة بيع رقم '.$sale->id,
                    'debit' => $sale->totalPrice,
                    'credit' => 0,
                ];
            });

        $this->custemer = Custemer::find($this->custemer_id);

        $this->sumSale = $this->custemer->sale->sum('totalPrice');
        $this->sumTransiction = Transaction::whereHas('sale', function ($q) {
            $q->where('custemer_id', $this->custemer_id);
        })->sum('amount');

        $this->reset = $this->sumSale - $this->sumTransiction;

        $this->transictions = Transaction::whereHas('sale', function ($q) {
            $q->where('custemer_id', $this->custemer_id);
        })->get()->map(function ($transiction) {
            return [
                'date' => $transiction->dateDay,
                'type' => 'دفعة',
                'info' => 'كاش',
                'debit' => 0,
                'credit' => $transiction->amount,
            ];
        });

        $this->statements = $this->sales
         ->concat($this->transictions)
          ->sortBy('date')
         ->values();

        $balance = 0;
        $this->statements = $this->statements->map(function ($item) use (&$balance) {
            $balance += $item['debit'] - $item['credit'];

            $item['balance'] = $balance;

            return $item;
        });
    }

    public function getspecifiedInfo()
    {
        $this->sales = Sale::where('custemer_id', $this->custemer_id)
        ->whereBetween('dateDay', [$this->firstDate,  $this->endDate])
           ->orderBy('dateDay', 'asc')->get()->map(function ($sale) {
               return [
                   'date' => $sale->dateDay,
                   'type' => 'فاتورة',
                   'info' => 'فاتورة بيع رقم '.$sale->id,
                   'debit' => $sale->totalPrice,
                   'credit' => 0,
               ];
           });

        $this->custemer = Custemer::find($this->custemer_id);

        $this->sumSale = $this->custemer->sale->sum('totalPrice');
        $this->sumTransiction = Transaction::whereHas('sale', function ($q) {
            $q->where('custemer_id', $this->custemer_id);
        })->sum('amount');

        $this->reset = $this->sumSale - $this->sumTransiction;

        $this->transictions = Transaction::whereHas('sale', function ($q) {
            $q->where('custemer_id', $this->custemer_id)
            ->whereBetween('dateDay', [$this->firstDate,  $this->endDate]);
        })->get()->map(function ($transiction) {
            return [
                'date' => $transiction->dateDay,
                'type' => 'دفعة',
                'info' => 'كاش',
                'debit' => 0,
                'credit' => $transiction->amount,
            ];
        });

        $this->statements = $this->sales
         ->concat($this->transictions)
          ->sortBy('date')
         ->values();

        $balance = 0;
        $this->statements = $this->statements->map(function ($item) use (&$balance) {
            $balance += $item['debit'] - $item['credit'];

            $item['balance'] = $balance;

            return $item;
        });
    }

    public function updateFirstDate($firstDate)
    {
        $this->firstDate = $firstDate;
        $this->getspecifiedInfo();
        $this->dispatch('refreshTable');
    }

    public function updateEndDate($endDate)
    {
        $this->endDate = $endDate;
        $this->getspecifiedInfo();
        $this->dispatch('refreshTable');
    }

    public function exportPdf()
    {
        return redirect()->to(route('accountStatmentCustemerPdf', ['custemerId' => $this->custemer_id]));
    }

    public function render()
    {
        return view('livewire.reports.account-statment-custemer');
    }
}
