<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sifariş məlumatı {{ $data->uid }}</title>
    <style type="text/css">
        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        html {
            width: 100%;
        }

        body {
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
            margin: 0;
            padding: 0;
        }

        table {
            border-spacing: 0;
            table-layout: fixed;
            margin: 0 auto;
        }

        table table table {
            table-layout: auto;
        }

        .yshortcuts a {
            border-bottom: none !important;
        }

        img:hover {
            opacity: 0.9 !important;
        }

        a {
            color: #6ec8c7;
            text-decoration: none;
        }

        .textbutton a {
            font-family: 'open sans', arial, sans-serif !important;
        }

        .btn-link a,
        .header-btn a {
            color: #FFFFFF !important;
        }

        .cta-btn a {
            color: #6ec8c7 !important;
        }

        /*Responsive*/
        @media only screen and (max-width: 640px) {
            body {
                margin: 0px;
                width: auto !important;
                font-family: 'Open Sans', Arial, Sans-serif !important;
            }

            .table-inner {
                width: 90% !important;
                max-width: 90% !important;
            }

            .table-full {
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        @media only screen and (max-width: 479px) {
            body {
                width: auto !important;
                font-family: 'Open Sans', Arial, Sans-serif !important;
            }

            .table-inner {
                width: 90% !important;
            }

            .table-full {
                width: 100% !important;
                max-width: 100% !important;
            }

            /*gmail*/
            u+.body .full {
                width: 100% !important;
                width: 100vw !important;
            }
        }
    </style>
    <style type="text/css">
        .product-unit-price {
            font-size: 1.7em;
        }

        .product-unit-price.action_price_flyout_cart {
            font-size: 1.1em;
            vertical-align: sub;
        }

        .product-subtotal {
            font-size: 1.6em;
        }

        .old-price {
            text-decoration: line-through;
            font-size: 0.8em;
            color: gray;
            margin-left: 0.3em
        }
    </style>
</head>

<body class="body">
    <table class="full" bgcolor="#ffffff" align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="background-size:cover; background-position:bottom;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td align="center" width="800">
                                    <table align="center" width="90%" class="table-inner" border="0"
                                        cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <!--profile-->
                                            <tr>
                                                <td align="center" style="line-height:0px;"><img
                                                        style="display:block; line-height:0px; font-size:0px; border:0px;width:200px "
                                                        src="https://organiksatinal.com/content/images/thumbs/0000188.png"
                                                        alt="img" /></td>
                                            </tr>
                                            <!--end profile-->
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <!--content-->
                                            <tr>
                                                <td align="center"
                                                    style="font-family:Open sans, Arial, Sans-serif; font-size:16px; color:#808E8E;line-height:30px;">

                                                    @if ($data->status == 2 || $data->status == 1)
                                                        Salam
                                                        {{ isset($data->user->name) && $data->user->name ? $data->user->name : null }}
                                                        {{ isset($data->user->surname) && $data->user->surname != null ? $data->user->surname : null }},
                                                        sifarişiniz alınmışdır. <a
                                                            href="https://organiksatinal.az">OrganikSatınAl</a>
                                                        seçiminiz üçün təşəkkür edirik. Sifarişiniz haqda yeniliklər
                                                        sizə
                                                        bildiriləcək.
                                                    @elseif($data->status == 3)
                                                        Salam

                                                        {{ isset($data->user->name) && $data->user->name ? $data->user->name : null }}
                                                        {{ isset($data->user->surname) && $data->user->surname != null ? $data->user->surname : null }},
                                                        sifarişiniz kuryerə təhvil verildi. <a
                                                            href="https://organiksatinal.az">OrganikSatınAl</a>
                                                        seçiminiz üçün təşəkkür edirik. Sifarişiniz haqda yeniliklər
                                                        sizə
                                                        bildiriləcək.
                                                    @elseif($data->status == 4)
                                                        Salam

                                                        {{ isset($data->user->name) && $data->user->name ? $data->user->name : null }}
                                                        {{ isset($data->user->surname) && $data->user->surname != null ? $data->user->surname : null }},
                                                        sifarişiniz tamamlandı. <a
                                                            href="https://organiksatinal.az">OrganikSatınAl</a>
                                                        seçiminiz üçün təşəkkür edirik.
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end content-->
                                            <!--dash-->
                                            <tr>
                                                <td align="center">
                                                    <table align="center" width="50" border="0" cellspacing="0"
                                                        cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td height="15"
                                                                    style="border-bottom:3px solid #7cc243;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--end dash-->
                                            <tr>
                                                <td height="20"></td>
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
    <table class="full" bgcolor="#ffffff" align="center" width="100%" border="0" cellspacing="0"
        cellpadding="0">
        <tr>
            <td align="center">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td align="center" width="800">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <table class="table-inner" width="95%" border="0" align="center"
                                            cellpadding="0" cellspacing="0">
                                            <!--title-->
                                            <tr>
                                                <td align="left"
                                                    style="font-family:Open sans, Arial, Sans-serif; font-size:16px; color:#4A4A4A;font-weight:bold;">
                                                    Sifariş haqqında</td>
                                            </tr>
                                            <!--end title-->
                                            <tr>
                                                <td height="5" style="border-bottom:2px solid #ECECEC;"></td>
                                            </tr>
                                            <tr>
                                                <td height="15"></td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" align="center" cellpadding="0"
                                            cellspacing="0">
                                            <tr>
                                                <td align="center"
                                                    style="text-align:center;vertical-align:top;font-size:0;">
                                                    <div style="display:inline-block; vertical-align:top;">
                                                        <table align="left" border="0" cellpadding="0"
                                                            cellspacing="0">
                                                            <tr>
                                                                <td align="left" width="800">
                                                                    <table width="90%" align="center"
                                                                        border="0" cellpadding="0"
                                                                        cellspacing="0">
                                                                        <!--content-->
                                                                        <tr>
                                                                            <td
                                                                                style="font-family:Open sans, Arial, Sans-serif; font-size:14px; color:#808E8E;line-height:28px;">
                                                                                Sifariş nömrəsi: {{ $data->uid }}
                                                                                <br />
                                                                                Tarix:
                                                                                {{ App\Helpers\Helper::getDateTimeViaTimeStamp($data->created_at) }}
                                                                                <br />
                                                                                Ödəniş növü: @if ($data->type == 1)
                                                                                    Kartla birbaşa ödəniş
                                                                                @elseif($data->type == 2)
                                                                                    Nağd
                                                                                @endif
                                                                                <br />
                                                                                <a target="_blank"
                                                                                    href="{{ env('APP_SITE_URL') . '/profile/orders/' . $data->uid }}">Sifariş
                                                                                    haqqında</a>
                                                                            </td>
                                                                        </tr>
                                                                        <!--end content-->
                                                                        <tr>
                                                                            <td height="25"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--2/2 panel-->
    <table class="full" bgcolor="#ffffff" align="center" width="100%" border="0" cellspacing="0"
        cellpadding="0">
        <tr>
            <td align="center">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="20"></td>
                    </tr>
                    <tr>
                        <td align="center" width="800">
                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="text-align:center;vertical-align:top;font-size:0;">
                                        <!--left-->
                                        <div style="display:inline-block; vertical-align:top;">
                                            <table align="center" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="400" align="center">
                                                        <table width="90%" border="0" align="center"
                                                            cellpadding="0" cellspacing="0">
                                                            <!--title-->
                                                            <tr>
                                                                <td
                                                                    style="font-family:Open sans, Arial, Sans-serif; font-size:16px; color:#4A4A4A;font-weight:bold;">
                                                                    Çatdırılma</td>
                                                            </tr>
                                                            <!--end title-->
                                                            <tr>
                                                                <td height="5"
                                                                    style="border-bottom:2px solid #ECECEC;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="20"></td>
                                                            </tr>
                                                            <!--content-->
                                                            <tr>
                                                                <td
                                                                    style="font-family:Open sans, Arial, Sans-serif; font-size:14px; color:#808E8E;line-height:28px;">
                                                                    {{ isset($data->deliveryaddress->receiver_name) && $data->deliveryaddress->receiver_name != null ? $data->deliveryaddress->receiver_name : null }}
                                                                    <br />
                                                                    Tel :
                                                                    {{ isset($data->deliveryaddress->receiver_phone) && $data->deliveryaddress->receiver_phone != null ? $data->deliveryaddress->receiver_phone : null }}
                                                                    <br />
                                                                    {{ isset($data->deliveryaddress->receiver_address) && $data->deliveryaddress->receiver_address != null ? $data->deliveryaddress->receiver_address : null }}
                                                                    <br />
                                                                    {{ isset($data->deliveryaddress->receiver_city) && $data->deliveryaddress->receiver_city != null ? $data->deliveryaddress->receiver_city : null }}
                                                                    <br />
                                                                    {{ isset($data->deliveryaddress->receiver_country) && $data->deliveryaddress->receiver_country != null ? $data->deliveryaddress->receiver_country : null }}
                                                                    <br />
                                                                </td>
                                                            </tr>
                                                            <!--end content-->
                                                            <tr>
                                                                <td height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!--end left-->
                                        <!--[if (gte mso 9)|(IE)]>
                                          </td>
                                          <td align="center" style="text-align:center;vertical-align:top;font-size:0;">
                                          <![endif]-->
                                        <!--right-->

                                        <!--end right-->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--end 2/2 panel-->
    <!--quote-->
    <table class="full" bgcolor="#ffffff" align="center" width="100%" border="0" cellspacing="0"
        cellpadding="0">
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td align="center" bgcolor="#ffffff" style="background-size:cover; background-position:bottom;">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" width="800">
                            <table align="center" width="100%" class="table-inner" border="0" cellspacing="0"
                                cellpadding="0">
                                <!--content-->
                                <tr>
                                    <td align="center"
                                        style="font-family:Open sans, Arial, Sans-serif; font-size:16px; color:#ffffff;line-height:30px;">
                                    </td>
                                </tr>
                                <!--end content-->
                                <tr>
                                    <td height="15"></td>
                                </tr>
                                <!--detail-->
                                <tr>
                                    <td align="center"
                                        style="font-family:Open sans, Arial, Sans-serif; font-size:14px; color:#333333;">
                                        @if (isset($data) && $data->action_price != 0)
                                            €{{ $data->action_price }}
                                            <span class="old-price">€{{ $data->price }}</span>
                                        @else
                                            €{{ $data->price }}
                                        @endif
                                    </td>
                                </tr>
                                <!--end detail-->
                                <tr>
                                    <td height="45"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--end quote-->
</body>

</html>
