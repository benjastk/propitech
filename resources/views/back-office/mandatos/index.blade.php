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
                            <h4 class="mb-0 font-size-18">Lista de Mandatos de Administración</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <div class="btn dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-file"></i>  Mandatos Demo <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/mandatos/demo/1">Raulí 5,6</a>
                                        <a class="dropdown-item" href="/mandatos/demo/2">Araucaria 7,5</a>
                                        <a class="dropdown-item" href="/mandatos/demo/3">Roble 9,5</a>
                                    </div>
                                </div>
                                <a href="/mandatos/liquidacion-inversionista" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-money font-size-16 align-middle mr-2"></i> Liquidacion de Inversionista
                                </a>
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
                                                <th scope="col" >Fecha de Inicio</th>
                                                <th scope="col" >Fecha de Termino</th>
                                                <th scope="col" style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;" >Propietario</th>
                                                <th scope="col" style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;" >Arrendatario</th>
                                                <th scope="col" style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;" >Propiedad</th>
                                                <th scope="col" >Estado</th>
                                                <th scope="col" >Comision <br>Administracion</th>
                                                <th scope="col" >Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($mandatosAdministracion as $mandato )
                                            <tr>
                                                <td>{{ strftime("%d de %B de %Y", strtotime($mandato->desde)) }}</td>
                                                <td>{{ strftime("%d de %B de %Y", strtotime($mandato->hasta)) }}</td>
                                                <td style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;" >{{ $mandato->nombrePropietario}} {{ $mandato->apellidoPropietario }}</td>
                                                <td style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;">{{ $mandato->nombreArrendatario }} {{ $mandato->apellidoArrendatario }}</td>
                                                <td style="width: 100px; word-wrap: break-word; overflow: hidden; text-overflow: ellipsis;" >{{ $mandato->direccionPropiedad }} {{ $mandato->block }}</td>
                                                <td>
                                                    <div>
                                                        @if($mandato->idEstadoMandato == 61)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">{{ $mandato->nombreEstado }}</a>
                                                        @elseif($mandato->idEstadoMandato == 62)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">{{ $mandato->nombreEstado }}</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">{{ $mandato->nombreEstado }}</a>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if($mandato->isAqua == 1)
                                                        <a href="#" class="badge badge-soft-info font-size-11 m-1">AQUA</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $mandato->comisionAdministracion }}%</td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item">
                                                            <form id="form1" action="{{ url('/mandatos/reimpresionMandatoAdministracion') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $mandato->idMandatoPropiedad }}"/>
                                                                <button style="border: 0px; background-color: transparent;" type="submit"><i class="bx bxs-printer"></i></button>
                                                            </form>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="/mandatos/edit/{{ $mandato->idMandatoPropiedad }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <form id="form1" action="{{ url('/mandatos/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $mandato->idMandatoPropiedad }}"/>
                                                                <button style="border: 0px; background-color: transparent;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/mandatos/edit/{{ $mandato->idMandatoPropiedad }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
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
        