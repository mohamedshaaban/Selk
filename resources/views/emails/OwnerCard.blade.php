<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html charset=UTF-8"/>
    <title>Voucher Card</title>
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
                                                            <td align="center"
                                                                style="padding:15px 0px; font-size: 17px; text-transform: uppercase; font-weight: bold;"
                                                                class="esd-block-text">{{__('website.gift_email_text') }}</td>

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
