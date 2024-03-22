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

    /* Estilos para motores Webkit y blink (Chrome, Safari, Opera... )*/

    .contenedor::-webkit-scrollbar {
        -webkit-appearance: none;
    }

    .contenedor::-webkit-scrollbar:vertical {
        width:10px;
    }

    .contenedor::-webkit-scrollbar-button:increment,.contenedor::-webkit-scrollbar-button {
        display: none;
    } 

    .contenedor::-webkit-scrollbar:horizontal {
        height: 10px;
    }

    .contenedor::-webkit-scrollbar-thumb {
        background-color: #556ee6;
        border-radius: 20px;
        border: 2px solid #f1f2f3;
    }

    .contenedor::-webkit-scrollbar-track {
        border-radius: 10px;  
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
                                </a>
                                <a href="/mandatos/export" class="btn btn-success waves-effect waves-light" style="margin-right: 10px">
                                    <i class="far fa-file-excel"></i> Descargar Excel
                                </a>-->
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <form method="GET" action="{{ route('buscarPagosMandatosMes') }}" >
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Mes y año</label>
                                    <select name="filtro" id="filtro" class="form-control" required>
                                        <option value="">Mes/Año</option>
                                        @if($mes && $anio)
                                            @foreach ($filtro as $filtros)
                                            <option value="{{$filtros->month}}/{{$filtros->year}}" {{ ($filtros->month.$filtros->year == $mes.$anio ) ? 'selected' :'' }} >{{$filtros->month}} / {{$filtros->year}}</option>
                                            @endforeach
                                        @else
                                            @foreach ($filtro as $filtros)
                                            <option value="{{$filtros->month}}/{{$filtros->year}}" >{{$filtros->month}} / {{$filtros->year}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Estado</label>
                                    <select name="tipo" class="form-control" required>
                                        @if($tipo)
                                        <option value="2" {{ ($tipo == 2 ) ? 'selected' :'' }} >No validados</option>
                                        <option value="1" {{ ($tipo == 1 ) ? 'selected' :'' }}>Validados/Liquidados</option>
                                        @else
                                        <option value="2">No validados</option>
                                        <option value="1">Validados/Liquidados</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>&nbsp;</label>
                                    <center><button style="width: 100%;" type="submit" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Buscar</button></center>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <form method="POST" action="{{ route('excelEstadosPagosMandatos') }}" >
                        @csrf
                            <input type="hidden" name="anio" value="{{$anio}}">
                            <input type="hidden" name="mes" value="{{$mes}}">
                            <input type="hidden" name="tipo" value="{{$tipo}}">
                            <div class="form-group col-md-12">
                                <center><button style="width: 100%;" type="submit" class="btn btn-block btn-primary btn-sm"><i class="fa fa-file"></i> Descargar planilla</button></center>
                            </div>
                        </form>
                    </div>
                    <!--<div class="col-sm-4">
                        <form method="POST" action="#" >
                        @csrf
                            <input type="hidden" name="anio" value="{{$anio}}">
                            <input type="hidden" name="mes" value="{{$mes}}">
                            <div class="form-group col-md-12">
                            <center><button style="width: 100%;" type="submit" class="btn btn-block btn-primary btn-sm"><i class="fa fa-file"></i> Pagos no realizados Excel</button></center>
                            </div>
                        </form>
                    </div>-->
                    <div class="col-sm-2">
                    <!--
                        <input type="hidden" name="anio" value="{{$anio}}">
                        <input type="hidden" name="mes" value="{{$mes}}">
                        <div class="form-group col-md-12">-->
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <center><button style="width: 100%;" data-toggle="modal" data-target="#validar" class="btn btn-block btn-success btn-sm"><i class="fa fa-check"></i> VALIDAR</button></center>
                    </div>
                    <div class="col-sm-2">
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        @if($mes)
                        <center><a href="{{ url('/comision/'.$mes.'/'.$anio) }}" ><button style="width: 100%;" class="btn btn-block btn-primary btn-sm"><i class="fa fa-link"></i> ACTUALIZAR</button></a></center>
                        @else
                        @php
                            $mes = date('m');
                            $anio = date('Y');
                        @endphp
                        <center><a href="{{ url('/comision/'.$mes.'/'.$anio) }}" ><button style="width: 100%;" class="btn btn-block btn-primary btn-sm"><i class="fa fa-redo-alt"></i> ACTUALIZAR</button></a></center>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive contenedor">
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
                                                <th>Garantia</th>
                                                <th>Comision de Corretaje</th>
                                                <th>Monto Pagado</th>
                                                <th>Comision</th>
                                                <th>Saldos a favor</th>
                                                <!--<th>Seguro de arriendo</th>-->
                                                <!--<th>Deuda</th>-->
                                                <th>Monto A Liquidar Propietario</th>
                                                <th>Estado</th>
                                                <th>Fecha liquidado</th>
                                                <th>Acciones</th>
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
                                            <!--<td>{{ $estadosDePagos->idEstadoPagoMandato}}</td>-->
                                            <td>{{ $estadosDePagos->rutPropietario}}</td>
                                            <td>{{ $estadosDePagos->nombrePropietario}} {{$estadosDePagos->apellidoPropietario}}</td>
                                            <td>{{ $estadosDePagos->rutArrendatario}}</td>
                                            <td>{{ $estadosDePagos->nombreArrendatario}} {{$estadosDePagos->apellidoArrendatario}}</td>
                                            <td>{{ $estadosDePagos->direccion }} {{ $estadosDePagos->numero }} - {{ $estadosDePagos->block}}</td>
                                            <td>${{ number_format($estadosDePagos->montoAPagar, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->cargosAbonos, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->garantia, 0, '', '.')}}</td>
                                            <td>${{ number_format($estadosDePagos->comisionCorretaje, 0, '', '.')}}</td>
                                            <td>@if($estadosDePagos->tieneTraspasoSaldo == 1) <strong style="color: red">*</strong> @endif${{ number_format($estadosDePagos->montoPagado, 0, '', '.')}}</td>
                                            <td>@if($estadosDePagos->montoComision < 0) 0 @else ${{ number_format($estadosDePagos->montoComision, 0, '', '.')}} @endif</td>
                                            <td>${{ number_format($estadosDePagos->saldoArrastre, 0, '', '.')}}</td>
                                            <!--<td>${{ number_format($estadosDePagos->valorSeguroArriendo, 0, '', '.')}}</td>-->
                                            <!--<td>{{ number_format($estadosDePagos->montoDeuda, 0, '', '.')}}</td>-->
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
        @if($estadosPagosMandatarios)
            @foreach ($estadosPagosMandatarios as $estadoPagoModal)    
            <div class="modal fade" id="exampleModalMandatario-{{$estadoPagoModal->idEstadoPagoMandato}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar estado de pago mandato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('editarEstadoPagoMandato') }}" >
                        @csrf
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Monto A Pagar</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="montoAPagar" value="{{$estadoPagoModal->montoAPagar}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Cargos Abonos</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="cargosAbonos" value="{{$estadoPagoModal->cargosAbonos}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Monto pagado</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="montoPagado" value="{{$estadoPagoModal->montoPagado}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Garantia</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="garantia" value="{{$estadoPagoModal->garantia}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Monto Comision</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="montoComision" value="{{$estadoPagoModal->montoComision}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Monto A Liquidar</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="montoALiquidarPropietario" value="{{$estadoPagoModal->montoALiquidarPropietario}}">
                                </div>
                            </div>
                            @if($estadoPagoModal->idEstado == 68)
                            @else
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Fecha Liquidado</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                    <input type="text" class="form-control" name="fechaLiquidado" value="<?php echo date('Y-m-d', strtotime($estadoPagoModal->fechaLiquidado)); ?>">
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label>Estado</label>
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-sm-8">
                                @if( !isset($estadoPagoModal->idEstado))
                                <select name="idEstado" class="form-control">
                                    @foreach ($estados as $estado)
                                    <option value="{{ $estado->idEstado }}">{{ $estado->nombreEstado}}</option>
                                    @endforeach
                                </select>
                                @else
                                <select name="idEstado" class="form-control">
                                    @foreach ($estados as $estado)
                                    <option value="{{ $estado->idEstado }}" {{ ($estadoPagoModal->idEstado == $estado->idEstado ) ? 'selected' :'' }}>{{ $estado->nombreEstado}}</option>
                                    @endforeach
                                </select>
                                @endif
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="idEstadoPago" id="idEstadoPago" value="{{ Crypt::encrypt($estadoPagoModal->idEstadoPagoMandato) }}" >
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        @if($estadosPagosMandatarios)
            @foreach ($estadosPagosMandatarios as $estadosPagosMandatariosEliminar)    
            <div class="modal fade" id="exampleModalCenterEliminar-{{$estadosPagosMandatariosEliminar->idEstadoPagoMandato}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Mandato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Esta seguro que desea eliminar el estado de pago?
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{action('MandatoAdministracionController@eliminarPagoMandato', $estadosPagosMandatariosEliminar->idEstadoPagoMandato)}}" >
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
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
        