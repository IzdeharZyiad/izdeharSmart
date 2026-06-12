<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function PurchaseDashboard()
    {
        return view('Dashboard.purchaseDashboard');
    }

    public function SaleDashboard()
    {
        return view('Dashboard.saleDashboard');
    }

    public function StockDashboard()
    {
        return view('Dashboard.stockDashboard');
    }
}
