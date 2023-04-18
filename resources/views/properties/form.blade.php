<div class="card-body">
    <div class="row">
        <div class="col-6">
            <label>Nombre de la Propiedad</label>
            @if(!isset($propiedad->nombrePropiedad))
                <input type="text" name="nombrePropiedad" value="{{old('nombrePropiedad')}}" class="form-control" placeholder="Nombre propiedad" required>
            @else
                <input type="text" name="nombrePropiedad" value="{{ $propiedad->nombrePropiedad }}" class="form-control" placeholder="Nombre propiedad" required>
            @endif
        </div>
        <div class="col-3">
            <label>Rol propiedad</label>
            @if(!isset($propiedad->rolPropiedad))
                <input type="text" name="rolPropiedad" value="{{old('rolPropiedad')}}" class="form-control" placeholder="Rol" required >
            @else
                <input type="text" name="rolPropiedad" value="{{ $propiedad->rolPropiedad }}" class="form-control" placeholder="Rol" required >
            @endif
        </div>
        <div class="col-3">
            <label>Estado</label>
            <select name="idEstado" id="idEstado" class="form-control" required >
                @if(!isset($propiedad->idEstado))
                    <option value="" >Seleccione estado</option>
                    @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ (Input::old("idEstado") == $estado->idPais ? "selected":"") }} >{{ $estado->nombreEstado }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione estado</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $propiedad->idEstado) ? 'selected' : ''}}>{{ $estado->nombreEstado}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-3">
            <label>Tipo Propiedad</label>
            <select name="idTipoPropiedad" id="idTipoPropiedad" class="form-control" required >
                @if(!isset($propiedad->idTipoPropiedad))
                    <option value="" >Tipo propiedad</option>
                    @foreach($tiposPropiedades as $tipo)
                        <option value="{{ $tipo->idTipoPropiedad }}" {{ (Input::old("idTipoPropiedad") == $tipo->idTipoPropiedad ? "selected":"") }} >{{ $tipo->nombreTipoPropiedad }}</option>
                    @endforeach
                @else
                    <option value="" >Tipo propiedad</option>
                    @foreach($tiposPropiedades as $tipo)
                        <option value="{{ $tipo->idTipoPropiedad }}" {{ ($propiedad->idTipoPropiedad == $tipo->idTipoPropiedad) ? 'selected' : ''}}>{{ $tipo->nombreTipoPropiedad }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-3">
            <label>Nivel de uso</label>
            <select name="idNivelUsoPropiedad" id="idNivelUsoPropiedad" class="form-control" required >
                @if(!isset($propiedad->idNivelUsoPropiedad))
                    <option value="" >Nivel Uso Propiedad</option>
                    @foreach($nivelesUsoPropiedad as $nivelUso)
                        <option value="{{ $nivelUso->idNivelUsoPropiedad }}" {{ (Input::old("idNivelUsoPropiedad") == $nivelUso->idNivelUsoPropiedad ? "selected":"") }} >{{ $nivelUso->nombreNivelUsoPropiedad }}</option>
                    @endforeach
                @else
                    <option value="" >Nivel Uso Propiedad</option>
                    @foreach($nivelesUsoPropiedad as $nivelUso)
                        <option value="{{ $nivelUso->idNivelUsoPropiedad }}" {{ ($propiedad->idNivelUsoPropiedad == $nivelUso->idNivelUsoPropiedad) ? 'selected' : ''}}>{{ $nivelUso->nombreNivelUsoPropiedad }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-3">
            <label>Precio venta</label>
            @if(!isset($propiedad->precio))
                <input type="number" name="precio" value="{{old('precio')}}" class="form-control" placeholder="Precio venta">
            @else
                <input type="number" name="precio" value="{{ $propiedad->precio }}" class="form-control" placeholder="Precio venta">
            @endif
        </div>
        <div class="col-3">
            <label>Precio Arriendo</label>
            @if(!isset($propiedad->valorArriendo))
                <input type="number" name="valorArriendo" value="{{old('valorArriendo')}}" class="form-control" placeholder="Precio Arriendo" required>
            @else
                <input type="number" name="valorArriendo" value="{{ $propiedad->valorArriendo }}" class="form-control" placeholder="Precio Arriendo" required>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-3">
            <label>N° Cliente Agua</label>
            @if(!isset($propiedad->numeroClienteAgua))
                <input type="text" name="numeroClienteAgua" value="{{old('numeroClienteAgua')}}" class="form-control" placeholder="N° Cliente Agua">
            @else
                <input type="text" name="numeroClienteAgua" value="{{ $propiedad->numeroClienteAgua }}" class="form-control" placeholder="N° Cliente Agua">
            @endif
        </div>
        <div class="col-3">
            <label>N° Cliente Luz</label>
            @if(!isset($propiedad->numeroClienteLuz))
                <input type="text" name="numeroClienteLuz" value="{{old('numeroClienteLuz')}}" class="form-control" placeholder="N° Cliente Luz">
            @else
                <input type="text" name="numeroClienteLuz" value="{{ $propiedad->numeroClienteLuz }}" class="form-control" placeholder="N° Cliente Luz">
            @endif
        </div>
        <div class="col-3">
            <label>N° Cliente Gas</label>
            @if(!isset($propiedad->numeroClienteGas))
                <input type="text" name="numeroClienteGas" value="{{old('numeroClienteGas')}}" class="form-control" placeholder="N° Cliente Gas">
            @else
                <input type="text" name="numeroClienteGas" value="{{ $propiedad->numeroClienteGas }}" class="form-control" placeholder="N° Cliente Gas">
            @endif
        </div>
        <div class="col-3">
            <label>Gasto Comun</label>
            @if(!isset($propiedad->gastosComunes))
                <input type="text" name="gastosComunes" value="{{old('gastosComunes')}}" class="form-control" placeholder="Gasto Comun" required>
            @else
                <input type="text" name="gastosComunes" value="{{ $propiedad->gastosComunes }}" class="form-control" placeholder="Gasto Comun" required>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-2">
            <label>M Total</label>
            @if(!isset($propiedad->mTotal))
                <input type="number" name="mTotal" value="{{old('mTotal')}}" class="form-control" placeholder="M Total" required >
            @else
                <input type="number" name="mTotal" value="{{ $propiedad->mTotal }}" class="form-control" placeholder="M Total" required >
            @endif
        </div>
        <div class="col-2">
            <label>M Constuido</label>
            @if(!isset($propiedad->mConstruido))
                <input type="number" name="mConstruido" value="{{old('mConstruido')}}" class="form-control" placeholder="M Constuido" required >
            @else
                <input type="number" name="mConstruido" value="{{ $propiedad->mConstruido }}" class="form-control" placeholder="M Constuido" required >
            @endif
        </div>
        <div class="col-2">
            <label>M Terraza</label>
            @if(!isset($propiedad->mTerraza))
                <input type="number" name="mTerraza" value="{{old('mTerraza')}}" class="form-control" placeholder="M Terraza" >
            @else
                <input type="number" name="mTerraza" value="{{ $propiedad->mTerraza }}" class="form-control" placeholder="M Terraza" >
            @endif
        </div>
        <div class="col-2">
            <label>Baño</label>
            @if(!isset($propiedad->bano))
                <input type="number" name="bano" value="{{old('bano')}}" class="form-control" placeholder="Baño" >
            @else
                <input type="number" name="bano" value="{{ $propiedad->bano }}" class="form-control" placeholder="Baño" >
            @endif
        </div>
        <div class="col-2">
            <label>Habitaciones</label>
            @if(!isset($propiedad->habitacion))
                <input type="number" name="habitacion" value="{{old('habitacion')}}" class="form-control" placeholder="Habitaciones" >
            @else
                <input type="number" name="habitacion" value="{{ $propiedad->habitacion }}" class="form-control" placeholder="Habitaciones" >
            @endif
        </div>
        <div class="col-2"> 
            <label>Piso</label>
            @if(!isset($propiedad->numeroPisos))
                <input type="number" name="numeroPisos" value="{{old('numeroPisos')}}" class="form-control" placeholder="Piso" >
            @else
                <input type="number" name="numeroPisos" value="{{ $propiedad->numeroPisos }}" class="form-control" placeholder="Piso" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-2">
            <label>Cod. Estacionamiento</label>
        </div>
        <div class="col-2">
        </div>
        <div class="col-2">
            <label>Cod. Bodega</label>
        </div>
        <div class="col-2">
        </div>
        <div class="col-2">
            <label>Años antiguedad</label>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            @if(!isset($propiedad->usoGoceEstacionamiento))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="usoGoceEstacionamiento1" type="checkbox" class="custom-control-input" id="customSwitch1"  {{ (Input::old("usoGoceEstacionamiento1") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch1">Estacionamiento</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="usoGoceEstacionamiento1" type="checkbox" class="custom-control-input" id="customSwitch1" {{ ( $propiedad->usoGoceEstacionamiento == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch1">Estacionamiento</label>
                </div>
            @endif
        </div>
        <div class="col-2">
            @if(!isset($propiedad->codigoEstacionamiento))
                <input type="number" name="codigoEstacionamiento" value="{{old('codigoEstacionamiento')}}" class="form-control" placeholder="Cod. Estacionamiento" >
            @else
                <input type="number" name="codigoEstacionamiento" value="{{ $propiedad->codigoEstacionamiento }}" class="form-control" placeholder="Cod. Estacionamiento" >
            @endif
        </div>
        <div class="col-2">
            @if(!isset($propiedad->bodega))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="usoGoceBodega1" type="checkbox" class="custom-control-input" id="customSwitch2" {{ (Input::old("usoGoceBodega1") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch2">Bodega</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="usoGoceBodega1" type="checkbox" class="custom-control-input" id="customSwitch2" {{ ( $propiedad->usoGoceBodega == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch2">Bodega</label>
                </div>
            @endif
        </div>
        <div class="col-2">
            @if(!isset($propiedad->codigoBodega))
                <input type="number" name="codigoBodega" value="{{old('codigoBodega')}}" class="form-control" placeholder="Cod. Bodega" >
            @else
                <input type="number" name="codigoBodega" value="{{ $propiedad->codigoBodega }}" class="form-control" placeholder="Cod. Bodega" >
            @endif
        </div>
        <div class="col-2">
            @if(!isset($propiedad->mascotas))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="mascotas1" type="checkbox" class="custom-control-input" id="customSwitch3" {{ (Input::old("mascotas1") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch3">Acepta Mascota</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="mascotas1" type="checkbox" class="custom-control-input" id="customSwitch3" {{ ( $propiedad->mascotas == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch3">Acepta Mascota</label>
                </div>
            @endif
        </div>
        <div class="col-2">
            @if(!isset($propiedad->antiguedad))
                <input type="number" name="antiguedad" value="{{old('antiguedad')}}" class="form-control" placeholder="Antiguedad" >
            @else
                <input type="number" name="antiguedad" value="{{ $propiedad->antiguedad }}" class="form-control" placeholder="Antiguedad" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-7">
            <label>Direccion</label>
            @if(!isset($propiedad->direccion))
                <input type="text" name="direccion" id="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion" required >
            @else
                <input type="text" name="direccion" id="direccion" value="{{ $propiedad->direccion }}" class="form-control" placeholder="Direccion" required >
            @endif
        </div>
        <div class="col-3">
            <label>Numero</label>
            @if(!isset($propiedad->numero))
                <input type="text" name="numero" id="numero" value="{{old('numero')}}" class="form-control" placeholder="Numero" required >
            @else
                <input type="text" name="numero" id="numero" value="{{ $propiedad->numero }}" class="form-control" placeholder="Numero" required >
            @endif
        </div>
        <div class="col-2">
            <label>Block/Dpto</label>
            @if(!isset($propiedad->block))
                <input type="text" name="block" id="block" value="{{old('block')}}" class="form-control" placeholder="Block/Dpto" >
            @else
                <input type="text" name="block" id="block" value="{{ $propiedad->block }}" class="form-control" placeholder="Block/Dpto" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-3">
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Pais</label>
                    <select name="idPais" id="idPais" class="form-control" required >
                        @if(!isset($propiedad->idPais))
                            <option value="" >Pais</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->idPais }}" {{ (Input::old("idPais") == $pais->idPais ? "selected":"") }} >{{ $pais->nombrePais }}</option>
                            @endforeach
                        @else
                            <option>Pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPais }}" {{ ($pais->idPais == $propiedad->idPais) ? 'selected' : ''}}>{{ $pais->nombrePais}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Region</label>
                    <select name="idRegion" id="idRegion" class="form-control" required >
                    @if(!isset($propiedad->idRegion))
                        <option value="" >Region</option>
                    @else
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" {{ ($region->id == $propiedad->idRegion) ? 'selected' : ''}}>{{ $region->nombre}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Provincia</label>
                    <select name="idProvincia" id="idProvincia" class="form-control" required>
                        @if(!isset($propiedad->idProvincia))
                            <option value="" >Provincia</option>
                        @else
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" {{ ($provincia->id == $propiedad->idProvincia) ? 'selected' : ''}}>{{ $provincia->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <div class="col-md-12">
                    <label>Comuna</label>
                    <select name="idComuna" id="idComuna" class="form-control" required>
                        @if(!isset($propiedad->idComuna))
                            <option value="" >Comuna</option>
                        @else
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" {{ ($comuna->id == $propiedad->idComuna) ? 'selected' : ''}}>{{ $comuna->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="form-row">
                <label>Mapa</label>
                <div class="col-xs-12 col-lg-12">
                    <div id="map" style="width: 100%; height: 300px;"/></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <label>Latitud</label>
            <input type="text" name="latitud" id="latitud" class="form-control" >
        </div>
        <div class="col-6">
            <label>Longitud</label>
            <input type="text" name="longitud" id="longitud" class="form-control" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <div class="row">
                @if(!isset($propiedad->fotoPrincipal))
                <div class="col-12">
                    <label>Subir foto principal</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" id="fotoPrincipal" accept="image/*">
                    <input type="hidden" class="form-control" name="imagenActual" id="imagenActual">
                </div>
                @else
                <div class="col-6">
                    <label>Subir foto principal</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" id="fotoPrincipal" accept="image/*">
                </div>
                <div class="col-6">
                <label>Foto principal</label>
                    <div class="form-group" >
                        <img src="/img/propiedad/{{ $propiedad->fotoPrincipal}}" width="150px" height="120px">
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-6">
            <label>Comodidades</label>
            <select class="form-control js-example-basic-multiple" name="comodidades[]" multiple='multiple' required>
            @if(!isset($propiedad->direccion))
                @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                    <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}">{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>
                @endforeach
            @else
                @if(isset($caracteristicaPorPropiedad))
                    @if($caracteristicaPorPropiedad->isEmpty())
                        @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                            <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}">{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>
                        @endforeach
                    @else
                        @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                            @php($encontrado = false)
                            @foreach ($caracteristicaPorPropiedad as $comodidadPropiedad)
                                @if($caracteristicaPropiedad->idCaracteristicaPropiedad == $comodidadPropiedad->idCaracteristicaPropiedad)
                                    @php($encontrado = true)
                                    <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}" selected>{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>        
                                    @break
                                @endif
                            @endforeach
                            @if($encontrado == false)
                                <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}">{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>
                            @endif
                        @endforeach
                    @endif
                @endif
            @endif
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Descripción de la Propiedad</label>
            @if(!isset($propiedad->descripcion))
                <textarea class="form-control" name="descripcion" rows="4" placeholder="Ingrese descripción de la propiedad" value="{{ old('descripcion') }}"></textarea>
            @else
                <textarea class="form-control" name="descripcion" rows="4" placeholder="Ingrese descripción de la propiedad" value="{{ $propiedad->descripcion }}"> {{ $propiedad->descripcion }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-3">
            
        </div>
        <div class="col-3">
            <label>Experto</label>
        </div>
        <div class="col-3">
            <label>Propietario</label>
        </div>
        <div class="col-3">
            <label>Rut Propietario</label>
        </div>
    </div>
    <div class="row">
        <div class="col-3" style="text-align:center">
            @if(!isset($propiedad->idDestacado))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="idDestacado1" type="checkbox" class="custom-control-input" id="customSwitch4" {{ (Input::old("idDestacado") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Destacar propiedad</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="idDestacado1" type="checkbox" class="custom-control-input" id="customSwitch4" {{ ( $propiedad->idDestacado == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Destacar propiedad</label>
                </div>
            @endif
        </div>
        <div class="col-3">
            <select name="idUsuarioExpertoVendedor" id="idUsuarioExpertoVendedor" class="form-control" required>
                @if(!isset($propiedad->idUsuarioExpertoVendedor))
                    <option value="" >Seleccione experto</option>
                    @foreach ($expertosVendedores as $experto)
                        <option value="{{ $experto->id }}" >{{ $experto->name }} {{ $experto->apellido }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione experto</option>
                    @foreach ($expertosVendedores as $experto)
                        <option value="{{ $experto->id }}" {{ ($experto->id == $propiedad->idUsuarioExpertoVendedor) ? 'selected' : ''}}>{{ $experto->name }} {{ $experto->apellido }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-3">
            <select name="idUsuarioPropietario" id="idUsuarioPropietario" class="form-control" >
                @if(!isset($usuarioPropietario))
                    <option value="" >Seleccione propietario</option>
                    @foreach ($propietarios as $propietario)
                        <option value="{{ $propietario->id }}" >{{ $propietario->name }} {{ $propietario->apellido }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione propietario</option>
                    @foreach ($propietarios as $propietario1)
                        <option value="{{ $propietario1->id }}" {{ ($propietario1->id == $usuarioPropietario->id_usuario) ? 'selected' : ''}}>{{ $propietario1->name }} {{ $propietario1->apellido }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-3">
            @if(!isset($propiedad->rut))
                <input type="text" name="rut" value="{{old('rut')}}" class="form-control" placeholder="Rut propietario">
            @else
                <input type="text" name="rut" value="{{ $propiedad->rut }}" class="form-control" placeholder="Rut propietario">
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/properties" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bxs-user-check font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        