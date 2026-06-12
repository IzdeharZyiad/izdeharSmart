<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function Attendances($userId)
    {
        $user = User::find($userId);
        $cycle = $user->salaryCycles()->where('is_closed', false)->latest()->first();
        $attendances = Attendance::where('user_id', $userId)->get();
        $events = $attendances->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->status,
                'start' => $item->date,
                'color' => $item->status === 'حضور' ? 'green' :
                           ($item->status === 'غياب' ? 'red' : 'orange'),
            ];
        });

        return view('User.attendances')->with(['user' => $user, 'events' => $events, 'cycle' => $cycle]);
    }

    public function Advance($userId)
    {
        $user = User::find($userId);
        $cycle = $user->salaryCycles()->where('is_closed', false)->latest()->first();
        $advances = Advance::where('user_id', $userId)->get();

        return view('User.advance')->with(['user' => $user, 'advances' => $advances, 'cycle' => $cycle]);
    }

    public function Salary($userId)
    {
        $user = User::find($userId);
        $cycle = $user->salaryCycles()->where('is_closed', false)->latest()->first();
        $salaryes = Salary::where('user_id', $userId)->get();

        return view('User.salary')->with(['user' => $user, 'salaryes' => $salaryes, 'cycle' => $cycle]);
    }

    public function UpdateUser($userId)
    {
        $user = User::find($userId);

        return view('User.updateUser')->with('user', $user);
    }

    public function EditUser(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'phoneNumber' => ['required', 'numeric'],
            'idNumber' => ['nullable', 'numeric', 'digits:9'],
            'salary_amount' => ['required', 'numeric', 'min:0'],
        ],
            [
                'phoneNumber.required' => 'يجب تعبئة هذا الحقل',
                'phoneNumber.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'phoneNumber.regex' => 'الرجاء كتابة رقم الهاتف بشكل صحيح',
                'name.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.required' => 'يجب تعبئة هذا الحقل',
                'idNumber.numeric' => 'يجب ان يحتوي الحقل  على  ارقام فقط',
                'idNumber.digits' => 'يجب ان يحتوي الحقل  على  9  ارقام فقط',
                'salary_amount.required' => 'يجب تعبئة هذا الحقل',
                'salary_amount.numeric' => 'يجب ان يحتوي  الحقل على  ارقام فقط',
                'salary_amount.min' => 'يجب ان يحتوي  الحقل على  رقم اكبر من 0 ',
            ]
        );

        $user = User::find($request->userId);

        $found = User::where(['phoneNumber' => $request->phoneNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        $found_idNumber = User::where(['idNumber' => $request->idNumber, 'admin_id' => Auth::guard('admin')->user()->id])->get();

        if ($user->idNumber == $request->idNumber && $user->phoneNumber == $request->phoneNumber) {
            $user->name = $request->name;
            $user->salary_amount = $request->salary_amount;
            $user->save();

            return redirect()->back()->with('success', 'تم التعديل بنجاح');
        } elseif ($user->idNumber != $request->idNumber && $user->phoneNumber == $request->phoneNumber) {
            if (blank($found_idNumber)) {
                $user->idNumber = $request->idNumber;
                $user->name = $request->name;
                $user->salary_amount = $request->salary_amount;
                $user->save();

                return redirect()->back()->with('success', 'تم التعديل بنجاح');
            } else {
                return redirect()->back()->with('error', 'رقم الهوية موجود سابقا');
            }
        } elseif ($user->idNumber == $request->idNumber && $user->phoneNumber != $request->phoneNumber) {
            if (blank($found)) {
                $user->name = $request->name;
                $user->phoneNumber = $request->phoneNumber;
                $user->salary_amount = $request->salary_amount;
                $user->save();

                return redirect()->back()->with('success', 'تم التعديل بنجاح');
            } else {
                return redirect()->back()->with('error', 'رقم الهاتف موجود سابقا');
            }
        } else {
            if (blank($found) && blank($found_idNumber)) {
                $user->phoneNumber = $request->phoneNumber;
                $user->idNumber = $request->idNumber;
                $user->name = $request->name;
                $user->salary_amount = $request->salary_amount;
                $user->save();

                return redirect()->back()->with('success', 'تم التعديل بنجاح');
            } else {
                return redirect()->back()->with('error', 'لا يمكن التعديل تأكد من بياناتك');
            }
        }
    }
}
