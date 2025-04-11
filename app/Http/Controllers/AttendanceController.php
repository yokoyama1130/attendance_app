<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::whereDate('date', Carbon::today())->first();
        return view('attendance.index', compact('attendance'));
    }

    public function store(Request $request)
    {
        $attendance = Attendance::whereDate('date', Carbon::today())->first();
        $action = $request->input('action');

        if (!$attendance) {
            if ($action === 'clock_in') {
                Attendance::create([
                    'date' => Carbon::today(),
                    'clock_in' => now(),
                ]);
            } else {
                return back()->withErrors(['error' => '最初に出勤を打刻してください。']);
            }
        } else {
            switch ($action) {
                case 'break_start':
                    if (!$attendance->break_start) {
                        $attendance->update(['break_start' => now()]);
                    } else {
                        return back()->withErrors(['error' => '休憩開始はすでに打刻されています。']);
                    }
                    break;
                case 'break_end':
                    if ($attendance->break_start && !$attendance->break_end) {
                        $attendance->update(['break_end' => now()]);
                    } else {
                        return back()->withErrors(['error' => '休憩開始後でないと休憩終了は打刻できません。']);
                    }
                    break;
                case 'clock_out':
                    if ($attendance->break_end && !$attendance->clock_out) {
                        $attendance->update(['clock_out' => now()]);
                    } else {
                        return back()->withErrors(['error' => '退勤は休憩終了後でないと打刻できません。']);
                    }
                    break;
                default:
                    return back()->withErrors(['error' => '無効な操作です。']);
            }
        }

        return redirect()->route('attendance.index');
    }
}
