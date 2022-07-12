<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'store_category_id',
        'post_code_1',
        'post_code_2',
        'address',
        'start_time',
        'end_time',
        'payment_method',
        'counter_count',
        'table_count',
        'room_count',
        'stand_count',
        'hotline',
        'homepage_url'
    ];

    protected $casts = [
        'payment_method' => 'array',
    ];

    protected $with = [
        'images'
    ];

    /**
     * Relationship to user table
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship to foods table
     *
     * @return HasMany
     */
    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

    /**
     * Relationship to drinks table
     *
     * @return HasMany
     */
    public function drinks(): HasMany
    {
        return $this->hasMany(Drink::class);
    }

    /**
     * Relationship to images table
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imaginable');
    }

    /**
     * Relationship to events table
     *
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relationship to informations table
     *
     * @return HasMany
     */
    public function informations(): HasMany
    {
        return $this->hasMany(Information::class);
    }

    /**
     * Relationship to system_information table
     *
     * @return HasOne
     */
    public function systemInformation(): HasOne
    {
        return $this->hasOne(SystemInformation::class);
    }

    /**
     * Relationship to workers table
     * @return HasMany
     */
    public function casts(): HasMany
    {
        return $this->hasMany(Cast::class);
    }

    /**
     * @return HasManyThrough
     */
    public function orderDetails()
    {
        return $this->hasManyThrough(OrderDetail::class, User::class);
    }
}
