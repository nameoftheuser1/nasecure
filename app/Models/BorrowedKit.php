<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowedKit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kit_id',
        'student_id',
        'quantity_borrowed',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
    ];

    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
