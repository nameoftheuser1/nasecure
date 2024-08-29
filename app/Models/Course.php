<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'course_name',
        'course_code',
    ];

    public function section(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

}
