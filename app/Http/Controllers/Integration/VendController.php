<?php

namespace App\Http\Controllers\Integration;

use App\Http\Classes\Vend;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\VendLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendController extends Controller {

	public function brand( Vend $vend ) {
		foreach ( $vend->getBrands() as $brand ) {
			if ( isset( $brand['id'] ) and ! isset( $brand['deleted_at'] ) ) {
				Brand::firstOrCreate( [
					'vend_id' => $brand['id']
				], [
					'name_en'         => $brand['name'],
					'name_ar'         => $brand['name'],
					'vend_updated_at' => Carbon::now(),
					'image'           => '',
					'top'             => 0,
					'home'            => 0,
					'sort_order'      => 0,
					'status'          => 1,
				] );
			}
		}
	}

	public function suppliers( Vend $vend ) {
		foreach ( $vend->getSuppliers() as $supplier ) {
			if ( isset( $supplier['id'] ) and ! isset( $supplier['deleted_at'] ) ) {
				Supplier::firstOrCreate( [
					'vend_id' => $supplier['id']
				], [
					'vend_name_en' => $supplier['name'],
					'vend_name_ar' => $supplier['name'],
				] );
			}
		}
	}

	public function products( Vend $vend ) {
		foreach ( $vend->getProducts() as $product ) {
			$this->addProduct( $product );
		}
	}

	public function inventory( Vend $vend ) {
		foreach ( $vend->getInventory() as $inv ) {
			if ( $prod = Product::where( 'vend_id', $inv['product_id'] )->first() ) {
				$prod->quantity = $inv['inventory_level'];
				$prod->save();
			} else {
				if ( $prod = $vend->getProduct( $inv['product_id'] ) ) {
					if ( $product = $this->addProduct( $prod ) ) {
						$product->quantity = $inv['inventory_level'];
						$product->save();
					}
				}
			}
		}
	}

	public function payment_type( Vend $vend ) {
		foreach ( $vend->getPaymentTypes() as $type ) {
			if ( isset( $type['id'] ) and ! isset( $type['deleted_at'] ) ) {
				PaymentType::firstOrCreate( [
					'vend_id' => $type['id']
				], [
					'name_en' => $type['name'],
					'name_ar' => $type['name'],
				] );
			}
		}
	}

	public function updateInventory( Request $request, Vend $vend ) {
		if ( ! ( $request->get( 'type', '' ) == 'inventory.update' && $request->get( 'payload', '' ) ) ) {
			return [ 'status' => false ];
		}

		$vendLog        = new VendLog();
		$vendLog->type  = 'Webhook: inventory.update';
		$vendLog->note  = $request->all();
		$vendLog->error = 0;
		$vendLog->save();

		try {
			$inv = json_decode( $request->get( 'payload', '{}' ), 1 );

			if ( $prod = Product::where( 'vend_id', $inv['product_id'] )->first() ) {
				$prod->quantity = $inv['count']?: Settings::getSetting('default_qty',0 );
				$prod->save();
			} else {
				if ( $prod = $vend->getProduct( $inv['product_id'] ) ) {
					if ( $product = $this->addProduct( $prod ) ) {
						$product->quantity = $inv['count']?: Settings::getSetting('default_qty',0 );
						$product->save();
					}
				}
			}

			return [ 'status' => true ];
		} catch ( \Exception $e ) {
		}

		return [ 'status' => false ];
	}


	private function addProduct( $product ) {
		if ( isset( $product['id'] ) and ! isset( $product['deleted_at'] ) ) {

			$name = $product['name'] ?? ( $product['variant_name'] ?? '' );

			try {

				$p = Product::firstOrCreate( [
					'vend_id' => $product['id']
				], [
					'vend_updated_at'        => Carbon::now(),
					'vend_price'             => $product['price_excluding_tax'] ?? ( $product['price_including_tax'] ?? 0 ),
					'vend_supplier_price'    => $product['supply_price'] ?? 0,
					'name_en'                => $name,
					'name_ar'                => $name,
					'sku'                    => '',
					'slug_name'              => str_slug( ( $product['sku'] ?? $product['version'] ) . ' ' . $name ),
					'short_description_en'   => $product['description'] ?? '',
					'short_description_ar'   => $product['description'] ?? '',
					'description_en'         => $product['description'] ?? '',
					'description_ar'         => $product['description'] ?? '',
					'price'                  => $product['price_excluding_tax'] ?? ( $product['price_including_tax'] ?? 0 ),
					'main_image'             => $product['image_url'] ?? '',
					'status'                 => $product['is_active'] ?? 0,
					'in_stock'               => $product['has_inventory'] ?? 0,
					'supplier_id'            => optional( Supplier::where( 'vend_id', $product['supplier_id'] ?? null )->first() )->id ?: 0,
					'brand_id'               => optional( Brand::where( 'vend_id', $product['brand_id'] ?? null )->first() )->id ?: 0,
					'delivery_and_return_en' => '',
					'delivery_and_return_ar' => '',
					'quantity'               => Settings::getSetting( 'default_qty', 0 ),
					'minimum_order'          => 0,
					'maxima_order'           => Settings::getSetting( 'max_order', 0 ),
					'weight'                 => 0,
					'height'                 => 0,
					'free_return'            => 0,
					'is_featured'            => 0,
					'pre_order'              => 0,
					'pre_order_days'         => 0,
					'created_at'             => now(),
					'images'                 => array_column( $product['images'] ?? [], 'url' ),
				] );


				$p->sku      = $product['sku'] ?? '';
				$p->name_en  = $name;
				$p->brand_id = optional( Brand::where( 'vend_id', $product['brand_id'] ?? null )->first() )->id ?: 0;
				$p->price    = $product['price_excluding_tax'] ?? ( $product['price_including_tax'] ?? 0 );
				$p->save();


				$options      = [];
				$optionsValue = [];

				foreach ( $product['variant_options'] ?? [] as $option ) {
					$optionModel = Option::firstOrCreate( [
						'name_en' => $option['name']
					], [
						'type'    => '',
						'name_en' => $option['name'],
						'name_ar' => $option['name'],
					] );

					if ( $optionModel ) {

						$optionValueModel = OptionValue::firstOrCreate( [
							'value_en'  => $option['value'],
							'option_id' => $optionModel->id
						], [
							'type'     => '',
							'value_ar' => $option['value'],
							'image'    => ''
						] );

						$options[]      = $optionModel->id;
						$optionsValue[] = $optionValueModel->id;
					}
				}

				$p->options()->sync( $options );
				$p->optionValues()->sync( $optionsValue );


				return $p;
			} catch ( \Exception $e ) {
			}
		}

		return null;
	}

}
