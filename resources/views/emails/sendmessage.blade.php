<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}_{{ strtoupper(app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
</head>

<body>

    <div id=":199" class="ii gt"
        jslog="20277; u014N:xr6bB; 1:WyIjdGhyZWFkLWY6MTc1MTk5MTE1MjM2OTY5OTE5MyIsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsW11d; 4:WyIjbXNnLWY6MTc1MTk5MTE1MjM2OTY5OTE5MyIsbnVsbCxbXV0.">
        <div id=":198" class="a3s aiL msg9194162894505647673">
            <u></u>

            <div>
                <table align="center" bgcolor="#f9fafc" border="0" cellpadding="0" cellspacing="0"
                    class="m_9194162894505647673email-container"
                    style="
              font-family: Helvetica, sans-serif;
              width: 100%;
              max-width: 598px;
              padding: 0 36px;
            ">
                    <tbody>
                        <tr>
                            <td>
                                <table align="left" border="0" cellpadding="0" cellspacing="0"
                                    style="font-family: Helvetica, sans-serif; width: 100%">
                                    <tbody>
                                        <tr style="width:30%; margin-left:auto; ">
                                            <td style="width: 35%"></td>

                                            @if (isset($setting->social_media['facebook_url']) && !empty(trim($setting->social_media['facebook_url'])))
                                                <td align="left"
                                                    style="
                            width: 25px;
                            padding: 41px 0 10px;
                            text-align: right;
                            margin-right:10px;
                          ">
                                                    <a href="{{ $setting->social_media['facebook_url'] }}"
                                                        style="display: block; width: 25px; height: 25px"
                                                        target="_blank"><img alt=""
                                                            src="https://ci4.googleusercontent.com/proxy/FoiTvwfVMtmSl7yrsMlDx4uW_cVGhbGC08zRG7J8SGGFDeDJPFHFEsG_AbYv71095pImNuIo4Tk9TBbtlbJqq_DWOjnY8wmD2Lf9LGBZmgvOgzqP4CZzk09kCVh2-ZROe1AlX_ONVG3uvZtYH4ru1yRtCF0gf8z5dGsraPgr_ATnyGaG1TjE=s0-d-e1-ft#https://bina.azstatic.com/assets/mails/facebook-b7c463345550c259830c5ec3dea7c4c6eb9aaa295428edc55f9d99cac67e1e17.png"
                                                            style="
                                display: block;
                                width: 25px;
                                height: 25px;
                                vertical-align: top;
                                border: 0;
                                margin-right:10px;
                              "
                                                            class="CToWUd" data-bit="iit" /></a>
                                                </td>
                                            @endif

                                            @if (isset($setting->social_media['instagram_url']) && !empty(trim($setting->social_media['instagram_url'])))
                                                <td align="left"
                                                    style="
                            width: 25px;
                            padding: 41px 0 10px;
                            text-align: right;
                            margin-right:10px;
                          ">
                                                    <a href="{{ $setting->social_media['instagram_url'] }}"
                                                        style="display: block; width: 25px; height: 25px"
                                                        target="_blank"><img alt=""
                                                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png"
                                                            style="
                                display: block;
                                width: 25px;
                                height: 25px;
                                vertical-align: top;
                                border: 0;

                              "
                                                            class="CToWUd" data-bit="iit" /></a>
                                                </td>
                                            @endif


                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="m_9194162894505647673content"
                                style="
                    padding: 20px 40px;
                    color: #87898f;
                    background-color: #fff;
                    border: 1px solid #dfebf9;
                    line-height: 1.36;
                    border-radius: 2px;
                    margin-top:-10px;
                  ">
                                <table align="center" border="0" cellpadding="0" cellspacing="0"
                                    style="font-family: Helvetica, sans-serif">
                                    <tbody>
                                        <tr>
                                            <td align="center"
                                                style="text-align: center; padding-bottom: 20px;font-size:40px;font-weight:bold;@if (env('WEBSITE_NAME') == 'ev-sat.az') color:#0C24AA; @else color:#07C1B9; @endif">
                                                <img src="https://admin.anthill.center/uploads/settings/AnthillServicesAdmin1687269658.svg"
                                                    onclick="window.location.href=`{{ route('welcome') }}`"
                                                    alt="{{ $setting->title[app()->getLocale() . '_title'] }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                    {!! $messagecontent !!}
                                                </p>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="m_9194162894505647673footer" style="padding: 11px 0 65px">
                                <p
                                    style="
                      font-size: 10px;
                      font-weight: 300;
                      text-align: center;
                      color: #000;
                      padding: 0;
                      margin: 0;
                    ">
                                    © {{ date('Y') }}
                                    <a href="{{ env('APP_URL') }}" target="_blank">{{ env('WEBSITE_NAME') }}</a>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="yj6qo"></div>
            <div class="adL"></div>
        </div>
    </div>
</body>

</html>
