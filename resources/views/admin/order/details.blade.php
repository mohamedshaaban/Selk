<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">&nbsp;</h3>
              <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 5px">
                  <a href="{{ route('admin_order.index') }}" class="btn btn-sm btn-default" title="List"><i
                        class="fa fa-list"></i><span class="hidden-xs">&nbsp;List</span></a>
                </div>
                <div class="btn-group pull-right" style="margin-right: 5px">
                  <button class="btn btn-sm btn-primary" id="printBtn" title="Print"><i class="fa fa-print"></i><span
                        class="hidden-xs">&nbsp;Print</span></button>
                </div>
                @if(!is_null($order->dhl_shipping_info_id))
                <div class="btn-group pull-right" style="margin-right: 5px">
                    <a href="{{ route('admin_order_shipment.create' , ['order_id' => $order->id]) }}"
                  <button class="btn btn-sm btn-primary"  title="Print"><i class="fa fa-truck"></i><span
                          class="hidden-xs">&nbsp;Ship</span></button>
                    </a>
                  </div>
                  @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="details">
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
                      @php

                      $add = optional(optional($order->userAddress)->countries)->title_en.',';
                      $add .= optional($order->userAddress)->city.',';
                      $add .= optional($order->userAddress)->province.',';
                      $add .= optional($order->userAddress)->first_address.',';
                      $add .= optional($order->userAddress)->second_address.',';

                      echo trim($add, ',');
                      @endphp
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 40%;">Mobile #:</td>
                    <td>{{ optional($order->userAddress)->mobile_no }} - {{ optional($order->userAddress)->phone_no }}</td>
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
                    <td>@switch($order->payment_method)
                        @case(App\Models\Order::VISA_PAYMENT_METHOD)
                        Visa Card
                        @break
                        @case(App\Models\Order::MASTER_PAYMENT_METHOD)
                        MasterCard
                        @break
                        @case(App\Models\Order::KNET_PAYMENT_METHOD)
                        Knet
                        @break
                        @case(App\Models\Order::CASH_ON_DELIVERY_PAYMENT_METHOD)
                        Cash
                        @break
                      @endswitch</td>
                  </tr>
                  <tr>
                    <td>Shipping Method:</td>
                    <td>{{ optional($order->shippingMethod)->title_en }}</td>
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
                    <div class="col-md-6 col-md-offset-3"><pre style="min-height: 39px">{{ $statusRow->comment }}</pre></div>
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
                <h3 class="box-title">Products</h3>
              </div>
              <div class="form-horizontal">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <thead>
                    <tr>
                      <th class="text-center" style="width: 100px">Product ID</th>
                      <th class="text-center" style="width: 200px">Image</th>
                      <th style="width: 200px">Product Name</th>
                      <th>Product Option</th>
                      <th class="text-center" style="width: 50px">Quantity</th>
                      <th class="text-center" style="width: 100px">Sub Total</th>
                      <th class="text-center" style="width: 100px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $subTotal = 0;
                    @endphp
                    @foreach($order->orderProducts as $orderProduct)
                      <tr>
                        <td class="text-center">{{ $orderProduct->product_id }}</td>
                        <td class="text-center"><img
                              src="{{ $orderProduct->product->main_image_path }}"
                              style="max-height: 150px;"/></td>
                        <td>{{ $orderProduct->product->name_en }}</td>
                        <td>
                          @foreach($orderProduct->orderProductOption as $productOption)
                            {{ $productOption->option->name_en }}: {{ $productOption->optionValue->value_en }}<br>
                          @endforeach
                        </td>

                        <td class="text-center">{{ $orderProduct->quantity }}</td>
                        <td class="text-center">{{ $orderProduct->sub_total }}</td>
                        <td class="text-center"></td>
                      </tr>
                      @php
                        $subTotal += $orderProduct->sub_total;
                      @endphp
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                      <td colspan="5" class="text-right">Totals:</td>
                      <td class="text-center">{{ $subTotal }}</td>
                      <td class="text-center">{{ $order->total }}</td>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div id="DivIdToPrint" style="display: none;">

        <meta charset="UTF-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta name="x-apple-disable-message-reformatting"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta content="telephone=no" name="format-detection"/>
        <title></title>
        <style>
            @import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800");

            * {
                font-family: "Open Sans", sans-serif;
            }
        </style>
        </head>

        <body>
        <div class="es-wrapper-color">
            <!--[if gte mso 9]>
            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                <v:fill type="tile" color="#f6f6f6"></v:fill>
            </v:background>
            <![endif]-->
            <table cellpadding="0" cellspacing="0" class="es-wrapper" width="100%">
                <tbody>
                <tr>
                    <td valign="top" class="esd-email-paddings">
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            class="es-header esd-header-popover"
                            align="center"
                            style="border:1px solid #ccc; border-bottom:0px;  padding: 15px;"
                        >
                            <tbody>
                            <tr>
                                <td class="esd-stripe" align="center">
                                    <table
                                        class="es-header-body"
                                        align="center"
                                        cellpadding="0"
                                        cellspacing="0"
                                        width="600"
                                    >
                                        <tbody>
                                        <tr>
                                            <td
                                                class="esd-structure es-p20b es-p20r es-p20l"
                                                align="left"
                                                style="background-position: center top; background-color: rgb(255, 255, 255);"
                                                bgcolor="#ffffff"
                                            >
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="100%"
                                                >
                                                    <tbody>
                                                    <tr>
                                                        <td
                                                            width="560"
                                                            class="esd-container-frame"
                                                            align="center"
                                                            valign="top"
                                                        >
                                                            <table
                                                                cellpadding="0"
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-image"
                                                                    >
                                                                        <a href="#" target="_blank"
                                                                        ><img
                                                                                src="{{ asset('img/logo.png') }}"
                                                                                alt=""
                                                                                width="200"
                                                                                style="display: block;"
                                                                            /></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-image"
                                                                    >
                                                                        <b>ADDRESS</b><br/>
                                                                       {{ $settings->address_en }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-image"
                                                                    >
                                                                        <b>Phone</b>
                                                                        {{ $settings->phone }}
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <table
                                                                cellpadding="0"
                                                                style="background: #efefef;  padding: 15px; border-top: 1px dashed;border-bottom: 1px dashed; margin-top: 15px;"
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    ></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        style="font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                        class="esd-block-text"
                                                                    >

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    >
                                                                        Order Number: #{{ $order->unique_id }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    >
                                                                        {{ $order->created_at }}
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <!-- second -->

                        <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                               style="border:1px solid #ccc; background: #efefef; border-top: 0px; border-bottom:0px;  padding: 0px 15px;">
                            <tbody>
                            <tr>
                                <td class="esd-stripe" align="center">
                                    <table
                                        class="es-content-body"
                                        align="center"
                                        cellpadding="0"
                                        cellspacing="0"
                                        width="600"
                                    >
                                        <tbody>
                                        <tr>
                                            <td class="esd-structure" align="left">
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="100%"
                                                >
                                                    <tbody>
                                                    <tr>
                                                        <td
                                                            width="600"
                                                            class="esd-container-frame"
                                                            align="left"
                                                            valign="top"
                                                        >
                                                            <table
                                                                cellpadding="0"
                                                                style="background: #efefef;"
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td class="esd-stripe" align="center">
                                                                        <table
                                                                            class="es-content-body"
                                                                            align="center"
                                                                            cellpadding="0"
                                                                            cellspacing="0"
                                                                            width="600"
                                                                        >
                                                                            <tbody>
                                                                            <tr>
                                                                                <td class="esd-structure" align="left">
                                                                                    <table
                                                                                        cellpadding="0"
                                                                                        cellspacing="0"
                                                                                        width="100%"
                                                                                    >
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td
                                                                                                width="600"
                                                                                                class="esd-container-frame"
                                                                                                align="left"
                                                                                                valign="top"
                                                                                            >
                                                                                                <table
                                                                                                    cellpadding="0"
                                                                                                    style=""
                                                                                                    cellspacing="0"
                                                                                                    width="100%"
                                                                                                >
                                                                                                    <tbody>
                                                                                                    <tr>
                                                                                                        <td
                                                                                                            align="center"
                                                                                                            class="esd-block-text"
                                                                                                        ></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th
                                                                                                            align="left"
                                                                                                            style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                                                            class="esd-block-text"
                                                                                                        >
                                                                                                            PRODUCT
                                                                                                        </th>
                                                                                                        <th
                                                                                                            align="right"
                                                                                                            style="padding:15px 0px;font-size: 17px;text-transform: uppercase;font-weight: bold;width: 50px;"
                                                                                                            class="esd-block-text"
                                                                                                        >
                                                                                                            QTY
                                                                                                        </th>
                                                                                                        <th
                                                                                                            align="right"
                                                                                                            style="padding:15px 0px;font-size: 17px;text-transform: uppercase;font-weight: bold;width: 130px;"
                                                                                                            class="esd-block-text"
                                                                                                        >
                                                                                                            PRICE
                                                                                                        </th>
                                                                                                        <th
                                                                                                            align="right"
                                                                                                            style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                                                            class="esd-block-text"
                                                                                                        >
                                                                                                            SUBTOTAL
                                                                                                        </th>
                                                                                                    </tr>

                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>


                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <table
                            cellpadding="0"
                            cellspacing="0"
                            class="es-content"
                            align="center"
                            style="border:1px solid #ccc; border-bottom:0.2px dashed #ccc;  background: #f9f9f9; border-top: 0px;  padding: 0px 15px;"
                        >
                            <tbody>
                            <tr>
                                <td class="esd-stripe" align="center">
                                    <table
                                        class="es-content-body"
                                        align="center"
                                        cellpadding="0"
                                        cellspacing="0"
                                        width="600"
                                    >
                                        <tbody>
                                        <tr>
                                            <td class="esd-structure" align="left">
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="100%"
                                                >
                                                    <tbody>
                                                    <tr>
                                                        <td
                                                            width="600"
                                                            class="esd-container-frame"
                                                            align="left"
                                                            valign="top"
                                                        >
                                                            <table
                                                                cellpadding="0"
                                                                style=""
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    ></td>
                                                                </tr>

                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style=" font-size: 16px; "
                                                                        class="esd-block-text"
                                                                    >
                                                                        PRODUCT
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td
                                                            width="600"
                                                            class="esd-container-frame"
                                                            align="left"
                                                            valign="top"
                                                        >
                                                            @foreach($order->orderProducts as $orderProduct)
                                                            <table
                                                                cellpadding="0"
                                                                style="margin-top:5px;"
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    ></td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style="font-size: 16px;width: 200px;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        {{ $orderProduct->product->name }}
                                                                    </td>
                                                                    <td
                                                                        align="right"
                                                                        style="font-size: 16px;width: 50px;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        {{ $orderProduct->quantity }}
                                                                    </td>
                                                                    <td
                                                                        align="right"
                                                                        style="font-size: 16px;width: 150px;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        KD {{ number_format((float)($orderProduct->sub_total), 2, '.', '') }}
                                                                    </td>
                                                                    <td
                                                                        align="right"
                                                                        style=" font-size: 16px; color: #cb131e; font-weight: 600;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        KD {{ number_format((float)($orderProduct->total), 2, '.', '')  }}
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                                @endforeach
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                               style="border:1px solid #ccc; background: #efefef; border-top: 0px;   padding: 0px 15px;">
                            <tbody>
                            <tr>
                                <td class="esd-stripe" align="center">
                                    <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                        <tbody>
                                        <tr>
                                            <td class="esd-structure" align="left">
                                                <table
                                                    cellpadding="0"
                                                    cellspacing="0"
                                                    width="100%"
                                                >
                                                    <tbody>
                                                    <tr>
                                                        <td
                                                            width="600"
                                                            class="esd-container-frame"
                                                            align="left"
                                                            valign="top"
                                                        >
                                                            <table
                                                                cellpadding="0"
                                                                style="background: #efefef;"
                                                                cellspacing="0"
                                                                width="100%"
                                                            >
                                                                <tbody>
                                                                <tr>
                                                                    <td
                                                                        align="center"
                                                                        class="esd-block-text"
                                                                    ></td>
                                                                </tr>

                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        SUBTOTAL
                                                                    </td>

                                                                    <td
                                                                        align="right"
                                                                        style="color: #cb131e; font-weight: 700;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        KD {{ number_format((float)($order->sub_total), 2, '.', '')  }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        DISCOUNT
                                                                    </td>

                                                                    <td
                                                                        align="right"
                                                                        style="color: #cb131e; font-weight: 700;"
                                                                        class="esd-block-text"
                                                                    >

                                                                        KD {{  number_format((float)($order->discount ), 2, '.', '') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        DELIVERY
                                                                    </td>

                                                                    <td
                                                                        align="right"
                                                                        style="color: #cb131e; font-weight: 700;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        KD {{ number_format((float)($order->delivery_charges), 2, '.', '') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td
                                                                        align="left"
                                                                        style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        TOTAL
                                                                    </td>

                                                                    <td
                                                                        align="right"
                                                                        style="color: #cb131e; font-weight: 700;"
                                                                        class="esd-block-text"
                                                                    >
                                                                        KD {{ number_format((float)($order->total), 2, '.', '') }}
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table cellpadding="0"
                                           style="background: #fff;  padding: 15px; border-top: 2px solid; border-bottom:0px;"
                                           cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td align="center" class="esd-block-text"></td>
                                        </tr>

                                        <tr>
                                            <td align="center" class="esd-block-text">
                                                Sold products can be returned whithin 14 days of <br>
                                                purchase ,if returned is saleable condition with sealed box.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center"
                                                style="font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                class="esd-block-text">
                                                THANK YOU for shopping with us
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>


                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        </body>
        </html>


    </div>
</section>
<script>

  function load() {
    $('#printBtn').click(function () {
        var divToPrint=document.getElementById('DivIdToPrint');

        var params = [
          'height=' + screen.height,
          'width=' + screen.width,
          'toolbar=no',
          'location=no',
          'directories=no',
          'status=no',
          'menubar=no',
          'scrollbars=no',
          'resizable=no',
          'fullscreen=yes' // only works in IE, but here for completeness
        ].join(',');


        var newWindow = window.open('', 'MyWindow', params);

        newWindow.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWindow.moveTo(0, 0);
        newWindow.focus();
        newWindow.print();
        newWindow.close();

        return false;
      }
    )
    ;
  }

  if (document.readyState === 'complete') {
    load();
  }
  else {
    $(document).ready(load);
  }
</script>
