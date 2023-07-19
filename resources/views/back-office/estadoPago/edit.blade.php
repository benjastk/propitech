@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Editar Estado de Pago</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Estados de pago</a></li>
                                    <li class="breadcrumb-item active">Editar Estado de Pago</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/estados-pagos/update/'.$estadoPago->idEstadoPago) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Fecha de vencimiento</label>
                                            @if(!isset($estadoPago->fechaVencimiento))
                                                <input type="date" name="fechaVencimiento" id="desde" value="{{ old('fechaVencimiento') }}" class="form-control" required >
                                            @else
                                                <input type="date" name="fechaVencimiento" id="desde"class="form-control" value="{{$estadoPago->fechaVencimiento}}" required>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label>Estado</label>
                                            @if( !isset($estadoPago->idEstado))
                                                <select name="idEstado" class="form-control">
                                                    @foreach ($estados as $estado)
                                                        <option value="{{ $estado->idEstado }}">{{ $estado->nombreEstado }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select name="idEstado" class="form-control">
                                                    @foreach ($estados as $estado)
                                                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $estadoPago->idEstado) ? 'selected' :'' }}>{{ $estado->nombreEstado }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Valor Arriendo</label>
                                            @if(!isset($estadoPago->arriendoMensual))
                                                <input type="number" name="arriendoMensual" value="{{ old('arriendoMensual') }}" class="form-control" required >
                                            @else
                                                <input type="number" name="arriendoMensual" class="form-control" value="{{$estadoPago->arriendoMensual}}" required>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <label>Garantia</label>
                                            @if(!isset($estadoPago->garantia))
                                                <input type="number" name="garantia" value="{{ old('garantia') }}" class="form-control" required >
                                            @else
                                                <input type="number" name="garantia" class="form-control" value="{{$estadoPago->garantia}}" required>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <label>Comision</label>
                                            @if(!isset($estadoPago->comision))
                                                <input type="number" name="comision" value="{{ old('comision') }}" class="form-control" required >
                                            @else
                                                <input type="number" name="comision" class="form-control" value="{{$estadoPago->comision}}" required>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <label>Subtotal</label>
                                            @if(!isset($estadoPago->subtotal))
                                                <input type="number" name="subtotal" value="{{ old('subtotal') }}" class="form-control" readonly >
                                            @else
                                                <input type="number" name="subtotal" class="form-control" value="{{$estadoPago->subtotal}}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Saldo</label>
                                            @if(!isset($estadoPago->saldo))
                                                <input type="number" name="saldo" value="{{ old('saldo') }}" class="form-control" readonly >
                                            @else
                                                <input type="number" name="saldo" class="form-control" value="{{$estadoPago->saldo}}" readonly>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <label>Total pagado</label>
                                            @if(!isset($estadoPago->totalPagado))
                                                <input type="number" name="totalPagado" value="{{ old('totalPagado') }}" class="form-control" readonly >
                                            @else
                                                <input type="number" name="totalPagado" class="form-control" value="{{$estadoPago->totalPagado}}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Notas</label>
                                            @if(!isset( $estadoPago->notas))
                                                <textarea class="form-control" id="nota" name="notas" rows="2" placeholder="Nota"></textarea>
                                            @else
                                                <textarea class="form-control" id="nota" name="notas" rows="2" placeholder="Nota"> {{ $estadoPago->notas }} </textarea>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12" style="text-align:center">
                                            <a href="/estados-pagos/mostrar/{{ $contrato->idContratoArriendo }}" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                                                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
                                            </a>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                <i class="bx bxs-user-check font-size-16 align-middle mr-2"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Cargos y Descuentos</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/estados-pagos/createCargoDescuento') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Tipo</label>
                                            <select name="tipo" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="1">Cargo</option>
                                                <option value="2">Descuento</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Nombre Cargo o Descuento</label>
                                            <input type="text" name="nombre" class="form-control" required >
                                        </div>
                                        <div class="col-3">
                                            <label>Corresponde A</label>
                                            <select name="correspondeA" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="1">Propietario</option>
                                                <option value="2">Arrendatario</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label>Monto</label>
                                            <input type="number" name="monto" class="form-control" required >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Descripcion</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="Descripcion"></textarea>
                                        </div>
                                        <div class="form-group col-md-6" style="display:none">
                                            <div class="form-group">
                                                <input type="text" class="form-control"  name="idEstadoPago" id="idEstadoPago" value="{{ $estadoPago->idEstadoPago }}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12" style="text-align:center">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                <i class="bx bxs-check font-size-16 align-middle mr-2"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Monto</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Corresponde A</th>
                                                    <th scope="col">Descripcion</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cargos as $cargo )
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
                                                    <td>{{ $cargo->descripcionCargo }}</td>
                                                    <td>
                                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                                            <li class="list-inline-item px-2">
                                                                <form action="{{ url('/estados-pagos/destroyCargoDescuento') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $cargo->idCargo }}"/>
                                                                    <input type="hidden" name="tipo" value="1"/>
                                                                    <input type="hidden" name="idEstadoPago" value="{{ $estadoPago->idEstadoPago }}"/>
                                                                    <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @foreach($descuentos as $descuento )
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
                                                    <td>{{ $descuento->descripcionDescuento }}</td>
                                                    <td>
                                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                                            <li class="list-inline-item px-2">
                                                                <form action="{{ url('/estados-pagos/destroyCargoDescuento') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="id" value="{{ $descuento->idDescuento }}"/>
                                                                    <input type="hidden" name="tipo" value="2"/>
                                                                    <input type="hidden" name="idEstadoPago" value="{{ $estadoPago->idEstadoPago }}"/>
                                                                    <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                                </form>
                                                            </li>
                                                        </ul>
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
    
@endsection