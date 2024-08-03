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
    protected $fillable = [
        'user_id',
        'expertise_id',
        'date_start_treatment',
    ];
    public function scopeSearchByName($query, $name)
    {
        return $query->whereHas('user', function ($query) use ($name) {
            $query->where('first_name', 'like', '%' . $name . '%')
                ->orWhere('last_name', 'like', '%' . $name . '%');
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function office(): HasOne
    {
        return $this->hasOne(Office::class);
    }

    public function expertise(): BelongsTo
    {
        return $this->belongsTo(Expertise::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
