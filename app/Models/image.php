<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = [
        'original_filename',
        'path',
        'thumbnail_path',
    ];
}