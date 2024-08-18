<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'max_patients_per_day',
        'appointment_duration',
    ];
    protected $casts = [
        // 'start_time' => 'datetime:H:i:s', // تبدیل زمان به شیء DateTime
        // 'end_time' => 'datetime:H:i:s',   // تبدیل زمان به شیء DateTime
        'appointment_duration' => 'integer', // تبدیل به عدد صحیح
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
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
    public function getStartTimeShamsiAttribute()
    {
        $start_time = $this->attributes['start_time'];
        return Verta::instance($start_time)->format('Y/m/d H:i:s');
    }
    public function getEndTimeShamsiAttribute()
    {
        $end_time = $this->attributes['end_time'];
        return Verta::instance($end_time)->format('Y/m/d H:i:s');
    }
    // protected $dates = ['birthday'];
    // public function setStartTimeAttribute($value)
    // {
    //     $this->attributes['start_time'] = Verta::parse($value)->toCarbon();
    // }
    // public function setEndTimeAttribute($value)
    // {
    //     $this->attributes['end_time'] = Verta::parse($value)->toCarbon();
    // }
}
