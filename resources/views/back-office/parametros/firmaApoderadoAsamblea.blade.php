@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Firma de Apoderado - Asamblea</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/parametros">Parametros Generales</a></li>
                                    <li class="breadcrumb-item active">Firma de Apoderado</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <p>Esta firma se usa autom&aacute;ticamente en el bloque "Firma del apoderado" de todos los
                                poderes simples de asamblea (Gustavo Cisternas), tanto en los PDF descargados desde el
                                back-office como en los firmados por los propietarios.</p>

                                @if($parametroFirma->textoValorParametro)
                                <p><strong>Firma actual:</strong></p>
                                <img src="{{ $parametroFirma->textoValorParametro }}" style="max-width: 260px; max-height: 100px; border: 1px solid #e2e2e2; border-radius: 6px; padding: 8px;">
                                <p>&nbsp;</p>
                                @endif

                                <p><strong>{{ $parametroFirma->textoValorParametro ? 'Reemplazar firma:' : 'Registrar firma:' }}</strong></p>
                                <canvas id="firmaCanvas" style="border: 2px dashed #b0b3b8; border-radius: 6px; width: 100%; max-width: 500px; height: 200px; touch-action: none; background: #fff;"></canvas>
                                <p id="errorFirma" class="text-danger" style="display:none;">Debe firmar antes de guardar.</p>

                                <form id="formFirma" action="{{ url('/parametros/firma-apoderado-asamblea') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="firma" id="firmaInput">
                                    <div style="margin-top: 12px;">
                                        <button type="button" class="btn btn-secondary" id="btnLimpiar">Limpiar</button>
                                        <button type="submit" class="btn btn-success">Guardar Firma</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Propitech.
                    </div>
                    <div class="col-sm-6">
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('script')
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
@endsection
