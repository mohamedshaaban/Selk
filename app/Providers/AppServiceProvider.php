<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Character;
use App\Models\Currency;
use App\Models\Settings;
use App\Models\OrderProduct;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        $this->sharedViews();
        view()->composer('*', function ($view) {
            $this->setCurrency();
            View::share([
                'selected_currency' => session()->get('currency'),
                'currencyLabel' => session()->get('currencyLabel'),
                'currencyCode' => session()->get('currencyCode'),
                'currencyValue' => session()->get('currencyValue'),
                'lang' =>  app()->getLocale()
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('settings', function () {
            return Settings::first();
        });
        $this->app->singleton('currencies', function () {
            return  Currency::all();
        });
    }

    public function sharedViews()
    {
        $categories = Category::OrderBy('sort_order', 'ASC')->get();

        $products = new OrderProduct();
        $products = $products->getMostSelling();

        View::share([
            'currencies' => app('currencies'),
            'sharedCategories' => $categories,
            'popularProducts' => $products,
            'settings' => app('settings')
        ]);
    }

    public function setCurrency()
    {
        if (is_null(session()->get('currency'))) {
            $ip = request()->ip();
            $currencyName = geoip()->getLocation($ip)->currency;
            $currency = app('currencies')->where('code', $currencyName)->first();
            if (!$currency) {
                $currency = app('currencies')->where('id', app('settings')->default_currency)->first();
            }
        } else {
            $currency = app('currencies')->where('id', session()->get('currency'))->first();
        }

        session()->put('currency', $currency->id);
        session()->put('currencyLabel', $currency->name_en);
        session()->put('currencyCode', $currency->code);
        session()->put('currencyValue', $currency->value);
        session()->save();
    }
}
