<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'clock_in',
        'break_start',
        'break_end',
        'clock_out',
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'break_start' => 'datetime',
        'break_end' => 'datetime',
        'clock_out' => 'datetime',
    ];
    
}
