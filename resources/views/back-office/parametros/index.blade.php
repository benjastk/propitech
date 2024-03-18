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
    .select2-container
    {
        width: 100% !important;
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
                            <h4 class="mb-0 font-size-18">Parametros Generales de Sistema</h4>

                            <div class="page-title-right">
                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">
                                    <i class="fa fa-whatsapp"></i> Whatsapp de Cobro
                                </button>
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla-ingresos" class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 50px !important">ID</th>
                                                <th scope="col" style="width: 20% !important">Parametro General</th>
                                                <th scope="col" style="width: 20% !important">Valor Parametro</th>
                                                <th scope="col" style="width: 20% !important">Texto Valor</th>
                                                <th scope="col" style="width: 20% !important">Descripcion</th>
                                                <th scope="col" style="width: 20% !important">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parametrosGenerales as $parametro )
                                            <tr>
                                                <td style="width: 50px !important">
                                                    {{ $parametro->idParametroGeneral}}
                                                </td>
                                                <td style="width: 20% !important">
                                                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $parametro->parametroGeneral }} </a></h5>
                                                </td>
                                                <td style="width: 20% !important" >
                                                    <a href="#" class="text-dark" style="font-weight: 500;">{{ $parametro->valorParametro }}</a>
                                                </td>
                                                <td style="width: 20% !important" >
                                                    <a href="#" class="text-dark">{{ $parametro->textoValorParametro }}</a>
                                                </td>
                                                <td style="width: 20% !important" >
                                                    <a href="#" class="text-dark">{{ $parametro->notas }}</a>
                                                </td>
                                                <td style="width: 20% !important" >
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="/parametros/edit/{{ $parametro->idParametroGeneral }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                <!-- paginatessss -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Enviar Whatsapp de Cobro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" style="padding:20px !important">
                                <h5>Seleccione usuarios</h5>
                                <form action="{{ url('/parametros/enviar-whatsapp') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <select class="form-control js-example-basic-multiple" name="usuarios[]" multiple='multiple' required>
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->apellido}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                            <button class="btn btn-success">Enviar</button>
                                        </div>
                                    </div>
                                </form>
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
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $("#formAgregar").submit(function(e){   
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url : "{{url('api/storeCaracteristica')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: form.serialize(),
                success: function(respuesta){  
                    $("#nombre").val("");
                    $("#orden").val("");
                    var tabla ='<div>'
                    for (var i=0; i<respuesta.caracteristicas.length;i++){
                        tabla+='<tr>';
                        tabla+='<td>'+respuesta.caracteristicas[i].nombreCaracteristica+'</td>';
                        tabla+='<td>'+respuesta.caracteristicas[i].orden+'</td>';
                        tabla+='<td><button onclick="eliminarCaracteristica('+respuesta.caracteristicas[i].idCaracteristica+');" style="border: 0px; background-color: white;" type="button">';
                        tabla+='<i class="bx bxs-trash-alt"></i>';
                        tabla+='</button></td>';
                        tabla+='</tr>';
                    }
                    tabla+='</div>';
                    $("#informacionTabla").html(tabla);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                } 
            });
        });
    });
</script>
<script>
    function eliminarCaracteristica(id)
    {
        $.ajax({
            type: "POST",
            url : "{{url('api/destroyCaracteristica')}}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { 'id': id},
            success: function(respuesta){  
                console.log(respuesta);
                $("#nombre").val("");
                $("#orden").val("");
                var tabla ='<div>'
                for (var i=0; i<respuesta.caracteristicas.length;i++){
                    tabla+='<tr>';
                    tabla+='<td>'+respuesta.caracteristicas[i].nombreCaracteristica+'</td>';
                    tabla+='<td>'+respuesta.caracteristicas[i].orden+'</td>';
                    tabla+='<td><button onclick="eliminarCaracteristica('+respuesta.caracteristicas[i].idCaracteristica+');" style="border: 0px; background-color: white;" type="button">';
                    tabla+='<i class="bx bxs-trash-alt"></i>';
                    tabla+='</button></td>';
                    tabla+='</tr>';
                }
                tabla+='</div>';
                $("#informacionTabla").html(tabla);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
            } 
        });
    }
</script>
<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('js/dataTables.bootstrap.min.js') }}"></script>
<script>
	$(document).ready( function () {
		$('#tabla-ingresos').DataTable( {
			"order": [[ 0, "desc" ]]
		});
	} );
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({});
    });
</script>
@endsection   