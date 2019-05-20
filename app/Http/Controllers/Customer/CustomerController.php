<?php

namespace App\Http\Controllers\Customer;

use App\Http\Interfaces\SlidersRepostoryInterface;
use App\Models\Area;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Auth;
use App\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAddress;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Tag;
use App\Models\Character;

class CustomerController extends Controller
{
    use Helpers;

    public function myProfile(Request $request)
    {
        return view('customer.account')->with('user', Auth::User());
    }

    public function updateProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'oldpassword' => ['required', 'string'],
        ]);
        if ($request->password) {
            $validate = Validator::make($request->all(), [
                'password' => ['required', 'string'],
            ]);
        }
        if ($validate->fails()) {
            return ['status' => 'false', 'errors' => $validate->errors()->all()];
        }
        if ($request->password) {
            $user =  User::updateOrCreate(['id' => Auth::id()], [
                'name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
        } else {

            $user =  User::updateOrCreate(['id' => Auth::id()], [
                'name' => $request->first_name . ' ' . $request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }
        return redirect(route('customer.my_profile'));
    }

    public function addressBook(Request $request)
    {
        $user = Auth::User();
        $defaultUserAddress = Auth::user()->userAddress()->where('is_default', '1')->get();
        $userAddress = Auth::user()->userAddress()->where('is_default', '0')->get();
        $countries = \App\Models\Countries::all();
        $provience = \App\Models\Provience::all();

        return view('customer.address')->with(compact('user', 'userAddress', 'defaultUserAddress', 'countries', 'provience'));
    }

    public function createAddressBook(Request $request)
    {
        $record = new UserAddress();
        $address = array_combine($record->getFillable(), array_fill(0, count($record->getFillable()), ''));
        $countries = \App\Models\Countries::all();
        $provience = \App\Models\Provience::all();
        $user = Auth::User();
        $create  = true;
        $cities = \App\Models\Cities::all();
        return view('customer.addEditAddress')->with(compact('user', 'address', 'create', 'countries', 'provience','cities'));
    }


    public function editAddressBook(Request $request)
    {
        $user = Auth::User();
        $address = UserAddress::find(request()->id);
        $create = false;
        $countries = \App\Models\Countries::all();
        $provience = \App\Models\Provience::where('country_id',$address->governorate_id)->get();
        $cities = \App\Models\Cities::where('provience_id',$address->provience->id)->get();

        return view('customer.addEditAddress')->with(compact('user', 'address', 'create', 'countries', 'provience','cities'));
    }
    public function saveAddress(Request $request)
    {
        $default_shipping = 0;
        if ($request->default_shipping == 'on') {
            $default_shipping = 1;
            UserAddress::where('user_id',  Auth::Id())->where('is_default', $default_shipping)->update(['is_default' => 0]);
            $userAddress = UserAddress::updateOrCreate([
                'user_label' => $request->user_label,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address_type' => $request->address_type,
                'first_address' => $request->first_address,
                'second_address' => $request->second_address,
                'city' => $request->city,
                'post_code' => $request->post_code,
                'governorate_id' => $request->governorate_id,
                'province' => $request->province,
                'phone_no' => $request->phone_no,
                'mobile_no' => $request->mobile_no,
                'is_default' => $default_shipping,
                'user_id' => Auth::Id(),
                'type' => 1

            ]);
        }


        $userAddress = UserAddress::updateOrCreate(['id' => $request->id], [
            'user_label' => $request->user_label,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_type' => $request->address_type,
            'first_address' => $request->first_address,
            'second_address' => $request->second_address,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'governorate_id' => $request->governorate_id,
            'province' => $request->province,
            'phone_no' => $request->phone_no,
            'mobile_no' => $request->mobile_no,
            'is_default' => $default_shipping,
            'user_id' => Auth::Id(),
            'type' => 2

        ]);
        return redirect(route('customer.address_book'));
    }

    public function deleteAddressBook(Request $request)
    {
        UserAddress::where('id', request()->id)->where('user_id',  Auth::Id())->delete();
        return redirect(route('customer.address_book'));
    }


    public function orderHistory(Request $request)
    {
        $orders = Order::where('user_id', Auth::Id())->with('status' ,'dhlshippinginfo')->OrderBy('id', 'DESC')->paginate(15);

        return view('customer.order_history')->with(compact('orders'));
    }

    public function orderTrack(Request $request)
    {
       return view('customer.order_track');
    }

    public function getAddressDetails(Request $request)
    {
        $userAddress = UserAddress::whereId($request->id)->with('provience')->with('countries')->first();
        return $userAddress;
    }


    public function notificationSettings(Request $request)
    {
        $user = Auth::user();
        return view('customer.notification_setting')->with(compact('user'));
    }

    public function addToWishlist(request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);

        if (!Auth::check()) {
            return response()->json(null, 401);
        }

        Wishlist::firstOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id
        ]);
        return response()->json(null, 200);
    }
    public function wishList(Request $request)
    {
        $productIds = Wishlist::where('user_id', Auth::Id())->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->with(['options', 'optionValues'])->paginate(15);
        return view('customer.wishlist')->with(compact('products'));
    }
    public function removeFromWishList(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
        ]);

        if (!Auth::check()) {
            return response()->json(null, 401);
        }

        Wishlist::where([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id
        ])->delete();
        return response()->json(null, 200);
    }
    public function updateNotificationSettings(Request $request)
    {
        $user = Auth::user();

        if ($request->type == 'email') {
            $user->email_notification = $request->value;
        } else {
            $user->sms_notification = $request->value;
        }

        $user->update();
        return;
    }
    public function addAddressAjax(Request $request)
    {
        $this->validate($request, [
            'user_label' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required',
            'first_address' => 'required',
            'second_address' => 'required',
            'post_code' => 'required',
            'city' => 'required',
            'governorate_id' => 'required',
            'province' => 'required',
            'phone_no' => 'required',
            'mobile_no' => 'required',
            'address_type' => 'required',
        ]);

        $userAddress = UserAddress::updateOrCreate(['id'=>$request->shippingAddressId],[
            'user_label' => $request->user_label,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_type' => $request->address_type,
            'first_address' => $request->first_address,
            'second_address' => $request->second_address,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'governorate_id' => $request->governorate_id,
            'province' => $request->province,
            'phone_no' => $request->phone_no,
            'mobile_no' => $request->mobile_no,
            'is_default' => 1,
            'user_id' => Auth::Id(),
            'type' => $request->is_shipping

        ]);
        $userAddressbil = UserAddress::updateOrCreate(['user_id'=>Auth::Id(), 'type' => 1],[
            'user_label' => $request->user_label,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address_type' => $request->address_type,
            'first_address' => $request->first_address,
            'second_address' => $request->second_address,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'governorate_id' => $request->governorate_id,
            'province' => $request->province,
            'phone_no' => $request->phone_no,
            'mobile_no' => $request->mobile_no,
            'is_default' => 1,
            'user_id' => Auth::Id(),
            'type' => 1

        ]);
        return UserAddress::whereId($userAddress->id)->with('provience')->with('countries')->first();
    }
    public function orderSubmission(Request $request)
    {
        $order = Order::find($request->id);
        $orders = Order::where('user_id', Auth::Id())->with('status')->OrderBy('id', 'DESC')->paginate(15);

        return view('customer.success_order_history')->with(compact('order', 'orders'));
    }
    public function orderDetails(Request $request)
    {
        $order = $order = Order::where('unique_id', $request->unique_id)->with('orderproducts')->first();

        return view('customer.order_details')->with(compact('order'));
    }
    public function getProvience(Request $request)
    {
        $provience = \App\Models\Provience::where('country_id', $request->country_id)->get()->toArray();
        return ($provience);
    }

    public function getCities(Request $request)
    {
        $provience = \App\Models\Cities::where('provience_id', $request->provience_id)->get()->toArray();
        return ($provience);
    }

    public function shopByInterest()
    {
        $auth = Auth::user();
        $categories = Category::all();
        $tags = Tag::all();
        $characters = Character::all();
        $brands = Brand::all();


        $userCategories = $auth->categories()->get()->pluck('id')->toArray();
        $userTags = $auth->tags()->get()->pluck('id')->toArray();
        $userCharacters = $auth->characters()->get()->pluck('id')->toArray();
        $userBrands = $auth->brands()->get()->pluck('id')->toArray();


        return view('customer.shop_by_interest')->with([
            'categories' => $categories,
            'tags' => $tags,
            'brands' => $brands,
            'characters' => $characters,
            'userCategories' => $userCategories,
            'userTags' => $userTags,
            'userCharacters' => $userCharacters,
            'userBrands' => $userBrands
        ]);
    }

    public function StoreShopByInterest(request $request)
    {
        $auth = Auth::user();

        if (isset($request['categories'])) {
            $auth->categories()->sync($request['categories']);
        }

        if (isset($request['tags'])) {
            $auth->tags()->sync($request['tags']);
        }

        if (isset($request['brands'])) {
            $auth->brands()->sync($request['brands']);
        }

        if (isset($request['characters'])) {
            $auth->characters()->sync($request['characters']);
        }

        return redirect()->back();
    }
}
