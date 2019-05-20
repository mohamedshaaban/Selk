<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Common;
use App\Models\DistanceGroups;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserAddress;
class Countries extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function getTitleAttribute()
    {
        return Common::nameLanguage($this->title_en, $this->title_ar);
    }

    public function career()
    {
        return $this->hasMany(Careers::class);
    }

}
