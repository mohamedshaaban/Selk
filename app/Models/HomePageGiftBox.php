<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageGiftBox extends Model
{
    protected $fillable = [
        'image_ar', 'image_en', 'url', 'status',
    ];
}
