<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrinkCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    protected $hidden = [
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
     * @return array|mixed
     */
    public function getAllDrinkCategory()
    {
        $record = $this->isParent() ? $this->childs() : $this;
        return $record->with(['drinks' => function ($query) {
            $query->belongsToBranch();
        }])->get()->toArray();
    }

    /**
     * @return HasMany
     */
    public function drinks(): HasMany
    {
        return $this->hasMany(Drink::class);
    }
}
