<?php

namespace App\Models;

use App\Traits\CommonScopeModel;
use App\Traits\HasBranchId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cast extends Model
{
    use HasFactory, SoftDeletes;
    use HasBranchId, CommonScopeModel;

    /**
     * @var string[]
     */
    protected $fillable = [
        'branch_id',
        'account_id',
        'name',
        'height',
        'blood_type',
        'hobbit',
        'type_person',
        'dream',
        'fetish',
        'slogan',
        'instagram_url',
        'special_skill',
        'is_service',
        'is_overtime'
    ];

    protected $with = [
        'images'
    ];

    /**
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imaginable')->orderBy('order');
    }

    /**
     * Relationship to schedule table
     *
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
