<?php

namespace App\Models;

use App\Enums\OrderDetailStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'orderable_id',
        'orderable_type',
        'price',
        'quantity',
        'status',
    ];

    protected $casts = [
      'status' => OrderDetailStatus::class
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo
     */
    public function orderable()
    {
        return $this->morphTo();
    }
}
