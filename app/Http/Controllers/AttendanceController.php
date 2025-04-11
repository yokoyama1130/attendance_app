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

        if (!$attendance) {
            $attendance = Attendance::create([
                'date' => Carbon::today(),
                'clock_in' => now(),
            ]);
        } elseif (!$attendance->break_start) {
            $attendance->update(['break_start' => now()]);
        } elseif (!$attendance->break_end) {
            $attendance->update(['break_end' => now()]);
        } elseif (!$attendance->clock_out) {
            $attendance->update(['clock_out' => now()]);
        } else {
            return back()->withErrors(['error' => '打刻の順番が正しくありません。']);
        }

        return redirect()->route('attendance.index');
    }
}
