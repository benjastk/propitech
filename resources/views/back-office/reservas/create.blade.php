@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Ingresar Reserva</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Reservas de Propiedades</a></li>
                                    <li class="breadcrumb-item active">Ingresar Reserva</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/reservas/store') }}" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                @include('back-office.reservas.form')
                            </form>
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
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $("#idPropiedad").change(function(){
                var idPropiedad = $("#idPropiedad").val();        
                $.ajax({
                    type: "GET",
                    url : "{{url('api/getPropiedad')}}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    data : { 'id' : idPropiedad },
                    success : function(respuesta){
                        document.getElementById("direccion").value = respuesta['direccion'];
                        document.getElementById("numero").value = respuesta['numero'];
                        document.getElementById("departamento").value = respuesta['block'];
                    }
                });
            });
        });
    </script>
@endsection