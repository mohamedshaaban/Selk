<?php

namespace App\Admin\Controllers\Order;

use App\Http\Classes\Vend;
use App\Models\Governorate;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Models\OrderProductOption;
use App\Models\OrderStatus;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Settings;
use App\Models\ShippingMethods;
use App\Models\StatusHistory;
use App\Models\UserAddress;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use App\Mail\AdminOrderMail;
use Mail;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Order Detail')
            ->description('description')
            ->body(view('admin.order.details')
	            ->with('statusHis', StatusHistory::with('status_history')->where('order_id', $id)->orderBy('id', 'desc')->get())
	            ->with('order', Order::getWithRelations($id))
	            ->with('settings', Settings::find(1))
            );
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body(view('admin.order.add_edit')
	            ->with('order', Order::getWithRelations($id))
	            ->with('order_status', OrderStatus::all())
	            ->with('statusHis', StatusHistory::with('status_history')->where('order_id', $id)->orderBy('id', 'desc')->get())
	            ->with('governorates', Governorate::where('status', 1)->get())
	            ->with('shipping_methods', ShippingMethods::all())
	            ->with('payment_methods', PaymentType::all())
            );
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create New Order')
            ->description('description')
	        ->body(
	        	view('admin.order.add_edit')
			        ->with('order', new Order())
			        ->with('order_status', OrderStatus::all())
			        ->with('statusHis', [])
			        ->with('governorates', Governorate::where('status', 1)->get())
			        ->with('shipping_methods', ShippingMethods::all())
			        ->with('payment_methods', PaymentType::all())
	        );
    }

	public function store(Request $request) {
		return $this->saveOrder(null, $request);
	}

	public function update($id, Request $request) {
    	Order::findOrFail($id);

		return $this->saveOrder($id, $request);
	}

	public function saveOrder( $order_id, Request $request ) {
		if(count($request->get('product', []))==0) {
			return ['status' => false, 'msg'=> 'You have to add products!'];
		}

		if($request->get('customer-add-type','off')=='on'){
			if(User::where('email', $request->get('user-email'))->exists()){
				return ['status' => false, 'msg'=> 'Email has exist!'];
			}

			$user = User::create([
				'name' => $request->get('user-name'),
				'email' => $request->get('user-email'),
				'password' =>  bcrypt(str_random(8)),
				'is_active' => 1,
				'phone' =>  $request->get('user-phone'),
			]);

			$userID = $user->id;
		}
		else {
			$userID = $request->get('customer_id');
		}

		if($request->get('add-address-type', 'off')=='off'){
			$userAddress = UserAddress::create([
				'address_type' => $request->get('address_type'),
				'user_label' => $request->get('user_label'),
				'first_address' => $request->get('first_address'),
				'second_address' => $request->get('second_address'),
				'user_id' => $userID,
				'mobile_no' => $request->get('mobile_no'),
				'phone_no' => $request->get('phone_no'),
				'governorate_id' => $request->get('governorate_id'),
				'is_default' => '0',
				'city' => $request->get('city'),
				'first_name' => $request->get('first_name'),
				'last_name' => $request->get('last_name'),
				'post_code' => $request->get('post_code'),
				'province' => $request->get('province'),
			]);

			$userAddressID = $userAddress->id;
		}
		else {
			$userAddressID = $request->get('address_id');
		}

		$shippingMethod = ShippingMethods::find($request->get('delivery_method'));


		$order = Order::findOrNew($order_id);

		$order->user_id = $userID;
		$order->address_id = $userAddressID;
		$order->unique_id = uniqid();
		$order->order_date = date('Y-m-d H:i:s');
		$order->delivery_charges = optional($shippingMethod)->price?: 0;
		$order->sub_total = 0;
		$order->total = 0;
		$order->is_paid = $request->get('is_paid', 0);
		$order->status_id = $request->get('order_status');
		$order->payment_method = $request->get('payment_method');

		$order->save();

		$total = 0;

		$vendProducts = [];

		foreach ($request->get('product') as $product){
			$oProduct = OrderProduct
				::updateOrCreate([
					'order_id' => $order->id,
					'product_id' => $product['product_id'],
				], [
					'quantity' => $product['price'],
					'sub_total' => $product['price'],
					'total' =>  $product['price']*$product['quantity'],
				]);

			$vendProducts[] = [
				'vend_id'  => optional(Product::find($product['product_id']))->vend_id,
				'quantity' => $product['quantity'],
				'price'    => $product['price']*$product['quantity']
			];

			if(isset($product['option_id'])) {
				foreach ($product['option_id'] as $optionId=>$optionValueId){
					OrderProductOption::updateOrCreate( [
						'order_product_id' => $oProduct->id
					], [
						'option_id'       => $optionId,
						'option_value_id' => $optionValueId
					] );
				}

			}

			$total +=$product['price']*$product['quantity'];
		}

		if($shippingMethod and $shippingMethod->is_free){

			if($total >= Settings::getSetting('free_delivery_amount')){
				$order->delivery_charges = 0;
			}
		}


		$order->sub_total = $total;
		$order->total = $total+$order->delivery_charges;

		$order->save();

		$statusHis =  StatusHistory::where('order_id', $order->id)->orderBy('id', 'desc')->first();

		if(!($statusHis and $statusHis->order_status_id == $order->status_id)){
			StatusHistory::create([
				'order_id' => $order->id,
				'order_status_id' => $request->get('order_status'),
				'comment' => $request->get('status_comment', ''),
			]);
		}

		if($order_id){
			$vend = new Vend();
			$vend->regSale($order->id, $vendProducts, optional(PaymentType::find($request->get('payment_method')))->vend_id);
		}


		$orderProducts = OrderProduct::with('orderProductOption')->where('order_id', $order->id)
		                             ->whereNotIn('product_id', array_column($request->get('product'), 'product_id'))
		                             ->get();

		foreach ($orderProducts as $row){
			$row->orderProductOption->delete();
			$row->delete();
		}

        Mail::to($order->user->email)->send(new AdminOrderMail($order->user, $order));

		return ['status' => true];
	}

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->id('Id');
        $grid->user()->name('Customer');
        $grid->unique_id('Order');
//	    $grid->sub_total('Sub total');
	    $grid->delivery_charges('Delivery charges');
	    $grid->total('Total');
	    $grid->is_paid('Is paid')->display(function($field){
	    	if($field){
	    		return '<span class="badge badge-success">Payed</span>';
		    }
		    return '<span class="badge badge-danger">Not Payed</span>';
	    });
	    $grid->payment_method('Payment method')->display(function($field){
	    	switch($field){
			    case Order::KNET_PAYMENT_METHOD:
			    	return '<span class="badge badge-primary">Knet</span>';
			    case Order::CASH_ON_DELIVERY_PAYMENT_METHOD:
				    return '<span class="badge badge-primary">Cash</span>';
			    case Order::MASTER_PAYMENT_METHOD:
				    return '<span class="badge badge-primary">MasterCard</span>';
		        case Order::VISA_PAYMENT_METHOD:
		            return '<span class="badge badge-primary">Visa Card</span>';
		    }
		    return '';
	    });
	    $grid->shippingMethod()->title_en('Shipping method');
	    $grid->order_date('Order date');

        return $grid;
    }

	public function customer_ajax( Request $request ) {
		$q = $request->get( 'q' );

		return User
			::where( 'is_active', 1)
			->where( function ( $query ) use ( $q ) {
				$query->where( 'name', 'like', "%$q%" );
				$query->orWhere( 'email', 'like', "%$q%" );
			} )
			->with('userAddress')
			->paginate();
	}

	public function product_ajax( Request $request ) {
		$q = $request->get( 'q' );

		return Product
			::where( 'status', 1)
			->where( function ( $query ) use ( $q ) {
				$query->where( 'name_en', 'like', "%$q%" );
				$query->orWhere( 'name_ar', 'like', "%$q%" );
			} )
			->with('options')
			->with('optionValues')
			->paginate();
	}

}
