@extends('layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Editar Propiedad</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Propiedades</a></li>
                                    <li class="breadcrumb-item active">Editar Propiedad</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/properties/update/'.$propiedad->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('properties.form')
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
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({});
        });
    </script>
    <script>
        $("#idPais").change(function(){
            var idPais = $("#idPais").val();          
            $.ajax({
                type: "GET",
                url : "{{url('api/getRegion')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: 'json',
                data : { 'id' : idPais},
                success : function(respuesta){
                    var select_region = '<option value="">Seleccione Region</option>'
                    for (var i=0; i<respuesta.length;i++){
                        select_region+='<option value="'+respuesta[i].id +'">'+respuesta[i].nombre+'</option>';
                    }
                    $("#idRegion").html(select_region);
                }
            });
        });
        $("#idRegion").change(function(){
            var idRegion = $("#idRegion").val();          
            $.ajax({
                type: "GET",
                url : "{{url('api/getProvincia')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: 'json',
                data : { 'id' : idRegion},
                success : function(respuesta){
                    var select_provincia = '<option value="">Seleccione Provincia</option>'
                    for (var i=0; i<respuesta.length;i++){
                        select_provincia+='<option value="'+respuesta[i].id +'">'+respuesta[i].nombre+'</option>';
                    }
                    $("#idProvincia").html(select_provincia);
                }
            });
        });
        $("#idProvincia").change(function(){
            var idProvincia = $("#idProvincia").val();          
            $.ajax({
                type: "GET",
                url : "{{url('api/getComuna')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: 'json',
                data : { 'id' : idProvincia},
                success : function(respuesta){
                    var select_comuna = '<option value="">Seleccione Comuna</option>'
                    for (var i=0; i<respuesta.length;i++){
                        select_comuna+='<option value="'+respuesta[i].id +'">'+respuesta[i].nombre+'</option>';
                    }
                    $("#idComuna").html(select_comuna);
                }
            });
        });
    </script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11'
        });
    </script>
    <script src="{{ asset('js/maps.js') }}"></script>
@endsection