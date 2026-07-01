@extends('back-office.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ url('css/dataTables.bootstrap.min.css') }}">
<style>
    .dataTables_length
    {
        float: left;
    }
    .paginate_button.previous
    {
        border: 1px solid black;
        padding: 6px;
        border-radius: 5px;
        background-color: #2a3042;
        color: white !important;
        font-weight: 500;
    }
    .paginate_button.next
    {
        border: 1px solid black;
        padding: 6px;
        border-radius: 5px;
        background-color: #2a3042;
        color: white !important;
        font-weight: 500;
    }
    .paginate_button
    {
        border: 1px solid black;
        padding: 6px;
        border-radius: 5px;
        background-color: #2a3042;
        color: white !important;
        font-weight: 500;
    }
    .pagination
    {
        float: right;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Mantención de propiedades</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabla-ingresos" class="table table-sm table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width:40%">Propiedad</th>
                                <th>Estado</th>
                                <th style="width:15%">Mantención TERMO</th>
                                <th style="width:15%">Mantención ENCIMERA</th>
                                <th style="width:15%">Mantención CALEFONT</th>
                                <th style="width:15%; text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propiedades as $propiedad)
                            <tr>
                                <td>
                                    {{ $propiedad->id }}
                                </td>
                                <td>
                                    <strong>
                                        {{ $propiedad->direccion }}
                                        {{ $propiedad->numero }},
                                        Departamento: {{ $propiedad->block }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $propiedad->nombreComuna }},
                                        {{ $propiedad->nombreRegion }}
                                    </small>
                                </td>
                                <td>
                                    @if($propiedad->idEstado == 42)
                                    <span class="badge badge-success">{{ $propiedad->nombreEstado }}</span><br>
                                    @elseif($propiedad->idEstado == 43)
                                    <span class="badge badge-warning">{{ $propiedad->nombreEstado }}</span><br>
                                    @elseif($propiedad->idEstado == 44)
                                    <span class="badge badge-success">{{ $propiedad->nombreEstado }}</span><br>
                                    @elseif($propiedad->idEstado == 45)
                                    <span class="badge badge-info">{{ $propiedad->nombreEstado }}</span><br>
                                    @elseif($propiedad->idEstado == 46)
                                    <span class="badge badge-danger">{{ $propiedad->nombreEstado }}</span><br>
                                    @else
                                    <span class="badge badge-dark">{{ $propiedad->nombreEstado }}</span><br>
                                    @endif
                                </td>
                                <td>
                                    <input
                                        type="date"
                                        class="form-control form-control-sm fecha-mantencion"
                                        name="fecha1"
                                        value="{{ $propiedad->mantencion_termo ?? '' }}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input
                                        type="date"
                                        class="form-control form-control-sm fecha-mantencion"
                                        name="fecha2"
                                        value="{{ $propiedad->mantencion_encimera ?? '' }}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input
                                        type="date"
                                        class="form-control form-control-sm fecha-mantencion"
                                        name="fecha3"
                                        value="{{ $propiedad->mantencion_calefont ?? '' }}"
                                        disabled
                                    >
                                </td>
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-sm btn-editar"
                                        data-id="{{ $propiedad->id }}"
                                    >
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm btn-guardar"
                                        data-id="{{ $propiedad->id }}"
                                        disabled
                                    >
                                        <i class="bx bx-save"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <p>TOTAL PROPIEDADES {{ $contador }}</p>
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Propitech.
                    </div>
                    <div class="col-sm-6">
                        <!--<div class="text-sm-right d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
@endsection
@section('script')
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	$('#tabla-ingresos').DataTable({
        paging: false,
        info: false,
        ordering: false,
        responsive: true,
        language: {
            search: "Buscar propiedad:",
            zeroRecords: "No se encontraron propiedades",
            infoEmpty: "",
            infoFiltered: ""
        }
    });

    $(document).on('click', '.btn-editar', function () {

        let fila = $(this).closest('tr');

        fila.find('.fecha-mantencion').prop('disabled', false);
        fila.find('.btn-guardar').prop('disabled', false);

        $(this).prop('disabled', true);
    });

    $(document).on('click', '.btn-guardar', function () {
        let fila = $(this).closest('tr');
        let id = $(this).data('id');
        $.ajax({
            url: '/mantenciones/guardar-mantencion',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                property_id: id,
                fecha1: fila.find('[name="fecha1"]').val(),
                fecha2: fila.find('[name="fecha2"]').val(),
                fecha3: fila.find('[name="fecha3"]').val()
            },
            success: function(response) {
                fila.find('.fecha-mantencion').prop('disabled', true);
                fila.find('.btn-guardar').prop('disabled', true);
                fila.find('.btn-editar').prop('disabled', false);
                toastr.success('Fechas guardadas correctamente');
            },
            error: function() {
                toastr.error('Error al guardar');
            }
        });
    });
</script>
@endsection
        