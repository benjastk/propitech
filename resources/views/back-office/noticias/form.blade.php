<div class="card-body">
    <div class="row">
        <div class="card-body pt-0"> 
            <div class="p-2">
                <div class="row">
                    @if(!isset($noticia->titulo))
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="user-thumb">
                            <label>Subir foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto" id="fotoPrincipal" accept="image/*">
                            <input type="hidden" class="form-control" name="imagenActual" id="imagenActual">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                    </div>
                    @else
                    <div class="col-lg-6 col-md-6 col-sm-12">                     
                        @if($noticia->imagenNoticia)
                            <img src="/img/noticias/{{ $noticia->imagenNoticia}}" alt="thumbnail" style="heigth: 200px; width: 200px">
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="user-thumb">
                            <label>Cambiar foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto" id="fotoPrincipal" accept="image/*">
                            <input type="hidden" class="form-control" name="imagenActual" id="imagenActual">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Titulo</label>
            @if(!isset($noticia->titulo))
                <input type="text" name="titulo" value="{{old('titulo')}}" class="form-control" placeholder="Titulo" required>
            @else
                <input type="text" name="titulo" value="{{ $noticia->titulo }}" class="form-control" placeholder="Titulo" required>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Texto resumen</label>
            @if(!isset($noticia->textoResumen))
                <input type="text" name="textoResumen" value="{{old('textoResumen')}}" class="form-control" placeholder="Texto resumen" required >
            @else
                <input type="text" name="textoResumen" value="{{ $noticia->textoResumen }}" class="form-control" placeholder="Texto resumen" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Texto</label>
            @if(!isset($noticia->texto))
                <textarea class="form-control" name="texto" id="summernote" rows="4" placeholder="Texto de la publicacion" value="{{ old('texto') }}"></textarea>
            @else
                <textarea class="form-control" name="texto" id="summernote" rows="4" placeholder="Texto de la publicacion" >{{ $noticia->texto }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Usuario</label>
            <select name="idUsuario" id="idUsuario" class="form-control" required>
                @if(!isset($noticia->idUsuario))
                    <option value="" >Seleccione usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" >{{ $user->name }} {{ $user->apellido }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione usuario</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ ($user->id == $noticia->idUsuario) ? 'selected' : ''}}>{{ $user->name }} {{ $user->apellido }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/noticias" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-news font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        