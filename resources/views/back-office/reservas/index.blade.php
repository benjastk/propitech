@extends('back-office.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ url('css/dataTables.bootstrap.min.css') }}">
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