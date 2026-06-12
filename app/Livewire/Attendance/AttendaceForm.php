<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\SalaryCycle;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class AttendaceForm extends Component
{
    public $open = false;
    public $errorMessage = '';
    public $successMessage = '';
    public $selectedDate;
    public $user_id;
    public $cycle_id;
    public $status;
    public $dateToday;
    public $attendance_id;
    public $attendance;

    protected $listeners = ['openAttendanceModal', 'openEditAttendance'];

    public function openAttendanceModal($date)
    {
        $this->openModal($date);
        $this->attendance_id = null;
        $this->status = null;
    }

    public function openEditAttendance($id)
    {
        $this->attendance = Attendance::find($id);
        $this->attendance_id = $this->attendance->id;
        $this->selectedDate = $this->attendance->date;
        $this->status = $this->attendance->status;
        $this->openModal($id);
    }

    public function mount($user_id, $cycle_id)
    {
        $this->user_id = $user_id;
        $this->cycle_id = $cycle_id;
        $carbon = Carbon::now('Asia/Gaza');
        $this->dateToday = $carbon->format('Y-m-d');
    }

    public function openModal($date)
    {
        $this->errorMessage = '';
        $this->successMessage = '';
        $this->selectedDate = $date;
        $this->open = true;
    }

    public function closeModal()
    {
        $this->open = false;
    }

    public function save()
    {
        Carbon::setLocale('ar');
        if ($this->attendance == null) {
            $user = User::find($this->user_id);
            $carbon = Carbon::parse($this->selectedDate)->timezone('Asia/Gaza');
            $this->selectedDate = $carbon->format('Y-m-d');
            $day = $carbon->translatedFormat('l');
            if ($this->selectedDate < $user->joinDate) {
                $this->successMessage = '';
                $this->errorMessage = 'هذا التاريخ قبل انضمام الموظف';
            } elseif ($this->selectedDate > $this->dateToday) {
                $this->successMessage = '';
                $this->errorMessage = 'هذا التاريخ لم يأتي بعد';
            } elseif ($this->status == null) {
                $this->successMessage = '';
                $this->errorMessage = 'الرجاء تحديد حالة الموظف';
            } else {
                $found = Attendance::where(['date' => $this->selectedDate, 'user_id' => $this->user_id])->get();
                if (blank($found)) {
                    Attendance::create([
                        'status' => $this->status,
                        'user_id' => $this->user_id,
                        'date' => $this->selectedDate,
                        'dayName' => $day,
                        'salary_cycle_id' => $this->cycle_id,
                    ]);

                    $this->successMessage = 'تمت الاضافة بنجاح';
                    $this->errorMessage = '';
                } else {
                    $this->successMessage = '';
                    $this->errorMessage = 'تمت تسجيل الحالة قبل';
                }
            }
        }

        if ($this->attendance != null) {
            $salaryCycle = SalaryCycle::find($this->attendance->salary_cycle_id);
            if ($salaryCycle->is_closed == 0 || $this->attendance->date == $salaryCycle->end_date) {
                $this->attendance->status = $this->status;
                $this->attendance->save();
                $this->successMessage = 'تم التعديل بنجاح';
                $this->errorMessage = '';
            } else {
                $this->errorMessage = 'لا يمكن التعديل';
                $this->successMessage = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.attendance.attendace-form');
    }
}
