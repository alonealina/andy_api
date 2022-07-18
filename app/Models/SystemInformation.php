<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'pm_last',
        'companion_fee',
        'nomination_fee',
        'extension_fee',
        'vip_fee',
        'shochu_fee',
        'brandy_fee',
        'whisky_fee',
    ];

    protected $casts = [
        'pm_last' => 'array',
        'companion_fee' => 'array',
        'nomination_fee' => 'array',
        'extension_fee' => 'array',
        'vip_fee' => 'array',
        'shochu_fee' => 'array',
        'brandy_fee' => 'array',
        'whisky_fee' => 'array',
    ];
}
