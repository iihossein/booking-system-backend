<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'user_id',
        'doctor_schedule_id',
        'appointment_date_time',
        'status',
    ];
    protected $casts = [
        'appointment_date_time' => 'datetime',
        'status' => 'string', // Status cast as a string since it's an ENUM
    ];
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
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
    public function getAppointmentDateTimeShamsiAttribute()
    {
        $appointment_date_time = $this->attributes['appointment_date_time'];
        return Verta::instance($appointment_date_time)->format('Y/m/d H:i:s');
    }
}
