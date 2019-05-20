<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{

    protected $fillable = [
        'first_name', 'last_name', 'email', 'tel' ,'nationality', 'position', 'attachment'
    ];
    public function isActive()
    {
        return $this->status == 1;
    }




    public function country()
    {
        return $this->belongsTo(Countries::class,'nationality');
    }


}
