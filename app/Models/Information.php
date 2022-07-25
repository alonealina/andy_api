<?php

namespace App\Models;

use App\Traits\CommonScopeModel;
use App\Traits\HasBranchId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory, SoftDeletes;
    use CommonScopeModel, HasBranchId;

    /**
     * @var string[]
     */
    protected $fillable = [
        'branch_id',
        'title',
        'content',
        'time_event',
    ];

    protected $with = [
        'images',
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
        return $this->morphMany(Image::class, 'imaginable');
    }
}
