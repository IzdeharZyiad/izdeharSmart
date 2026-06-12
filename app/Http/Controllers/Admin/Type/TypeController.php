<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductDetails;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\RawMaterial;
use App\Models\Recipe;
use App\Models\RecipeDetial;
use App\Models\StockMovement;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function Items($typeId)
    {
        $type = Type::find($typeId);

        return view('Type.items')->with(['typeId' => $typeId, 'typeName' => $type->name]);
    }

    public function Products($itemId)
    {
        $item = Item::find($itemId);
        $products = Product::where('item_id', $itemId)->get();

        return view('Type.products')->with(['item' => $item, 'products' => $products]);
    }

    public function addProductDetails($itemId, $productId)
    {
        $item = Item::find($itemId);
        $product = Product::find($productId);

        return view('Type.addProductDetails')->with(['item' => $item, 'product' => $product]);
    }

    public function ProductDetails($itemId, $productId)
    {
        $item = Item::find($itemId);
        $product = Product::find($productId);
        $ProductDetails = ProductDetail::where('product_id', $product->id)->get();

        return view('Type.productDetails')->with(['item' => $item, 'product' => $product, 'ProductDetails' => $ProductDetails]);
    }

    public function storeProductDetails(AddProductDetails $request)
    {
        if ($request->size == '') {
            return redirect()->back()->with('error', 'يرجى اختيار الحجم');
        } else {
            $befor_Quantity = ProductDetail::where(['size' => $request->size, 'product_id' => $request->product_id])->get('Quantity')->first();
            $befor = '';

            if (blank($befor_Quantity)) {
                $befor = 0;
            } else {
                $befor = $befor_Quantity->Quantity;
            }

            $ProductDetail = ProductDetail::create([
                'Quantity' => $request->Quantity,
                'sale_price' => $request->sale_price,
                'lessQuantity' => $request->lessQuantity,
                'size' => $request->size,
                'product_id' => $request->product_id,
            ]);

            $after_quantity = +$request->Quantity;

            StockMovement::create([
                'product_detail_id' => $ProductDetail->id,
                'type' => 'يدوي',
                'before_quantity' => $befor,
                'after_quantity' => $after_quantity,
                'quantity' => $request->Quantity,
                'purchase_detail_id' => null,
                'admin_id' => Auth::guard('admin')->user()->id,
            ]);

            return redirect()->back()->with('success', 'تم تسجيل البيانات بنجاح');
        }
    }

    public function UpdateProductDetail($productDetailId)
    {
        $productDetail = ProductDetail::find($productDetailId);

        return view('Type.updateProductDetail')->with('productDetail', $productDetail);
    }

    public function EditeProductDetail(AddProductDetails $request)
    {
        $productDetail = ProductDetail::find($request->productDetailId);

        $productDetail->sale_price = $request->sale_price;
        $productDetail->lessQuantity = $request->lessQuantity;
        $productDetail->save();

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function Recipes($productDetailId)
    {
        $productDetail = ProductDetail::find($productDetailId);
        $recipe = Recipe::firstOrCreate([
            'product_detail_id' => $productDetail->id,
        ], [
            'name' => $productDetail->product->name.' '.$productDetail->size,
            'admin_id' => auth('admin')->id(),
        ]);

        $recipeFound = Recipe::where(['product_detail_id' => $productDetail->id,  'admin_id' => auth('admin')->id()])->first();
        $recipeDetials = RecipeDetial::where(['recipe_id' => $recipeFound->id])->get();

        return view('Type.recipes')->with(['recipe' => $recipe, 'productDetail' => $productDetail, 'recipeDetials' => $recipeDetials]);
    }

    public function AddRecipeDetail($recipeId)
    {
        $recipe = Recipe::find($recipeId);
        $rawMetarials = RawMaterial::where('admin_id', auth('admin')->id())->get();

        return view('Type.addRecipeDetail')->with(['recipe' => $recipe, 'rawMetarials' => $rawMetarials]);
    }

    public function StoreRecipeDetail(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:0'],
        ], [
            'quantity.required' => 'يجب تعبئة هذا الحقل',
            'quantity.numeric' => 'يجب ان يحتوي الحقل على ارقام فقط',
            'quantity.min' => 'يجب ان يكون الحقل اكبر من او يساوي 0',
        ]);

        if ($request->raw_material_id == 0) {
            return redirect()->back()->with('error', 'يرجى اختيار الماده الخام');
        } else {
            $found = RecipeDetial::where(['recipe_id' => $request->recipe_id, 'raw_material_id' => $request->raw_material_id])->get();
            if (blank($found)) {
                RecipeDetial::create([
                    'recipe_id' => $request->recipe_id,
                    'raw_material_id' => $request->raw_material_id,
                    'quantity' => $request->quantity,
                ]);

                return redirect()->back()->with('success', 'تمت الاضافة  بنجاح');
            } else {
                return redirect()->back()->with('error', 'تم تسجيل الماده من قبل');
            }
        }
    }
}
