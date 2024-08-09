<?php

namespace App\Models;

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
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

}
