<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\ProductReview;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Character;
use App\Models\Brand;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'code', 'is_active', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'users_interests');
    }
    public function tags()
    {
        return $this->morphedByMany(Tag::class, 'users_interests');
    }
    public function characters()
    {
        return $this->morphedByMany(Character::class, 'users_interests');
    }
    public function brands()
    {
        return $this->morphedByMany(Brand::class, 'users_interests');
    }
}
