<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <style>
            @import url('https://fonts.googleapis.com/css?family=Open+Sans');
            *{font-family: 'Open Sans', sans-serif;}
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
                        <table cellpadding="0" cellspacing="0" class="es-header esd-header-popover" align="center" style="border:1px solid #ccc; border-bottom:0px;  padding: 15px;">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-header-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20b es-p20r es-p20l" align="left" style="background-position: center top; background-color: rgb(255, 255, 255);" bgcolor="#ffffff">
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="560" class="esd-container-frame" align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" class="esd-block-image">
                                                                                        <a href="#" target="_blank"><img src="/img/logo.png" alt="" width="200" style="display: block;"></a>
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
                        <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="border:1px solid #ccc;border-top: 0px; border-bottom:0px;  padding: 0px 15px;">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                            <tbody>
                                                <tr>
                                                    <td class="esd-structure es-p20 esd-checked" align="left" style="background-image:url(https://demo.stripo.email/content/guids/0090d7d7-0c2a-49aa-a0dd-3d41ca8f70e8/images/26001544009868286.jpg);background-position: center top; background-repeat: no-repeat;">
                                                        <table cellpadding="0" cellspacing="0" width="100%" style="background-position: left top;">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="560" class="esd-container-frame" align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%" style="background-position: center top;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" class="esd-block-text es-m-txt-c es-p10" bgcolor="transparent">
                                                                                        <h2 style="color: #ffffff;  margin-top:30px;   text-transform: uppercase;"><strong>{{ $card->name_en }}</strong></h2>
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
                        <table cellpadding="0" cellspacing="0" class="es-content" align="center"  style="border:1px solid #ccc;border-top: 0px; border-bottom:0px;  padding: 15px;">
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
                                                                    <td width="600" class="esd-container-frame" align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="esd-block-text">
                                                                                        <p style="color:#222222;margin:0px; ">Dear <strong style="color:#000;">{{ $gift['name'] }}</strong></p>
                                                                                        <p style="color:#222222;margin-top:10px; ">You have recieved a gift card from <strong style="color:#000;">{{ $user['name'] }}</strong>, enjoy your shopping experience at <span style="color:#be1522;"><a href="{{ route('home') }}"> Sellektes.com</a></span>, your gateway to the best products available!</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="600" class="esd-container-frame" align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" style="background:url({{ asset('uploads/'.$card->image) }})no-repeat center top;" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="center" class="esd-block-spacer" height="80"></td>
                                                                                    <td align="center" class="esd-block-spacer" height="80"></td>
                                                                                    <td align="center" class="esd-block-spacer" height="80"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                     <td align="center" class="esd-block-spacer" height="80"></td>
                                                                                    <td align="center" class="esd-block-spacer" height="80"></td>
                                                                                    <td align="center" class="esd-block-spacer" height="80"></td>

                                                                                </tr>
                                                                                <tr>
                                                                                        <td align="center" class="esd-block-spacer" height="40"></td>
                                                                                    </tr>
                                                                                        <tr>
                                                                                        <td align="left" class="esd-block-spacer" height="20"></td>
                                                                                        <td align="right" class="esd-block-spacer" style="font-size: 30px; font-weight: bold; padding-right: 100px; ;color: {{ $card->color}};" height="20">{{ $currencyLabel }} <span style="font-size: 60px ;color: {{ $card->color}};">{{$gift->amount * $currencyValue  }}</span> </td>
                                                                                         </tr>
                                                                                         <tr>
                                                                                            <td align="center" class="esd-block-spacer" height="40"></td>
                                                                                            <td align="right" style="    padding-right: 55px;
                                                                                            padding-bottom: 0px; font-size:16px; color: #222222;" class="esd-block-spacer" height="40">YOUR GIFT VOUCHER CODE</td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" class="esd-block-spacer" height="20"></td>
                                                                                            <td align="right" style="    padding-right: 135px; font: bold !important;font-size: 20px; padding-bottom:30px; ;color: {{ $card->color}}" class="esd-block-spacer" height="25">{{ $gift->card }}</td>

                                                                                        </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="600" class="esd-container-frame" align="center" valign="top">
                                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="esd-block-text">
                                                                                        <p style="margin-bottom: 0px; color: #222222;">Voucher issue date : {{ $card->created_at->format('d-m-Y') }}</p>
                                                                                        <p style="margin-top: 5px; color: #222222;">this voucher is valid for {{ $card->availability }} months from the issue date</p>
                                                                                        <p style="color: #222222;">You can use this code for any purchase of items from  Sellekete website and mobile app, simply by using the code in check out page and enjoy your shoping</p>
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

                        <table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center" style="background: #000; padding: 15px;">
                            <tbody>
                                <tr>
                                    <td class="esd-stripe" align="center">
                                        <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: transparent;">
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
                        <table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center" style="background: #000; padding: 15px;">
                                <tbody>
                                    <tr>
                                        <td class="esd-stripe" align="center">
                                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: transparent;">
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
                                                                                        <td class="esd-block-image es-infoblock" align="left" style="color: #fff;">
                                                                                                <tr style="background: url(/img/mail/line-a.png)no-repeat;">                                                                                                       <td class="esd-block-image es-infoblock" align="center" style="height: 1px; display: block;"></td>
                                                                                                </tr>
                                                                                            <tr>
                                                                                                <td class="esd-block-image es-infoblock" align="center" style="color: #fff;    padding: 15px; padding-bottom: 0px; font-size: 14px; margin-bottom: 0px; display: block;">© Copyright 2018 Sellektis. All right Reserved</td>

                                                                                            </tr>

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
    </div>
</body>


</html>
