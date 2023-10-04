<div class="card-body">
    <div class="row">
        <div class="card-body pt-0"> 
            <div class="p-2">
                <div class="row">
                    @if(!isset($usuario->name))
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="user-thumb">
                            <label>Subir foto</label>
                            <input type="file" class="form-control-file" id="foto" name="foto" id="fotoPrincipal" accept="image/*">
                            <input type="hidden" class="form-control" name="imagenActual" id="imagenActual">
                        </div>
                    </div>
                    <div class="col-6">
                    </div>
                    @else
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="user-thumb text-center">                        
                            @if($usuario->avatarImg)
                                <img src="/img/usuarios/{{ $usuario->avatarImg}}" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                            @endif
                            <h5 class="font-size-15 mt-3">{{ $usuario->name }} {{ $usuario->apellido }} </h5>
                        </div>
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
        <div class="col-lg-6 col-md-6 col-sm-12">
        <label>Nombres</label>
            @if(!isset($usuario->name))
                <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Nombre" required>
            @else
                <input type="text" name="name" value="{{ $usuario->name }}" class="form-control" placeholder="Nombre" required>
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <label>Apellidos</label>
            @if(!isset($usuario->apellido))
                <input type="text" name="apellido" value="{{old('apellido')}}" class="form-control" placeholder="Apellido" required >
            @else
                <input type="text" name="apellido" value="{{ $usuario->apellido }}" class="form-control" placeholder="Apellido" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
        <label>Rut</label>
            @if(!isset($usuario->rut))
                <input type="text" name="rut" value="{{old('rut')}}" class="form-control" placeholder="Rut" required>
            @else
                <input type="text" name="rut" value="{{ $usuario->rut }}" class="form-control" placeholder="Rut" required>
            @endif
            
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <label>Numero de Serie</label>
            @if(!isset($usuario->numeroSerie))
                <input type="text" name="numeroSerie" value="{{old('numeroSerie')}}" class="form-control" placeholder="Numero de Serie">
            @else
                <input type="text" name="numeroSerie" value="{{ $usuario->numeroSerie }}" class="form-control" placeholder="Numero de Serie">
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <label>Correo electronico</label>
            @if(!isset($usuario->email))
                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Correo" required>
            @else
                <input type="email" name="email" value="{{ $usuario->email }}" class="form-control" placeholder="Correo" required>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
        <label>Telefono</label>
            @if(!isset($usuario->telefono))
                <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="Telefono" required>
            @else
                <input type="text" name="telefono" value="{{ $usuario->telefono }}" class="form-control" placeholder="Telefono" required>
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <label>Profesion</label>
            @if(!isset($usuario->profesion))
                <input type="text" name="profesion" value="{{old('profesion')}}" class="form-control" placeholder="Profesion" >
            @else
                <input type="text" name="profesion" value="{{ $usuario->profesion }}" class="form-control" placeholder="Profesion" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Pais</label>
                    <select name="idPais" id="idPais" class="form-control" required >
                        @if(!isset($usuario->idPais))
                            <option value="" >Pais</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->idPais }}" {{ (Input::old("idPais") == $pais->idPais ? "selected":"") }} >{{ $pais->nombrePais }}</option>
                            @endforeach
                        @else
                            <option>Pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPais }}" {{ ($pais->idPais == $usuario->idPais) ? 'selected' : ''}}>{{ $pais->nombrePais}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Region</label>
                    <select name="idRegion" id="idRegion" class="form-control" required >
                    @if(!isset($usuario->idRegion))
                        <option value="" >Region</option>
                    @else
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" {{ ($region->id == $usuario->idRegion) ? 'selected' : ''}}>{{ $region->nombre}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Provincia</label>
                    <select name="idProvincia" id="idProvincia" class="form-control" required>
                        @if(!isset($usuario->idProvincia))
                            <option value="" >Provincia</option>
                        @else
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" {{ ($provincia->id == $usuario->idProvincia) ? 'selected' : ''}}>{{ $provincia->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Comuna</label>
                    <select name="idComuna" id="idComuna" class="form-control" required>
                        @if(!isset($usuario->idComuna))
                            <option value="" >Comuna</option>
                        @else
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" {{ ($comuna->id == $usuario->idComuna) ? 'selected' : ''}}>{{ $comuna->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12">
        <label>Direccion</label>
            @if(!isset($usuario->direccion))
                <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion" required >
            @else
                <input type="text" name="direccion" value="{{ $usuario->direccion }}" class="form-control" placeholder="Direccion" required >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        <label>Numero</label>
            @if(!isset($usuario->numero))
                <input type="text" name="numero" value="{{old('numero')}}" class="form-control" placeholder="numero" required >
            @else
                <input type="text" name="numero" value="{{ $usuario->numero }}" class="form-control" placeholder="numero" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Genero</label>
                    <select name="idGenero" class="form-control" required >
                        @if(!isset($usuario->idGenero))
                            @foreach($generos as $genero)
                                <option value="{{ $genero->idGenero }}" {{ (Input::old("idGenero") == $genero->idGenero ? "selected":"") }} >{{ $genero->nombreGenero }}</option>
                            @endforeach
                        @else
                            @foreach($generos as $genero)
                                <option value="{{ $genero->idGenero }}" {{ $usuario->idGenero == $genero->idGenero ? "selected":"" }} >{{ $genero->nombreGenero }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
        <label>Nacionalidad</label>
            @if(!isset($usuario->nacionalidad))
                <input type="text" name="nacionalidad" value="{{old('nacionalidad')}}" class="form-control" placeholder="nacionalidad" required >
            @else
                <input type="text" name="nacionalidad" value="{{ $usuario->nacionalidad }}" class="form-control" placeholder="nacionalidad" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
        <label>Estado Civil</label>
            @if(!isset($usuario->estadoCivil))
                <input type="text" name="estadoCivil" value="{{old('estadoCivil')}}" class="form-control" placeholder="Estado Civil">
            @else
                <input type="text" name="estadoCivil" value="{{ $usuario->estadoCivil }}" class="form-control" placeholder="Estado Civil">
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Tipo Usuario Comercial</label>
                    <select name="idTipoUsuarioComercial" class="form-control" required >
                        @if(!isset($usuario->idTipoUsuarioComercial))
                            @foreach($tiposComerciales as $tipos)
                            <option value="{{ $tipos->idTipoComercial }}" {{ (Input::old("idTipoUsuarioComercial") == $tipos->idTipoComercial ? "selected":"") }} >{{ $tipos->nombreTipoComercial }}</option>
                            @endforeach
                        @else
                            @foreach($tiposComerciales as $tipos)
                            <option value="{{ $tipos->idTipoComercial }}" {{ $usuario->idTipoUsuarioComercial == $tipos->idTipoComercial ? "selected":"" }} >{{ $tipos->nombreTipoComercial }}</option>
                            @endforeach
                        @endif                                        
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
        <label>Contraseña</label>
            @if(!isset($usuario->password))
                <input type="password" name="contrasena1" class="form-control" placeholder="Contraseña" required >
            @else
                <input type="password" name="contrasena1" value="{{ $usuario->password }}" class="form-control" placeholder="Contraseña" required >
            @endif 
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
        <label>Confirme contraseña</label>
            @if(!isset($usuario->password))
                <input type="password" name="contrasena2" class="form-control" placeholder="Contraseña" required >
            @else
                <input type="password" name="contrasena2" value="{{ $usuario->password }}" class="form-control" placeholder="Contraseña" required >
            @endif 
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <div class="form-group row">
                <div class="col-md-12">
                <label>Rol Usuario</label>
                    <select name="idRol" class="form-control" required >
                        <option value="" >Seleccione un rol</option>
                        @if(!isset($usuario->idRol))
                            @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ (Input::old("idRol") == $rol->id ? "selected":"") }} >{{ $rol->nombre }}</option>
                            @endforeach
                        @else
                            @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ $usuario->idRol == $rol->id ? "selected":"" }} >{{ $rol->nombre }}</option>
                            @endforeach
                        @endif                                        
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Modo</label>
            @if(!isset($usuario->modoOscuro))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="modoOscuro1" type="checkbox" class="custom-control-input" id="modoOscuro1"  {{ (Input::old("modoOscuro") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="modoOscuro1">Modo Oscuro</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="modoOscuro1" type="checkbox" class="custom-control-input" id="modoOscuro1" {{ ( $usuario->modoOscuro == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="modoOscuro1">Modo Oscuro</label>
                </div>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
        </div>
        <div class="col-6">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
        </div>
        <div class="col-6">
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/users" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bxs-user-check font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        