<?php
/**
 * Created by PhpStorm.
 * User: Abdelqader Osama
 * Date: 3/5/19
 * Time: 1:31 PM
 */

namespace App\Http\Classes;


use App\Models\VendLog;

class Vend {
	const API_URL_BRAND = "2.0/brands";
	const API_URL_REFRESH_TOKEN = "1.0/token";
	const API_URL_SUPPLIERS = "2.0/suppliers";
	const API_URL_PRODUCTS = "2.0/products";
	const API_URL_INVENTORY = "2.0/inventory";
	const API_URL_REG_SALES = "register_sales";
	const API_URL_PAYMENT_TYPES = "payment_types";

	public function getBrands() {
		$token = $this->refreshToken();

		if ( $brands = $this->getRequest( self::API_URL_BRAND, false, false, $token ) ) {
			return $brands['data'] ?? [];
		}

		return [];
	}

	public function getSuppliers() {
		$token = $this->refreshToken();

		if ( $brands = $this->getRequest( self::API_URL_SUPPLIERS, false, false, $token ) ) {
			return $brands['data'] ?? [];
		}

		return [];
	}

	public function getProducts($version) {
		$token = $this->refreshToken();
		$extra = '';
		if($version){
			if(is_numeric($version)){
				$extra="?after=".$version;
			}
		}
		else {
			return false;
		}

		if ( $products = $this->getRequest( self::API_URL_PRODUCTS.$extra, false, false, $token ) ) {
			return $products ?: [];
		}

		return false;
	}

	public function getProduct( $productID ) {
		$token = $this->refreshToken();

		if ( $brands = $this->getRequest( self::API_URL_PRODUCTS . "/$productID", false, false, $token ) ) {
			return $brands['data'] ?? [];
		}

		return [];
	}

	public function getInventory($version) {
		$token = $this->refreshToken();
		$extra = '';
		if($version){
			if(is_numeric($version)){
				$extra="?after=".$version;
			}
		}
		else {
			return false;
		}

		if ( $inventory = $this->getRequest( self::API_URL_INVENTORY.$extra, false, false, $token ) ) {
			return $inventory ?: [];
		}

		return [];
	}

	public function getPaymentTypes() {
		$token = $this->refreshToken();

		if ( $paymentTypes = $this->getRequest( self::API_URL_PAYMENT_TYPES, false, false, $token ) ) {
			return $paymentTypes['payment_types'] ?? [];
		}

		return [];
	}

	public function regSale( $orderID, $products, $paymentID ) {
		if ( ! $products ) {
			return null;
		}

		$amount = 0;

		foreach ( $products as $product ) {
			$registerSaleProducts[] = [
				"product_id" => $product['vend_id'],
				"quantity"   => $product['quantity'],
				"price"      => $product['price']
			];

			$amount += $product['price'];
		}

		$postField = [
			"source_id"               => "",
			"accounts_transaction_id" => "",
			"register_id"             => "06e08a30-ee9c-11e7-ec24-71ec3ed6af73",
			"customer_id"             => "06e08a30-ee9c-11e7-ec24-71ec3eceebf7",
			"user_id"                 => "06e08a30-ee38-11e7-ec24-867cb0bcee6a",
			"sale_date"               => date( "Y-m-d H:i:s" ),
			"note"                    => config( 'app.env' ) == 'production' ? "" : "mawaqaa test",
			"status"                  => config( 'app.env' ) == 'production' ? "CLOSED" : "VOIDED",
			"short_code"              => ( config( 'app.env' ) == 'production' ? 'mq-' : 'mqt-' ) . $orderID,
			"invoice_number"          => ( config( 'app.env' ) == 'production' ? 'mq-' : 'mqt-' ) . $orderID,
			"register_sale_products"  => $registerSaleProducts,
			"register_sale_payments"  => [
				"register_id"              => "06e08a30-ee9c-11e7-ec24-71ec3ed6af73",
				"retailer_payment_type_id" => $paymentID, // 06e08a30-ee9c-11e7-ec24-71ec3ed6d54f
				"payment_date"             => date( "Y-m-d H:i:s" ),
				"amount"                   => $amount
			]
		];

		$token = $this->refreshToken();


		if ( $sale = $this->getRequest( self::API_URL_REG_SALES, json_encode( $postField ), true, $token ) ) {
			return $sale['register_sale'] ?? null;
		}

		return null;
	}


	protected function refreshToken() {
		$fields = [
			"client_id"     => "8HRNmdKoVTGNsbHV5urxwEdMq0x8rQfW",
			"client_secret" => "sYANyW8RXSdQTjJafrMpnzfqX2gvUxTT",
			"redirect_uri"  => config( "app.url" ),
			"grant_type"    => "refresh_token",
			"refresh_token" => "qZENlix1GZb6OgxxV3DiKtlKRCZJOKpuyvqoPE45"
		];

		$response = $this->getRequest( self::API_URL_REFRESH_TOKEN, $fields, true );

		if ( is_array( $response ) ) {
			return ( $response['token_type'] ?? '' ) . ' ' . ( $response['access_token'] ?? '' );
		}

		return false;
	}

	private function getRequest( $api_url, $postFields = null, $post_method = true, $header_token = null ) {

		$curlArray = [
			CURLOPT_URL            => "https://chicshop.vendhq.com/api/" . $api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => $post_method ? "POST" : "GET",
		];


		if ( $header_token ) {
			$curlArray[ CURLOPT_HTTPHEADER ] = [
				"accept: application/json",
				"authorization: " . $header_token,
				"content-type: application/json",
			];
		}
		if ( $postFields ) {
			$curlArray[ CURLOPT_POSTFIELDS ] = $postFields;
		}

		$curl = curl_init();

		curl_setopt_array( $curl, $curlArray );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		$vendLog = new VendLog();

		$vendLog->type=$api_url;
		$vendLog->note=$postFields;
		$vendLog->error=$err;

		$vendLog->save();

		if ( $err ) {
			// echo "cURL Error #:" . $err;
			return null;
		}

		try {
			if ( $r = json_decode( $response, 1 ) ) {
				return $r;
			}
		} catch ( \Exception $e ) {
		}

		return $response;
	}

}