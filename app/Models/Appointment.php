<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;
    /**
     * Get the doctor that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    /**
     * Get the patient that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    /**
     * Get all of the payments for the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(payment::class);
    }
    /**
     * Get all of the receipts for the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
