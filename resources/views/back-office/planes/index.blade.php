@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Lista de Planes de Administración</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">
                                <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Agregar caracteristica Plan
                                </button>
                                <a href="/planes/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Crear Plan de Administración
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 70px;">Estado</th>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Comision Corretaje</th>
                                                <th scope="col">IVA Corretaje</th>
                                                <th scope="col">Comision Administración</th>
                                                <th scope="col">IVA Administración</th>
                                                <th scope="col">Destacado</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($planes as $plan )
                                            <tr>
                                                <td>
                                                    <div>
                                                        @if($plan->activo == 1)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">Activado</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">Desactivado</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $plan->nombre }} </a></h5>
                                                </td>
                                                <td ><a href="#" class="text-dark" style="font-weight: 500;">{{ $plan->comisionCorretaje }}%</a></td>
                                                <td>
                                                    <div>
                                                        @if($plan->ivaCorretaje == 1)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">Activado</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-warning font-size-11 m-1">Desactivado</a>
                                                        @endif
                                                    </div>
                                                <td ><a href="#" class="text-dark" style="font-weight: 500;" >{{ $plan->comisionAdministracion }}%</a></td>
                                                <td>
                                                    <div>
                                                        @if($plan->ivaAdministracion == 1)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">Activado</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-warning font-size-11 m-1">Desactivado</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        @if($plan->destacado == 0)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">No Desctacado</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">Destacado</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item px-2">
                                                            <a href="/planes/edit/{{ $plan->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <form id="form1" action="{{ url('/planes/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $plan->id }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/planes/edit/{{ $plan->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
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
        <!--  Modal Caracteristicas -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Caracteristicas Planes</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Caracteristica</th>
                                        <th>Orden</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="informacionTabla">
                                    @if($caracteristicas)
                                    @foreach($caracteristicas as $caracteristica)
                                    <tr>
                                        <td>{{ $caracteristica->nombreCaracteristica }}</td>
                                        <td>{{ $caracteristica->orden }}</td>
                                        <td>
                                            <button onclick="eliminarCaracteristica({{ $caracteristica->idCaracteristica }});" style="border: 0px; background-color: white;" type="button">
                                                <i class="bx bxs-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12" style="padding:20px !important">
                                <h5>Agregar nueva caracteristica</h5>
                                <form id="formAgregar" >
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input id="nombre" name="nombre" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="orden">Orden</label>
                                                <input id="orden" name="orden" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                            <button class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
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
@endsection        