<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


use App\User;
use App\Models\PostsCategories;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\Faq;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\Governorate;
use App\Models\Area;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\Character;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // trancate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        PostsCategories::truncate();
        Posts::truncate();
        Pages::truncate();
        Faq::truncate();
        Settings::truncate();
        Currency::truncate();
        Area::truncate();
        Governorate::truncate();
        Category::truncate();
        Brand::truncate();
        Tag::truncate();
        Character::truncate();
        Product::truncate();
        DB::table('product_characters')->truncate();
        DB::table('product_categories')->truncate();
        DB::table('product_tags')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // users seeder
        factory(User::class, 50)->create();
        //Post Caregories Seeder
        factory(PostsCategories::class, 5)->create();
        //Posts Seeder
        factory(Posts::class, 5)->create();
        // Pages seeder
        factory(Pages::class, 5)->create();
        // Faq seeder
        factory(Faq::class, 10)->create();
        // Currency seeder
        factory(Currency::class, 1)->create();
        // Settings seeder
        factory(Settings::class, 1)->create();
        // Governorate seeder
        factory(Governorate::class, 1)->create();
        // Area seeder
        factory(Area::class, 1)->create();
        // Character seeder
        factory(Character::class, 5)->create();
        // Category seeder
        factory(Category::class, 5)->create();
        // Tag seeder
        factory(Tag::class, 5)->create();
        // Brand seeder
        factory(Brand::class, 5)->create();
        // products seeder
        factory(Product::class, 100)->create()->each(
            function ($product) {
                // product tags seeder
                $tags = Tag::all()->random(mt_rand(1, 2))->pluck('id');
                $product->tags()->attach($tags);
                // product categories seeder
                $categories = Category::all()->random(mt_rand(1, 2))->pluck('id');
                $product->categories()->attach($categories);
                // product characteries seeder
                $characters = Character::all()->random(mt_rand(1, 2))->pluck('id');
                $product->characters()->attach($characters);
            }
        );
        
        
        //Admin Menu Seeder
        DB::table('admin_menu')->truncate();
        $adminMenus = array(
            array('parent_id' => '0', 'order' => '1','title'=>'Index','icon'=>'fa-bar-chart','uri'=>'/','permission'=>''),
            array('parent_id' => '0', 'order' => '2','title'=>'Admin','icon'=>'fa-tasks','uri'=>'','permission'=>''),
            array('parent_id' => '2', 'order' => '3','title'=>'Users','icon'=>'fa-users','uri'=>'auth/users','permission'=>''),
            array('parent_id' => '2', 'order' => '4','title'=>'Roles','icon'=>'fa-user','uri'=>'auth/roles','permission'=>''),
            array('parent_id' => '2', 'order' => '5','title'=>'Permission','icon'=>'fa-ban','uri'=>'auth/permissions','permission'=>''),
            array('parent_id' => '2', 'order' => '6','title'=>'Menu','icon'=>'fa-bars','uri'=>'auth/menu','permission'=>''),
            array('parent_id' => '2', 'order' => '7','title'=>'Operation log','icon'=>'fa-history','uri'=>'auth/logs','permission'=>''),
            array('parent_id' => '0', 'order' => '9','title'=>'Exception Reporter','icon'=>'fa-bug','uri'=>'exceptions','permission'=>''),
            array('parent_id' => '0', 'order' => '10','title'=>'CMS','icon'=>'fa-bug','uri'=>'exceptions','permission'=>''),
            array('parent_id' => '9', 'order' => '11','title'=>'Posts Categories','icon'=>'fa-bug','uri'=>'posts_categories','permission'=>''),
            array('parent_id' => '9', 'order' => '12','title'=>'Posts','icon'=>'fa-bug','uri'=>'posts','permission'=>''),
            array('parent_id' => '9', 'order' => '13','title'=>'Pages','icon'=>'fa-bug','uri'=>'pages','permission'=>''),
            array('parent_id' => '9', 'order' => '14','title'=>'Sliders','icon'=>'fa-bug','uri'=>'sliders','permission'=>''),
            array('parent_id' => '9', 'order' => '15','title'=>'Faqs','icon'=>'fa-bug','uri'=>'faqs','permission'=>''),
            array('parent_id' => '0', 'order' => '16','title'=>'Settings','icon'=>'fa-bug','uri'=>'settings','permission'=>''),
	        array('parent_id' => '0', 'order' => '17','title'=>'Vend','icon'=>'fa-tty','uri'=>'exceptions','permission'=>''),
	        array('parent_id' => '16', 'order' => '18','title'=>'Vend Integration','icon'=>'fa-th-large','uri'=>'vend','permission'=>''),
	        array('parent_id' => '16', 'order' => '19','title'=>'Vend Log','icon'=>'fa-file-o','uri'=>'vend/log','permission'=>''),
        );

        foreach ($adminMenus as $key => $adminMenu) {
            $insertSql[] = "( \"" . implode('", "', $adminMenu) . '")';
        }

        DB::insert(
            "insert into admin_menu (`parent_id`, `order`, `title`,`icon`,`uri`,`permission`) values " .
                implode(', ', $insertSql) 

        );
    }
}
