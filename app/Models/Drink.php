<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drink extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'type',
        'name',
        'price',
        'image',
        'description',
        'status',
    ];

    protected $with = [
        'images'
    ];

    /**
     * Relationship to store table
     *
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
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
     * @return MorphMany
     */
    public function orderDetails()
    {
        return $this->morphMany(OrderDetail::class, 'orderable');
    }
}
