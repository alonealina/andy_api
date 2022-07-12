<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cast_id',
        'year',
        'month',
        'day',
        'working_time',
    ];

    protected $casts = [
        'working_time' => 'array'
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship to cast table
     *
     * @return BelongsTo
     */
    public function cast(): BelongsTo
    {
        return $this->belongsTo(Cast::class);
    }
}
