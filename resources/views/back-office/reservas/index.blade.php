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
                            <h4 class="mb-0 font-size-18">Reservas de propiedades</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <a href="/reservas/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-file font-size-16 align-middle mr-2"></i> Crear Reserva
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
                                    <table id="tabla-ingresos" class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Fecha de Pago</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Rut</th>
                                                <th scope="col">Propiedad</th>
                                                <th scope="col">Valor Reserva</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($reservas as $reserva )
                                            <tr>
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($reserva->fechaDePago)) }}
                                                </td>
                                                <td>
                                                    {{ $reserva->nombre }} {{ $reserva->apellido }}
                                                </td>
                                                <td>{{ $reserva->rut }}</td>
                                                <td>{{ $reserva->direccion }} {{ $reserva->numero }} {{ $reserva->departamento }}</div>
                                                <td>${{ number_format($reserva->valorReserva, 0, '', '.')}}</td>
                                                <td>
                                                    @if($reserva->eliminado == 1)
                                                    <span class="badge badge-danger">Eliminado</span><br>
                                                    @else
                                                        @if($reserva->idEstado == 47)
                                                        <span class="badge badge-info">{{ $reserva->nombreEstado }}</span>
                                                        @elseif($reserva->idEstado == 48)
                                                        <span class="badge badge-success">{{ $reserva->nombreEstado }}</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        @if($reserva->idEstado != 48)
                                                        <li class="list-inline-item">
                                                            <a href="#" data-toggle="modal" data-target=".modalPago{{ $reserva->idReserva }}" title="Pagar"><i class="bx bx-money"></i></a>
                                                        </li>
                                                        @endif
                                                        <li class="list-inline-item">
                                                            <a href="/reservas/edit/{{ $reserva->idReserva }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <form id="form1" action="{{ url('/reservas/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $reserva->idReserva }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/reservas/edit/{{ $reserva->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
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
            </div> <!-- container-fluid -->
        </div>
        @if($reservas)
        @foreach($reservas as $reserva)
        <div class="modal fade bs-example-modal-md modalPago{{ $reserva->idReserva}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Pago manual de reserva</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" style="padding:20px !important">
                                <form method="POST" action="{{ route('pagoManualReserva') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="nombre">Fecha de vencimiento</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="fechaVencimiento" name="fechaVencimiento" type="date" value="{{ $reserva->fechaDePago}}" class="form-control" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="nombre">Valor reserva</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input id="valorReserva" name="valorReserva" type="text" value="{{ $reserva->valorReserva}}" class="form-control" readonly >
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
                                                    @if($metodosPagos)
                                                    @foreach($metodosPagos as $metodoPago)
                                                        <option value="{{ $metodoPago->idMetodosPagos }}">{{ $metodoPago->nombreMetodoPago }}</option>
                                                    @endforeach
                                                    @endif
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
                                            <input type="text" name="idReserva" id="idReserva" class="form-control" value="{{ $reserva->idReserva }}" >
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