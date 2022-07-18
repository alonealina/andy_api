<?php

namespace App\Models;

use App\Enums\AccountRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
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
        'admin_id',
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
    public function getAdminIdAttribute()
    {
        return $this->getAdmin()->username;
    }
}
