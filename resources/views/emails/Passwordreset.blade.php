
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('customer.reset_password')}}</title>
</head>

<body>
<table width="100%" style="min-width:1000px;" border="0" cellspacing="0" cellpadding="20">
    <tr>
        <td height="130" align="center" valign="top" bgcolor="#cfd6de"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                    <td width="50%" height="68" style="padding:5px;" bgcolor="#FFFFFF"></td>
                    <td width="50%"    align="right" valign="middle" bgcolor="#FFFFFF" style="font-family:Verdana, Geneva, sans-serif; font-size:16px; line-height:normal; padding:5px">

                </tr>
                <tr>
                    <td height="274" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"; style="min-height:300px;">
                        <div style=" padding:20px; font-size:28px; font-family:Verdana, Geneva, sans-serif; font-weight:bold;  color:#fff; background-color:#fa9b18">{{ __('customer.thank_you_label')}}<span style="color:#2175aa">  </span>

                            {{ __('customer.reset_password_emil_label')}} }}<span style="color:#2175aa">  </span></div>
                         
                        <p style="line-height: normal;    padding: 28px 10px 25px 10px;    font-size: 16px;    text-align: center;    font-family: Verdana, Geneva, sans-serif;    border: solid 1px #e4e8eb;    margin: 10px 20px 10px 20px;">{{ __('customer.reset_password_link_label')}}<a style="text-decoration:none; color:#000; font-family:Verdana, Geneva, sans-serif; color:#2175aa;" href="{{ route('password.reset.token',$token) }}">{{ __('customer.reset_password_label')}}</a>  </p></td>

                </tr>
                
            </table></td>
    </tr>
</table>
</body>
</html>
