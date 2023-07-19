<!DOCTYPE html>
<html>
<head>
    <title>Propitech.cl</title>
</head>
<body>
    <h1>Nuevo contacto desde formulario web - Propitech.cl</h1>
    <p>Nombre: {{ $details->nombre }}</p>
    <p>Correo: {{ $details->email }}</p>
    <p>Telefono: {{ $details->telefono }}</p>
    <p>Mensaje: {{ $details->mensaje }}</p>
    <p>Formulario: {{ $details->nombreFormulario }}</p>
    <p>Created at: {{ $details->created_at }}</p>
    <p>www.propitech.cl</p>
</body>
</html>