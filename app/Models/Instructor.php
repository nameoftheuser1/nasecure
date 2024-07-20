<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pin_code',
        'rfid',
    ];


    public function section(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function attendanceLogs(): HasMany
{
    return $this->hasMany(AttendanceLog::class);
}

}
