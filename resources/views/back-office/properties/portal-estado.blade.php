@extends('back-office.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ url('css/dataTables.bootstrap.min.css') }}">
<style>
    .dataTables_length { float: left; }
    .pagination { float: right; }
    .paginate_button {
        border: 1px solid black;
        padding: 6px;
        border-radius: 5px;
        background-color: #2a3042;
        color: white !important;
        font-weight: 500;
    }
    .resumen-pi .card { margin-bottom: 12px; }
    .resumen-pi h3 { margin: 0; }
</style>
@endsection
@section('content')
@php
    $etiquetas = [
        'vencida'        => ['Vencida', 'danger', 'Cerrada en el portal sin que propitech la desactivara'],
        'por_vencer'     => ['Vence en ≤ 7 días', 'warning', 'Activa, pero su fecha de término está cerca'],
        'pausada'        => ['Pausada / revisión', 'secondary', 'paused, under_review u otro estado no activo'],
        'no_encontrada'  => ['No existe en PI', 'dark', 'El item guardado en propitech no responde en el portal (borrado o ID inválido)'],
        'huerfana'       => ['Sin propiedad', 'info', 'Item del vendedor en el portal que ninguna propiedad de propitech referencia'],
        'cerrada_manual' => ['Desactivada por nosotros', 'light', 'Cerrada con el botón Desactivar de propitech'],
        'activa'         => ['Activa', 'success', 'Publicada y vigente'],
    ];
@endphp
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Estado de publicaciones en Portal Inmobiliario</h4>
                            <div class="page-title-right">
                                <small class="text-muted">Consultado {{ now()->format('d-m-Y H:i') }} · solo lectura</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row resumen-pi">
                    @foreach($etiquetas as $clave => $et)
                    <div class="col-6 col-md-3 col-xl">
                        <div class="card">
                            <div class="card-body p-3" title="{{ $et[2] }}">
                                <span class="badge badge-{{ $et[1] }}">{{ $et[0] }}</span>
                                <h3 class="mt-2">{{ $resumen[$clave] ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-relist" action="{{ url('/portalinmobiliario/relist-lote') }}" method="post">
                                    {{ csrf_field() }}
                                    <div id="ids-relist"></div>
                                    @if(($resumen['vencida'] ?? 0) > 0)
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-danger" id="btn-relist">
                                            <i class="bx bx-refresh"></i> Republicar seleccionadas (<span id="cnt-relist">0</span>)
                                        </button>
                                        <small class="text-muted ml-2">Solo se republica lo que en el portal siga cerrado. Cada una queda con un item ID nuevo.</small>
                                    </div>
                                    @endif
                                </form>
                                <div class="table-responsive">
                                    <table id="tabla-pi" class="table table-centered table-borderless">
                                        <thead>
                                            <tr>
                                                <th>
                                                    @if(($resumen['vencida'] ?? 0) > 0)
                                                    <input type="checkbox" id="chk-todas" title="Seleccionar todas las vencidas">
                                                    @endif
                                                </th>
                                                <th>Categoría</th>
                                                <th>ID</th>
                                                <th>Propiedad</th>
                                                <th>Item PI</th>
                                                <th>Status / sub_status</th>
                                                <th>Término (stop_time)</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($filas as $fila)
                                            @php $et = $etiquetas[$fila->categoria] ?? [$fila->categoria, 'dark', '']; @endphp
                                            <tr>
                                                <td>
                                                    @if($fila->categoria == 'vencida' && $fila->propiedad)
                                                    <input type="checkbox" class="chk-relist" value="{{ $fila->propiedad->id }}">
                                                    @endif
                                                </td>
                                                <td data-order="{{ array_search($fila->categoria, array_keys($etiquetas)) }}">
                                                    <span class="badge badge-{{ $et[1] }}" title="{{ $et[2] }}">{{ $et[0] }}</span>
                                                </td>
                                                <td>{{ $fila->propiedad->id ?? '—' }}</td>
                                                <td>
                                                    @if($fila->propiedad)
                                                        <strong>{{ $fila->propiedad->nombrePropiedad }}</strong><br>
                                                        <small class="text-muted">{{ $fila->propiedad->direccion }} {{ $fila->propiedad->numero }}, {{ $fila->propiedad->nombreComuna }}</small><br>
                                                        <span class="badge badge-soft-dark">{{ $fila->propiedad->nombreEstado }}</span>
                                                    @else
                                                        <em>{{ $fila->item['title'] ?? 'Sin propiedad asociada' }}</em>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php $link = $fila->item['permalink'] ?? ($fila->propiedad->urlPortalInmobiliario ?? null); @endphp
                                                    @if($link)
                                                        <a href="{{ $link }}" target="_blank" rel="noopener">{{ $fila->itemId }}</a>
                                                    @else
                                                        {{ $fila->itemId }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $fila->status ?? '—' }}
                                                    @if($fila->subStatus)<br><small class="text-muted">{{ $fila->subStatus }}</small>@endif
                                                </td>
                                                <td data-order="{{ $fila->stopTime ? $fila->stopTime->timestamp : 0 }}">
                                                    @if($fila->stopTime)
                                                        {{ $fila->stopTime->format('d-m-Y') }}<br>
                                                        <small class="text-muted">{{ $fila->stopTime->diffForHumans() }}</small>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($fila->propiedad)
                                                        <a href="/properties/edit/{{ $fila->propiedad->id }}" title="Editar propiedad"><i class="bx bxs-edit-alt font-size-18"></i></a>
                                                        @if($fila->categoria == 'vencida')
                                                            <a href="/portalinmobiliario/relist/{{ $fila->propiedad->id }}" class="btn btn-sm btn-outline-danger ml-1"
                                                               onclick="return confirm('¿Republicar la propiedad {{ $fila->propiedad->id }} en Portal Inmobiliario?')">Republicar</a>
                                                        @elseif($fila->categoria == 'no_encontrada')
                                                            <a href="/portalinmobiliario/add/{{ $fila->propiedad->id }}" class="btn btn-sm btn-outline-primary ml-1"
                                                               onclick="return confirm('El item ya no existe en el portal. ¿Crear una publicación nueva para la propiedad {{ $fila->propiedad->id }}?')">Publicar de nuevo</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Propitech.
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('script')
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var tabla = $('#tabla-pi').DataTable({
            "order": [[ 1, "asc" ], [ 6, "asc" ]],
            "columnDefs": [{ "orderable": false, "targets": [0, 7] }],
            "pageLength": 50
        });

        // Usa la API de DataTables para incluir también filas de otras páginas
        function seleccionadas() {
            return tabla.$('input.chk-relist:checked');
        }
        function actualizarContador() {
            $('#cnt-relist').text(seleccionadas().length);
        }
        $('#chk-todas').on('change', function () {
            tabla.$('input.chk-relist').prop('checked', this.checked);
            actualizarContador();
        });
        $('#tabla-pi').on('change', 'input.chk-relist', actualizarContador);

        $('#form-relist').on('submit', function (e) {
            var marcadas = seleccionadas();
            if (marcadas.length === 0) {
                alert('Selecciona al menos una propiedad vencida.');
                e.preventDefault();
                return;
            }
            if (!confirm('¿Republicar ' + marcadas.length + ' propiedades en Portal Inmobiliario? Puede tardar un par de minutos.')) {
                e.preventDefault();
                return;
            }
            var contenedor = $('#ids-relist').empty();
            marcadas.each(function () {
                contenedor.append($('<input>', { type: 'hidden', name: 'ids[]', value: this.value }));
            });
            $('#btn-relist').prop('disabled', true).html('<i class="bx bx-loader bx-spin"></i> Republicando…');
        });
    });
</script>
@endsection
