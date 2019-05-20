<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\GiftCards;
use Illuminate\Support\Facades\Request;
use Auth;

class GiftCardController extends Controller
{
    public function giftCard(Request $request)
    {
        $cards = GiftCards::where('status',1)->get();
        return view('cards.list')->with(compact('cards'));
    }
    
    
    public function cardInfo(Request $request)
    {
         $card = GiftCards::whereId(request()->id)->with('cardprices')->first();
         $user = Auth::user();
        return view('cards.details')->with(compact('card','user'));
    }
    public function sendGiftCard(Request $request)
    {
        dd($request);
    }
}