<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

use DHL\Entity\EA\KnownTrackingRequest as Tracking;
use DHL\Client\Web as WebserviceClient;
use DHL\Entity\EA\TrackingResponse;
use App\Models\DhlShipping;

require(__DIR__ . '/../../../../DHL/init.php');

class TrackingOrderController extends Controller
{
    public function orderTrack(Request $request)
    {
        $data = [];
        if ($request->has('tracking_number')) {
            $this->validate($request, [
                'tracking_number' => 'required|max:11',
            ]);

            $data =  $this->getTrackingOrder($request->get('tracking_number'));
        }

        return view('customer.order_track')->with([
            'data' => $data
        ]);
    }

    public function getTrackingOrder($tracking_number)
    {
        $dhlConfig = DhlShipping::first();

        $request = new Tracking();
        $request->SiteID = $dhlConfig->access_id;
        $request->Password = $dhlConfig->password;
        $request->MessageReference = '1234567890123456789012345678';
        $request->MessageTime = date('c');
        $request->LanguageCode = 'en';
        $request->AWBNumber = $tracking_number; //'7112192371'; //'8564385550';
        $request->LevelOfDetails = 'ALL_CHECK_POINTS';
        $request->PiecesEnabled = 'S';

        $client = new WebserviceClient();
        $xml = $client->call($request);

        $laodString = simplexml_load_string($xml);
        $json = json_encode($laodString);
        $json = json_decode($json, false);

        $data = [];
       if (isset($json->AWBInfo)) {
            $data = $json->AWBInfo;
        } else {
            $data = [];
        }

        return $data;
    }
}
