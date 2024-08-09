<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kit_name',
        'description',
        'quantity',
    ];

    public function borrowedKits(): HasMany
    {
        return $this->hasMany(BorrowedKit::class);
    }
}
