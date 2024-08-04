<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'attendance_date',
        'time_in',
        'time_out',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    protected $casts = [
        'attendance_date' => 'datetime',
    ];
}
