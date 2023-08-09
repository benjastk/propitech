@extends('emails.layouts')
@section('content')
    <h1>Nueva solicitud de canje - Propitech.cl</h1>
    <br>
    <h1>Datos corredor</h1>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Nombre</strong></td>
                <td style="width: 50%; ">{{ $details->nombreCorredor }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Correo</strong></td>
                <td style="width: 50%; ">{{ $details->emailCorredor }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Telefono</strong></td>
                <td style="width: 50%; ">{{ $details->telefonoCorredor }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Cantidad de propiedades</strong></td>
                <td style="width: 50%; ">{{ $details->cantidadPropiedades }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Operación</strong></td>
                <td style="width: 50%; ">{{ $details->nombreTipoComercial }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Created at</td>
                <td style="width: 50%; ">{{ $details->created_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection