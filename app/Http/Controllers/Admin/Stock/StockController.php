<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use App\Models\PurchaseDetail;
use App\Models\StockMovement;

class StockController extends Controller
{
    public function StockMovments($productDetailId)
    {
        $stocks = StockMovement::where(['product_detail_id' => $productDetailId])->get();

        return view('Stock.StockMovment')->with('stocks', $stocks);
    }

    public function StockRefrence($purchaseDetailId)
    {
        $purchaseDetail = PurchaseDetail::where('id', $purchaseDetailId)->first();

        return view('Stock.stockRefrence')->with('purchaseDetail', $purchaseDetail);
    }
}
