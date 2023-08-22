<html>
    <head>
        <style>
            @page {
                margin: 100px 100px;
                font-size: 15px;
                font-family: Arial, Helvetica, sans-serif;
            }

            header {
                position: fixed;
                top: -50px;
                left: 0px;
                right: 0px;
                height: 50px;
                background-color: white;
                color: white;
                text-align: center;
                line-height: 35px;
                width: 615px;
            }

            footer {
                position: fixed; 
                bottom: -20px; 
                left: 0px; 
                right: 0px;
                height: 20px; 
                background-color: white;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            th, td {
                height: 12px !important;
            }
            p
            {
                padding: 0px !important;
                margin: 0px !important;
            }
        </style>
    </head>
    <body style="text-align: justify;">
        <footer>
        </footer>
        <main>
            <p style="text-align: center;"><span style="text-decoration: underline;"><strong>DECLARACI&Oacute;N JURADA DE RESIDENCIA</strong></span></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @php
            $rutUsuario1 = explode( "-", $usuario->rut );
            $rutUsuario = number_format( $rutUsuario1[0], 0, "", ".") . '-' . $rutUsuario1[1];
            @endphp
            <p>Yo, {{ $usuario->name }} {{ $usuario->apellido }}, C&eacute;dula Nacional de Identidad N&deg; {{ $rutUsuario }}, con domicilio en
            {{ $usuario->direccion }} {{ $usuario->numero }}, @if($usuario->block ) {{ $usuario->block }}, @endif comuna de {{ $usuario->nombreComuna }}, por medio de este 
            documento declaro bajo juramento lo siguiente:</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>Que el domicilio indicado, ubicado en {{ $usuario->direccion }} {{ $usuario->numero }}, @if($usuario->block ) {{ $usuario->block }}, @endif
                 comuna de {{ $usuario->nombreComuna }}, regi&oacute;n {{ $usuario->nombreRegion }}, corresponde a mi residencia.</p>
            <p>&nbsp;</p>
            <p>Esta declaraci&oacute;n ser&aacute; utilizada para presentar en cordones y controles sanitarios y para los dem&aacute;s fines que sean 
            pertinentes.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            @php(setlocale(LC_TIME, 'spanish'))
            <p>En Santiago, a {{ strftime("%d de %B de %Y", strtotime($fechaHoy)) }}.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p style="text-align: center;">______________________________</p>
            <p style="text-align: center;">{{ $usuario->name }} {{ $usuario->apellido }}</p>
            <p style="text-align: center;">C&eacute;dula Nacional de Identidad N&deg; {{ $rutUsuario }}</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </main>
    </body>
</html>