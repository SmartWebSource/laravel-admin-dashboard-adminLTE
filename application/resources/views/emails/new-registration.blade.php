@extends('emails.master')

@section('body')
<table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
    <tbody>
        <tr>
            <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">
                    Hello {{$name}},
                </h1>
                <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                    Thanks so much for signing up with {{$appName}}!
                    <br>
                    To finish signing up click below to activate your account
                </p>
                <table align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
                    <tbody>
                        <tr>
                            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                                                <a href="{{url('account/active/'.$token)}}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1">
                                                                    ACTIVATE MY ACCOUNT
                                                                </a>
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
                <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                    Keep below information safe 
                    <br><br>
                    Email: {{$email}}
                    <br>
                    Password: {{$password}}
                    <br><br>
                    <small>NOTE: The activation link will be valid for one hour.</small>
                </p>
                <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                    Regards,<br>{{$appName}}
                </p>
                <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px">
                    <tbody>
                        <tr>
                            <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                                <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px">
                                    If you're having trouble clicking the "ACTIVATE MY ACCOUNT" button, copy and paste the URL below into your web browser: 
                                    <a href="{{url('account/active/'.$token)}}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4">{{url('account/active/'.$token)}}</a>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@endsection
