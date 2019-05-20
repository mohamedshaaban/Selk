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
                                                                                        <td align="right" class="esd-block-spacer" style="font-size: 30px; font-weight: bold; padding-right: 100px; ;color: {{ $card->color}};" height="20">{{ $currencyLabel }} <span style="font-size: 60px ;color: {{ $card->color}};">{{$card->price  * $currencyValue }}</span> </td>
                                                                                         </tr>
                                                                                         <tr>
                                                                                            <td align="center" class="esd-block-spacer" height="40"></td>
                                                                                            <td align="right" style="    padding-right: 55px;
                                                                                            padding-bottom: 0px; font-size:16px; color: #222222;" class="esd-block-spacer" height="40">YOUR GIFT VOUCHER CODE</td>

                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td align="center" class="esd-block-spacer" height="20"></td>
                                                                                            <td align="right" style="    padding-right: 55px; font-size: 20px; padding-bottom:30px; ;color: {{ $card->color}}" class="esd-block-spacer" height="25">12G5 F0D9  9512 7894</td>

                                                                                        </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="600" class="esd-container-frame" align="center" valign="top">

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
