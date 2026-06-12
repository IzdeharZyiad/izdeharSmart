<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function ForgetPassword()
    {
        return view('ForgetPassword');
    }

    public function StoreforgetPassword(Request $request)
    {
        $adminId = Admin::where('phoneNumber', $request->phoneNumber)->get('id');

        if (blank($adminId)) {
            return redirect()->back()->with('error', 'رقم الهاتف غير موجود');
        } else {
            try {
                $admin = Admin::find($adminId);
                $admin[0]->password = Hash::make($request->password);
                $admin[0]->save();

                return redirect()->back()->with('success', 'تم التعديل بنجاح');
            } catch (\Illuminate\Database\QueryException $q) {
                return redirect()->back()->with('error', 'حدث خطأ ما يرجى المحاولة لاحقا');
            }
        }
    }

    public function Login(Request $request)
    {
        try {
            if (Auth::guard('admin')->attempt($request->only('phoneNumber', 'password'))) {
                $request->session()->regenerate(); // 🔥 مهم للأمان
                $request->session()->put('adminName', Auth::guard('admin')->user()->name);

                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'يرجى التأكد من بياناتك ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ ما يرجى المحاوله لاحقا ');
        }
    }

    public function Logout(Request $request)
    {
        Auth::guard('admin')->logout(); // 🔐 تسجيل خروج الأدمن

        $request->session()->invalidate();      // حذف الجلسة
        $request->session()->regenerateToken();
        $request->session()->forget('adminName'); // حماية CSRF

        return redirect()->route('login'); // رجوع لصفحة الدخول
    }
}
