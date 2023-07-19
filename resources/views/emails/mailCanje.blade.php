<!DOCTYPE html>
<html>
<head>
    <title>Propitech.cl</title>
</head>
<body>
    <h1>Nueva solicitud de canje - Propitech.cl</h1>
    <br>
    <h1>Datos corredor</h1>
    <p>Nombre: {{ $details->nombreCorredor }}</p>
    <p>Correo: {{ $details->emailCorredor }}</p>
    <p>Telefono: {{ $details->telefonoCorredor }}</p>
    <p>Cantidad de propiedades: {{ $details->cantidadPropiedades }}</p>
    <p>Operación: {{ $details->nombreTipoComercial }}</p>
    <p>Created at: {{ $details->created_at }}</p>
    <p>www.propitech.cl</p>
</body>
</html>