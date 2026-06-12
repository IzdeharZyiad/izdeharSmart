<?php

namespace App\Http\Controllers\Admin\Material;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function AddMatrial()
    {
        return view('Material.addMaterial');
    }

    public function StoreMatrial(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:0'],
            'lessQuantity' => ['required', 'numeric',  'min:0'],
            'name' => ['required'],
        ], [
            'quantity.required' => 'يجب تعبئة هذا الحقل',
            'quantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'quantity.min' => 'يجب ان يحتوي الحقل على رقم اكبر من او يساوي 0 ',
            'name.required' => 'يجب تعبئة هذا الحقل',
            'lessQuantity.required' => 'يجب تعبئة هذا الحقل',
            'lessQuantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'lessQuantity.min' => 'يجب ان يحتوي الحقل على رقم اكبر من او يساوي 0 ',
        ]);

        if ($request->unit == 0) {
            return redirect()->back()->with('error', 'يرجى اختيار الوحدة ');
        } else {
            $found = RawMaterial::where(['name' => $request->name, 'admin_id' => Auth::guard('admin')->user()->id])->get();
            if (blank($found)) {
                DB::transaction(function () use ($request) {
                    $rawMaterial = RawMaterial::create(
                        [
                            'name' => $request->name,
                            'quantity' => $request->quantity,
                            'unit' => $request->unit,
                            'pruches_unit' => $request->pruches_unit,
                            'lessQuantity' => $request->lessQuantity,
                            'admin_id' => Auth::guard('admin')->user()->id,
                        ]);

                    StockMovement::create([
                        'product_detail_id' => null,
                        'raw_material_id' => $rawMaterial->id,
                        'type' => 'يدوي',
                        'before_quantity' => 0,
                        'after_quantity' => $rawMaterial->quantity,
                        'quantity' => $request->quantity,
                        'sale_detail_id' => null,
                        'admin_id' => auth('admin')->id(),
                    ]);
                });

                return redirect()->back()->with('success', 'تمت الاضافة بنجاح');
            } else {
                return redirect()->back()->with('error', 'تم تسجيل الماده من قبل');
            }
        }
    }
}
