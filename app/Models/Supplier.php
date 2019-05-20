<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['vend_id', 'vend_name_en', 'vend_name_ar'];
}
