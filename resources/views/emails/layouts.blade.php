<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="https://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <meta content="width=device-width" name="viewport"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>

    <title>@yield('titulo')</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: 20px;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }

        .button {
            background-color: #EF3340;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
    <style id="media-query" type="text/css">
        @media (max-width: 720px) {

            .block-grid,
            .col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }
        .video-wrapper {display:none;}
        @media (-webkit-min-device-pixel-ratio: 0) and (min-device-width:1024px) 
        {
          .video-wrapper { display:block!important; }
          .video-fallback { display:none!important; }
        }
        @supports (-webkit-overflow-scrolling:touch) and (color:#ffffffff) {
            div[class^=video-wrapper] { display:block!important; }
            div[class^=video-fallback] { display:none!important; }
        }
        #MessageViewBody .video-wrapper { display:block!important; }
        #MessageViewBody .video-fallback { display:none!important; }
    </style>
</head>

<body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: transparent;">
    <table bgcolor="transparent" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: transparent; width: 100%;" valign="top" width="100%">
        <tbody>
            <tr style="vertical-align: top;" valign="top">
            <td style="word-break: break-word; vertical-align: top;" valign="top">
            <div style="background-color:transparent;">
                <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #F3F3F1;">
                    <div style="border-collapse: collapse;display: table;width: 100%;background-color:#F3F3F1;">
                        <div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                            <div style="width:100% !important;">
                                <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
                                    <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                        <img align="center" alt="Image" border="0" class="center fixedwidth" src=" http://propitech.cl/front/01copia.png" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 350px; display: block;" title="Image" width="350">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background-color:transparent;">
                <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
                    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                        <div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top; width: 680px;">
                            <div style="width:100% !important;">
                                <div style="border-top:0px solid transparent; border-left:10px solid #F3F3F1; border-bottom:0px solid transparent; border-right:10px solid #F3F3F1; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
                                    <div style="color:#555555;font-family:'Montserrat', 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;line-height:120%;padding-top:30px;padding-right:60px;padding-bottom:30px;padding-left:60px;">
                                        <div style="font-family: 'Montserrat', 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif; font-size: 12px; line-height: 14px; color: #555555;">
                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </td>
            </tr>
        </tbody>
    </table>
    <div style="background-color:transparent;">
        <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 700px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
                <div class="col num12" style="min-width: 320px; max-width: 700px; display: table-cell; vertical-align: top; width: 700px;">
                    <div style="background-color:#F3F3F1;width:100% !important;">
                        <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
                            <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
                                <div style="font-size:1px;line-height:50px"> </div>
                                <!--<img align="center" alt="Image" border="0" class="center fixedwidth" src="{{ asset('/dist/img/AdminLTELogo.png') }}" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 10%; max-width: 350px; display: block;" title="Image" width="350"/><br>-->
                                <div style="font-size:1px;line-height:10px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>