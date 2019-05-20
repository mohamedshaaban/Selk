<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\DhlShipping;
use App\Models\ShippingSetting;
use DHL\Entity\AM\GetQuote;
use DHL\Datatype\AM\PieceType;
use DHL\Client\Web as WebserviceClient;

require(__DIR__ . '/../../../../DHL/init.php');

class DhlQuoteContoller extends Controller
{
    /**
     * @var object
     */
    protected $quoteObj;

    /**
     * @var array
     */
    protected $credentialsArr;

    /**
     * @var object
     */
    protected $response;

    /**
     * @var object
     */
    protected $dhlConfig;

    /**
     * @var object
     */
    protected $shippingSetting;



    public function __construct()
    {
        $this->dhlConfig = DhlShipping::first();
        $this->shippingSetting = ShippingSetting::first();
        $this->credentialsArr = $this->credentials();
        $this->quoteObj = $this->quote();
        $this->packageDetails();
        $this->senderDetails();
        $this->dutiable();
    }

    public function credentials()
    {
        return [
            'id' => $this->dhlConfig->access_id,
            'pass' => $this->dhlConfig->password,
            'shipperAccountNumber' => $this->dhlConfig->password,
            'billingAccountNumber' => $this->dhlConfig->account_number,
            'dutyAccountNumber' => $this->dhlConfig->account_number,
        ];
    }

    public function quote()
    {
        $data = new GetQuote();
        $data->SiteID = $this->credentialsArr['id'];
        $data->Password = $this->credentialsArr['pass'];

        // Set values of the request
        $data->MessageTime = '2019-12-17T09:30:47-05:00';
        $data->MessageReference = '1234567890123456789012345678901';
        return $data;
    }

    public function pieceTypes($product)
    {
        $piece = new PieceType();
        $piece->PieceID = $product->id;
        // $piece->Height = 10;
        // $piece->Depth = 5;
        // $piece->Width = 10;
        $piece->Weight = $product->weight != 0 ? $product->weight : 1;
        $this->quoteObj->BkgDetails->addPiece($piece);
    }

    public function packageDetails()
    {
        $this->quoteObj->BkgDetails->IsDutiable = 'N';
        $this->quoteObj->BkgDetails->QtdShp->QtdShpExChrg->SpecialServiceType = 'WY';
        $this->quoteObj->BkgDetails->ReadyTime = 'PT10H21M';
        $this->quoteObj->BkgDetails->ReadyTimeGMTOffset = '+01:00';
        $this->quoteObj->BkgDetails->DimensionUnit = 'CM';
        $this->quoteObj->BkgDetails->WeightUnit = $this->dhlConfig->weight_unit;
        $this->quoteObj->BkgDetails->PaymentCountryCode = 'KW';
        // $this->quoteObj->BkgDetails->IsDutiable = 'Y';
        // Request Paperless trade
        $this->quoteObj->BkgDetails->QtdShp->QtdShpExChrg->SpecialServiceType = 'WY';
        // Request date
        $this->quoteObj->BkgDetails->Date = date('Y-m-d');
    }

    public function senderDetails()
    {
        $this->quoteObj->From->CountryCode = $this->shippingSetting->country->iso_2_code;
        $this->quoteObj->From->Postalcode = $this->shippingSetting->postal_code;
        $this->quoteObj->From->City = $this->shippingSetting->city;
    }


    public function receiverDetails($userAddress)
    {
        $this->quoteObj->To->CountryCode = $userAddress->countries->iso_2_code;
        $this->quoteObj->To->Postalcode = $userAddress->post_code;
        $this->quoteObj->To->City = $userAddress->city;
    }

    public function dutiable()
    {
        $this->quoteObj->Dutiable->DeclaredValue = '10';
        $this->quoteObj->Dutiable->DeclaredCurrency = 'KWD';
    }

    public function sendRequest($userAddress, $products)
    {
        if (!$this->dhlConfig->status) {
            return [];
        }

        foreach ($products as $product) {
            $this->pieceTypes($product->product);
        }

        $this->receiverDetails($userAddress);

        // Call DHL XML API
        if ($this->dhlConfig->is_test) {
            $client = new WebserviceClient('staging');
        } else {
            $client = new WebserviceClient('production');
        }

        $xml = $client->call($this->quoteObj);
        $laodString = simplexml_load_string($xml);
        $json = json_encode($laodString);
        $this->response = json_decode($json, false);
    }

    public function getResponse()
    {
        $response = [
            'status' => false,
            'data' => []
        ];

        if (empty($this->response)) {
            return $response;
        }

        if (isset($this->response->GetQuoteResponse->BkgDetails->QtdShp)) {
            $quotes = count($this->response->GetQuoteResponse->BkgDetails->QtdShp) > 1 ? $this->response->GetQuoteResponse->BkgDetails->QtdShp : [$this->response->GetQuoteResponse->BkgDetails->QtdShp];

            foreach ($quotes as $quote) {
                $rate_code = ((string)$quote->GlobalProductCode);
                $rate_title = ((string)$quote->ProductShortName);
                $delivery_date = ((string)$quote->DeliveryDate);
                $rate_cost = (float)((string)$quote->ShippingCharge);
                $total_transit_days = $quote->TotalTransitDays;

                $quote_data[$rate_code] = array(
                    'global_product_code'            =>  $quote->GlobalProductCode,
                    'local_product_code'             =>  $quote->LocalProductCode,
                    'title'                          =>  $total_transit_days . ' Days DHL ' . $rate_title,
                    'cost'                           =>  $rate_cost,
                    'text'                           =>  $rate_title,
                    'date'                           =>  $delivery_date,
                    'days'                           =>  $total_transit_days
                );
            }
            $response = [
                'status' => true,
                'data' => $quote_data
            ];
        }
        return $response;
    }
}
