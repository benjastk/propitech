@extends('emails.layouts')
@section('content')
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
        <tbody>
            <tr>
                <td valign="top" style="text-align: center;">
                    <p class="v1MsoNormal"><strong>&iexcl;Hola&nbsp;{{ $estadoPago->name }} {{ $estadoPago->apellido }}</strong><strong>👋!</strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
        <tbody>
            <tr>
                <td valign="top">
                    <p class="v1MsoNormal" style="text-align: center;">Ya se encuentra disponible el pago de tu arriendo del mes de {{ strftime("%B de %Y", strtotime($estadoPago->fechaVencimiento)) }}.</p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    
    <table style="width: 100%;">
        <tbody>
            <tr>@php(setlocale(LC_TIME, 'spanish'))
                <td style="width: 50%;"><strong>Valor arriendo</strong></td>
                <td style="width: 50%; text-align: right;">$ {{ number_format($estadoPago->arriendoMensual, 0, ",", ".") }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Garantia</strong></td>
                <td style="width: 50%; text-align: right;">${{ number_format($garantia, 0, ",", ".") }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Comisión</strong></td>
                <td style="width: 50%; text-align: right;">${{ number_format($comision, 0, ",", ".") }}</td>
            </tr
            <tr>
                <td style="width: 50%;"><strong>Abonos</strong></td>
                <td style="width: 50%; text-align: right;">${{ number_format($totalCargo, 0, ",", ".") }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Descuentos</strong></td>
                <td style="width: 50%; text-align: right;">${{ number_format($totalDescuento, 0, ",", ".") }}</td>
            </tr>
            <!--<tr>
                <td style="width: 50%;">&nbsp;</td>
                <td style="width: 50%; text-align: right;">$0</td>
            </tr>-->
        </tbody>
    </table>
    <br>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Total</strong></td>
                <td style="width: 50%; text-align: right;"><strong><span style="color: #3366ff;">$ {{ number_format($estadoPago->subtotal, 0, ",", ".") }}</span></strong></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td valign="top">
                    <p class="v1MsoNormal" align="center">Para realizar el pago s&oacute;lo debes hacer<strong>&nbsp;clic en el siguiente bot&oacute;n</strong>👇:</p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 100; text-align: center;">
                    <a href="https://propitech.cl/pago-online" target="_blank" rel="noreferrer" style="padding: 10px; background-color: red; color: white; font-weight: bolder; font-size: 16px; border-radius: 5px;">
                        Pagar Arriendo
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td valign="top">
                    <p class="v1MsoNormal">Si el enlace del bot&oacute;n no funciona, ingresa a&nbsp;<a href="https://otrospagos.com/publico/portal/enlace?convenio=propitech" target="_blank" rel="noreferrer">https://otrospagos.com/publico/portal/enlace?convenio=propitech</a>&nbsp;&nbsp;y sigue los pasos</p>
                    <p class="v1MsoNormal" align="center">&nbsp;</p>
                    <p class="v1MsoNormal" align="center">👀 Si ya realizaste el pago, por favor omite este mensaje 😁.</p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td valign="top">
                    <p class="v1MsoNormal" align="center"><strong>&iquest;Tienes dudas?</strong></p>
                    <p class="v1MsoNormal" align="center">Escr&iacute;benos a nuestro WhatsApp haciendo<a href="https://api.whatsapp.com/send/?phone=56956790356&amp;text&amp;type=phone_number&amp;app_absent=0&amp;utm_source=sendinblue&amp;utm_campaign=CHI%20-%20TRA-%20%20TENANT%20COBRO%20MENSUALIDAD&amp;utm_medium=email" target="_blank" rel="noreferrer"><strong>&nbsp;clic aqu&iacute;.&nbsp;</strong></a></p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="v1MsoNormalTable" border="0" width="100%" cellspacing="0" cellpadding="0" >
        <tbody>
            <tr>
                <td valign="top">
                    <p class="v1MsoNormal" style="font-size: 9px !important">Con el objetivo de proteger tus datos personales y evitar que caigas en estafas o fraudes, te recomendamos:&nbsp;</p>
                    <p class="v1MsoNormal" style="font-size: 9px !important">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Revisar el remitente de los mensajes que recibas. Todos nuestros correos tienen dominio @propitech.cl &nbsp;</p>
                    <p class="v1MsoNormal" style="font-size: 9px !important">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No hacer clic en links de cuentas que no conozcas.&nbsp;</p>
                    <p class="v1MsoNormal" style="font-size: 9px !important">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si desconf&iacute;as de un mensaje, escr&iacute;benos y nosotros te corroboraremos si es seguro o no.&nbsp;</p>
                    <p class="v1MsoNormal" style="font-size: 9px !important">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nunca descargues archivos de remitentes desconocidos.&nbsp;</p>
                    <p class="v1MsoNormal" style="font-size: 9px !important">&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No descargues archivos, fotos o videos de un correo que te solicite informaci&oacute;n con urgencia.&nbsp;</p>
                    <p class="v1MsoNormal" align="center">www.propitech.cl</p>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
