@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Editar Mandato de Administracion</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Mandatos de Administracion</a></li>
                                    <li class="breadcrumb-item active">Editar Mandato de Administracion</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/mandatos/update/'.$mandato->idMandatoPropiedad) }}" method="POST" enctype="multipart/form-data">
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
            url: '/api/buscarUsuario',
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
                document.getElementById("numeroPropietario").value = respuesta['telefono'];
                document.getElementById("direccionPropietario").value = respuesta['direccion'];
            },
            error: function(err) {
                alert("Usuario no encontrado");
            }
        });
        });
    });
</script>
@endsection