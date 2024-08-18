<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
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
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];
    protected $casts = [
        'date_start_treatment' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
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
    public function schedules(): HasOne
    {
        return $this->hasOne(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function expertise(): BelongsTo
    {
        return $this->belongsTo(Expertise::class);
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    public function getCreatedAtShamsiAttribute()
    {
        $created_at = $this->attributes['created_at'];
        return Verta::instance($created_at)->format('Y/m/d H:i:s');
    }

    public function getUpdatedAtShamsiAttribute()
    {
        $updated_at = $this->attributes['updated_at'];
        return Verta::instance($updated_at)->format('Y/m/d H:i:s');
    }
    public function getDateStartTreatmentShamsiAttribute()
    {
        $date_start_treatment = $this->attributes['date_start_treatment'];
        return Verta::instance($date_start_treatment)->format('Y/m/d');
    }
    // public function setDateStartTreatmentAttribute($value)
    // {
    //     // تبدیل تاریخ شمسی به میلادی
    //     $date_start_treatment = Verta::createFromFormat('Y/m/d', $value); // فرمت ورودی تاریخ شمسی
    //     $this->attributes['date_start_treatment'] = $date_start_treatment->toCarbon(); // تبدیل به Carbon و ذخیره
    // }
}
