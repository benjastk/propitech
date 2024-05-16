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
                            <h4 class="mb-0 font-size-18">Propiedades Suspendidas</h4>

                            <!--<div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>
                                <a href="/properties/export" class="btn btn-success waves-effect waves-light" style="margin-right: 10px">
                                <i class="far fa-file-excel"></i> Descargar Excel
                                </a>
                                <a href="/properties/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Crear Propiedad
                                </a>
                            </div>-->
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
                                            <th scope="col" style="text-align:center" >Valor</th>
                                            <th scope="col" style="text-align:center" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($propiedades as $propiedad)
                                        <tr>
                                            <td>
                                                <p>{{ $propiedad->id }}</p>
                                            </td>
                                            <td>
                                                <img src="/img/propiedad/{{ $propiedad->fotoPrincipal}}" width="120px" height="100px">
                                            </td>
                                            <td style="width: 50px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">
                                                <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">{{ $propiedad->nombrePropiedad }}</a> 
                                                    <br>
                                                    <span class="badge badge-soft-primary">{{ $propiedad->nombreTipoPropiedad}}</span>
                                                    
                                                </h5>
                                                @if($propiedad->idDestacado == 1)
                                                    <span class="badge badge-success" style="color:black; background-color: yellow"><i class="mdi mdi-star mr-1"></i>Destacado</span>
                                                @endif
                                                @if($propiedad->urlPortalInmobiliario)
                                                    <span class="badge badge-info" style="color:black;"><i class="mdi mdi-star mr-1"></i>Portal Inmobiliario</span>
                                                @endif
                                                @if($propiedad->urlYapo)
                                                    <span class="badge badge-success" style="color:black; background-color: orange"><i class="mdi mdi-star mr-1"></i>Yapo</span>
                                                @endif
                                                <p class="text-muted mb-0">{{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }}</p>
                                                @if($propiedad->idExterno)
                                                    ID Ext: {{ $propiedad->idExterno }}
                                                @endif
                                            </td>
                                            <td style="text-align:center" >
                                            @if($propiedad->habitacion > 0)<i class="bx bx-bed"></i> {{ $propiedad->habitacion }} @else <i class="bx bx-bed"></i> Estudio @endif - 
                                                <i class="bx bx-bath"></i> {{ $propiedad->bano }}<br>
                                                @if($propiedad->estacionamiento)<i class="bx bx-car"></i> {{ $propiedad->estacionamiento }} - @endif
                                                @if($propiedad->bodega)<i class="bx bx-box"></i> {{ $propiedad->bodega }}@endif
                                            </td>
                                            <td style="text-align:center">
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
                                                <span class="badge badge-soft-dark">{{ $propiedad->nombreNivelUsoPropiedad }}</span>
                                                <br>
                                                @if($propiedad->idTipoComercial == 1)
                                                <span class="badge badge-info">VENTA</span>
                                                @elseif($propiedad->idTipoComercial == 2)
                                                <span class="badge badge-info">ARRIENDO</span>
                                                @else
                                                <span class="badge badge-info">SIN CATEGORIA</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($propiedad->idTipoComercial == 2)
                                                    <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">${{ number_format($propiedad->valorArriendo, 0, ",", ".") }} </font></font></h5>
                                                @elseif($propiedad->idTipoComercial == 1)
                                                <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">UF {{ number_format($propiedad->precio, 0, ",", ".") }} </font></font></h5>
                                                @else
                                                Sin Categorizacion
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="/properties/edit/{{ $propiedad->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        <form id="form1" action="{{ url('/properties/destroy-completo') }}" method="post">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="id" value="{{ $propiedad->id }}"/>
                                                            <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                        </form>
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
        