<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Common;
use App\Models\DistanceGroups;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserAddress;

class Provience extends Model
{
 
    use SoftDeletes;
    protected $table= 'provience';
    protected $dates = ['deleted_at'];
        public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function getTitleAttribute()
    {
        return Common::nameLanguage($this->title_en, $this->title_ar);
    }
    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}
