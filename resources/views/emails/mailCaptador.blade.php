<!DOCTYPE html>
<html>
<head>
    <title>Propitech.cl</title>
</head>
<body>
    <h1>Nueva solicitud de captador - Propitech.cl</h1>
    <br>
    <h1>Datos propietario</h1>
    <p>Nombre: {{ $details->nombrePropietario }}</p>
    <p>Correo: {{ $details->correoPropietario }}</p>
    <p>Telefono: {{ $details->telefonoPropietario }}</p>
    <p>Fecha visita: {{ $details->diaVisita }}</p>
    <p>Direccion propiedad: {{ $details->direccionPropiedad }}</p>
    <p>Tipo Operación: {{ $details->nombreTipoComercial }}</p>
    <p>Tipo Propiedad: {{ $details->nombreTipoPropiedad }}</p>
    <p>Dormitorios: {{ $details->dormitorios }}</p>
    <p>Baños: {{ $details->banos }}</p>
    <p>Estacionamiento: {{ $details->estacionamiento }}</p>
    <p>Bodega: {{ $details->bodega }}</p>

    <br>
    <h1>Datos Captador</h1>
    <p>Nombre: {{ $details->nombreCaptador }}</p>
    <p>Rut: {{ $details->rutCaptador }}</p>
    <p>Telefono: {{ $details->telefonoCaptador }}</p>
    <p>Created at: {{ $details->created_at }}</p>
    <p>www.propitech.cl</p>
</body>
</html>