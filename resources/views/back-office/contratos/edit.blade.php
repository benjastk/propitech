@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Editar Contrato de arriendo</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contratos</a></li>
                                    <li class="breadcrumb-item active">Editar Contrato de arriendo</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('/contratos/update/'.$contrato->idContratoArriendo) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('back-office.contratos.form')
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
        if({{ $contrato->rutCodeudor }} != '')
        {
            document.getElementById("formularioCodeudor").style.display = "inline";
            $('#codeudor').prop('checked', true);
        }
        if({{ $contrato->reajustePesos }} > 0)
        {
            $('#elegirReajuste').val(2)
            document.getElementById("reajustePesos").style.display = "inline";
            document.getElementById("reajustePorcentaje").style.display = "none";
            document.getElementById("antesDeReajuste").style.display = "none";
        }
        else
        {
            $('#elegirReajuste').val(1)
            document.getElementById("reajustePesos").style.display = "none";
            document.getElementById("reajustePorcentaje").style.display = "inline";
            document.getElementById("antesDeReajuste").style.display = "none";
        }
        $("#rutArrendatario").change(function(){
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
                document.getElementById("nombreArrendatario").value = respuesta['name'];
                document.getElementById("apellidoArrendatario").value = respuesta['apellido'];
                document.getElementById("correoArrendatario").value = respuesta['email'];
                document.getElementById("numeroTelefonoArrendatario").value = respuesta['telefono'];
                document.getElementById("nacionalidadArrendatario").value = respuesta['nacionalidad'];
                document.getElementById("estadoCivilArrendatario").value = respuesta['estadoCivil'];
                document.getElementById("direccionArrendatario").value = respuesta['direccion'];
                document.getElementById("nombreComunaArrendatario").value = respuesta['nombreComuna'];
                document.getElementById("nombreRegionArrendatario").value = respuesta['nombreRegion'];
            },
            error: function(err) {
                alert("Usuario no encontrado");
            }
        });
        });
    });
</script>
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
<script>
  $(document).ready(function(){
        $("#rutCodeudor").change(function(){
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
                document.getElementById("nombreCodeudor").value = respuesta['name'];
                document.getElementById("apellidoCodeudor").value = respuesta['apellido'];
                document.getElementById("correoCodeudor").value = respuesta['email'];
                document.getElementById("telefonoCodeudor").value = respuesta['telefono'];
                document.getElementById("direccionCodeudor").value = respuesta['direccion'];
                document.getElementById("nacionalidadCodeudor").value = respuesta['nacionalidad'];
            },
            error: function(err) {
                alert("Usuario no encontrado");
            }
        });
        });
    });
</script>
<script type="text/javascript">
    $('input[type="checkbox"][name="codeudor"]').change(function() {
        if(this.checked) {
            document.getElementById("formularioCodeudor").style.display = "inline";
        }else{
            document.getElementById("formularioCodeudor").style.display = "none";
            document.getElementById("rutCodeudor").value = "";
            document.getElementById("nombreCodeudor").value = "";
            document.getElementById("apellidoCodeudor").value = "";
            document.getElementById("correoCodeudor").value = "";
            document.getElementById("telefonoCodeudor").value = "";
            document.getElementById("direccionCodeudor").value = "";
            document.getElementById("nacionalidadCodeudor").value = "";
        }
    });
    $('#elegirReajuste').change(function() {
        if(this.value == 1) {
            document.getElementById("reajustePesos").style.display = "none";
            document.getElementById("reajustePorcentaje").style.display = "inline";
            document.getElementById("antesDeReajuste").style.display = "none";
        }
        else if(this.value == 2)
        {
            document.getElementById("reajustePesos").style.display = "inline";
            document.getElementById("reajustePorcentaje").style.display = "none";
            document.getElementById("antesDeReajuste").style.display = "none";
        }
        else
        {
            document.getElementById("reajustePesos").style.display = "none";
            document.getElementById("reajustePorcentaje").style.display = "none";
            document.getElementById("antesDeReajuste").style.display = "inline";
        }
    });
</script>
@endsection