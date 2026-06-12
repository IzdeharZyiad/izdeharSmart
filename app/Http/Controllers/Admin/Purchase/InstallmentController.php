<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\InstallmentDetail;
use App\Models\Purchase;
use App\Models\Seller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentController extends Controller
{
    public function Instalment($purchaseId, $installmentId = null)
    {
        $purchase = Purchase::find($purchaseId);
        if ($installmentId != null) {
            $installment = Installment::find($installmentId);

            $installmentDetails = InstallmentDetail::where('installment_id', $installment->id)->get();

            return view('Installment.installments')->with(['purchase' => $purchase, 'installmentDetails' => $installmentDetails]);
        } else {
            return view('Installment.installments')->with(['purchase' => $purchase, 'installmentDetails' => []]);
        }
    }

    public function AddInstalment($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);

        return view('Installment.addInstallment')->with('purchase', $purchase);
    }

    public function StoreInstalment(Request $request)
    {
        $purchase = Purchase::find($request->purchaseId);
        $pruchase_date = $purchase->dateDay;

        $seller = Seller::find($purchase->seller->id);

        $startDate = Carbon::parse($request->startDate);
        if ($startDate < $pruchase_date) {
            return redirect()->back()->with('error', 'هذا التاريخ قبل عملية الشراء');
        }
        if ($request->finalMount < 0) {
            return redirect()->back()->with('error', 'المبلغ النهائي يجب ان يكون موجب');
        } elseif ($request->intervalType == null) {
            return redirect()->back()->with('error', 'يرجى اختيار نوع المده');
        } else {
            try {
                $installment = $purchase->installment()->create([
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
                        'purchase_id' => $purchase->id,
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

                $seller->balance += $request->finalMount;
                $seller->save();

                return redirect()->route('purchases.instalment', ['purchaseId' => $purchase->id, 'installmentId' => $installment->id]);
            } catch (\illuminate\Database\QueryException $e) {
                return redirect()->back()->with('error', 'حدثت مشكلة يرجى المحاولة لاحقا');
            }
        }
    }

    public function AddInstallmentMount($installmentDetailId)
    {
        $installmentDetail = InstallmentDetail::find($installmentDetailId);

        return view('Installment.addInstallmentMount')->with('installmentDetail', $installmentDetail);
    }

    public function StoreInstallmentMount(Request $request)
    {
        $installmentDetail = InstallmentDetail::find($request->installmentDetailId);

        $purchase = Purchase::find($installmentDetail->installment->installmentable->id);
        $seller = Seller::find($purchase->seller->id);

        $installment = Installment::find($installmentDetail->installment->id);

        $date_purchase = $installmentDetail->installment->installmentable->dateDay;
        if ($request->dateToday < $date_purchase) {
            return redirect()->back()->with('error', 'هذا التاريخ قبل عمليةالشراء');
        } else {
            if ($installmentDetail->status == 'غير مدفوع') {
                Transaction::create([
                    'dateDay' => $request->dateToday,
                    'dayName' => $request->dayName,
                    'purchase_id' => $installmentDetail->installment->purchase_id,
                    'amount' => $request->mount,
                    'payment_methode' => 'كاش',
                    'type' => 'دفع',
                    'refrece_id' => $installmentDetail->installment->id,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
                $installmentDetail->status = 'مدفوع';
                $installmentDetail->save();

                $seller->balance -= $request->mount;
                $seller->save();

                $sumMount = Transaction::where('refrece_id', $installmentDetail->installment->id)->sum('amount');

                if ($purchase->finalPrice == $sumMount) {
                    $purchase->status = 'مدفوع';
                    $purchase->save();
                }

                if ($purchase->status == 'مدفوع') {
                    $installment->status = 'مدفوع';
                    $installment->save();
                }

                return redirect()->back()->with('success', 'تم تسجيل الدفعه بنجاح');
            } else {
                return redirect()->back()->with('error', 'تم تسجيل الدفعه سابقا');
            }
        }
    }
}
