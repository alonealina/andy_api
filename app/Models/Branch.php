<?php

namespace App\Models;

use App\Enums\AccountRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'tablet_count'
    ];

    protected $with = [
        'images'
    ];

    protected $appends = [
        'admin_username',
    ];

    /**
     * Relationship to accounts table
     *
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
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
     * @return HasMany
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * @return HasMany
     */
    public function drinkcategories(): HasMany
    {
        return $this->hasMany(DrinkCategory::class);
    }

    /**
     * Get Admin
     *
     * @return Model|HasMany|object|null
     */
    public function getAdmin()
    {
        return $this->accounts()->where('role', AccountRole::ADMIN)->first();
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getAdminUsernameAttribute()
    {
        return $this->getAdmin() ? $this->getAdmin()->username : "";
    }

    /**
     * @return HigherOrderBuilderProxy|mixed
     */
    public function getAdminIdAttribute()
    {
        return $this->getAdmin() ? $this->getAdmin()->id : "";
    }

    /**
     * @return HasMany
     */
    public function backgrounds(): HasMany
    {
        return $this->hasMany(Background::class);
    }

    /**
     * @return BelongsToMany
     */
    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'branch_news', 'branch_id', 'news_id');
    }
}
