<?php
/**
 * Created by PhpStorm.
 * User: sh3ban
 * Date: 4/30/19
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Knet;


use App\Models\OrderTransactions;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Session;
use Carbon\Carbon;

use Mail;

use Dingo\Api\Routing\Helpers;
use Auth;

use App\Models\Order;

use App\Models\Settings;
use App\Mail\OrderTransactionMail;
use App\Mail\OrderCardTransactionMail;
use App\Mail\VoucherCard;
use App\Mail\VoucherOwnerCard;
class KnetController extends Controller
{
    use Helpers;

    //Redirect to Knet Payment Page with order detail
    public function redirect($order_id,$cards,$extraAmount)
    {
        $order = Order::find($order_id);
        $TranAmount = $order->total;

        $TranportalId=env('KNET_Tranportal_ID');
        $ReqTranportalId="id=".$TranportalId;
        $TranportalPassword=env('KNET_Tranportal_Password');
        $ReqTranportalPassword="password=".$TranportalPassword;
        $ReqAmount="amt=".($TranAmount+$extraAmount);
        $TranTrackid=mt_rand();
        $ReqTrackId="trackid=".$TranTrackid;
        $ReqCurrency="currencycode=414";
        $ReqLangid="langid=USA";
        $ReqAction="action=1";
        $ResponseUrl=env('APP_URL').env('KNET_SUCCESS_URL');
        $ReqResponseUrl="responseURL=".$ResponseUrl;
        $ErrorUrl=env('APP_URL').env('KNET_FAILURE_URL');
        $ReqErrorUrl="errorURL=".$ErrorUrl;

        $ReqUdf1="udf1=".$order_id;
        $ReqUdf2="udf2=udf2";
        if(count($cards)>0)
        {
            $ReqUdf2='udf2='.implode('@',$cards);
        }

        $ReqUdf3="udf3=test3";
        $ReqUdf4="udf4=test4";
        $ReqUdf5="udf5=test5";

        $param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1."&".$ReqUdf2."&".$ReqUdf3."&".$ReqUdf4."&".$ReqUdf5;


        $termResourceKey=env('KNET_Terminal_Key');
        $param=$this->encryptAES($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;
 return ["params"=> $param , "knetUrl"=> env('KNET_URL')];
    }
    public function cardRedirect($amount , $cards)
    {

        $TranAmount = $amount;
        $TranportalId=env('KNET_Tranportal_ID');
        $ReqTranportalId="id=".$TranportalId;
        $TranportalPassword=env('KNET_Tranportal_Password');
        $ReqTranportalPassword="password=".$TranportalPassword;
        $ReqAmount="amt=".$TranAmount;
        $TranTrackid=mt_rand();
        $ReqTrackId="trackid=".$TranTrackid;
        $ReqCurrency="currencycode=414";
        $ReqLangid="langid=USA";
        $ReqAction="action=1";
        $ResponseUrl=env('APP_URL').env('KNET_SUCCESS_URL');
        $ReqResponseUrl="responseURL=".$ResponseUrl;
        $ErrorUrl=env('APP_URL').env('KNET_FAILURE_URL');
        $ReqErrorUrl="errorURL=".$ErrorUrl;

        $ReqUdf1="udf1=card";
        $ReqUdf2='udf2='.implode('@',$cards);

        $ReqUdf3="udf3=test3";
        $ReqUdf4="udf4=test4";
        $ReqUdf5="udf5=test5";

        $param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1."&".$ReqUdf2."&".$ReqUdf3."&".$ReqUdf4."&".$ReqUdf5;


        $termResourceKey=env('KNET_Terminal_Key');
        $param=$this->encryptAES($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;
 return ["params"=> $param , "knetUrl"=> env('KNET_URL')];
    }



    //Successfull transaction view
    public function success(Request $request)
    {
        $settings = Settings::find(1);
        $transData = $this->decrypt($request->trandata, env('KNET_Terminal_Key'));

        parse_str($transData, $output);
        if ($output['udf1'] != 'card') {
            $cards = explode('@',$output['udf2']);
            foreach($cards as $card) {

                $gift = \App\Models\CustomerGiftCards::find($card);

                $card = \App\Models\GiftCards::find($gift->card_id);
                Mail::to($gift->email)->send(new VoucherCard($card, $gift, Auth::user()));
                Mail::to(Auth::user()->email)->send(new VoucherOwnerCard($card, $gift, Auth::user()));
            }
        $order = Order::find($output['udf1']);
        $orderTransaction = OrderTransactions::firstOrCreate(['order_id' => $output['udf1'],
            'payment_id' => $output['paymentid'],
            'result' => $output['result'],
            'auth' => $output['auth'],
            'reference' => $output['ref'],
            'track_id' => $output['trackid'] ? $output['trackid'] : 0,
            'tran_id' => isset($output['tranid']) ? $output['tranid'] : 0,
            'amount' => $output['amt'],
            'currency' => 414,
            'time' => Carbon::now()->format('h:s:i')]);


        $order->is_paid = 1;
        $order->update();

            Mail::to($order->user->email)->send(new OrderTransactionMail($order->user, $order , $orderTransaction));
    }
        else
        {
            $cards = explode('@',$output['udf2']);
            foreach($cards as $card) {

                $gift = \App\Models\CustomerGiftCards::find($card);

                $card = \App\Models\GiftCards::find($gift->card_id);
                Mail::to($gift->email)->send(new VoucherCard($card, $gift, Auth::user()));
                Mail::to(Auth::user()->email)->send(new VoucherOwnerCard($card, $gift, Auth::user()));
            }
            $orderTransaction = OrderTransactions::firstOrCreate(['order_id' => Carbon::now()->format('h:s:i'),
                'payment_id' => $output['paymentid'],
                'result' => $output['result'],
                'auth' => $output['auth'],
                'reference' => $output['ref'],
                'track_id' => $output['trackid'] ? $output['trackid'] : 0,
                'tran_id' => isset($output['tranid']) ? $output['tranid'] : 0,
                'amount' => $output['amt'],
                'currency' => 414,
                'time' => Carbon::now()->format('h:s:i')]);

            Mail::to(Auth::user()->email)->send(new OrderCardTransactionMail(Auth::user() , $orderTransaction));
        }
        if ($output['result'] != 'CAPTURED') {
            return view('knet.failure')->with(compact('settings', 'orderTransaction'));
        }

//        $orderTransaction = OrderTransactions::whereId($orderTransaction->id)->exclude()->toArray();

        return view('knet.success')->with(compact( 'settings' , 'orderTransaction'));
    }




    //Built in KNet Methods
    //AES Encryption Method Starts
    function encryptAES($str,$key) {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted=unpack('C*', ($encrypted));
        $encrypted=$this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    function pkcs5_pad ($text) {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }
    function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }
    function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }
    function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
    function decrypt($code,$key) {
        $code =  $this->hex2ByteArray(trim($code));
        $code=   $this->byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return $this->pkcs5_unpad($decrypted);
    }
//AES Encryption Method Ends
}
