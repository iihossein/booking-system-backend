<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;
    /**
     * Get the patient that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    /**
     * Get the appointment that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    /**
     * Get all of the receipts for the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
