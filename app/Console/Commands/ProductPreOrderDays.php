<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ProductPreOrderDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:pre-order-days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subtract from product pre_order column 1 day if product is pre order and out of stock';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::where('pre_order', 1)
            ->where('in_stock', 0)
            ->where('pre_order_days', '>', 1)
            ->get();

        foreach ($products as $product) {
            $product->pre_order_days -= 1;
            $product->save();
        }
    }
}
