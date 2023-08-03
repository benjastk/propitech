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
                            <h4 class="mb-0 font-size-18">Formularios de contacto</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="width: 100%;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!--<h4 class="card-title">Custom Tabs</h4>-->

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">Formularios de Contacto</span> 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">Formularios Canjes</span> 
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block">Formularios Captador</span>   
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content p-3 text-muted">
                                    <div class="tab-pane active" id="home1" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="tabla-ingresos" class="table table-centered table-nowrap table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Telefono</th>
                                                        <th scope="col">Correo Electronico</th>
                                                        
                                                        <th scope="col">Mensaje</th>
                                                        <th scope="col">Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leadsContactos as $leadContacto )
                                                    <tr>
                                                        <td>{{ $leadContacto->nombre }}</td>
                                                        <td>{{ $leadContacto->telefono }}</td>
                                                        <td>{{ $leadContacto->email }}</td>
                                                        <td>{{ $leadContacto->mensaje }}</td>
                                                        <td>{{ strftime("%d-%m-%Y", strtotime($leadContacto->created_at)) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile1" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="tabla-ingresos2" class="table table-centered table-nowrap table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Correo Electronico</th>
                                                        <th scope="col">Telefono</th>
                                                        <th scope="col">Cantidad Propiedades</th>
                                                        <th scope="col">Operacion</th>
                                                        <th scope="col">Ciudad</th>
                                                        <th scope="col">Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leadsCanjes as $leadCanje )
                                                    <tr>
                                                        <td>{{ $leadCanje->nombreCorredor }}</td>
                                                        <td>{{ $leadCanje->emailCorredor }}</td>
                                                        <td>{{ $leadCanje->telefonoCorredor }}</td>
                                                        <td>{{ $leadCanje->cantidadPropiedades }}</td>
                                                        <td>{{ $leadCanje->nombreTipoComercial }}</td>
                                                        <td>{{ $leadCanje->ciudadCorredor }}</td>
                                                        <td>{{ strftime("%d/%m/%Y", strtotime($leadCanje->created_at)) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="messages1" role="tabpanel">
                                        <div class="table-responsive">
                                            <table id="tabla-ingresos3" class="table table-centered table-nowrap table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Propietario</th>
                                                        <th scope="col">Email Propietario</th>
                                                        <th scope="col">Telefono Propietario</th>
                                                        <th scope="col">Dia de visita</th>
                                                        <th scope="col">Direccion</th>
                                                        <th scope="col">Operacion</th>
                                                        <th scope="col">Tipo</th>
                                                        <th scope="col">Dormitorios</th>
                                                        <th scope="col">Baños</th>
                                                        <th scope="col">Estacionamiento</th>
                                                        <th scope="col">Bodega</th>
                                                        <th scope="col">Captador</th>
                                                        <th scope="col">Rut Captador</th>
                                                        <th scope="col">Telefono Captador</th>
                                                        <th scope="col">Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leadsCaptadores as $leadCaptador )
                                                    <tr>
                                                        <td>{{ $leadCaptador->nombrePropietario }}</td>
                                                        <td>{{ $leadCaptador->correoPropietario }}</td>
                                                        <td>{{ $leadCaptador->telefonoPropietario }}</td>
                                                        <td>{{ strftime("%d/%m/%Y %R hrs", strtotime($leadCaptador->diaVisita)) }}</td>
                                                        <td>{{ $leadCaptador->direccionPropiedad }}</td>
                                                        <td>{{ $leadCaptador->nombreTipoComercial }}</td>
                                                        <td>{{ $leadCaptador->nombreTipoPropiedad }}</td>
                                                        <td>{{ $leadCaptador->dormitorios }}</td>
                                                        <td>{{ $leadCaptador->banos }}</td>
                                                        <td>{{ $leadCaptador->estacionamiento }}</td>
                                                        <td>{{ $leadCaptador->bodega }}</td>
                                                        <td>{{ $leadCaptador->nombreCaptador }}</td>
                                                        <td>{{ $leadCaptador->rutCaptador }}</td>
                                                        <td>{{ $leadCaptador->telefonoCaptador }}</td>
                                                        <td>{{ strftime("%d/%m/%Y", strtotime($leadCaptador->created_at)) }}</td>
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
        $('#tabla-ingresos2').DataTable( {
			"order": [[ 0, "desc" ]]
		});
        $('#tabla-ingresos3').DataTable( {
			"order": [[ 0, "desc" ]]
		});
	} );
</script>
@endsection