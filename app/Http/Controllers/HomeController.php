<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\Product;
use App\Models\Brand;
use App\Models\HomePageGiftBox;


class HomeController extends Controller
{
    use Helpers;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $products = Product::with(['offer', 'options', 'optionValues'])->get();
        $brands = Brand::all();
        $instagramImages = $this->getInstagramImages();
        $giftBoxes = HomePageGiftBox::orderBy('sort_order')->limit(3)->get();

        return view('welcome')
            ->with([
                'titlePage' => 'SelleKts',
                'products' => $products,
                'brands' => $brands,
                'instagramImages' => $instagramImages,
                'giftBoxes' => $giftBoxes
            ]);
    }

    public function getInstagramImages()
    {
        //ToDO remove return here
//        return [];
        $curlArray = [
            CURLOPT_URL            => "https://api.instagram.com/v1/users/self/media/recent?access_token=" . env('INSTAGRAM_ACCESS_KEY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $curlArray);

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return [];
        }
        $response = json_decode($response);
        if ($response->meta->code == 400) {
            return [];
        } else {
            return $response->data;
        }
    }
}
