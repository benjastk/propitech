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
                        <h4 class="mb-0 font-size-18">PANEL DE VENTAS</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VENTAS</a></li>
                                <li class="breadcrumb-item active">PANEL DE VENTAS</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <!--<a href="#" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>-->
                            </div> <!-- end dropdown -->
                            <h4 class="card-title mb-4">ENTRANTES</h4>
                            <div id="upcoming-task" class="pb-1 task-list">
                                <div class="text-center">
                                    <a href="/ventas/create" class="btn btn-primary btn-block mt-1 waves-effect waves-light"><i class="mdi mdi-plus mr-1"></i> Agregar nueva</a>
                                </div>
                                <br>
                                @if($entrantes)
                                @foreach($entrantes as $entrante)
                                <div class="card task-box">
                                    <div class="card-body">
                                        <div class="float-right ml-2">
                                            <span class="badge badge-pill badge-soft-secondary font-size-12">Entrante</span>
                                            <br>
                                            <a href="/ventas/edit/{{ $entrante->idVenta }}"><i class="bx bxs-edit-alt"></i></a>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $entrante->direccion }} {{ $entrante->numero }} @if($entrante->block) Dpto. {{ $entrante->block }}@endif</a></h5>
                                            <p class="text-muted mb-4">{{ strftime("%d-%m-%Y", strtotime( $entrante->fechaInicio )) }}</p>
                                        </div>
                                        <div class="team float-left">
                                            {{ $entrante->name }} {{ $entrante->apellido }}
                                        </div>
                                        <div class="text-right">
                                            <h5 class="font-size-15 mb-1">${{ number_format($entrante->precioVenta, 0, ",", ".") }}</h5>
                                            <p class="mb-0 text-muted">Budget</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <!-- end task card -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <!--<a href="#" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>-->
                            </div> <!-- end dropdown -->
                            <h4 class="card-title mb-4">EN PROCESO</h4>
                            <div id="inprogress-task" class="pb-1 task-list">
                                <div class="text-center">
                                    <a href="/ventas/create" class="btn btn-primary btn-block mt-1 waves-effect waves-light"><i class="mdi mdi-plus mr-1"></i> Agregar nueva</a>
                                </div>
                                <br>
                                @if($enProgreso)
                                @foreach($enProgreso as $enProgresos)
                                <div class="card task-box">
                                    <div class="card-body">
                                        <div class="float-right ml-2">
                                            <span class="badge badge-pill badge-soft-info font-size-12">En Progreso</span>
                                            <br>
                                            <a href="/ventas/edit/{{ $enProgresos->idVenta }}"><i class="bx bxs-edit-alt"></i></a>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $enProgresos->direccion }} {{ $enProgresos->numero }} @if($enProgresos->block) Dpto. {{ $enProgresos->block }}@endif</a></h5>
                                            <p class="text-muted mb-4">{{ strftime("%d-%m-%Y", strtotime( $enProgresos->fechaInicio )) }}</p>
                                        </div>
                                        <div class="team float-left">
                                            {{ $enProgresos->name }} {{ $enProgresos->apellido }}
                                        </div>
                                        <div class="text-right">
                                            <h5 class="font-size-15 mb-1">${{ number_format($enProgresos->precioVenta, 0, ",", ".") }}</h5>
                                            <p class="mb-0 text-muted">Budget</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <!-- end task card -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="dropdown float-right">
                                <!--<a href="#" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>-->
                            </div> <!-- end dropdown -->
                            <h4 class="card-title mb-4">FINALIZADAS</h4>
                            <div id="complete-task" class="pb-1 task-list">
                                <div class="text-center">
                                    <a href="/ventas/create" class="btn btn-primary btn-block mt-1 waves-effect waves-light"><i class="mdi mdi-plus mr-1"></i> Agregar nueva</a>
                                </div>
                                <br>
                                @if($finalizadas)
                                @foreach($finalizadas as $finalizada)
                                <div class="card task-box">
                                    <div class="card-body">
                                        <div class="float-right ml-2">
                                            <span class="badge badge-pill badge-soft-success font-size-12">Finalizada</span>
                                            <br>
                                            <a href="/ventas/edit/{{ $finalizada->idVenta }}"><i class="bx bxs-edit-alt"></i></a>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{ $finalizada->direccion }} {{ $finalizada->numero }} @if($finalizada->block) Dpto. {{ $finalizada->block }}@endif</a></h5>
                                            <p class="text-muted mb-4">{{ strftime("%d-%m-%Y", strtotime( $finalizada->fechaInicio )) }}</p>
                                        </div>
                                        <div class="team float-left">
                                            {{ $finalizada->name }} {{ $finalizada->apellido }}
                                        </div>
                                        <div class="text-right">
                                            <h5 class="font-size-15 mb-1">${{ number_format($finalizada->precioVenta, 0, ",", ".") }}</h5>
                                            <p class="mb-0 text-muted">Budget</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
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
                    <div class="text-sm-right d-none d-sm-block">
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection
@section('script')
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('js/dragula/dragula.min.js') }}"></script>
<script src="{{ url('js/pages/task-kanban.init.js') }}"></script>
<script>
	$(document).ready( function () {
		$('#tabla-ingresos').DataTable( {
			"order": [[ 0, "desc" ]]
		});
	} );
</script>
@endsection
        