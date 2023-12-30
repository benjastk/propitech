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
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Liquidacion Inversionista</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>
                                <a href="/contratos/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-user-plus font-size-16 align-middle mr-2"></i> Crear Contrato de arriendo
                                </a>-->
                                <a href="/mandatos/export" class="btn btn-success waves-effect waves-light" style="margin-right: 10px">
                                    <i class="far fa-file-excel"></i> Descargar Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="tabla-ingresos" class="table table-centered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                            <th>ID</th>
                                            <th>Rut Propietario</th>
                                            <th>Propietario</th>
                                            <th>Rut Arrendatario</th>
                                            <th>Arrendatario</th>
                                            <th>Propiedad</th>
                                            <th>Monto A Pagar</th>
                                            <th>Cargos / Descuentos</th>
                                            <th>Monto Pagado</th>
                                            <th>Garantia</th>
                                            <th>Comision de Corretaje</th>
                                            <th>Comision</th>
                                            <th>Saldos a favor</th>
                                            <th>Seguro de arriendo</th>
                                            <th>Deuda</th>
                                            <th>Monto A Liquidar Propietario</th>
                                            <th>Estado</th>
                                            <th>Fecha liquidado</th>
                                            <th>@if($tipo == 2) Acciones @endif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php(setlocale(LC_TIME, 'spanish'))
                                        @if($estadosPagosMandatarios != null)
                                        @foreach ($estadosPagosMandatarios as $estadosDePagos)
                                            <tr>
                                            @if($tipo == 2)
                                            <td>@if($estadosDePagos->nombreEstado == 'NO LIQUIDADO')<input type="checkbox" id="pagos[]" name="pagos[]" class="check" value="{{ $estadosDePagos->idEstadoPagoMandato }}" >
                                            @endif</td>
                                            @endif
                                            <td>{{ $estadosDePagos->idEstadoPagoMandato}}</td>
                                            <td>{{ $estadosDePagos->rutPropietario}}</td>
                                            <td>{{ $estadosDePagos->nombrePropietario}} {{$estadosDePagos->apellidoPropietario}}</td>
                                            <td>{{ $estadosDePagos->rutArrendatario}}</td>
                                            <td>{{ $estadosDePagos->nombreArrendatario}} {{$estadosDePagos->apellidoArrendatario}}</td>
                                            <td>{{ $estadosDePagos->nombrePropiedad }} - {{ $estadosDePagos->block}}</td>
                                            <td>${{ number_format($estadosDePagos->montoAPagar, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->cargosAbonos, 0, '', '.')}}</td>
                                            <td>@if($estadosDePagos->tieneTraspasoSaldo == 1) <strong style="color: red">*</strong> @endif${{ number_format($estadosDePagos->montoPagado, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->garantia, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->comisionCorretaje, 0, '', '.')}}</td>
                                            <td>@if($estadosDePagos->montoComision < 0) 0 @else ${{ number_format($estadosDePagos->montoComision, 0, '', '.')}} @endif</td>
                                            <td>${{ number_format($estadosDePagos->saldoArrastre, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->valorSeguroArriendo, 0, '', '.')}}</td>
                                            <td>{{ number_format($estadosDePagos->montoDeuda, 0, '', '.')}}</td>
                                            <td>{{ number_format($estadosDePagos->montoALiquidarPropietario, 0, '', '.')}}</td>
                                            <td>{{ $estadosDePagos->nombreEstado }}</td>
                                            <td>{{ $estadosDePagos->fechaLiquidado}}</td>
                                            <td>
                                            @if($estadosDePagos->nombreEstado == "NO LIQUIDADO" )
                                            <div class="dropdown" style="text-align: right;">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Seleccione Acción
                                            </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                
                                                <a class="dropdown-item"  data-toggle="modal" data-target="#exampleModalMandatario-{{ $estadosDePagos->idEstadoPagoMandato }}" href="#"><i class="fa fa-edit"></i> Editar</a>
                                                <a class="dropdown-item" href="imprimirComprobantePagoPropietario/{{$estadosDePagos->idEstadoPagoMandato}}"><i class="fa fa-print"></i> Imprimir Comprobante A Inversionista</a>
                                                <!--<a class="dropdown-item" href="descuentos/{{$estadosDePagos->idEstadoPago}}"><i class="fa fa-arrow-down"></i> Descuentos</a>-->
                                                <a class="dropdown-item"  data-toggle="modal" data-target="#exampleModalCenterEliminar-{{ $estadosDePagos->idEstadoPagoMandato }}" href="#"><i class="fa fa-trash"></i> Eliminar</a>
                                                </div>
                                            </div>
                                            @else
                                            <div class="dropdown" style="text-align: right;">
                                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Seleccione Acción
                                            </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="imprimirComprobantePagoPropietario/{{$estadosDePagos->idEstadoPagoMandato}}"><i class="fa fa-print"></i> Imprimir Comprobante A Inversionista</a>
                                                </div>
                                            </div>
                                            @endif
                                            </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        @endif    
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                </div>
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
<script>
	$(document).ready( function () {
		$('#tabla-ingresos').DataTable( {
			"order": [[ 0, "desc" ]]
		});
	} );
</script>
@endsection
        