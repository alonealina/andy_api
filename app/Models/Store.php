<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'store_category_id',
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

    protected $with = [
        'images'
    ];

    /**
     * Relationship to branch table
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
