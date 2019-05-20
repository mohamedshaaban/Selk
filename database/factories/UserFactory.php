<?php

use Faker\Generator as Faker;
use App\Models\PostsCategories;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\Settings;
use App\Models\Faq;
use App\Models\Currency;
use App\Models\Governorate;
use App\Models\Area;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\Character;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | This directory should contain each of the model factory definitions for
  | your application. Factories provide a convenient way to generate new
  | model instances for testing / seeding your application's database.
  |
 */

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('123456'), // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(PostsCategories::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,
        'name_ar' => $faker->name,
        'status' => $faker->randomElement([true, false]),
    ];
});

$factory->define(Posts::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(0, 5),
        'name_ar' => $faker->sentence,
        'name_en' => $faker->sentence,
        'description_ar' => $faker->sentence,
        'description_en' => $faker->sentence,
        'status' => $faker->randomElement([true, false]),
    ];
});

$factory->define(Pages::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug(),
        'name_en' => $faker->name,
        'name_ar' => $faker->name,
        'description_ar' => $faker->sentence,
        'description_en' => $faker->sentence,
    ];
});

$factory->define(Faq::class, function (Faker $faker) {
    return [
        'question_ar' => $faker->sentence,
        'question_en' => $faker->sentence,
        'answer_ar' => $faker->sentence,
        'answer_en' => $faker->sentence,
        'status' => $faker->randomElement([true, false]),
    ];
});

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'name_en' => 'Kuwaiti dinar',
        'name_ar' => 'دينار كويتي',
        'code' => 'KWD',
        'symbol_en' => 'KWD',
        'symbol_ar' => 'دينار كويتي',
        'value' => 2,
        'status' => 1,
    ];
});
$factory->define(Settings::class, function (Faker $faker) {
    return [
        'logo_ar' => $faker->image(),
        'logo_en' => $faker->image(),
        'facebook' => $faker->url,
        'instagram' => $faker->url,
        'twitter' => $faker->url,
        'whatsapp' => $faker->phoneNumber,
        'google_store_link' => $faker->url,
        'app_store_link' => $faker->url,
        'copy_right_ar' => $faker->sentence(),
        'copy_right_en' => $faker->sentence(),
        'address_ar' => $faker->address,
        'address_en' => $faker->address,
        'phone' => $faker->phoneNumber,
        'email_support' => $faker->email,
        'email_info' => $faker->email,
        'default_currency' => 1,
        'working_hours' => '00:00 - 13:00'
    ];
});

$factory->define(Governorate::class, function (Faker $faker) {
    $governorates = array(
        [
            'name_ar' => 'Capital',
            'name_en' => 'Capital',
            'status' => 1
        ],
        [
            'name_ar' => 'Hawalli',
            'name_en' => 'Hawalli',
            'status' => 1
        ],
        [
            'name_ar' => 'Farwaniya',
            'name_en' => 'Farwaniya',
            'status' => 1
        ],
        [
            'name_ar' => 'Jahra',
            'name_en' => 'Jahra',
            'status' => 1
        ],
        [
            'name_ar' => 'AlAhmadi',
            'name_en' => 'AlAhmadi',
            'status' => 1
        ]
    );
    $insertSql = [];
    foreach ($governorates as $key => $governorate) {
        $insertSql[] = "(\"" . implode('", "', $governorate) . '")';
    }
    DB::insert(
        "insert into governorates (name_ar, name_en, status) values " .
            implode(', ', $insertSql) .
            " on duplicate key update name_ar = values(name_ar), name_en = values(`name_en`), status = values(`status`)"
    );
    return [
        'name_ar' => 'Mubarak AlKabeer',
        'name_en' => 'Mubarak AlKabeer',
        'status' => 1
    ];
});

$factory->define(Area::class, function (Faker $faker) {
    $areas = array(
        [
            'name_ar' => 'Kuwait City',
            'name_en' => 'Kuwait City',
            'status' => 1,
            'governorate_id' => 1
        ],
        [
            'name_ar' => 'Sharq',
            'name_en' => 'Sharq',
            'status' => 1,
            'governorate_id' => 1
        ],
        [
            'name_ar' => 'Qortuba',
            'name_en' => 'Qortuba',
            'status' => 1,
            'governorate_id' => 1
        ],
        [
            'name_ar' => 'Ardhiya',
            'name_en' => 'Ardhiya',
            'status' => 1,
            'governorate_id' => 3
        ]
    );

    $insertSql = [];
    foreach ($areas as $key => $area) {
        $insertSql[] = "(\"" . implode('", "', $area) . '")';
    }
    DB::insert(
        "insert into areas (name_ar, name_en, status ,governorate_id) values " .
            implode(', ', $insertSql) .
            " on duplicate key update name_ar = values(name_ar), name_en = values(`name_en`), status = values(`status`), governorate_id = values(`governorate_id`)"
    );
    return [
        'name_ar' => 'Jabriya',
        'name_en' => 'Jabriya',
        'status' => 1,
        'governorate_id' => 4
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,//,
        'name_ar' => $faker->name,//$faker->image(),
        'description_en' => $faker->sentence,
        'description_ar' => $faker->sentence,
        'image' => $faker->randomElement(['seeder/category1.jpg', 'seeder/category2.jpg', 'seeder/category3.jpg', 'seeder/category4.jpg', 'seeder/category5.jpg']),
        'top' => $faker->randomElement([true, false]),
        'home' => $faker->randomElement([true, false]),
        'sort_order' => $faker->numberBetween(0, 5),
        'status' => true,
        'parent_id' => 0,
    ];
});


$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,//,
        'name_ar' => $faker->name,//$faker->image(),
        'image' => $faker->randomElement(['seeder/brand1.jpg', 'seeder/brand2.jpg', 'seeder/brand3.jpg', 'seeder/brand4.jpg', 'seeder/brand5.jpg']),
        'top' => $faker->randomElement([true, false]),
        'home' => $faker->randomElement([true, false]),
        'sort_order' => $faker->numberBetween(0, 5),
        'status' => true,
    ];
});

$factory->define(Character::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,//,
        'name_ar' => $faker->name,//$faker->image(),
        'image' => $faker->image(),
        'top' => $faker->randomElement([true, false]),
        'sort_order' => $faker->numberBetween(0, 5),
        'status' => true,
    ];
});

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,//,
        'name_ar' => $faker->name,//$faker->image(),
        'status' => true,
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name_en' => 'Product-' . $faker->numberBetween(0, 100000),
        'name_ar' => 'Product-' . $faker->numberBetween(0, 100000),
        'slug_name' => 'Product' . $faker->slug(),
        'sku' => 'sku-' . $faker->numberBetween(0, 100000),
        'short_description_en' => $faker->name,
        'short_description_ar' => $faker->name,
        'description_en' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'description_ar' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'delivery_and_return_en' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'delivery_and_return_ar' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'main_image' => $faker->randomElement(['seeder/product1.png', 'seeder/product2.png', 'seeder/product3.png', 'seeder/product4.png', 'seeder/product5.png']),
        'images' => ["2019\/products\/6c613891371cee148ff00ae32c9d5e9e.jpg", "2019\/products\/36c460c99afb9c38a7773a4e1b67f397.jpg", "2019\/products\/25561a3b74176902e0e9c97a502654d8.jpg", "2019\/products\/621925f8a388aa2437e97f6367f45056.jpg", "2019\/products\/7af82d3fa4f1ac53dfb04bf1cc8d9701.jpg", "2019\/products\/5a90f1aa39fb0638dd83290e87f8e5e8.jpg", "2019\/products\/52f7701105474c07a7c342e1931cafd9.jpg"],
        'price' => $faker->randomFloat(2, 1, 100),
        'quantity' => $faker->numberBetween(0, 50),
        'minimum_order' => $faker->numberBetween(1, 10),
        'brand_id' => Brand::all()->random()->id,
        'is_featured' => 1,
        'status' => 1,
    ];
});

