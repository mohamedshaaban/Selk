<?php

namespace App\Admin\Controllers\Order;


use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\StatusHistory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use DHL\Entity\GB\ShipmentResponse;
use DHL\Entity\GB\ShipmentRequest;
use DHL\Client\Web as WebserviceClient;
use DHL\Datatype\GB\Piece;
use DHL\Datatype\GB\SpecialService;
use DHL\Entity\GB\BookPURequestCustome;

use App\Models\ShippingSetting;
use App\Models\DhlShipping;
use App\Models\DhlShippingInfo;
use Session;

// You may use your own init script, as long as it takes care of autoloading
require(__DIR__ . '/../../../../DHL/init.php');

class DhlController extends Controller
{

    use HasResourceActions;

    /**
     * @var object
     */
    protected $shippingSetting;

    /**
     * @var object
     */
    protected $order;

    /**
     * @var object
     */
    protected $dhlConfig;

    /**
     * @var object
     */
    protected $shippmentRequest;

    /**
     * @var object
     */
    protected $pickupRequest;
    /**
     * @var object
     */
    protected $websiteSetting;

    /**
     * @var float
     */
    protected $packageWeight = 0.00;

    /**
     * @var object
     */
    protected $response;

    public function __construct(Request $request)
    {

        $this->order = Order::getWithRelations($request->get('order_id'));
        $this->shippingSetting = ShippingSetting::first();
        $this->websiteSetting = app('settings');
        $this->dhlConfig = DhlShipping::first();
        $this->shippmentRequest = new ShipmentRequest();
        $this->pickupRequest = new BookPURequestCustome();
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */

    public function create(Content $content)
    {


        if (is_null($this->order) || is_null($this->order->dhl_shipping_info_id)) {
                abort(404);
            // return redirect()->back();
        }
        \Session::flash('success', \Session::get('success'));

        $order_id = request('order_id');
        return $content
            ->header('Create Order Shippment')
            ->description('description')
            ->body(
                view('admin.order_shippment.create')
                    ->with('statusHis', StatusHistory::with('status_history')->where('order_id', $order_id)->orderBy('id', 'desc')->get())
                    ->with('order', $this->order)
                    ->with('dhlShippingInfo', DhlShippingInfo::where('order_id', $this->order->id)->first())
            );
    }

    public function store(Request $request)
    {
        $response = '';
        if ($request->has('pickup_request')) {

            $this->header('pickupRequest');
            // $this->pices('pickupRequest');
            // $this->shippmentDetails('pickupRequest');
            $this->pickupPlace($request);
            $this->sendRequest('pickupRequest');
            $response = $this->getPickupResponse();
        } elseif ($request->has('shippment_request')) {
            $this->header('shippmentRequest');
            $this->pices('shippmentRequest');
            $this->shippmentDetails('shippmentRequest');
            $this->info();
            $this->billing();
            $this->consignee();
            $this->commodity();
            $this->dutiable();
            $this->reference();
            $this->shipper();
            // $this->specialService();
            $this->sendRequest('shippmentRequest');
            $response = $this->getShippmentResponse();
        }

        \Session::flash('success', $response);
        return redirect()->route('admin_order_shipment.create', ['order_id' => $this->order->id]);
    }

    public function header($object)
    {
        $this->$object->SiteID = $this->dhlConfig->access_id;
        $this->$object->Password = $this->dhlConfig->password;
        $this->$object->MessageTime = date('c');
        $this->$object->MessageReference = '1234567890123456789012345678901';
    }
    public function info()
    {
        $this->shippmentRequest->RegionCode = 'AP';
        $this->shippmentRequest->RequestedPickupTime = 'Y';
        $this->shippmentRequest->NewShipper = 'N';
        $this->shippmentRequest->LanguageCode = 'en';
        $this->shippmentRequest->PiecesEnabled = 'Y';
        $this->shippmentRequest->LabelImageFormat = 'PDF';

        // $this->shippingRequest->UseDHLInvoice = 'Y';
        // $this->shippingRequest->DHLInvoiceLanguageCode = 'en';
        // $this->shippingRequest->DHLInvoiceType = 'CMI';
    }

    public function billing()
    {
        $this->shippmentRequest->Billing->ShipperAccountNumber = $this->dhlConfig->account_number; //'951691180'; //$this->dhlConfig->account_number;
        $this->shippmentRequest->Billing->ShippingPaymentType = 'S';
        $this->shippmentRequest->Billing->BillingAccountNumber = $this->dhlConfig->account_number; //'951691180'; //$this->dhlConfig->account_number;
        // $this->shippmentRequest->Billing->DutyPaymentType = 'S';
        // $this->shippmentRequest->Billing->DutyAccountNumber = $this->dhlConfig->account_number; // '951691180'; //$this->dhlConfig->account_number;
    }

    public function consignee()
    {
        $this->shippmentRequest->Consignee->CompanyName = ' ';
        $this->shippmentRequest->Consignee->addAddressLine($this->order->userAddress->first_address);
        $this->shippmentRequest->Consignee->addAddressLine($this->order->userAddress->second_address);
        $this->shippmentRequest->Consignee->City = $this->order->userAddress->city;
        $this->shippmentRequest->Consignee->PostalCode = $this->order->userAddress->post_code;
        $this->shippmentRequest->Consignee->CountryCode = $this->order->userAddress->countries->iso_2_code;
        $this->shippmentRequest->Consignee->CountryName = $this->order->userAddress->countries->title_en;
        $this->shippmentRequest->Consignee->Contact->PhoneNumber = $this->order->userAddress->mobile_no;
        // $this->shippmentRequest->Consignee->Contact->PhoneExtension = '123';
        // $this->shippmentRequest->Consignee->Contact->FaxNumber = '506-851-7403';
        // $this->shippmentRequest->Consignee->Contact->Telex = '506-851-7121';
        $this->shippmentRequest->Consignee->Contact->PersonName = $this->order->user->name;
        $this->shippmentRequest->Consignee->Contact->Email = $this->order->user->email;
    }


    public function commodity()
    {
        $this->shippmentRequest->Commodity->CommodityCode = 'cc';
        $this->shippmentRequest->Commodity->CommodityName = 'cn';
    }

    public function dutiable()
    {
        $this->shippmentRequest->Dutiable->DeclaredValue = $this->order->total;
        $this->shippmentRequest->Dutiable->DeclaredCurrency = $this->websiteSetting->currency->code;
        // $this->shippmentRequest->Dutiable->ScheduleB = '3002905110';
        // $this->shippmentRequest->Dutiable->ExportLicense = 'D123456';
        // $this->shippmentRequest->Dutiable->ShipperEIN = '112233445566';
        // $this->shippmentRequest->Dutiable->ShipperIDType = 'S';
        // $this->shippmentRequest->Dutiable->ImportLicense = 'ALFAL';
        // $this->shippmentRequest->Dutiable->ConsigneeEIN = 'ConEIN2123';
        $this->shippmentRequest->Dutiable->TermsOfTrade = 'DTP';
    }

    public function reference()
    {
        $this->shippmentRequest->Reference->ReferenceID = '#' . $this->order->unique_id;
        // $this->shippmentRequest->Reference->ReferenceType = 'St';
    }
    public function shippmentDetails($object)
    {
        $this->$object->ShipmentDetails->Weight = $this->packageWeight;
        $this->$object->ShipmentDetails->WeightUnit = substr($this->dhlConfig->weight_unit, 0, 1);
        $this->$object->ShipmentDetails->GlobalProductCode = $this->order->dhlShippingInfo->global_product_code;
        $this->$object->ShipmentDetails->LocalProductCode = $this->order->dhlShippingInfo->local_product_code;
        $this->$object->ShipmentDetails->Date = date('Y-m-d');
        $this->$object->ShipmentDetails->Contents = 'AM international shipment contents';
        $this->$object->ShipmentDetails->DoorTo = 'DD';
        $this->$object->ShipmentDetails->DimensionUnit = 'C';
        // $this->shippmentRequest->ShipmentDetails->InsuredAmount = '1200.00';
        $this->$object->ShipmentDetails->PackageType = 'EE';
        $this->$object->ShipmentDetails->IsDutiable = 'Y';
        $this->$object->ShipmentDetails->CurrencyCode = $this->websiteSetting->currency->code;
        $this->$object->ShipmentDetails->NumberOfPieces = count($this->order->orderProducts);
    }
    public function shipper()
    {
        $this->shippmentRequest->Shipper->ShipperID = $this->dhlConfig->account_number; //'951691180';
        $this->shippmentRequest->Shipper->CompanyName =  config('app.name');
        $this->shippmentRequest->Shipper->RegisteredAccount = $this->dhlConfig->account_number; // '951691180';
        $this->shippmentRequest->Shipper->addAddressLine($this->shippingSetting->street_line1);
        $this->shippmentRequest->Shipper->addAddressLine($this->shippingSetting->street_line2);
        $this->shippmentRequest->Shipper->City = $this->shippingSetting->city;
        $this->shippmentRequest->Shipper->PostalCode = $this->shippingSetting->postal_code;
        $this->shippmentRequest->Shipper->CountryCode = $this->shippingSetting->country->iso_2_code;
        $this->shippmentRequest->Shipper->CountryName =  $this->shippingSetting->country->title_en;
        $this->shippmentRequest->Shipper->Contact->PersonName = $this->shippingSetting->contact_name;
        $this->shippmentRequest->Shipper->Contact->PhoneNumber = $this->shippingSetting->contact_phone;
        $this->shippmentRequest->Shipper->Contact->PhoneExtension = $this->shippingSetting->contact_phoen_ext;
        if ($this->shippingSetting->contact_fax) {
            $this->shippmentRequest->Shipper->Contact->FaxNumber = $this->shippingSetting->contact_fax;
        }
        $this->shippmentRequest->Shipper->Contact->Email = $this->shippingSetting->contact_email;
    }

    public function pices($object)
    {
        $i = 1;
        foreach ($this->order->orderProducts as $orderProduct) {
            $this->packageWeight += $orderProduct->product->weight;
            $piece = new Piece();
            $piece->PieceID = $i++;
            $piece->PackageType = 'EE';
            $piece->Weight = $orderProduct->product->weight;
            // $piece->DimWeight = '600.0';
            // $piece->Width = '50';
            // $piece->Height = '100';
            // $piece->Depth = '150';
            $this->$object->ShipmentDetails->addPiece($piece);
        }
    }

    public function specialService()
    {
        $specialService = new SpecialService();
        $specialService->SpecialServiceType = 'A';
        $this->shippmentRequest->addSpecialService($specialService);
    }

    public function sendRequest($object)
    {
        if ($this->dhlConfig->is_test) {
            $client = new WebserviceClient('staging');
        } else {
            $client = new WebserviceClient('production');
        }

        $xml = $client->call($this->$object);
        $laodString = simplexml_load_string($xml);
        $json = json_encode($laodString);
        $this->response = json_decode($json, false);
    }

    public function getShippmentResponse()
    {
        $hit_sucess = '';
        if (empty($this->response)) {
            $hit_sucess = "DHL Connection Problem With API.";
        } else if (isset($this->response->Response->Status->ActionStatus)) {
            $hit_sucess = $this->response->Response->Status->Condition->ConditionData;
        } else {
            $tracking_number = (string)$this->response->AirwayBillNumber;
            // $shipping_charge = (string)$response->ShippingCharge;
            $service = (string)$this->response->ProductShortName;
            $labelPath = 'uploads/orders/dhl/dhl-label-order-' . $this->order->id . '.pdf';
            file_put_contents($labelPath, base64_decode($this->response->LabelImage->OutputImage));

            DhlShippingInfo::where('order_id', $this->order->id)->update([
                'tracking_number' => $tracking_number,
                'service' => $service,
                'label_file' => '/' . $labelPath
            ]);

            $hit_sucess =  "Shipment Created Successfully";
        }

        return $hit_sucess;
    }

    public function getPickupResponse()
    {
        $hit_sucess = '';
        if (empty($this->response)) {
            $hit_sucess = "DHL Connection Problem With API.";
        } else if (isset($this->response->Response->Status->ActionStatus)) {
            $hit_sucess = $this->response->Response->Status->Condition->ConditionData;
        } else {
            $ConfirmationNumber = (string)$this->response->ConfirmationNumber;

            DhlShippingInfo::where('order_id', $this->order->id)->update([
                'confirmation_number' => $ConfirmationNumber
            ]);

            $hit_sucess =  "Pickup Booked Successfully";
        }

        return $hit_sucess;
    }

    public function pickupPlace(Request $request)
    {
        $pickup_day = $request->pickup_day;
        $pickup_month = $request->pickup_month;
        $pickup_year = $request->pickup_year;
        $this->pickupRequest->Requestor->AccountType = 'D';
        $this->pickupRequest->Requestor->AccountNumber = $this->dhlConfig->account_number;
        $this->pickupRequest->Requestor->CompanyName = 'Selecttes';
        $this->pickupRequest->RegionCode = 'AP';

        $this->pickupRequest->Place->CompanyName = config('app.name');
        $this->pickupRequest->Place->LocationType = 'B';
        $this->pickupRequest->Place->Address1 = $this->shippingSetting->street_line1;
        $this->pickupRequest->Place->City = $this->shippingSetting->city;
        $this->pickupRequest->Place->PackageLocation = $this->shippingSetting->city;
        $this->pickupRequest->Place->CountryCode =  $this->shippingSetting->country->iso_2_code;
        $this->pickupRequest->Place->PostalCode = $this->shippingSetting->postal_code;
        $this->pickupRequest->Pickup->PickupDate = date('Y-m-d', strtotime($pickup_year . '-' . $pickup_month . '-' . $pickup_day));
        $this->pickupRequest->Pickup->ReadyByTime = '00:00';
        $this->pickupRequest->Pickup->CloseTime = '12:00';
        $this->pickupRequest->PickupContact->PersonName = (string)$this->shippingSetting->contact_name;
        $this->pickupRequest->PickupContact->Phone = (string)$this->shippingSetting->contact_phone;
    }
}
