<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html charset=UTF-8"/>
    <title>Order Details</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/slick.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/dd.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/flags.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/style.css')}}"/>
    <link rel="stylesheet" href="{{ asset('css/developer.css')}}"/>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');

        * {
            font-family: 'Open Sans', sans-serif;
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
                <table cellpadding="0" cellspacing="0" class="es-header esd-header-popover" align="center"
                       style="border:1px solid #ccc; border-bottom:0px;  padding: 15px;">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-header-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p20b es-p20r es-p20l" align="left"
                                        style="background-position: center top; background-color: rgb(255, 255, 255);"
                                        bgcolor="#ffffff">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="560" class="esd-container-frame" align="center" valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-image">
                                                                <a href="#" target="_blank"><img
                                                                        src="{{ asset('img/logo.png') }}" alt=""
                                                                        width="200" style="display: block;"></a>
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

                <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                       style="border:1px solid #ccc;border-top: 0px; border-bottom:0px;  padding: 15px;">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td class="esd-structure" align="left">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="300" class="esd-container-frame" style="padding-right:10px"
                                                    align="left" valign="top">
                                                    <table cellpadding="0" style="background: #efefef; padding: 15px;"
                                                           cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"
                                                                style="font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.summary_label') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"
                                                                class="esd-block-text">{{__('website.for_using_sel_label') }}</td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="font-size: 17px; border-bottom:1px solid #efefef; text-transform: uppercase; padding:15px 0px; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.customer_inf_label') }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.first_name_order_label') }} </strong>: {{$user['first_name']}}
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.last_name_order_label') }} </strong>: {{$user['last_name']}}
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.mobile_label') }} </strong>
                                                                : {{$user['phone']}} </td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="300" class="esd-container-frame" style="padding-left:10px"
                                                    align="left" valign="top">
                                                    <table cellpadding="0" style="background: #efefef;  padding: 15px;"
                                                           cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"
                                                                style="font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.your_order_label') }} </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center"
                                                                class="esd-block-text">{{__('website.order_num_label') }}
                                                                : {{$order['unique_id']}}</td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="font-size: 17px; text-transform: uppercase; border-bottom:1px solid #efefef; padding:15px 0px; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.order_details_label') }}
                                                                !
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.company_label') }}</strong> :
                                                                Sellekts
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.order_details_label') }}</strong>
                                                                : {{ $order['created_at']->format('d M y') }} </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.order_time_label') }}</strong>
                                                                :{{ $order['created_at']->format('H:i:s') }} </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.Transaction_ID_label') }}</strong>
                                                                : {{$order['unique_id']}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td align="left" style="font-size: 16px; padding:5px 0px;"
                                                                class="esd-block-text">
                                                                <strong>{{__('website.order_status') }}</strong>
                                                                : {{$order['status']['title_en']}}</td>
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
                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td class="esd-structure" align="left">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="600" class="esd-container-frame" align="left" valign="top">
                                                    <table cellpadding="0" style="background: #efefef;" cellspacing="0"
                                                           width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.payment_methos') }}</td>
                                                            @if($order['payment_method']==1)
                                                                <td align="right" style="" class="esd-block-text"><img
                                                                        src="{{ asset('img/vista.png') }}" alt=""></td>
                                                            @elseif($order['payment_method']==2)
                                                                <td align="right" style="" class="esd-block-text"><img
                                                                        src="{{ asset('img/mastercard.png') }}" alt="">
                                                                </td>

                                                            @elseif($order['payment_method']==3)
                                                                <td align="right" style="" class="esd-block-text"><img
                                                                        src="{{ asset('img/knett.png') }}" alt=""></td>

                                                            @else
                                                                <td align="right" style=""
                                                                    class="esd-block-text">{{ __("website.cod") }}</td>

                                                            @endif
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


                @foreach($order['orderproducts'] as $product)
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                           style="border:1px solid #ccc; background: #f9f9f9; border-top: 0px; border-bottom:0px;  padding: 0px 15px; margin-top:5px;margin-bottom:5px;">
                        <tbody>
                        <tr>
                            <td class="esd-stripe" align="center">
                                <table class="es-content-body" align="center" cellpadding="0" cellspacing="0"
                                       width="600">
                                    <tbody>
                                    <tr>
                                        <td class="esd-structure" align="left">
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td width="600" class="esd-container-frame" align="left"
                                                        valign="top">
                                                        <table cellpadding="0" style="" cellspacing="0" width="100%">
                                                            <tbody>
                                                            <tr>
                                                                <td align="center" class="esd-block-text">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th align="left"
                                                                    style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;width:200px;"
                                                                    class="esd-block-text">{{__('website.product_label') }}</th>
                                                                <th align="center"
                                                                    style="padding:15px 0px;font-size: 17px;text-transform: uppercase;font-weight: bold;width: 50px;"
                                                                    class="esd-block-text">{{__('website.qty_label') }}</th>
                                                                <th align="right"
                                                                    style="padding:15px 0px;font-size: 17px;text-transform: uppercase;font-weight: bold;width: 130px;"
                                                                    class="esd-block-text">{{__('website.price_label') }}</th>
                                                                <th align="right"
                                                                    style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                    class="esd-block-text">{{__('website.sub_total') }}</th>
                                                            </tr>


                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="600" class="esd-container-frame" align="left"
                                                        valign="top">
                                                        <table cellpadding="0" style="margin-top:5px;" cellspacing="0"
                                                               width="100%">
                                                            <tbody>
                                                            <tr>
                                                                <td align="center" class="esd-block-text">

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="font-size: 16px;width: 200px;"
                                                                    class="esd-block-text">{{ $product['product']['name']  }}</td>
                                                                <td align="center" style="font-size: 16px;width: 50px;"
                                                                    class="esd-block-text">{{ $product['quantity'] }}</td>
                                                                <td align="right" style="font-size: 16px;width: 150px;"
                                                                    class="esd-block-text">
                                                                    KD {{ number_format((float)($product['sub_total']), 2, '.', '') }}</td>
                                                                <td align="right"
                                                                    style=" font-size: 16px; color: #cb131e; font-weight: 600;"
                                                                    class="esd-block-text">
                                                                    KD {{ number_format((float)($product['total']), 2, '.', '') }}</td>
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







                @endforeach
                <table cellpadding="0" cellspacing="0" class="es-content" align="center"
                       style="border:1px solid #ccc; background: #efefef; border-top: 0px; border-bottom:0px;  padding: 0px 15px;">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td class="esd-structure" align="left">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="600" class="esd-container-frame" align="left" valign="top">
                                                    <table cellpadding="0" style="background: #efefef;" cellspacing="0"
                                                           width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-block-text">

                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td align="left"
                                                                style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.sub_total') }}</td>

                                                            <td align="right" style="color: #cb131e; font-weight: 700;"
                                                                class="esd-block-text">KD {{ number_format((float)($order['sub_total']), 2, '.', '') }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td align="left"
                                                                style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.delivery') }}</td>

                                                            <td align="right" style="color: #cb131e; font-weight: 700;"
                                                                class="esd-block-text">
                                                                KD {{ number_format((float)($order['delivery_charges']), 2, '.', '') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.total') }}</td>

                                                            <td align="right" style="color: #cb131e; font-weight: 700;"
                                                                class="esd-block-text">KD {{ number_format((float)($order['total']), 2, '.', '') }}</td>
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


                <table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center"
                       style="background: #000; padding: 15px;">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600"
                                   style="background-color: transparent;">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p30t es-p30b es-p20r es-p20l" align="left">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="" class="esd-container-frame" align="center" valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff; font-size: 18px; font-weight: bold;     margin-bottom: 20px; display: block;">{{__('website.social_media_label') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff; font-size: 18px; font-weight: bold;">
                                                                <a style="width: 30px; display: inline-table;" href="#"><img
                                                                        src="{{ asset('img/mail/fb.png') }}" alt=""></a>
                                                                <a style="width: 50px; text-align: center ; display: inline-table;"
                                                                   href="#"><img src="{{ asset('img/mail/twit.png') }}"
                                                                                 alt=""></a>
                                                                <a style="width: 50px; text-align: center ; display: inline-table;"
                                                                   href="#"><img src="{{ asset('img/mail/insta.png') }}"
                                                                                 alt=""></a>
                                                            </td>
                                                        </tr>


                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td width="" class="esd-container-frame" align="center"
                                                    style="width: 255px;" valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff; font-size: 18px; font-weight: bold;     margin-bottom: 20px; display: block;">{{__('website.download_app') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff; font-size: 18px; font-weight: bold;">
                                                                <a style=" display: inline-table;" href="#"><img
                                                                        src="{{ asset('img/mail/appstore.png') }}"
                                                                        alt=""></a>
                                                                <a style="text-align: center ; display: inline-table;"
                                                                   href="#"><img
                                                                        src="{{ asset('img/mail/googleplay.png') }}"
                                                                        alt=""></a>
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
                <table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center"
                       style="background: #000; padding: 15px;">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600"
                                   style="background-color: transparent;">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p30t es-p30b es-p20r es-p20l" align="left">
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td width="556" class="esd-container-frame" align="center" valign="top">
                                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="left"
                                                                style="color: #fff;">
                                                            </td>
                                                        </tr>
                                                        <tr style="background: url(img/mail/line-a.png)no-repeat;">
                                                            <td class="esd-block-image es-infoblock" align="center"
                                                                style="height: 1px; display: block;"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="esd-block-image es-infoblock" align="center"
                                                                style="color: #fff;    padding: 15px; padding-bottom: 0px; font-size: 14px; margin-bottom: 0px; display: block;">
                                                                © {{__('website.coypright') }} {{__('website.right_reserved') }}</td>

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
</div>

</body>



</html>
