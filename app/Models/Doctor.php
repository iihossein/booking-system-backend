<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Doctor extends Model
{
    use HasFactory;
    /**
     * Get the office associated with the Doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function office(): HasOne
    {
        return $this->hasOne(Office::class);
    }
    /**
     * Get the expertise that owns the Doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expertise(): BelongsTo
    {
        return $this->belongsTo(Expertise::class);
    }
    /**
     * Get all of the appointments for the Doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    /**
     * Get all of the receipts for the Doctor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
}
