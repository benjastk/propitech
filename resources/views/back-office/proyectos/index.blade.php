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

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Listado de proyectos</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>
                                <a href="/properties/export" class="btn btn-success waves-effect waves-light" style="margin-right: 10px">
                                    <i class="far fa-file-excel"></i> Descargar Excel
                                </a>-->
                                <a href="/properties/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Crear Proyecto
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="table-responsive">
                                <table id="tabla-ingresos" class="table project-list-table table-centered table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col" >ID</th>
                                            <th scope="col" style="width: 100px">Foto</th>
                                            <th scope="col" style="width: 50px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">Propiedad</th>
                                            <th scope="col" style="text-align:center" >Distribucion</th>
                                            <th scope="col" style="text-align:center" >Estado</th>
                                            <th scope="col" style="text-align:center" >Valor UF</th>
                                            <th scope="col" style="text-align:center" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proyectos as $proyecto)
                                        <tr>
                                            <td>
                                                <p>{{ $proyecto->id }}</p>
                                            </td>
                                            <td>
                                                <img src="/img/proyecto/{{ $proyecto->fotoProyecto}}" width="120px" height="100px">
                                            </td>
                                            <td style="width: 50px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">{{ $proyecto->nombreProyecto }}</a> 
                                                    <br>
                                                    <span class="badge badge-soft-primary">{{ $proyecto->nombreTipoPropiedad}}</span>
                                                    
                                                </h5>
                                            </td>
                                            <td style="text-align:center" >
                                            </td>
                                            <td style="text-align:center">
                                                @if($proyecto->idEstado == 42)
                                                <span class="badge badge-success">{{ $proyecto->nombreEstado }}</span><br>
                                                @elseif($proyecto->idEstado == 43)
                                                <span class="badge badge-warning">{{ $proyecto->nombreEstado }}</span><br>
                                                @elseif($proyecto->idEstado == 44)
                                                <span class="badge badge-success">{{ $proyecto->nombreEstado }}</span><br>
                                                @elseif($proyecto->idEstado == 45)
                                                <span class="badge badge-info">{{ $proyecto->nombreEstado }}</span><br>
                                                @elseif($proyecto->idEstado == 46)
                                                <span class="badge badge-danger">{{ $proyecto->nombreEstado }}</span><br>
                                                @else
                                                <span class="badge badge-dark">{{ $proyecto->nombreEstado }}</span><br>
                                                @endif
                                                <span class="badge badge-soft-dark">{{ $proyecto->nombreNivelUsoPropiedad }}</span>
                                                <br>
                                            </td>
                                            <td>
                                                <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">UF {{ number_format($proyecto->valorUFDesde, 0, ",", ".") }} </font></font></h5> - 
                                                <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">UF {{ number_format($proyecto->valorUFHasta, 0, ",", ".") }} </font></font></h5>
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
                                                        <a href="/proyectos/edit/{{ $proyecto->idProyecto }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <form id="form1" action="{{ url('/proyectos/destroy') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $proyecto->idProyecto }}"/>
                                                            <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                        </form>
                                                        <!--<a href="/users/edit/{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="text-align:center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        