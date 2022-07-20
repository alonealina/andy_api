<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrinkCategory extends Model
{
    use HasFactory;

    protected $hidden = [
        'parent_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * @return HasMany
     */
    public function childs(): HasMany
    {
        return $this->hasMany(DrinkCategory::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DrinkCategory::class);
    }

    /**
     * @return bool
     */
    public function isParent(): bool
    {
        return !$this->parent_id;
    }

    /**
     * @return DrinkCategory|Collection
     */
    public function getAllDrinkCategory()
    {
        return $this->isParent() ? $this->childs()->get() : $this;
    }

    /**
     * @return HasMany
     */
    public function drinks(): HasMany
    {
        return $this->hasMany(Drink::class)->orderBy('category_child');
    }
}
