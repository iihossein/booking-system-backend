<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Expertise extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    protected $fillable = ['name', 'slug'];


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
