@extends('emails.layouts')
@section('content')
    <h1>Fallo al refrescar el token de Portal Inmobiliario</h1>
    <br>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Motivo</strong></td>
                <td style="width: 50%; ">{{ $details->motivo ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Fecha</td>
                <td style="width: 50%; ">{{ $details->fecha ?? 'No informado' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h1>Detalle</h1>
    <p style="white-space: pre-wrap; word-break: break-all;">{{ $details->raw ?? 'Sin datos' }}</p>
    <br>
    <p>Ingresa a <a href="https://propitech.cl/api/portalinmobiliario/redirect">https://propitech.cl/api/portalinmobiliario/redirect</a> para reautorizar manualmente.</p>
@endsection
