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
                            <h4 class="mb-0 font-size-18">Pagos {{ $estadoPago->direccionPropiedad }} 
                                @if($estadoPago->block), Departamento {{ $estadoPago->block }} @endif {{ $estadoPago->nombreComunaPropiedad}}
                            </h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
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
                                                <th scope="col">Valor Pagado</th>
                                                <th scope="col">Numero Transaccion</th>
                                                <th scope="col">Comentario</th>
                                                <th scope="col">Metodo de pago</th>
                                                <th scope="col">Creado por</th>
                                                <th scope="col">Fecha de Pago</th>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($pagos as $pago)
                                            <tr>
                                                <td>
                                                    ${{ number_format($pago->montoPago, 0, '', '.')}}
                                                </td>
                                                <td>
                                                    {{ $pago->numeroTransaccion}}
                                                </td>
                                                <td>
                                                    {{ $pago->comentarios }}
                                                </td>
                                                <td>
                                                    {{ $pago->nombreMetodoPago}}
                                                </td>
                                                <td>
                                                    {{ $pago->creadoPor}}
                                                </td>
                                                <td>{{ strftime("%d de %B de %Y a las %H:%M", strtotime( $pago->created_at )) }}</td>
                                                <td style="text-align:center">@if($pago->rutaDocumento) <a target="_blank" href="/documentosPagos/{{ $pago->rutaDocumento }}"><i class="bx bxs-download"></i></a>@else <i title="Sin documento adjunto" style="color: red" class="bx bxs-error"></i> @endif</td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item px-2">
                                                            <form id="form1" action="{{ url('/estados-pagos/pagos/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $pago->idPago }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/planes/edit/{{ $estadoPago->idEstadoPago }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                        </li>
                                                    </ul>
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
                <br>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Pago Manual</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ route('pagoManualIndex') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="nombre">Arriendo Mensual</label>
                                            <input id="arriendoMensual" name="arriendoMensual" type="text" value="{{ $estadoPago->arriendoMensual}}" class="form-control" readonly >
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Garantia</label>
                                            <input id="garantia" name="garantia" type="text" value="{{ $estadoPago->garantia}}" class="form-control" readonly >
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Comision</label>
                                            <input id="comision" name="comision" type="text" value="{{ $estadoPago->comision}}" class="form-control" readonly >
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Total a Pagar</label>
                                            <input id="subtotal" name="subtotal" type="text" value="{{ $estadoPago->subtotal - $estadoPago->totalPagado}}" class="form-control" readonly >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="nombre">Fecha de vencimiento</label>
                                            <input id="fechaVencimiento" name="fechaVencimiento" type="date" value="{{ $estadoPago->fechaVencimiento}}" class="form-control" readonly >
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Metodo de pago</label>
                                            <select name="idMetodoPago" id="idMetodoPago" class="form-control" required>
                                                <option value="">Seleccione metodo de pago</option>
                                                @foreach($metodosPagos as $metodoPago)
                                                    <option value="{{ $metodoPago->idMetodosPagos }}">{{ $metodoPago->nombreMetodoPago }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Numero de Transaccion</label>
                                            <input id="numeroTransaccion" name="numeroTransaccion" type="text" class="form-control" >
                                        </div>
                                        <div class="col-3">
                                            <label for="nombre">Monto a Pagar</label>
                                            <input id="montoAPagar" name="montoAPagar" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="nombre">Comentario</label>
                                            <textarea name="comentarios" class="form-control" id="comentarios" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="nombre">Documento</label>
                                            <input id="documento" name="documento" type="file" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6" style="display: none">
                                            <input type="text" name="idEstadoPago" id="idEstadoPago" class="form-control" value="{{ Crypt::encrypt($estadoPago->idEstadoPago) }}" >
                                        </div>
                                        <div class="col-sm-8">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                        </div>
                                        <div class="col-sm-4" style="text-align: right">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                            <button class="btn btn-success"><i class="bx bx-money"></i> Pagar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <a href="/estados-pagos/mostrar/{{ $estadoPago->idContratoArriendo}}" class="btn btn-danger">Volver</a>
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

@endsection