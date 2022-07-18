<?php

namespace App\Models;

use App\Traits\CommonScopeModel;
use App\Traits\HasBranchId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drink extends Model
{
    use HasFactory, SoftDeletes;
    use CommonScopeModel, HasBranchId;

    protected $fillable = [
        'branch_id',
        'drink_category_id',
        'name',
        'price',
        'image',
        'description',
        'status',
    ];

    protected $hidden = [
        'drink_category_id'
    ];

    protected $with = [
        'images',
        'drinkCategory'
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
    public function drinkCategory()
    {
        return $this->belongsTo(DrinkCategory::class);
    }
}
