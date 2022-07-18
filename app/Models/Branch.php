<?php

namespace App\Models;

use App\Enums\AccountRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tablet_count'
    ];

    /**
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return Model|HasMany|object|null
     */
    public function getAdmin()
    {
        return $this->accounts()->where('role', AccountRole::ADMIN)->first();
    }
}
