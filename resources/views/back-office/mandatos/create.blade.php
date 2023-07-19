@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Ingresar Mandato de Administracion</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Mandatos de Administracion</a></li>
                                    <li class="breadcrumb-item active">Ingresar Mandato de Administracion</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/mandatos/store') }}" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                @include('back-office.mandatos.form')
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
        $("#rutPropietario").change(function(){
        var rut = $(this).val();
        $.ajax({
            url: '/api/buscarUsuarioPropietario',
            method:'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
            dataType: 'json',
            data:     { data: rut },
            success: function (respuesta) {
                console.log(respuesta);
                document.getElementById("nombrePropietario").value = respuesta['name'];
                document.getElementById("apellidoPropietario").value = respuesta['apellido'];
                document.getElementById("correoPropietario").value = respuesta['email'];
                document.getElementById("estadoCivilPropietario").value = respuesta['estadoCivil'];
                document.getElementById("nacionalidadPropietario").value = respuesta['nacionalidad'];
                document.getElementById("profesionPropietario").value = respuesta['profesion'];
                document.getElementById("direccionPropietario").value = respuesta['direccion'] + ' ' + respuesta['numero'];
                document.getElementById("comunaPropietario").value = respuesta['nombreComuna'];
                document.getElementById("regionPropietario").value = respuesta['nombreRegion'];
                var cuentas = respuesta['cuentas'];
                var select_prov = '<option value="">Seleccione Cuenta Bancaria</option>'
                for (var i=0; i < cuentas.length;i++){
                    console.log(cuentas[i]);
                  select_prov+='<option value="'+cuentas[i].idUsuarioCuentaBancaria +'">'+cuentas[i].numeroCuenta+' - '+cuentas[i].nombreBanco+ ' - ' + cuentas[i].nombreTipoCuenta +'</option>';
                }
                $("#cuentaBancaria").html(select_prov);
            },
            error: function(err) {
                alert("Usuario no encontrado");
            }
        });
        });
    });
</script>
@endsection