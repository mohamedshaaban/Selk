<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div id="details">
                @if(\Session::has('success'))
                <div class="pad margin no-print">
                    <div class="callout callout-info" style="margin-bottom: 0!important;">
                        <h4><i class="fa fa-info"></i> Info:</h4>
                        {{ \Session::get('success') }}
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Main Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <!-- form start -->
                                <table class="table table-hover">
                                    <tr>
                                        <td style="width: 40%;">Order ID:</td>
                                        <td>{{ $order->unique_id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;">Sub total:</td>
                                        <td>{{ $order->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <td>Deliver Charge:</td>
                                        <td>{{ $order->delivery_charges }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><strong>{{ $order->total }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Customer Details</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <td style="width: 40%;">Customer Name:</td>
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;">Address:</td>
                                        <td>
                                            @php $add = optional(optional($order->userAddress)->countries)->title_en.','; $add .= optional($order->userAddress)->city.',';
                                            $add .= optional($order->userAddress)->province.','; $add .= optional($order->userAddress)->first_address.',';
                                            $add .= optional($order->userAddress)->second_address.','; echo trim($add, ',');
                                            
@endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;">Mobile #:</td>
                                        <td>{{ optional($order->userAddress)->mobile_no }} - {{ optional($order->userAddress)->phone_no
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Order Date:</td>
                                        <td>{{ $order->order_date }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Payment Details</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <td style="width: 40%;">Payment Status:</td>
                                        <td>{{ $order->is_paid? 'Payed': 'Not Payed' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Method:</td>
                                        <td>@switch($order->payment_method) @case(App\Models\Order::VISA_PAYMENT_METHOD) Visa
                                            Card @break @case(App\Models\Order::MASTER_PAYMENT_METHOD) MasterCard @break
                                            @case(App\Models\Order::KNET_PAYMENT_METHOD) Knet @break @case(App\Models\Order::CASH_ON_DELIVERY_PAYMENT_METHOD)
                                            Cash @break @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Method:</td>
                                        
                                        @if(!is_null($order->dhl_shipping_info_id))
                                        <td>{{ $order->dhlShippingInfo->title}}</td>
                                        @else
                                        <td>{{ optional($order->shippingMethod)->title_en }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Order Status</td>
                                        <td>{{ optional($order->orderstatus)->title_en }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Order Status</h3>
                            </div>
                            <div class="box-body">
                                @foreach($statusHis as $statusRow)
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3"><label>{{ optional($statusRow->status_history)->title_en }}</label> <span class="pull-right">{{ $statusRow->created_at->diffForHumans() }}</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <pre style="min-height: 39px">{{ $statusRow->comment }}</pre>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Shipping and Tracking Information </h3>
                            </div>

                            <div class="form-horizontal" style="margin: auto;">

                                <div class="box-body table-responsive no-padding">
                                    
                                    @if(!is_null($order->dhl_shipping_info_id) && is_null($dhlShippingInfo->tracking_number))
                                    <form action="{{ route('admin_order_shipment.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{ $order->id}}" name="order_id" />
                                        <input type="hidden" value="shippment_request" name="shippment_request">
                                        <div class="row">
                                            <div class="btn-group pull-left col-md-offset-5">
                                                <button class="btn btn-lg btn-block btn-primary  center">create Shippment</button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 100px">Service</th>
                                                <th class="text-center" style="width: 200px">Cost</th>
                                                <th style="width: 200px">Label</th>
                                                <th>Tracking Number</th>
                                                @if(!is_null($dhlShippingInfo->tracking_number) )
                                                <th>Pickup</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">{{ $dhlShippingInfo->service }}</td>
                                                <td class="text-center"> {{ $dhlShippingInfo->cost }}</td>
                                                <td><a target="_blank" href="{{$dhlShippingInfo->label_file}}">download</a></td>
                                                <td> {{$dhlShippingInfo->tracking_number}}</td>
                                                @if(!is_null($dhlShippingInfo->tracking_number) && is_null($dhlShippingInfo->confirmation_number))
                                                <td>
                                                    <div class="row">
                                                        <div class="btn-group pull-left">
                                                            <button type="button" class="btn btn-sm btn-primary  center" data-toggle="modal" data-target="#book-pickup">
                                                                    Book Pickup
                                                              </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                @else
                                                <td>
                                                    {{ $dhlShippingInfo->confirmation_number }}
                                                </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="book-pickup">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Book Pickup</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin_order_shipment.store') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $order->id}}" name="order_id" />
                        <input type="hidden" value="pickup_request" name="pickup_request">
                        <div class="row">

                            <div class="col-md-3">
                                <select name="pickup_day" id="input-packing-type" class="form-control">
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                          </select>
                            </div>
                            <div class="col-md-3">
                                <select name="pickup_month" id="input-packing-type" class="form-control">
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                              </select>
                            </div>
                            <div class="col-md-3">
                                <select name="pickup_year" id="input-packing-type" class="form-control">
                                        <option value="{{ date('Y')}}">{{ date('Y')}}</option>
                              </select>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group pull-right">
                                    <button class="btn btn-primary ">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{--
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>