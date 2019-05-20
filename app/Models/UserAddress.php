<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Countries;
use App\Models\Provience;
class UserAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected $table='user_address';
    protected $fillable = [
        'user_label','address_type','city' ,'type','first_name' , 'last_name' ,'province' , 'post_code', 'first_address', 'second_address' ,'user_id' ,'mobile_no' ,'phone_no' ,'governorate_id' ,'is_default'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function countries()
    {
        return $this->belongsTo(Countries::class,'governorate_id' ,'id' );
    }
    public function provience()
    {
        return $this->belongsTo(Provience::class,'province' ,'id' );
    }    
}
