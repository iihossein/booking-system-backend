<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Doctor;
use Hekmatinasser\Verta\Facades\Verta;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'phone',
        'national_code',
        'gender',
        'birthday',
        'code',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gender' => 'boolean',
        'birthday' => 'datetime',
        'status' => 'boolean',
        'code' => 'integer',
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
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
    public function getBirthdayShamsiAttribute()
    {
        $birthday = $this->attributes['birthday'];
        return Verta::instance($birthday)->format('Y/m/d');
    }
    // protected $dates = ['birthday'];
    // public function setBirthdayAttribute($value)
    // {
    //     $this->attributes['birthday'] = Verta::parse("{$value} 00:00:00")->datetime ();
    // }
}
