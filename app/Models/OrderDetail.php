<?php

namespace App\Models;

use App\Enums\OrderDetailStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
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
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return HasOneThrough
     */
    public function account(): HasOneThrough
    {
        return $this->hasOneThrough(Account::class, Order::class, 'id', 'id', 'order_id', 'account_id');
    }

    /**
     * @return MorphTo
     */
    public function orderable()
    {
        return $this->morphTo();
    }
}
