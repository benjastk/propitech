@extends('emails.layouts')
@section('content')
    <h1>Nuevo contacto - Portal Inmobiliario / Mercado Libre</h1>
    <br>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Nombre</strong></td>
                <td style="width: 50%; ">{{ $details->nombre ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Correo</strong></td>
                <td style="width: 50%; ">{{ $details->email ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Telefono</strong></td>
                <td style="width: 50%; ">{{ $details->telefono ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Mensaje</td>
                <td style="width: 50%; ">{{ $details->mensaje ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Item ID (aviso)</td>
                <td style="width: 50%; ">{{ $details->itemId ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Dirección</td>
                <td style="width: 50%; ">{{ $details->direccion ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Block/Depto</td>
                <td style="width: 50%; ">{{ $details->block ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Comuna</td>
                <td style="width: 50%; ">{{ $details->comuna ?? 'No informado' }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Topic</td>
                <td style="width: 50%; ">{{ $details->topic ?? 'No informado' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h1>Datos completos recibidos (crudo)</h1>
    <p style="white-space: pre-wrap; word-break: break-all;">{{ $details->raw ?? 'Sin datos' }}</p>
@endsection
