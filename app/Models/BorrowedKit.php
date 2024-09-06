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
        'borrower_name',
        'quantity_borrowed',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function kit(): BelongsTo
    {
        return $this->belongsTo(Kit::class);
    }

}
