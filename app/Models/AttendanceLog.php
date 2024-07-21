<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'user_id',
        'attendance_date',
    ];

    public function user()
    {
        return $this->morphTo();
    }

    protected $casts = [
        'attendance_date' => 'datetime',
    ];
}
