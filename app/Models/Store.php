<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
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

    /**
     * Relationship to user table
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
