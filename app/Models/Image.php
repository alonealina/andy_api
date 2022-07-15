<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'imaginable_id',
        'imaginable_type',
        'order'
    ];

    protected $visible = [
        'file_name',
        'file_url',
        'order'
    ];

    protected $appends = [
        'file_url'
    ];

    /**
     * @return string
     */
    public function getFileUrlAttribute(): string
    {
//        return Storage::disk()->url(IMAGES_PATH) . '/' . $this->file_name;
        return IMAGES_PATH . '/' . $this->file_name;
    }
}
