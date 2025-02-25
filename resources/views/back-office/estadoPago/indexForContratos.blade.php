@extends('back-office.layouts.app')
@section('css')
<style>
    .expandChildTable:before {
        content: "+";
        display: block;
        cursor: pointer;
    }
    .expandChildTable.selected:before {
        content: "-";
    }
    .childTableRow {
        display: none;
    }
    .childTableRow table {
        border: 2px solid #555;
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
                            <h4 class="mb-0 font-size-18">Estados de pago {{ $propiedad->direccion }} {{ $propiedad->numero }}
                                @if($propiedad->block), Departamento {{ $propiedad->block }} @endif - Contrato: {{ $contrato->nombreContrato }}
                            </h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target=".agregar-estado-pago" title="agregar estado de pago"><i class="bx bx-money"></i>Agregar Estado de Pago</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Fecha Vencimiento</th>
                                                <th scope="col">Valor a Pagar</th>
                                                <th scope="col">Saldo</th>
                                                <th scope="col">Cuota</th>
                                                <th scope="col">Rut Arrendatario</th>
                                                <th scope="col">Contrato</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($estadosPagos as $estadoPago )
                                            <tr>
                                                <td>
                                                    <div style="display:flex">
                                                        <span class="expandChildTable"></span>
                                                        @if($estadoPago->idEstado == 47)
                                                        <a href="#" class="badge badge-soft-info font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 48)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 49)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 50)
                                                        <a href="#" class="badge badge-soft-warning font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 70)
                                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 83)
                                                        <a href="#" class="badge badge-soft-dark font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 84)
                                                        <a href="#" class="badge badge-soft-secondary font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @elseif($estadoPago->idEstado == 89)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">{{ $estadoPago->nombreEstado }}</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ strftime("%d de %B de %Y", strtotime($estadoPago->fechaVencimiento)) }}</td>
                                                <td>${{ number_format($estadoPago->subtotal, 0, '', '.')}}</td>
                                                <td>${{ number_format($estadoPago->saldo, 0, '', '.')}}</td>
                                                <td>{{ $estadoPago->numeroCuota }}</td>
                                                <td>{{ $estadoPago->rutArrendatario }}</td>
                                                <td>{{ $estadoPago->nombreArrendatario }} {{ $estadoPago->apellidoArrendatario }}</td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item">
                                                            <a href="#" data-toggle="modal" data-target=".modalPago{{ $estadoPago->idEstadoPago}}" title="Pagar"><i class="bx bx-money"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="/estados-pagos/pagos/{{ $estadoPago->idEstadoPago }}" data-toggle="tooltip" data-placement="top" title="Pagos"><i class="bx bxs-dollar-circle"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="/estados-pagos/edit/{{ $estadoPago->idEstadoPago }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <form id="form1" action="{{ url('/estados-pagos/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $estadoPago->idContrato }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/planes/edit/{{ $estadoPago->idEstadoPago }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr class="childTableRow">
                                                <td colspan="8">
                                                    <h5>Detalle del pago</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Arriendo Mensual</th>
                                                            <th>Garantia</th>
                                                            <th>Comision</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>${{ number_format($estadoPago->arriendoMensual, 0, '', '.')}}</td>
                                                                <td>${{ number_format($estadoPago->garantia, 0, '', '.')}}</td>
                                                                <td>${{ number_format($estadoPago->comision, 0, '', '.')}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <h5>Cargos y descuentos</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">Nombre</th>
                                                            <th scope="col">Monto</th>
                                                            <th scope="col">Tipo</th>
                                                            <th scope="col">Corresponde A</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($estadoPago->cargos as $cargo)
                                                            <tr>
                                                                <td>{{ $cargo->nombreCargo }}</td>
                                                                <td>${{ number_format($cargo->montoCargo, 0, '', '.')}}</td>
                                                                <td><a href="#" class="badge badge-soft-primary font-size-11 m-1">Cargo</a></td>
                                                                <td>
                                                                    @if($cargo->correspondeA == 1)
                                                                    <a href="#" class="badge badge-soft-secondary font-size-11 m-1">Propietario</a>
                                                                    @else
                                                                    <a href="#" class="badge badge-pill badge-dark font-size-11 m-1">Arrendatario</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @foreach($estadoPago->descuentos as $descuento)
                                                            <tr>
                                                                <td>{{ $descuento->nombreDescuento }}</td>
                                                                <td>${{ number_format($descuento->montoDescuento, 0, '', '.')}}</td>
                                                                <td><a href="#" class="badge badge-soft-danger font-size-11 m-1">Descuento</a></td>
                                                                <td>
                                                                    @if($descuento->correspondeADescuentos == 1)
                                                                    <a href="#" class="badge badge-soft-secondary font-size-11 m-1">Propietario</a>
                                                                    @else
                                                                    <a href="#" class="badge badge-pill badge-dark font-size-11 m-1">Arrendatario</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>            
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                <!-- paginatessss -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  Modal Caracteristicas -->
                @if($estadosPagos)
                @foreach($estadosPagos as $estadoPagoModal)
                <div class="modal fade bs-example-modal-md modalPago{{ $estadoPagoModal->idEstadoPago}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Pago rapido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12" style="padding:20px !important">
                                        <form method="POST" action="{{ route('pagoManual') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Fecha de vencimiento</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="fechaVencimiento" name="fechaVencimiento" type="date" value="{{ $estadoPagoModal->fechaVencimiento}}" class="form-control" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Arriendo Mensual</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="arriendoMensual" name="arriendoMensual" type="text" value="{{ $estadoPagoModal->arriendoMensual}}" class="form-control" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Garantia</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="garantia" name="garantia" type="text" value="{{ $estadoPagoModal->garantia}}" class="form-control" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Comision</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="comision" name="comision" type="text" value="{{ $estadoPagoModal->comision}}" class="form-control" readonly >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        @if($estadoPagoModal->saldo > 0)
                                                        <label for="nombre">Saldo</label>
                                                        @else
                                                        <label for="nombre">Total a Pagar</label>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        @if($estadoPagoModal->saldo > 0)
                                                        <input id="subtotal" name="subtotal" type="text" value="{{ $estadoPagoModal->saldo }}" class="form-control" readonly >
                                                        @else
                                                        <input id="subtotal" name="subtotal" type="text" value="{{ $estadoPagoModal->subtotal}}" class="form-control" readonly >
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Metodo de pago</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select name="idMetodoPago" id="idMetodoPago" class="form-control" required>
                                                            <option value="">Seleccione metodo de pago</option>
                                                            @foreach($metodosPagos as $metodoPago)
                                                                <option value="{{ $metodoPago->idMetodosPagos }}">{{ $metodoPago->nombreMetodoPago }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Numero de Transaccion</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="numeroTransaccion" name="numeroTransaccion" type="text" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Comentario</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <textarea name="comentarios" class="form-control" id="comentarios" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Documento</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="documento" name="documento" type="file" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6" style="display: none">
                                                    <input type="text" name="idEstadoPago" id="idEstadoPago" class="form-control" value="{{ Crypt::encrypt($estadoPagoModal->idEstadoPago) }}" >
                                                </div>
                                                <div class="col-sm-8">
                                                    <p style="margin-bottom: 5px">&nbsp;</p>
                                                </div>
                                                <div class="col-sm-4" style="text-align: right">
                                                    <p style="margin-bottom: 5px">&nbsp;</p>
                                                    <button class="btn btn-success"><i class="bx bx-money"></i> Pagar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <!--  Modal AGREGAR ESTADO DE PAGO -->
                <div class="modal fade bs-example-modal-md agregar-estado-pago" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Agregar Estado de Pago</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12" style="padding:20px !important">
                                        <form method="POST" action="{{ route('crearEstadoPago') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Fecha de vencimiento</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="fechaVencimiento" name="fechaVencimiento" type="date" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Arriendo Mensual</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="arriendoMensual" name="arriendoMensual" type="text" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Garantia</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="garantia" name="garantia" type="text" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Comision</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input id="comision" name="comision" type="text" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="nombre">Nota</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <textarea name="notas" class="form-control" id="notas" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="text" style="display: none" name="idContrato" id="idContrato" class="form-control" value="{{ $contrato->idContratoArriendo }}" >
                                                </div>
                                                <div class="col-sm-4" style="text-align: right">
                                                    <p style="margin-bottom: 5px">&nbsp;</p>
                                                    <button class="btn btn-success"><i class="bx bx-plus"></i> Crear</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
@endsection
@section('script')
<script>
    $(function() {
        $('.expandChildTable').on('click', function() {
            $(this).toggleClass('selected').closest('tr').next().toggle();
        })
    });
</script>
@endsection        