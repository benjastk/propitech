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
                            <h4 class="mb-0 font-size-18">Contratos vencidos / Reajustes</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>
                                <a href="/contratos/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-user-plus font-size-16 align-middle mr-2"></i> Crear Contrato de arriendo
                                </a>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form method="POST" action="{{ route('buscarVencidos') }}" >
                        @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Desde</label>
                                    @if($desde)
                                        <input type="date" name="desde" id="desde" value="{{$desde}}" class="form-control" required >
                                    @else
                                        <input type="date" name="desde" id="desde"class="form-control"  required>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Hasta</label>
                                    @if($desde)
                                        <input type="date" name="hasta" id="hasta" value="{{$hasta}}" class="form-control" required >
                                    @else
                                        <input type="date" name="hasta" id="hasta"class="form-control"  required>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipo Consulta</label>
                                    <select name="tipo" class="form-control" required>
                                        @if($tipo)
                                        <option value="" >Seleccione opcion</option>
                                        <option value="2" {{ ($tipo == 2 ) ? 'selected' :'' }} >Contratos vencidos</option>
                                        <option value="1" {{ ($tipo == 1 ) ? 'selected' :'' }}>Reajustes</option>
                                        @else
                                        <option value="" >Seleccione opcion</option>
                                        <option value="2">Contratos vencidos</option>
                                        <option value="1">Reajustes</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>&nbsp;</label>
                                    <center><button style="width: 100%;" type="submit" class="btn btn-block btn-primary btn-sm"><i class="fa fa-search"></i> Buscar</button></center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla-ingresos" class="table table-centered table-hover">
                                        @if($tipo == 2)
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Rut</th>
                                                <th scope="col">Arrendatario</th>
                                                <th scope="col">Propiedad</th>
                                                <th scope="col">Valor Mensual</th>
                                                <th scope="col">Fecha de Inicio</th>
                                                <th scope="col">Fecha de Termino</th>
                                                <!--<th scope="col">Nota</th>-->
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($contratosArriendos as $contrato )
                                            <tr>
                                                <td>
                                                    {{ $contrato->rutArrendatario }}
                                                </td>
                                                <td >{{ $contrato->nombreArrendatario }} {{ $contrato->apellidoArrendatario }}</td>
                                                <td >{{ $contrato->direccion }} {{ $contrato->numero }}
                                                     @if($contrato->block), Dpto. {{ $contrato->block }} @endif
                                                </td>
                                                <td>${{ number_format($contrato->arriendoMensual, 0, '', '.')}}</td>
                                                <!--<td>{{ $contrato->nota }}</td>-->
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($contrato->desde)) }}
                                                </td>
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($contrato->hasta)) }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item">
                                                            <a href="/estados-pagos/mostrar/{{ $contrato->idContratoArriendo }}" data-toggle="tooltip" data-placement="top" title="Estados de pago"><i class="bx bxs-dollar-circle"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="/contratos/create?propiedad={{ $contrato->idPropiedad }}" data-toggle="tooltip" data-placement="top" title="Renovar"><i class="bx bx-bookmarks"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Rut</th>
                                                <th scope="col">Arrendatario</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Propiedad</th>
                                                <th scope="col">Valor Mensual</th>
                                                <th scope="col">Fecha Proximo Vencimiento</th>
                                                <th scope="col">Proxima Cuota</th>
                                                <!--<th scope="col">Nota</th>-->
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($estadosPagos as $estadoPago )
                                            <tr>
                                                <td>
                                                    {{ $estadoPago->rut }}
                                                </td>
                                                <td >{{ $estadoPago->nombreArrendatario }} {{ $estadoPago->apellidoArrendatario }}</td>
                                                <td >{{ $estadoPago->email }}</td>
                                                <td >{{ $estadoPago->direccion }} {{ $estadoPago->numero }}
                                                     @if($estadoPago->block), Dpto. {{ $estadoPago->block }} @endif
                                                </td>
                                                <td>${{ number_format($estadoPago->arriendoMensual, 0, '', '.')}}</td>
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($estadoPago->fechaVencimiento)) }}
                                                </td>
                                                <td>
                                                    {{ $estadoPago->numeroCuota }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="/estados-pagos/mostrar/{{ $estadoPago->idContrato }}" data-toggle="tooltip" data-placement="top" title="Estados de pago"><i class="bx bxs-dollar-circle"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
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
			"order": [[ 6, "asc" ]]
		});
	} );
</script>
@endsection
