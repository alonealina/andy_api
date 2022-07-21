<?php

namespace App\Models;

use App\Traits\CommonScopeModel;
use App\Traits\HasBranchId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;
    use CommonScopeModel, HasBranchId;

    protected $table = 'foods';

    /**
     * @var mixed
     */
    protected $fillable = [
        'branch_id',
        'name',
        'price',
        'description',
        'status',
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

    /**
     * @return BelongsTo
     */
    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class);
    }
}
