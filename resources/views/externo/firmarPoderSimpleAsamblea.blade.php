<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Firma de Poder Simple - Asamblea</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 16px;
            color: #222;
        }
        .card {
            max-width: 680px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
            padding: 24px;
        }
        h1 {
            font-size: 20px;
            text-align: center;
            margin-top: 0;
        }
        h2 {
            font-size: 15px;
            text-align: center;
            margin-top: 0;
            color: #555;
        }
        .documento {
            text-align: justify;
            font-size: 14px;
            line-height: 1.5;
            background: #fafafa;
            border: 1px solid #e2e2e2;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }
        .documento strong { color: #111; }
        canvas {
            border: 2px dashed #b0b3b8;
            border-radius: 6px;
            width: 100%;
            max-width: 100%;
            height: 200px;
            touch-action: none;
            background: #fff;
        }
        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }
        button {
            flex: 1;
            padding: 12px;
            font-size: 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-limpiar {
            background: #eceeef;
            color: #333;
        }
        .btn-firmar {
            background: #34c38f;
            color: #fff;
            font-weight: bold;
        }
        .btn-descargar {
            display: inline-block;
            margin-top: 16px;
            background: #556ee6;
            color: #fff;
            text-decoration: none;
            padding: 12px;
            width: 100%;
            text-align: center;
            border-radius: 6px;
            font-weight: bold;
        }
        .aviso-firmado {
            text-align: center;
            background: #e8f8f2;
            border: 1px solid #34c38f;
            color: #1e7a5c;
            border-radius: 6px;
            padding: 16px;
            margin-top: 16px;
        }
        .error {
            color: #d9534f;
            font-size: 13px;
            text-align: center;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Poder Simple</h1>
        <h2>Asistencia a Asamblea de Copropietarios</h2>

        @php
        $rutPropietario1 = explode('-', $mandato->rutPropietario);
        $rutPropietarioFormateado = number_format($rutPropietario1[0], 0, '', '.') . '-' . $rutPropietario1[1];
        @endphp
        <div class="documento">
            <p>Yo, <strong>{{ $mandato->nombrePropietario }} {{ $mandato->apellidoPropietario }}</strong>, c&eacute;dula de
            identidad N.&ordm; <strong>{{ $rutPropietarioFormateado }}</strong>, domiciliado(a) en
            <strong>{{ $mandato->direccionPropietario }}</strong>, en mi calidad de copropietario(a) de la unidad N.&ordm;
            <strong>{{ $mandato->departamentoPropiedad }}</strong>, ubicada en <strong>{{ $mandato->direccionPropiedad }}</strong>,
            por el presente instrumento confiero poder simple a don <strong>Gustavo Cisternas</strong>, c&eacute;dula de
            identidad <strong>11.857.826-0</strong>, Representante legal de <strong>Inversiones y Servicios Profesionales B&amp;C</strong>,
            c&eacute;dula de identidad N.&ordm; <strong>77.135.302-9</strong>, para que me represente en la Asamblea de
            Copropietarios que se celebrar&aacute; el d&iacute;a <strong>{{ $asamblea['fechaAsamblea'] }}</strong>, a las
            <strong>{{ $asamblea['horaAsamblea'] }}</strong>, as&iacute; como en su eventual segunda citaci&oacute;n.</p>
            <p>&nbsp;</p>
            <p>El apoderado queda facultado para asistir, intervenir, emitir voz y voto en mi nombre, aprobar o rechazar las
            materias sometidas a consideraci&oacute;n, suscribir el acta y efectuar las dem&aacute;s actuaciones necesarias
            para el adecuado ejercicio de esta representaci&oacute;n, dentro de los l&iacute;mites establecidos por la ley y
            el reglamento de copropiedad.</p>
            <p>&nbsp;</p>
            <p>Este poder se otorga exclusivamente para la asamblea indicada y quedar&aacute; sin efecto una vez concluida.</p>
        </div>

        @if($mandato->fechaFirmaPoderSimpleAsamblea)
            <div class="aviso-firmado">
                Este poder simple ya fue firmado el
                {{ \Carbon\Carbon::parse($mandato->fechaFirmaPoderSimpleAsamblea)->format('d-m-Y') }} a las
                {{ \Carbon\Carbon::parse($mandato->fechaFirmaPoderSimpleAsamblea)->format('H:i') }} hrs.
            </div>
            <a class="btn-descargar" href="{{ url('/firma-poder-simple/'.$mandato->tokenMandato.'/descargar') }}">Descargar PDF firmado</a>
        @else
            <p style="font-size: 14px; margin-bottom: 4px;"><strong>Firme dentro del recuadro:</strong></p>
            <canvas id="firmaCanvas"></canvas>
            <p id="errorFirma" class="error" style="display:none;">Debe firmar antes de continuar.</p>
            <form id="formFirma" action="{{ url('/firma-poder-simple/'.$mandato->tokenMandato) }}" method="POST">
                @csrf
                <input type="hidden" name="firma" id="firmaInput">
                <div class="acciones">
                    <button type="button" class="btn-limpiar" id="btnLimpiar">Limpiar</button>
                    <button type="submit" class="btn-firmar" id="btnFirmar">Firmar y confirmar</button>
                </div>
            </form>
        @endif
    </div>

    @if(!$mandato->fechaFirmaPoderSimpleAsamblea)
    <script>
        (function () {
            var canvas = document.getElementById('firmaCanvas');
            var ctx = canvas.getContext('2d');
            var dibujando = false;
            var tieneTrazo = false;

            function ajustarTamano() {
                var ratio = window.devicePixelRatio || 1;
                var rect = canvas.getBoundingClientRect();
                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                ctx.scale(ratio, ratio);
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#111';
            }
            ajustarTamano();

            function posicion(evento) {
                var rect = canvas.getBoundingClientRect();
                if (evento.touches && evento.touches.length) {
                    return { x: evento.touches[0].clientX - rect.left, y: evento.touches[0].clientY - rect.top };
                }
                return { x: evento.clientX - rect.left, y: evento.clientY - rect.top };
            }

            function iniciar(evento) {
                dibujando = true;
                tieneTrazo = true;
                var p = posicion(evento);
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
                evento.preventDefault();
            }
            function mover(evento) {
                if (!dibujando) return;
                var p = posicion(evento);
                ctx.lineTo(p.x, p.y);
                ctx.stroke();
                evento.preventDefault();
            }
            function terminar() {
                dibujando = false;
            }

            canvas.addEventListener('mousedown', iniciar);
            canvas.addEventListener('mousemove', mover);
            window.addEventListener('mouseup', terminar);
            canvas.addEventListener('touchstart', iniciar, { passive: false });
            canvas.addEventListener('touchmove', mover, { passive: false });
            canvas.addEventListener('touchend', terminar);

            document.getElementById('btnLimpiar').addEventListener('click', function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                tieneTrazo = false;
            });

            document.getElementById('formFirma').addEventListener('submit', function (evento) {
                if (!tieneTrazo) {
                    evento.preventDefault();
                    document.getElementById('errorFirma').style.display = 'block';
                    return;
                }
                document.getElementById('errorFirma').style.display = 'none';
                document.getElementById('firmaInput').value = canvas.toDataURL('image/png');
            });
        })();
    </script>
    @endif
</body>
</html>
