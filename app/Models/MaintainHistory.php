<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintainHistory extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'branch_ids',
        'role',
        'message',
        'start_time',
        'end_time',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'branch_ids' => 'array'
    ];

    protected $appends = [
        'branches'
    ];

    /**
     * @return mixed
     */
    public function getBranchesAttribute()
    {
        return Branch::select('id', 'name')->whereIn('id',
            is_array($this->branch_ids) ? $this->branch_ids : [$this->branch_ids])
            ->get()->toArray();
    }
}
