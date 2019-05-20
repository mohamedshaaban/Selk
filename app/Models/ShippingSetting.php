<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Countries;

class ShippingSetting extends Model
{
    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
