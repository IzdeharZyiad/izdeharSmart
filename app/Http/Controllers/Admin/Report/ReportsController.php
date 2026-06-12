<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Custemer;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function AccountStatementCustemer()
    {
        $custmers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Report.AccountStatementCustemer')->with('custmers', $custmers);
    }

    public function ProductName()
    {
        $types = Type::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Report.productName')->with('types', $types);
    }

    public function ReportCustemers()
    {
        $custemers = Custemer::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Report.custemerReport')->with('custemers', $custemers);
    }
}
