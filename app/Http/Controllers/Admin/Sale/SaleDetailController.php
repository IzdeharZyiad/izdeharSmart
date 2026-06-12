<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Models\ProductDetail;
use App\Models\PurchaseDetail;
use App\Models\Recipe;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleProductBatche;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleDetailController extends Controller
{
    public function SaleDetails($saleId)
    {
        $sale = Sale::find($saleId);
        $saleDetails = SaleDetail::where('sale_id', $saleId)->get();

        return view('Sale.saleDetails')->with(['sale' => $sale, 'saleDetails' => $saleDetails]);
    }

    public function AddSaleDetails($saleId)
    {
        $sale = Sale::find($saleId);
        $types = Type::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Sale.addSaleDetails')->with(['sale' => $sale, 'types' => $types]);
    }

    public function StoreSaleDetails(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric'],
            'totalPrice' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        if ($request->productSize_id == null) {
            return redirect()->back()->with('error', 'يرجى اختيار الحجم ');
        }
        // بدي اشوف اذا المنتج هاظ بحتوي على وصفه او لا
        if ($request->type == 'recipe') {
            $recipe = Recipe::where('product_detail_id', $request->productSize_id)->first();
            if ($recipe) {
                return $this->FIFOMaterial($recipe, $request);
            } else {
                return redirect()->back()->with('error', 'هذا المنتج لا يوجد له وصفة');
            }
        } else {
            $totalAvailable = PurchaseDetail::where('product_detail_id', $request->productSize_id)
             ->sum('remaining_quantity');

            if ($totalAvailable < $request->quantity) {
                return redirect()->back()->with('error', 'المخزون غير كافي');
            }

            try {
                DB::transaction(function () use ($request) {
                    $originalQty = $request->quantity;
                    $remainingQty = $request->quantity;
                    $totalCost = 0;

                    // 1. إنشاء SaleDetail أولاً
                    $SaleDetail = SaleDetail::create([
                        'sale_id' => $request->sale_id,
                        'product_detail_id' => $request->productSize_id,
                        'quantity' => $originalQty,
                        'sale_price' => $request->price,
                        'subtotal' => $request->totalPrice,
                        'profit' => 0, // رح نحسبه بعدين
                    ]);

                    // 2. جلب المخزون FIFO
                    $PurchaseDetails = PurchaseDetail::where('product_detail_id', $request->productSize_id)
                        ->where('remaining_quantity', '>', 0)
                        ->orderBy('purchase_id')
                        ->get();

                    foreach ($PurchaseDetails as $PurchaseDetail) {
                        if ($remainingQty <= 0) {
                            break;
                        }

                        $takeQty = min($PurchaseDetail->remaining_quantity, $remainingQty);

                        // تكلفة الشراء
                        $totalCost += $takeQty * $PurchaseDetail->unit_cost_after_discount;

                        // إنقاص المخزون من الدفعة
                        $PurchaseDetail->remaining_quantity -= $takeQty;
                        $PurchaseDetail->save();

                        // تسجيل الباتش وربطه بـ SaleDetail
                        SaleProductBatche::create([
                            'sale_id' => $request->sale_id,
                            'sale_detail_id' => $SaleDetail->id, // 🔥 أهم تعديل
                            'purchase_id' => $PurchaseDetail->purchase_id,
                            'quantity' => $takeQty,
                            'admin_id' => auth('admin')->id(),
                            'price_purchase' => $PurchaseDetail->unit_cost_after_discount,
                        ]);

                        $remainingQty -= $takeQty;
                    }

                    // 3. الحسابات
                    $revenue = $originalQty * $request->price;
                    $profit = $revenue - $totalCost;

                    $SaleDetail->update([
                        'profit' => $profit,
                        'purchase_cost' => $totalCost,
                    ]);

                    // 4. تحديث المخزون العام
                    $productDetail = ProductDetail::find($request->productSize_id);

                    StockMovement::create([
                        'product_detail_id' => $productDetail->id,
                        'type' => 'بيع',
                        'before_quantity' => $productDetail->Quantity,
                        'after_quantity' => $productDetail->Quantity - $originalQty,
                        'quantity' => $originalQty,
                        'sale_detail_id' => $SaleDetail->id,
                        'admin_id' => Auth::guard('admin')->id(),
                    ]);

                    $productDetail->Quantity -= $originalQty;
                    $productDetail->save();
                });

                return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public function FIFOMaterial(Recipe $recipe, Request $request)
    {
        $qty = $request->quantity;

        // 1. CHECK STOCK FIRST
        foreach ($recipe->details as $detail) {
            $requiredQty = $detail->quantity * $qty;
            $rawMaterial = $detail->rawMaterial;

            if ($rawMaterial->quantity < $requiredQty) {
                return redirect()->back()->with(
                    'error',
                    'مخزون '.$rawMaterial->name.' غير كافي'
                );
            }
        }

        // 2. PROCESS SALE
        DB::transaction(function () use ($request, $recipe, $qty) {
            // إنشاء البيع مرة واحدة
            $saleDetail = SaleDetail::create([
                'sale_id' => $request->sale_id,
                'product_detail_id' => $request->productSize_id,
                'quantity' => $qty,
                'sale_price' => $request->price,
                'subtotal' => $request->totalPrice,
                'profit' => 0,
            ]);

            $totalCost = 0;

            // 3. LOOP MATERIALS
            foreach ($recipe->details as $detail) {
                $rawMaterial = $detail->rawMaterial;

                $requiredQty = $detail->quantity * $qty;
                $remainingQty = $requiredQty;

                $purchaseDetails = PurchaseDetail::where('raw_material_id', $rawMaterial->id)
                    ->where('remaining_quantity', '>', 0)
                    ->orderBy('purchase_id')
                    ->get();

                foreach ($purchaseDetails as $purchaseDetail) {
                    if ($remainingQty <= 0) {
                        break;
                    }

                    $takeQty = min($purchaseDetail->remaining_quantity, $remainingQty);

                    // cost
                    $totalCost += $takeQty * ($purchaseDetail->unit_cost_after_discount / 1000);

                    // update batch
                    $purchaseDetail->remaining_quantity -= $takeQty;
                    $purchaseDetail->save();

                    // log batch usage
                    SaleProductBatche::create([
                        'sale_id' => $request->sale_id,
                        'sale_detail_id' => $saleDetail->id,
                        'purchase_id' => $purchaseDetail->purchase_id,
                        'quantity' => $takeQty,
                        'admin_id' => auth('admin')->id(),
                        'price_purchase' => $purchaseDetail->unit_cost_after_discount,
                    ]);

                    $remainingQty -= $takeQty;
                }

                // update stock movement (per raw material)
                StockMovement::create([
                    'raw_material_id' => $rawMaterial->id,
                    'type' => 'بيع',
                    'before_quantity' => $rawMaterial->quantity,
                    'after_quantity' => $rawMaterial->quantity - $requiredQty,
                    'quantity' => $requiredQty,
                    'sale_detail_id' => $saleDetail->id,
                    'admin_id' => auth('admin')->id(),
                ]);

                // update raw material stock
                $rawMaterial->quantity -= $requiredQty;
                $rawMaterial->save();
            }

            // 4. PROFIT CALCULATION (after all materials)
            $revenue = $qty * $request->price;
            $profit = $revenue - $totalCost;

            $saleDetail->update([
                'profit' => $profit,
                'purchase_cost' => $totalCost,
            ]);
        });

        return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
    }

    public function UpdateSaleDetail($saleDetailId)
    {
        $saleDetail = SaleDetail::find($saleDetailId);
        $types = Type::where('admin_id', Auth::guard('admin')->user()->id)->get();

        return view('Sale.updateSaleDetail')->with(['saleDetail' => $saleDetail, 'types' => $types]);
    }

    public function CancelSaleDetail($saleDetailId)
    {
        DB::transaction(function () use ($saleDetailId) {
            $saleDetail = SaleDetail::findOrFail($saleDetailId);
            $sale = Sale::find($saleDetail->sale_id);

            $batchs = SaleProductBatche::where('sale_detail_id', $saleDetail->id)->get();
            foreach ($batchs as $batch) {
                $purchaseDetail = PurchaseDetail::where('purchase_id', $batch->purchase_id)
                 ->where('product_detail_id', $saleDetail->product_detail_id)->first();

                if ($purchaseDetail) {
                    $purchaseDetail->remaining_quantity += $batch->quantity;
                    $purchaseDetail->save();
                }

                $batch->delete();
            }

            $productDetail = ProductDetail::find($saleDetail->product_detail_id);

            StockMovement::create([
                'product_detail_id' => $productDetail->id,
                'type' => 'إلغاء بيع',
                'before_quantity' => $productDetail->Quantity,
                'after_quantity' => $productDetail->Quantity + $saleDetail->quantity,
                'quantity' => $saleDetail->quantity,
                'sale_detail_id' => null,
                'admin_id' => auth('admin')->id(),
            ]);

            $productDetail->Quantity += $saleDetail->quantity;
            $productDetail->save();

            StockMovement::where('sale_detail_id', $saleDetail->id)
            ->update([
                'sale_detail_id' => null,
            ]);

            $saleDetail->delete();
            $totalPrice = SaleDetail::where('sale_id', $saleDetail->sale_id)
             ->sum('subtotal');

            $totalProfit = SaleDetail::where('sale_id', $saleDetail->sale_id)
              ->sum('profit');
            $pastTotal = $sale->totalPrice;
            $sale->totalPrice = $totalPrice;
            $sale->totalProfit = $totalProfit;
            if ($totalPrice == 0) {
                $sale->status = 'ملغية';
            }
            $sale->save();
            $carbon = Carbon::now('Asia/Gaza');

            Transaction::create([
                'dateDay' => $carbon->format('Y-m-d'),
                'dayName' => $carbon->translatedFormat('l'),
                'sale_id' => $sale->id,
                'purchase_id' => null,
                'amount' => ($pastTotal - $totalPrice) * -1,
                'payment_methode' => 'كاش',
                'type' => 'بيع مرتجع',
                'refrece_id' => $sale->id,
                'admin_id' => auth('admin')->id(),
            ]);
        });
    }
}
