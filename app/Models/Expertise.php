<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expertise extends Model
{
    use HasFactory;
    /**
     * Get all of the doctors for the Expertise
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
