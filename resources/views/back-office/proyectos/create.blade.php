@extends('back-office.layouts.app')
@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Ingresar Proyecto</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Proyectos</a></li>
                                    <li class="breadcrumb-item active">Ingresar Proyecto</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/proyectos/store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('back-office.proyectos.form')
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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({});
        });
        $('#summernote').summernote({
            placeholder: '',
            tabsize: 2,
            height: 200,
            dialogsInBody: true,
            dialogsFade: true,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['picture', ['picture']],
                ['table', ['table']]
            ]
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
        $("#idTipoComercial").change(function(){
            var idTipoComercial = $("#idTipoComercial").val();          
            if(idTipoComercial == 1)
            {
                document.getElementById('tipoOperacionVenta').style.display = "block";
                document.getElementById('tipoOperacionAfter').style.display = "none";
                document.getElementById('tipoOperacionArriendo').style.display = "none";
                $("precio").prop('required', true);
                $("valorArriendo").prop('required', false);
            }
            else if(idTipoComercial == 2)
            {
                document.getElementById('tipoOperacionVenta').style.display = "none";
                document.getElementById('tipoOperacionAfter').style.display = "none";
                document.getElementById('tipoOperacionArriendo').style.display = "block";
                $("precio").prop('required', false);
                $("valorArriendo").prop('required', true);
            }
            else
            {
                document.getElementById('tipoOperacionVenta').style.display = "none";
                document.getElementById('tipoOperacionAfter').style.display = "block";
                document.getElementById('tipoOperacionArriendo').style.display = "none";
                $("precio").prop('required', false);
                $("valorArriendo").prop('required', false);
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map;
            var latlng = new google.maps.LatLng( -33.4569400, -70.6482700);
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: latlng,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true
            });
        }
    </script>
    <script src="{{ asset('js/maps.js') }}"></script>
@endsection