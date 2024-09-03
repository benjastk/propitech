@extends('back-office.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('content')
<div class="main-content" id='app'>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Lista de Ventas</h4>

                        <div class="page-title-right">
                            <!--<ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                <li class="breadcrumb-item active">Lista de usuarios</li>
                            </ol>-->
                            <a href="/ventas/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                <i class="bx bx-user-plus font-size-16 align-middle mr-2"></i> Crear Venta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <indexventas></indexventas>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/app.js') }}"></script>
@endsection

