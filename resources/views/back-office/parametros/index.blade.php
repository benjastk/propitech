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
                            <h4 class="mb-0 font-size-18">Parametros Generales de Sistema</h4>

                            <div class="page-title-right">
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
                                                        <li class="list-inline-item px-2">
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
</script>
@endsection   