<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>{{env('APP_NAME')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style type="text/css">
    body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
    }

    a {
        color: #D12F2F;
    }

    @media only screen and (max-width:767px) {
        .mob-col-padding {
            padding: 20px 15px !important;
        }

        .no-padd {
            padding: 10px !important;
        }
    }
    </style>
</head>

<body width="100%" style="margin: 0; padding: 0 !important; font-family: 'Inter', sans-serif; color:#fff;">
    <center style="width: 100%; height: 100%; background-color: #fff;">
        <div style="max-width: 600px; margin: 0 auto;">
            <!-- BEGIN BODY -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="margin: auto; background-color:#0b2139">

                <tr>
                    <td valign="top">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="">
                            <tr>
                                <td style="text-align:center;">
                                    <a href="{{url('/')}}" target="_blank"
                                        style="padding: 20px 0 0;display: block;"><img
                                            src="{{url('/assets/images/logo-white.png')}}"
                                            style="width: 120px;margin: 8px;" /></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td class="no-padd" valign="top" style="padding: 20px 20px;">
                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
                            width="100%" style="margin: auto; background-color:#fff; border-radius:20px;">
                            <tr>
                                <td>
                                    <div class="mob-col-padding" style="padding: 2em; text-align: center;">
                                        <h2 class="mob-title1"
                                            style="margin-top:5px; margin-bottom: 18px; font-size: 22px; font-weight: 700; line-height: 28px; color:#000000; font-family: 'Inter', sans-serif;">
                                            Hi {{ $username }},
                                        </h2>

                                        <p
                                            style="color: #555; font-weight: 500; line-height: 24px; font-size: 14px; margin:0px; padding:0px 0px 10px 0px; font-family: 'Inter', sans-serif;">
                                            You have requested a internal transfer of amount {{$amount}} {{$currency}} :
                                        </p>

                                        <p
                                            style="color: #555; font-weight: 500; line-height: 24px; font-size: 14px; margin:0px; padding:0px 0px 20px 0px; font-family: 'Inter', sans-serif;">
                                            Your one time password for transfer confirmation is below :
                                        </p>
                                        <div class="otpborder"
                                            style="max-width: 400px; font-family: 'Inter', sans-serif; margin:0px auto 20px; border: 2px dashed #056fb4; color: #fff; text-align: center; padding:20px 30px; border-radius: 5px;">
                                            <h3
                                                style="font-weight: 700; line-height: normal; font-size: 22px; color: #056fb4; margin:0 0 0 0;">
                                                OTP : {{ $otp }}
                                            </h3>
                                        </div>

                                        <p
                                            style="color: #555; font-weight: 500; line-height: 24px; font-size: 14px; margin:0px; padding:0px 0px 10px 0px; font-family: 'Inter', sans-serif;">
                                            Your OTP is valid for {{ $otp_valid_mins }} mins.
                                        </p>

                                        <p
                                            style="color: #555; font-weight: 500; line-height: 24px; font-size: 14px; margin:0px; padding:0px 0px 20px 0px; font-family: 'Inter', sans-serif;">
                                            If you did NOT requested OTP from this email address, then please ignore
                                            this email. Please note that many times, the situation isn’t a phishing
                                            attempt but either a misunderstanding of how to use our services or someone
                                            setting up email sending capabilities on your behalf as a part of
                                            justifiable service but if you are still concerned,
                                        </p>
                                        <!-- <p
                                            style="font-family: 'Inter', sans-serif; color: #555; line-height: 24px; font-size: 14px; margin:0px; font-weight: 500; padding:0px 0px 20px 0px;">
                                            Please Write us at <a href="#"
                                                style="font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500; display: inline-block; color: #000; text-decoration: none;"></a><br />

                                        </p> -->
                                        <p
                                            style="color: #555; font-size: 14px; margin:0px; line-height: 24px; font-weight: 500; padding:0px 0px 0px 0px; font-family: 'Inter', sans-serif;">
                                            Thank you<br />
                                            <strong
                                                style="color: #000; font-size: 16px; margin:0px; line-height: 24px; font-weight: 600; font-family: 'Inter', sans-serif;">{{env('APP_NAME')}}
                                                Team</strong>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- end tr -->

                <tr>
                    <td valign="middle" style="padding:30px 20px;">

                        <table style="width:100%;">
                            <tr>
                                <td>
                                    <div class="mob-col-padding2" style="text-align: center;">
                                        <div
                                            style="margin-bottom:30px; border-bottom: #D3D3D3 1px solid; color: #A3A3A3; padding: 0 0 20px 0;">
                                            <div>
                                                <strong
                                                    style="color: #A3A3A3; font-weight: 600; font-family: 'Inter', sans-serif; font-size: 12px; margin:0px 0 10px 0; padding:0px 0px 0px 0px;  display: block;">Please
                                                    Write us at</strong>
                                                <a href="mailto:{{env('MAIL_FROM_ADDRESS')}}"
                                                    style="text-decoration: none; color: #fff; margin:0px; font-size: 14px; font-weight: 500;">{{env('MAIL_FROM_ADDRESS')}}</a>

                                            </div>
                                        </div>


                                        <p
                                            style="text-align:justify; color: #A3A3A3; font-weight: 500; font-size: 12px; margin:0px auto 20px; padding:0px 0px 0px 0px; font-family: 'Inter', sans-serif; max-width: 510px;">
                                            Note: {{env('APP_NAME')}} will never call or e-mail you and ask you to
                                            disclose or verify your password or bank details. If you receive a
                                            suspicious e-mail with a link to update your account information, do not
                                            click on the link, instead report the e-mail to {{env('APP_NAME')}} for
                                            investigation
                                            <br />
                                            <br />
                                            Please do not reply to this email. Emails sent to this address will not be
                                            answered.
                                        </p>
                                        <p
                                            style="color: #A3A3A3; font-weight: 500; font-family: 'Inter', sans-serif; font-size: 12px; margin:0px; padding:0px 0px 0 0px; font-family: 'Inter', sans-serif;">
                                            © {{env('APP_NAME')}} All Rights Reserved</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </div>
    </center>
</body>

</html>