<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Models\Custemer;
use App\Models\Installment;
use App\Models\InstallmentDetail;
use App\Models\Sale;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentSaleController extends Controller
{
    public function Instalment($saleId, $installmentId = null)
    {
        $sale = Sale::find($saleId);
        if ($installmentId != null) {
            $installment = Installment::find($installmentId);

            $installmentDetails = InstallmentDetail::where('installment_id', $installment->id)->get();

            return view('Installment.installmentSale')->with(['sale' => $sale, 'installmentDetails' => $installmentDetails]);
        } else {
            return view('Installment.installmentSale')->with(['sale' => $sale, 'installmentDetails' => []]);
        }
    }

    public function AddInstalment($saleId)
    {
        $sale = Sale::find($saleId);

        return view('Installment.addInstallmentSale')->with('sale', $sale);
    }

    public function StoreInstalment(Request $request)
    {
        $sale = Sale::find($request->saleId);

        $custemer = Custemer::find($sale->custemer->id);

        $sale_date = $sale->dateDay;

        $startDate = Carbon::parse($request->startDate);
        if ($startDate < $sale_date) {
            return redirect()->back()->with('error', 'هذا التاريخ قبل عملية البيع');
        }
        if ($request->finalMount < 0) {
            return redirect()->back()->with('error', 'المبلغ النهائي يجب ان يكون موجب');
        } elseif ($request->intervalType == null) {
            return redirect()->back()->with('error', 'يرجى اختيار نوع المده');
        } else {
            try {
                $installment = $sale->installment()->create([
                    'firstPay' => $request->firstPay,
                    'finalMount' => $request->finalMount,
                    'installmentsCount' => $request->installmentsCount,
                    'installmentAmount' => $request->installmentAmount,
                    'intervalDays' => $request->intervalDays,
                    'dateDay' => $request->startDate,
                    'status' => 'غير مدفوع',
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);

                if ($request->firstPay != 0) {
                    Transaction::create([
                        'dateDay' => $request->dateToday,
                        'dayName' => $request->dayName,
                        'sale_id' => $sale->id,
                        'amount' => $request->firstPay,
                        'payment_methode' => 'كاش',
                        'type' => 'دفع',
                        'refrece_id' => $installment->id,
                        'admin_id' => Auth::guard('admin')->user()->id,
                    ]);
                }

                for ($i = 0; $i < $request->installmentsCount; ++$i) {
                    if ($request->intervalType == 'day') {
                        $date = $startDate->copy()->addDays($i * $request->intervalDays);
                    }

                    if ($request->intervalType == 'week') {
                        $date = $startDate->copy()->addWeeks($i * $request->intervalDays);
                    }

                    if ($request->intervalType == 'month') {
                        $date = $startDate->copy()->addMonths($i * $request->intervalDays);
                    }
                    InstallmentDetail::create([
                        'installment_id' => $installment->id,
                        'amount' => $request->installmentAmount,
                        'due_date' => $date->format('Y-m-d'),
                        'status' => 'غير مدفوع',
                    ]);
                }

                $custemer->balance += $request->finalMount;
                $custemer->save();

                return redirect()->route('sales.instalment', ['saleId' => $sale->id, 'installmentId' => $installment->id]);
            } catch (\illuminate\Database\QueryException $e) {
                // return redirect()->back()->with('error', 'حدثت مشكلة يرجى المحاولة لاحقا');
                return redirect()->back()->with('error', $e);
            }
        }
    }

    public function AddInstallmentMount($installmentDetailId)
    {
        $installmentDetail = InstallmentDetail::find($installmentDetailId);

        return view('Installment.addInstallmentMountSale')->with('installmentDetail', $installmentDetail);
    }

    public function StoreInstallmentMount(Request $request)
    {
        $installmentDetail = InstallmentDetail::find($request->installmentDetailId);

        $sale = Sale::find($installmentDetail->installment->installmentable->id);
        $custemer = Custemer::find($sale->custemer->id);

        $installment = Installment::find($installmentDetail->installment->id);

        $date_sale = $installmentDetail->installment->installmentable->dateDay;
        if ($request->dateToday < $date_sale) {
            return redirect()->back()->with('error', 'هذا التاريخ قبل عملية البيع');
        } else {
            if ($installmentDetail->status == 'غير مدفوع') {
                Transaction::create([
                    'dateDay' => $request->dateToday,
                    'dayName' => $request->dayName,
                    'sale_id' => $installmentDetail->installment->sale_id,
                    'amount' => $request->mount,
                    'payment_methode' => 'كاش',
                    'type' => 'بيع',
                    'refrece_id' => $installmentDetail->installment->id,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
                $installmentDetail->status = 'مدفوع';
                $installmentDetail->save();

                $custemer->balance -= $request->mount;
                $custemer->save();

                $sumMount = Transaction::where('refrece_id', $installmentDetail->installment->id)->sum('amount');

                if ($sale->totalPrice == $sumMount) {
                    $sale->status = 'مدفوع';
                    $sale->save();
                }

                if ($sale->status == 'مدفوع') {
                    $installment->status = 'مدفوع';
                    $installment->save();
                }

                return redirect()->back()->with('success', 'تم تسجيل الدفعه بنجاح');
            } else {
            }

            return redirect()->back()->with('error', 'تم تسجيل الدفعه سابقا');
        }
    }
}
