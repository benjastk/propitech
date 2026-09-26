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
            p
            {
                padding: 0px !important;
                margin: 0px !important;
            }
            .firma-bloque {
                width: 100%;
                margin-top: 10px;
            }
            .firma-bloque td {
                width: 50%;
                vertical-align: bottom;
                padding: 0px;
            }
        </style>
    </head>
    <body style="text-align: justify;">
        <footer>
        </footer>
        <main>
        @php
        $rutPropietario1 = explode('-', $mandato->rutPropietario);
        $rutPropietarioFormateado = number_format($rutPropietario1[0], 0, '', '.') . '-' . $rutPropietario1[1];
        @endphp
        <center><p><strong><u>PODER SIMPLE</u></strong></p></center>
        <p>&nbsp;</p>
        <p>Yo, <strong>{{ $mandato->nombrePropietario }} {{ $mandato->apellidoPropietario }}</strong>, c&eacute;dula de identidad
        N.&ordm; <strong>{{ $rutPropietarioFormateado }}</strong>, domiciliado(a) en <strong>{{ $mandato->direccionPropietario }}</strong>,
        en mi calidad de copropietario(a) de la unidad N.&ordm; <strong>{{ $mandato->departamentoPropiedad }}</strong>, ubicada en
        <strong>{{ $mandato->direccionPropiedad }}</strong>, por el presente instrumento confiero poder simple a don
        <strong>Gustavo Cisternas</strong>, c&eacute;dula de identidad <strong>11.857.826-0</strong>, Representante legal de
        <strong>Inversiones y Servicios Profesionales B&amp;C</strong>, c&eacute;dula de identidad N.&ordm; <strong>77.135.302-9</strong>,
        para que me represente en la Asamblea de Copropietarios que se celebrar&aacute; el d&iacute;a <strong>{{ $asamblea['fechaAsamblea'] }}</strong>,
        a las <strong>{{ $asamblea['horaAsamblea'] }}</strong>, as&iacute; como en su eventual segunda citaci&oacute;n.</p>
        <p>&nbsp;</p>
        <p>El apoderado queda facultado para asistir, intervenir, emitir voz y voto en mi nombre, aprobar o rechazar las materias
        sometidas a consideraci&oacute;n, suscribir el acta y efectuar las dem&aacute;s actuaciones necesarias para el adecuado
        ejercicio de esta representaci&oacute;n, dentro de los l&iacute;mites establecidos por la ley y el reglamento de
        copropiedad.</p>
        <p>&nbsp;</p>
        <p>Este poder se otorga exclusivamente para la asamblea indicada y quedar&aacute; sin efecto una vez concluida.</p>
        <p>&nbsp;</p>
        @php(setlocale(LC_TIME, 'es_CL.UTF-8','es_CL.utf8','es_ES.UTF-8','es_ES'))
        <p>En Santiago, a {{ strftime("%d de %B de %Y", strtotime($fechaHoy)) }}.</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table class="firma-bloque">
            <tr>
                <td>
                    @if($mandato->firmaPoderSimpleAsamblea)
                    <center><img src="{{ $mandato->firmaPoderSimpleAsamblea }}" style="max-width: 220px; max-height: 90px;"></center>
                    @else
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    @endif
                    <p>________________________________</p>
                    <p>Firma del/de la otorgante</p>
                    <p>Nombre: {{ $mandato->nombrePropietario }} {{ $mandato->apellidoPropietario }}</p>
                    <p>RUT: {{ $rutPropietarioFormateado }}</p>
                </td>
                <td>
                    @if($firmaApoderado)
                    <center><img src="{{ $firmaApoderado }}" style="max-width: 220px; max-height: 90px;"></center>
                    @else
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    @endif
                    <p>________________________________</p>
                    <p>Firma del apoderado</p>
                    <p>Nombre: Gustavo Cisternas</p>
                    <p>RUT: 11.857.826-0</p>
                </td>
            </tr>
        </table>
        </main>
    </body>
</html>
