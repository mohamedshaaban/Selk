<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    public function saving(Product $product)
    {
    	if($product->slug_name==''){
		    $product->slug_name = str_slug(uniqid().' '.$product->name_en);
	    }
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    { 
        $product->options()->detach();
        $product->optionValues()->detach();
        $product->characters()->detach();
        $product->tags()->detach();
        $product->categories()->detach();
        $product->reviews()->delete();
        $product->relatedProducts()->detach();
        $product->productsTogetherPrice()->delete();

    }
}
