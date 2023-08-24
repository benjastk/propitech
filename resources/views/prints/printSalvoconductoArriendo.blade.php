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
        <center><p><strong><u>PODER SIMPLE</u></strong></p></center>
        <p>&nbsp;</p>
        <center><p><strong><u>SALVOCONDUCTO ARRENDATARIO</u></strong></p></center>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        @php
        $rutUsuario1 = explode( "-", $salvoconducto->rutPropietario );
        $rutUsuario = number_format( $rutUsuario1[0], 0, "", ".") . '-' . $rutUsuario1[1];

        $rutUsuario2 = explode( "-", $salvoconducto->rutArrendatario );
        $rutUsuarios = number_format( $rutUsuario2[0], 0, "", ".") . '-' . $rutUsuario2[1];
        @endphp
        @php(setlocale(LC_TIME, 'spanish'))
        <p>Santiago, <strong>{{ strftime("%d de %B de %Y", strtotime($fechaHoy)) }}</strong>.</p>
        <p>&nbsp;</p>
        <p>Yo, <strong>{{ $salvoconducto->nombrePropietario }} {{ $salvoconducto->apellidoPropietario }}</strong>, c&eacute;dula nacional de 
        identidad n&uacute;mero RUT <strong>{{ $rutUsuario }}</strong>, propietario/a del inmueble 
        ubicado en <strong>{{ $salvoconducto->direccionPropiedad }} @if($salvoconducto->block), Dpto. {{ $salvoconducto->block }}@endif</strong>, 
        comuna <strong>{{ $salvoconducto->nombreComuna}}</strong>, región <strong>{{ $salvoconducto->nombreRegion }}</strong>, 
        pa&iacute;s Chile.</p>
        <p>&nbsp;</p>
        <p>Declaro que el arrendatario u ocupante don/do&ntilde;a <strong>{{ $salvoconducto->nombreArrendatario }} {{ $salvoconducto->apellidoArrendatario }}</strong>, 
        c&eacute;dula nacional de identidad n&uacute;mero RUT <strong>{{ $rutUsuarios }}</strong>, se encuentra al 
        d&iacute;a en todos los pagos involucrados a este arrendamiento, incluyendo la renta correspondiente al &uacute;ltimo mes y los 
        servicios con que cuenta el inmueble.</p>
        <p>&nbsp;</p>
        <p>Por lo tanto, no hay impedimento legal, judicial ni contractual alguno de mi parte para que traslade sus bienes muebles del domicilio 
        reci&eacute;n mencionado.</p>
        <p>Emito la presente declaraci&oacute;n en cumplimiento con la Ley 20.227 a fin de que se obtenga la correspondiente declaraci&oacute;n 
        jurada.</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <center><p>_______________________________________</p></center>
        <p>&nbsp;</p>
        <center><p><strong>{{ $salvoconducto->nombrePropietario }} {{ $salvoconducto->apellidoPropietario }}</strong></p></center>
        <p>&nbsp;</p>
        <center><p><strong>{{ $rutUsuario }}</strong></p> </center>
        </main>
    </body>
</html>