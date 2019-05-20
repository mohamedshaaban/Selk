<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use App\Common;
use App\Models\Currency;

/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $twitter
 * @property string|null $loginimage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agreed_delivery_time
 * @property string|null $location_en
 * @property string|null $location_ar
 * @property string|null $phone
 * @property string|null $email
 * @property-read mixed $location
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereAgreedDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereLocationAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereLocationEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereLoginimage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Settings extends Model
{

    static private $setting_row = null;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $table = 'settings';

    protected $fillable = ['logo_ar', 'logo_en', 'facebook', 'instagram', 'twitter', 'whatsapp', 'google_store_link', 'app_store_link', 'copy_right_ar', 'copy_right_en', 'address_ar', 'address_en', 'phone', 'email_support', 'email_info', 'default_currency', 'working_hours', 'google_map', 'banner_login', 'banner_wishlist', 'banner_order_history', 'banner_order_details', 'banner_notification_setting', 'banner_home', 'banner_address_list', 'banner_editaddresss', 'banner_user_account', 'banner_product_listing', 'banner_product_details', 'banner_categories_listing', 'banner_characters_listing', 'banner_cart', 'banner_checkout', 'banner_faq', 'banner_contactus', 'banner_sitemap'];

    public function getLoginimageAttribute($loginimage)
    {
        return   asset('/uploads/' . $loginimage);
    }

    public function getAddressAttribute()
    {
        return Common::nameLanguage($this->address_en, $this->address_ar);
    }

    public function getDummyStringAttribute()
    {
        return Common::nameLanguage($this->dummy_string_en, $this->dummy_string_ar);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'default_currency', 'id');
    }

    public static function getSetting($name, $default = '')
    {
        if (!self::$setting_row) {
            self::$setting_row = self::first();
        }

        if (self::$setting_row) {
            return self::$setting_row->getAttribute($name);
        }

        return $default;
    }
}
