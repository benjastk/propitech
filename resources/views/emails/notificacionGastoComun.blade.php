@extends('emails.layouts')
@section('css')
    <style type="text/css"> * {margin:0; padding:0; text-indent:0; }
        .s1 { color: #3B4757; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 13.5pt; }
        .s2 { color: #3A3E44; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; text-decoration: none; font-size: 11.5pt; }
        .s3 { color: #3A3E44; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s4 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; }
        .s5 { color: #161C2D; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11.5pt; }
        .s6 { color: #161C2D; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s7 { color: #A62626; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 13.5pt; }
        .s9 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s11 { color: #00F; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: underline; font-size: 12pt; }
        .s13 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11.5pt; }
        .s14 { color: #6B6B6B; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 9.5pt; }
        table, tbody {vertical-align: top; overflow: visible; }
    </style>
@endsection
@section('content')
    <table style="border-collapse:collapse;margin: auto !important;" cellspacing="0">
        <tr style="height:32pt">
            <td colspan="2">
                <p class="s1" style="padding-left: 22pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Hola {{ $informacion->nombreArrendatario }} {{ $informacion->apellidoArrendatario }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s2" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">Te escribimos respecto a la propiedad que arriendas, ubicada en {{ $informacion->direccionPropiedad }}
                @if($informacion->block) , departamento {{ $informacion->block }} @endif, comuna de {{ $informacion->nombreComunaPropiedad }}, Región {{ $informacion->nombreRegionPropiedad }}.
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s7" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">
                    Actualmente mantienes 2 o más gastos comunes pendientes de pago.
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s3" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">
                    Te recordamos que, según lo establecido en el contrato de arriendo suscrito, la cláusula Sexta de Prohibiciones señala:
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s14" style="padding-left: 26pt;padding-right: 26pt;text-indent: 0pt;text-align: justify;">
                    <i>"Queda prohibido a la arrendataria: (...) d) Retrasar el pago de las cuentas de los servicios básicos, tales como luz, agua potable, teléfono, gastos comunes, extracción de basuras, cable e internet, etc. (...)"</i>
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s3" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">
                    Para evitar mayores inconvenientes, te pedimos regularizar tu situación a la brevedad, dirigiéndote directamente a administración.
                </p>
            </td>
            <td style="width:47pt">
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
            </td>
        </tr>
    </table>
    <table style="border-collapse:collapse;margin: auto !important" cellspacing="0">
        <tr>
            <td colspan="2">
                <p class="s3" style="padding-top: 5pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">
                    <span class="s9">☝</span> Si ya realizaste el pago o tienes dudas sobre tu situación, por favor comunícate con nosotros a
                    <a href="mailto:contacto@propitech.cl" class="s11" target="_blank">contacto@propitech.cl</a> o
                    <a href="mailto:administracion@propitech.cl" class="s11" target="_blank">administracion@propitech.cl</a>.
                </p>
            </td>
        </tr>
        <tr style="height:123pt" style="margin: auto !important">
            <td colspan="2">
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p style="padding-top: 10pt; text-align: center;">
                    <a href="mailto:administracion@propitech.cl" style=" color: #3A3E44; font-family:&quot;Lucida Sans Unicode&quot;, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt;" target="_blank">
                        ¡Siempre estamos para ayudarte!
                    </a>
                    <br>
                    <a href="mailto:administracion@propitech.cl" class="s11" target="_blank">
                        contacto@propitech.cl
                    </a>
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p style="text-align: center;">
                    <span>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin: auto !important;">
                            <tr>
                                <td>
                                    <img width="118" height="34" src="https://propitech.cl/front/011.png"/>
                                </td>
                            </tr>
                        </table>
                    </span>
                </p>
            </td>
        </tr>
    </table>
@include('emails.gastoComunFooterIcons')
@endsection
