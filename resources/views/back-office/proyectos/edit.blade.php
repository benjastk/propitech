@extends('back-office.layouts.app')
@section('css')
<link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<style>
    .dropzone .dz-message
    {
        margin: 0px !important;
    }
    .dropzone
    {
        min-height: 80px !important;
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
                            <h4 class="mb-0 font-size-18">Editar Proyecto</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Proyectos</a></li>
                                    <li class="breadcrumb-item active">Editar proyecto</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-body pt-0"> 
                                        <div class="p-2">
                                            <div class="row">
                                                <label>Fotos Proyecto</label>
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>Subir</strong><small> Imagenes</small>
                                                        </div>
                                                        <div class="card-body">
                                                            <div></div>
                                                            <div class="dropzone" id="myDropZone"></div>
                                                        </div>
                                                    </div>
                                                    @if(isset($fotos))
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>Imagenes</strong><small> Cargadas</small>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                            @foreach($fotos as $foto)
                                                                <div class="col-xl-3">
                                                                    <div class="card">
                                                                    <img src="/img/proyecto/{{ $foto->nombreArchivo }}" class="card-img-top" alt="...">
                                                                    <div class="card-footer">
                                                                        <form action="/proyectos/img/eliminar/{{ $foto->id }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-link btn-sm pull-right">Eliminar</button>
                                                                        </form>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <label>Fotos Lugares Cerca</label>
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>Subir</strong><small> Imagenes</small>
                                                        </div>
                                                        <div class="card-body">
                                                            <div></div>
                                                            <div class="dropzone" id="myDropZoneCerca"></div>
                                                        </div>
                                                    </div>
                                                    @if(isset($fotosCercanas))
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <strong>Imagenes</strong><small> Cargadas</small>
                                                        </div>

                                                        <div class="card-body">
                                                            <div class="row">
                                                            @foreach($fotosCercanas as $foto)
                                                                <div class="col-xl-3">
                                                                    <div class="card">
                                                                    <img src="/img/cercana/{{ $foto->nombreArchivo }}" class="card-img-top" alt="...">
                                                                    <div class="card-footer">
                                                                        <form action="/proyectos/img/eliminarCercana/{{ $foto->idFotoCercana }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-link btn-sm pull-right">Eliminar</button>
                                                                        </form>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ url('/proyectos/update/'.$proyecto->idProyecto) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('back-office.proyectos.form2')
                            </form>
                        </div>
                        <br>
                        <br>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12" style="text-align:left">
                                        <label>Tipologias</label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12" style="text-align:right">
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target=".agregar-tipologia" title="agregar tipologia"><i class="bx bx-building"></i>Agregar Tipologia</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <table id="tableUsuario" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Descripcion Tipologia</th>
                                                    <th>Mts. Construidos</th>
                                                    <th>Mts. Totales</th>
                                                    <th>Dormitorios</th>
                                                    <th>Baños</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                @if($tipologias)
                                                <tbody>
                                                    @foreach($tipologias as $tipologia)
                                                    <tr>
                                                        <td>
                                                            <img src="/img/tipologia/{{ $tipologia->fotoTipologia }}" width="120px" height="100px">
                                                        </td>
                                                        <td>{{ $tipologia->descripcionTipologia }}</td>
                                                        <td>{{ $tipologia->mContruidos }}</td>
                                                        <td>{{ $tipologia->mTotales }}</td>
                                                        <td>{{ $tipologia->dormitorios }}</td>
                                                        <td>{{ $tipologia->banos }}</td>
                                                        <td>
                                                            <form id="form1" action="{{ route('delete-tipologia') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="idTipologia" value="{{ $tipologia->idTipologia }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @endif
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  Modal AGREGAR Tipologia -->
                        <div class="modal fade bs-example-modal-md agregar-tipologia" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Agregar Tipologia</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12" style="padding:20px !important">
                                                <form method="POST" action="{{ route('create-tipologia') }}" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Nombre Tipologia</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="descripcionTipologia" name="descripcionTipologia" type="text" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Metros Construidos</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="mContruidos" name="mContruidos" type="number" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Metros Totales</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="mTotales" name="mTotales" type="number" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Dormitorios</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="dormitorios" name="dormitorios" type="text" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Baños</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="banos" name="banos" type="text" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="nombre">Plano Tipologia</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input id="fotoTipologia" name="fotoTipologia" type="file" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <input type="text" style="display: none" name="idProyecto" id="idProyecto" class="form-control" value="{{ $proyecto->idProyecto }}" >
                                                        </div>
                                                        <div class="col-sm-4" style="text-align: right">
                                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                                            <button class="btn btn-success"><i class="bx bx-plus"></i> Crear</button>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({});
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
            $('#summernote2').summernote({
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I&callback=initMap" async defer></script>
    <script type="text/javascript">
        function initMap() {
            var map;
            var latlng = new google.maps.LatLng( {{ $proyecto->latitud }} , {{ $proyecto->longitud }});
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: latlng,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true
            });
        }
    </script>
    <script src="{{ asset('js/maps.js') }}"></script>
    <script src="https://unpkg.com/dropzone@5.9.3/dist/dropzone.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js" integrity="sha512-LjPH94gotDTvKhoxqvR5xR2Nur8vO5RKelQmG52jlZo7SwI5WLYwDInPn1n8H9tR0zYqTqfNxWszUEy93cHHwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        // "myDropZone" es el ID de nuestro formulario usando la notación camelCase
        Dropzone.options.myDropZone = {
            url: '/proyectos/img/subir/{{$proyecto->idProyecto}}',
            paramName: "file", // Las imágenes se van a usar bajo este nombre de parámetro
            maxFilesize: 10, // Tamaño máximo en MB
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            transformFile: function(file, done) {

                var myDropZone = this;

                // Create the image editor overlay
                var editor = document.createElement('div');
                editor.style.position = 'fixed';
                editor.style.left = 0;
                editor.style.right = 0;
                editor.style.top = 0;
                editor.style.bottom = 0;
                editor.style.zIndex = 9999;
                editor.style.backgroundColor = '#000';

                // Create the confirm button
                var confirm = document.createElement('button');
                confirm.style.position = 'absolute';
                confirm.style.left = '10px';
                confirm.style.top = '10px';
                confirm.style.zIndex = 9999;
                confirm.textContent = 'GUARDAR';
                confirm.addEventListener('click', function() {

                // Get the canvas with image data from Cropper.js
                var canvas = cropper.getCroppedCanvas({
                    width: 1300,
                    height: 840,
                    minWidth: 1300,
                    minHeight: 840,
                    maxWidth: 1300,
                    maxHeight: 840,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                // Turn the canvas into a Blob (file object without a name)
                canvas.toBlob(function(blob) {

                    // Update the image thumbnail with the new image data
                    myDropZone.createThumbnail(
                    blob,
                    myDropZone.options.thumbnailWidth,
                    myDropZone.options.thumbnailHeight,
                    myDropZone.options.thumbnailMethod,
                    false, 
                    function(dataURL) {

                        // Update the Dropzone file thumbnail
                        myDropZone.emit('thumbnail', file, dataURL);

                        // Return modified file to dropzone
                        done(blob);
                    }
                    );

                });

                // Remove the editor from view
                editor.parentNode.removeChild(editor);

                });
                editor.appendChild(confirm);

                // Load the image
                var image = new Image();
                image.src = URL.createObjectURL(file);
                editor.appendChild(image);

                // Append the editor to the page
                document.body.appendChild(editor);

                // Create Cropper.js and pass image
                var cropper = new Cropper(image, {
                    aspectRatio: 3 / 2,
                    dragMode: 'move',
                    data:
                    {
                        width: 1300,
                        height:  840,
                    },
                });
            }
        };
    </script>
    <script type="text/javascript">
        // "myDropZone" es el ID de nuestro formulario usando la notación camelCase
        Dropzone.options.myDropZoneCerca = {
            url: '/proyectos/img/subirCercana/{{$proyecto->idProyecto}}',
            paramName: "file", // Las imágenes se van a usar bajo este nombre de parámetro
            maxFilesize: 10, // Tamaño máximo en MB
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            transformFile: function(file, done) {

                var myDropZoneCerca = this;

                // Create the image editor overlay
                var editor = document.createElement('div');
                editor.style.position = 'fixed';
                editor.style.left = 0;
                editor.style.right = 0;
                editor.style.top = 0;
                editor.style.bottom = 0;
                editor.style.zIndex = 9999;
                editor.style.backgroundColor = '#000';

                // Create the confirm button
                var confirm = document.createElement('button');
                confirm.style.position = 'absolute';
                confirm.style.left = '10px';
                confirm.style.top = '10px';
                confirm.style.zIndex = 9999;
                confirm.textContent = 'GUARDAR';
                confirm.addEventListener('click', function() {

                // Get the canvas with image data from Cropper.js
                var canvas = cropper.getCroppedCanvas({
                    width: 1300,
                    height: 840,
                    minWidth: 1300,
                    minHeight: 840,
                    maxWidth: 1300,
                    maxHeight: 840,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                // Turn the canvas into a Blob (file object without a name)
                canvas.toBlob(function(blob) {

                    // Update the image thumbnail with the new image data
                    myDropZoneCerca.createThumbnail(
                    blob,
                    myDropZoneCerca.options.thumbnailWidth,
                    myDropZoneCerca.options.thumbnailHeight,
                    myDropZoneCerca.options.thumbnailMethod,
                    false, 
                    function(dataURL) {

                        // Update the Dropzone file thumbnail
                        myDropZoneCerca.emit('thumbnail', file, dataURL);

                        // Return modified file to dropzone
                        done(blob);
                    }
                    );

                });

                // Remove the editor from view
                editor.parentNode.removeChild(editor);

                });
                editor.appendChild(confirm);

                // Load the image
                var image = new Image();
                image.src = URL.createObjectURL(file);
                editor.appendChild(image);

                // Append the editor to the page
                document.body.appendChild(editor);

                // Create Cropper.js and pass image
                var cropper = new Cropper(image, {
                    aspectRatio: 3 / 2,
                    dragMode: 'move',
                    data:
                    {
                        width: 1300,
                        height:  840,
                    },
                });
            }
        };
    </script>
@endsection