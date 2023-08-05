@extends('back-office.layouts.app')
@section('css')
<link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-body pt-0"> 
                                        <div class="p-2">
                                            <div class="row">
                                            <label>Fotos propiedad</label>
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
                                                                <img src="/img/propiedad/{{ $foto->nombreArchivo }}" class="card-img-top" alt="...">
                                                                <div class="card-footer">
                                                                    <form action="/properties/img/eliminar/{{ $foto->idFoto }}" method="POST">
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
                            <form action="{{ url('/properties/update/'.$propiedad->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('back-office.properties.form')
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
            var idTipoComercial = $("#idTipoComercial").val();          
            if(idTipoComercial == 1)
            {
                document.getElementById('tipoOperacionVenta').style.display = "block";
                document.getElementById('tipoOperacionAfter').style.display = "none";
                document.getElementById('tipoOperacionArriendo').style.display = "none";
            }
            else if(idTipoComercial == 2)
            {
                document.getElementById('tipoOperacionVenta').style.display = "none";
                document.getElementById('tipoOperacionAfter').style.display = "none";
                document.getElementById('tipoOperacionArriendo').style.display = "block";
            }
            else
            {
                document.getElementById('tipoOperacionVenta').style.display = "none";
                document.getElementById('tipoOperacionAfter').style.display = "block";
                document.getElementById('tipoOperacionArriendo').style.display = "none";
            }
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
    <script src="https://unpkg.com/dropzone@5.9.3/dist/dropzone.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js" integrity="sha512-LjPH94gotDTvKhoxqvR5xR2Nur8vO5RKelQmG52jlZo7SwI5WLYwDInPn1n8H9tR0zYqTqfNxWszUEy93cHHwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        // "myDropZone" es el ID de nuestro formulario usando la notación camelCase
        Dropzone.options.myDropZone = {
            url: '/properties/img/subir/{{$propiedad->id}}',
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
@endsection