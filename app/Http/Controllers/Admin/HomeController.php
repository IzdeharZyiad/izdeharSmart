<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cheque;
use App\Models\Expense;
use App\Models\InstallmentDetail;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\RawMaterial;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Seller;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function Login()
    {
        return view('login');
    }

    public function Settings()
    {
        return view('settings');
    }

    public function UpdateSettings(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ],
            [
                'name.required' => 'يجب تعبئة هذاالحقل',
            ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->name = $request->name;
        $admin->company_name = $request->company_name;
        $admin->save();

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function Sellers()
    {
        $sellers = Seller::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Seller.sellers')->with(['sellers' => $sellers]);
    }

    public function Types()
    {
        $types = Type::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Type.types')->with('types', $types);
    }

    public function Dashboard()
    {
        return view('Dashboard.dashboard');
    }

    public function Purchases()
    {
        $purchases = Purchase::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Purchase.purchases')->with('purchases', $purchases);
    }

    public function Sales()
    {
        $sales = Sale::where(['admin_id' => Auth::guard('admin')->user()->id])->get();

        return view('Sale.Sales')->with('sales', $sales);
    }

    public function Stocks()
    {
        $products = Product::where(['admin_id' => Auth::guard('admin')->user()->id])->get();

        return view('Stock.Stocks')->with('products', $products);
    }

    public function Financials()
    {
        $SumPurchase = Purchase::where('admin_id', Auth::guard('admin')->user()->id)->sum('totalPrice');

        $SumSale = Sale::where('admin_id', Auth::guard('admin')->user()->id)->sum('totalPrice');

        $SumTransication = Transaction::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('purchase_id', '!=', 'null')->sum('amount');

        $SumSaleCash = Transaction::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('sale_id', '!=', 'null')->sum('amount');

        $SumProfit = SaleDetail::whereHas('sale', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->user()->id);
        })->sum('profit');

        $sumExpenses = Expense::where('admin_id', Auth::guard('admin')->user()->id)->sum('mount');

        $profit = $SumProfit - $sumExpenses;

        $sumCheque = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('chequeable_type', Purchase::class)
        ->sum('amount');

        $sumInstallment = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Purchase::class);
        })
    ->where('status', 'غير مدفوع')
    ->sum('amount');

        $sumChequeSale = Cheque::where('admin_id', Auth::guard('admin')->user()->id)
        ->where('status', 'غير مقبوض')
        ->where('chequeable_type', Sale::class)
        ->sum('amount');

        $sumInstallmentSale = InstallmentDetail::whereHas('installment', function ($q) {
            $q->where('admin_id', Auth::guard('admin')->id())
             ->where('installmentable_type', Sale::class);
        })
    ->where('status', 'غير مدفوع')
    ->sum('amount');

        $sum = $sumCheque + $sumInstallment;
        $receivable = $sumChequeSale + $sumInstallmentSale;

        return view('Financial.financials')->with(['SumPurchase' => $SumPurchase,
            'SumTransication' => $SumTransication, 'sum' => $sum, 'SumSale' => $SumSale,
            'SumSaleCash' => $SumSaleCash,
            'receivable' => $receivable, 'profit' => $profit,
            'sumExpenses' => $sumExpenses]);
    }

    public function Users()
    {
        $users = User::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('User.users')->with('users', $users);
    }

    public function Custemers()
    {
        return view('Custemer.custemers');
    }

    public function Reports()
    {
        return view('Report.reports');
    }

    public function RawMaterials()
    {
        $rawMaterials = RawMaterial::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Material.RawMaterials')->with('rawMaterials', $rawMaterials);
    }
}
