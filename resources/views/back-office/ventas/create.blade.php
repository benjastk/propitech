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
                            <h4 class="mb-0 font-size-18">Ingresar venta</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Ventas</a></li>
                                    <li class="breadcrumb-item active">Ingresar Venta</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/ventas/store') }}" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                @include('back-office.ventas.form')
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
                    success : function(respuesta)
                    {
                        document.getElementById("direccion").value = respuesta['direccion'];
                        document.getElementById("numero").value = respuesta['numero'];
                        document.getElementById("departamento").value = respuesta['block'];
                        document.getElementById("idPais").value = respuesta['idPais'];
                        document.getElementById("idProvincia").value = respuesta['idProvincia'];
                        document.getElementById("idRegion").value = respuesta['idRegion'];
                        document.getElementById("idComuna").value = respuesta['idComuna'];
                    }
                });
            });
        });
    </script>
    <script>
        /*$("#idPais").change(function(){
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
        });*/
    </script>
@endsection