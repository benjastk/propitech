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
                            <h4 class="mb-0 font-size-18">Listado de propiedades</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <a href="/properties/suspendidas" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                                    <i class="fa fa-minus"></i> Propiedades Supendidas
                                </a>
                                <a href="/properties/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Crear Propiedad
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
                                            <th scope="col" style="text-align:center" >Valor</th>
                                            <th scope="col" style="text-align:center" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
			"order": [[ 0, "desc" ]],
			"processing": true,
			"serverSide": true,
			"ajax": "{{ url('/properties/datatable') }}",
			"columns": [
				{ "data": "id" },
				{ "data": "foto", "orderable": false, "searchable": false },
				{ "data": "propiedad" },
				{ "data": "distribucion", "orderable": false, "searchable": false, "className": "text-center" },
				{ "data": "estado", "className": "text-center" },
				{ "data": "valor" },
				{ "data": "acciones", "orderable": false, "searchable": false }
			]
		});
	} );
</script>
@endsection
        