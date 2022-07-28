<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'branch_id',
        'role',
        'maintain_status',
        'message',
        'start_time',
        'end_time',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'start_time' => 'datetime:Y-m-d H:i',
        'end_time' => 'datetime:Y-m-d H:i',
    ];
}
