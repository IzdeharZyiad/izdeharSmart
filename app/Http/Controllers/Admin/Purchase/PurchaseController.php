<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\ProductDetail;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\RawMaterial;
use App\Models\Seller;
use App\Models\StockMovement;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function AddPurchase()
    {
        $sellers = Seller::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Purchase.addPurchase')->with('sellers', $sellers);
    }

    public function StorePurchase(Request $request)
    {
        $payment_type = null;
        if ($request->seller_id == 0) {
            return redirect()->back()->with('error', 'يرجى اختيار اسم التاجر');
        } elseif ($request->payment_type == null) {
            return redirect()->back()->with('error', 'يرجى اختيار طبيعة الدفع');
        } else {
            if ($request->payment_type == 0) {
                $payment_type = 'كاش';
            } elseif ($request->payment_type == 1) {
                $payment_type = 'شيك';
            } elseif ($request->payment_type == 2) {
                $payment_type = 'تقسيط';
            } else {
            }
            try {
                $purchase = Purchase::create([
                    'seller_id' => $request->seller_id,
                    'dateDay' => $request->dateToday,
                    'dayName' => $request->dayName,
                    'payment_type' => $payment_type,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);

                return redirect()->route('purchases.purchaseDetails', ['purchaseId' => $purchase->id]);
            } catch (\illuminate\Database\QueryException $e) {
                return redirect()->back()->with('error', 'حدثت مشكلة يرجى المحاولة لاحقا');
            }
        }
    }

    public function PurchaseDetails($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $purchaseDetails = PurchaseDetail::where('purchase_id', $purchaseId)->get();

        return view('Purchase.purchaseDetails')->with(['purchase' => $purchase, 'purchaseDetails' => $purchaseDetails]);
    }

    public function AddPurchaseDetails($purchaseId)
    {
        $purchase = Purchase::find($purchaseId);
        $types = Type::where('admin_id', auth('admin')->id())->get();
        $rawMaterials = RawMaterial::where('admin_id', auth('admin')->id())->get();

        return view('Purchase.addPurchaseDetails')->with(['purchase' => $purchase, 'types' => $types, 'rawMaterials' => $rawMaterials]);
    }

    public function StorePurchaseDetails(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ], [
            'quantity.required' => 'يجب تعبئة هذا الحقل',
            'quantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'price.required' => 'يجب تعبئة هذا الحقل',
            'price.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
        ]);

        $purchaseData = [
            'quantity' => $request->quantity,
            'price' => $request->price,
            'type' => $request->type,
            'subtotal' => $request->totalPrice,
            'purchase_id' => $request->purchase_id,
        ];

        if ($request->type == 'product') {
            if ($request->productSize_id == null) {
                return redirect()->back()->with('error', 'يرجى اختيار الحجم ');
            } else {
                $purchaseData['product_detail_id'] = $request->productSize_id;
                $purchaseData['remaining_quantity'] = $request->quantity;
                $purchaseDetail = PurchaseDetail::create($purchaseData);
                $productDetail = ProductDetail::find($request->productSize_id);
                StockMovement::create([
                    'product_detail_id' => $productDetail->id,
                    'type' => 'شراء',
                    'before_quantity' => $productDetail->Quantity,
                    'after_quantity' => $productDetail->Quantity + $request->quantity,
                    'quantity' => $request->quantity,
                    'purchase_detail_id' => $purchaseDetail->id,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);
                $productDetail->Quantity += $request->quantity;
                $productDetail->save();

                return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
            }
        } else {
            if ($request->rawMaterial_id == null) {
                return redirect()->back()->with('error', 'يرجى اختيار الماده الخام ');
            } else {
                $purchaseData['raw_material_id'] = $request->rawMaterial_id;
                $purchaseData['remaining_quantity'] = $request->quantity * 1000;
                $purchaseDetail = PurchaseDetail::create($purchaseData);
                $rawMaterial = RawMaterial::find($request->rawMaterial_id);
                StockMovement::create([
                    'raw_material_id' => $rawMaterial->id,
                    'type' => 'شراء',
                    'before_quantity' => $rawMaterial->quantity,
                    'after_quantity' => $rawMaterial->quantity + $request->quantity * 1000,
                    'quantity' => $request->quantity,
                    'purchase_detail_id' => $purchaseDetail->id,
                    'admin_id' => Auth::guard('admin')->user()->id,
                ]);

                $rawMaterial->quantity += $request->quantity * 1000;
                $rawMaterial->save();

                return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
            }
        }
    }
}
