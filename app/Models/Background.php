<?php

namespace App\Models;

use App\Traits\CommonScopeModel;
use App\Traits\HasBranchId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Background extends Model
{
    use HasFactory;
    use CommonScopeModel, HasBranchId;

    protected $fillable = [
        'branch_id',
        'position',
        'file_name',
        'role_background'
    ];

    protected $visible = [
        'id',
        'branch_id',
        'position',
        'role_background',
        'file_name',
        'file_url'
    ];

    protected $appends = [
        'file_url'
    ];

    /**
     * @return string
     */
    public function getFileUrlAttribute(): string
    {
        return IMAGES_PATH . '/' . $this->file_name;
    }

    /**
     * Relationship to branch table
     *
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
