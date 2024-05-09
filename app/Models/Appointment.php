<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'office_id',
        'user_id',
        'date',
        'number',
    ];
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
