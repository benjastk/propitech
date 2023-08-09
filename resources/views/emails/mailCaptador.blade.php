
    

@extends('emails.layouts')
@section('content')
    <h1>Nueva solicitud de canje - Propitech.cl</h1>
    <br>
    <h1>Datos propietario</h1>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Nombre</strong></td>
                <td style="width: 50%; ">{{ $details->nombrePropietario }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Correo</strong></td>
                <td style="width: 50%; ">{{ $details->correoPropietario }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Telefono</strong></td>
                <td style="width: 50%; ">{{ $details->telefonoPropietario }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Fecha visita</td>
                <td style="width: 50%; ">{{ $details->diaVisita }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Direccion propiedad</td>
                <td style="width: 50%; ">{{ $details->direccionPropiedad }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Tipo Operación</td>
                <td style="width: 50%; ">{{ $details->nombreTipoComercial }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Tipo Propiedad</td>
                <td style="width: 50%; ">{{ $details->nombreTipoPropiedad }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Dormitorios</td>
                <td style="width: 50%; ">{{ $details->dormitorios }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Baños</td>
                <td style="width: 50%; ">{{ $details->banos }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Estacionamiento</td>
                <td style="width: 50%; ">{{ $details->estacionamiento }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Bodega</td>
                <td style="width: 50%; ">{{ $details->bodega }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h1>Datos Captador</h1>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%;"><strong>Nombre</strong></td>
                <td style="width: 50%; ">{{ $details->nombreCaptador }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Rut</strong></td>
                <td style="width: 50%; ">{{ $details->rutCaptador }}</td>
            </tr>
            <tr>
                <td style="width: 50%;"><strong>Telefono</strong></td>
                <td style="width: 50%; ">{{ $details->telefonoCaptador }}</td>
            </tr>
            <tr>
                <td style="width: 50%;">Created at</td>
                <td style="width: 50%; ">{{ $details->created_at }}</td>
            </tr>
        </tbody>
    </table>
@endsection