<div class="card-body">
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-12">
            <label>Nombre del Proyecto</label>
            @if(!isset($proyecto->nombreProyecto))
                <input type="text" name="nombreProyecto" value="{{old('nombreProyecto')}}" class="form-control" placeholder="Nombre proyecto" required>
            @else
                <input type="text" name="nombreProyecto" value="{{ $proyecto->nombreProyecto }}" class="form-control" placeholder="Nombre proyecto" required>
            @endif
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12">
            <label>Valor Desde</label>
            @if(!isset($proyecto->valorUFDesde))
                <input type="number" name="valorUFDesde" value="{{old('valorUFDesde')}}" class="form-control" placeholder="Valor desde" >
            @else
                <input type="number" name="valorUFDesde" value="{{ $proyecto->valorUFDesde }}" class="form-control" placeholder="Valor desde" >
            @endif
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12">
            <label>Valor Hasta</label>
            @if(!isset($proyecto->valorUFHasta))
                <input type="number" name="valorUFHasta" value="{{old('valorUFHasta')}}" class="form-control" placeholder="Valor hasta" >
            @else
                <input type="number" name="valorUFHasta" value="{{ $proyecto->valorUFHasta }}" class="form-control" placeholder="Valor hasta" >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Estado</label>
            <select name="idEstado" id="idEstado" class="form-control" required >
                @if(!isset($proyecto->idEstado))
                    <option value="" >Seleccione estado</option>
                    @foreach($estados as $estado)
                    <option value="{{ $estado->idEstado }}" {{ (Input::old("idEstado") == $estado->idEstado ? "selected":"") }} >{{ $estado->nombreEstado }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione estado</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $proyecto->idEstado) ? 'selected' : ''}}>{{ $estado->nombreEstado}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Tipo Propiedad</label>
            <select name="tipoPropiedad" id="tipoPropiedad" class="form-control" required >
                @if(!isset($proyecto->tipoPropiedad))
                    <option value="" >Tipo propiedad</option>
                    @foreach($tiposPropiedades as $tipo)
                        <option value="{{ $tipo->idTipoPropiedad }}" {{ (Input::old("tipoPropiedad") == $tipo->idTipoPropiedad ? "selected":"") }} >{{ $tipo->nombreTipoPropiedad }}</option>
                    @endforeach
                @else
                    <option value="" >Tipo propiedad</option>
                    @foreach($tiposPropiedades as $tipo)
                        <option value="{{ $tipo->idTipoPropiedad }}" {{ ($proyecto->tipoPropiedad == $tipo->idTipoPropiedad) ? 'selected' : ''}}>{{ $tipo->nombreTipoPropiedad }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Cantidad departamentos</label>
            @if(!isset($proyecto->cantidadDepartamentos))
                <input type="number" name="cantidadDepartamentos" value="{{old('cantidadDepartamentos')}}" class="form-control" placeholder="Cantidad departamentos" >
            @else
                <input type="number" name="cantidadDepartamentos" value="{{ $proyecto->cantidadDepartamentos }}" class="form-control" placeholder="Cantidad departamentos" >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Metros desde</label>
            @if(!isset($proyecto->metrosDesde))
                <input type="number" name="metrosDesde" value="{{old('metrosDesde')}}" class="form-control" placeholder="Metros desde" >
            @else
                <input type="number" name="metrosDesde" value="{{ $proyecto->metrosDesde }}" class="form-control" placeholder="Metros desde" >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Metros Hasta</label>
            @if(!isset($proyecto->metrosHasta))
                <input type="number" name="metrosHasta" value="{{old('metrosHasta')}}" class="form-control" placeholder="Metros hasta" >
            @else
                <input type="number" name="metrosHasta" value="{{ $proyecto->metrosHasta }}" class="form-control" placeholder="Metros hasta" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Dormitorios desde</label>
            @if(!isset($proyecto->direccion))
                <input type="text" name="dormitoriosDesde" id="dormitoriosDesde" value="{{old('dormitoriosDesde')}}" class="form-control" placeholder="Dormitorios desde" required >
            @else
                <input type="text" name="dormitoriosDesde" id="dormitoriosDesde" value="{{ $proyecto->dormitoriosDesde }}" class="form-control" placeholder="Dormitorios desde" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Dormitorios Hasta</label>
            @if(!isset($proyecto->dormitoriosHasta))
                <input type="text" name="dormitoriosHasta" id="dormitoriosHasta" value="{{old('dormitoriosHasta')}}" class="form-control" placeholder="Dormitorios Hasta" required >
            @else
                <input type="text" name="dormitoriosHasta" id="dormitoriosHasta" value="{{ $proyecto->dormitoriosHasta }}" class="form-control" placeholder="Dormitorios Hasta" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Baños desde</label>
            @if(!isset($proyecto->baniosDesde))
                <input type="text" name="baniosDesde" id="baniosDesde" value="{{old('baniosDesde')}}" class="form-control" placeholder="Baños desde" required >
            @else
                <input type="text" name="baniosDesde" id="baniosDesde" value="{{ $proyecto->baniosDesde }}" class="form-control" placeholder="Baños desde" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Baños hasta</label>
            @if(!isset($proyecto->baniosHasta))
                <input type="text" name="baniosHasta" id="baniosHasta" value="{{old('baniosHasta')}}" class="form-control" placeholder="Baños hasta" required >
            @else
                <input type="text" name="baniosHasta" id="baniosHasta" value="{{ $proyecto->baniosHasta }}" class="form-control" placeholder="Baños hasta" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12">
            <label>Direccion</label>
            @if(!isset($proyecto->direccion))
                <input type="text" name="direccion" id="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion" required >
            @else
                <input type="text" name="direccion" id="direccion" value="{{ $proyecto->direccion }}" class="form-control" placeholder="Direccion" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Numero</label>
            @if(!isset($proyecto->numero))
                <input type="text" name="numero" id="numero" value="{{old('numero')}}" class="form-control" placeholder="Numero" required >
            @else
                <input type="text" name="numero" id="numero" value="{{ $proyecto->numero }}" class="form-control" placeholder="Numero" required >
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
                        @if(!isset($proyecto->idPais))
                            <option value="" >Pais</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->idPais }}" {{ (Input::old("idPais") == $pais->idPais ? "selected":"") }} >{{ $pais->nombrePais }}</option>
                            @endforeach
                        @else
                            <option>Pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPais }}" {{ ($pais->idPais == $proyecto->idPais) ? 'selected' : ''}}>{{ $pais->nombrePais}}</option>
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
                    @if(!isset($proyecto->idRegion))
                        <option value="" >Region</option>
                    @else
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" {{ ($region->id == $proyecto->idRegion) ? 'selected' : ''}}>{{ $region->nombre}}</option>
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
                        @if(!isset($proyecto->idProvincia))
                            <option value="" >Provincia</option>
                        @else
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" {{ ($provincia->id == $proyecto->idProvincia) ? 'selected' : ''}}>{{ $provincia->nombre}}</option>
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
                        @if(!isset($proyecto->idComuna))
                            <option value="" >Comuna</option>
                        @else
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" {{ ($comuna->id == $proyecto->idComuna) ? 'selected' : ''}}>{{ $comuna->nombre}}</option>
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
                    <div id="map" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display:none">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Latitud</label>
            <input type="text" name="latitud" id="latitud" class="form-control" >
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Longitud</label>
            <input type="text" name="longitud" id="longitud" class="form-control" >
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="row">
                @if(!isset($proyecto->fotoProyecto))
                <div class="col-12">
                    <label>Subir foto principal</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" id="fotoProyecto" accept="image/*">
                    <input type="hidden" class="form-control" name="imagenActual" id="imagenActual">
                </div>
                @else
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <label>Subir foto principal</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" id="fotoProyecto" accept="image/*">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                <label>Foto principal</label>
                    <div class="form-group" >
                        <img src="/img/propiedad/{{ $proyecto->fotoProyecto}}" width="150px" height="120px">
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Amenidades</label>
            <select class="form-control js-example-basic-multiple" name="comodidades[]" multiple='multiple' required>
            @if(!isset($proyecto->direccion))
                @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                    <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}">{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>
                @endforeach
            @else
                @if(isset($caracteristicasProyectos))
                    @if($caracteristicasProyectos->isEmpty())
                        @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                            <option value="{{ $caracteristicaPropiedad->idCaracteristicaPropiedad }}">{{ $caracteristicaPropiedad->nombreCaracteristica }}</option>
                        @endforeach
                    @else
                        @foreach ($caracteristicasPropiedades as $caracteristicaPropiedad)
                            @php($encontrado = false)
                            @foreach ($caracteristicasProyectos as $comodidadPropiedad)
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
            <label>Acerca del proyecto</label>
            @if(!isset($proyecto->descripcion))
                <textarea class="form-control" name="descripcion" id="summernote" rows="4" placeholder="" >{{ old('descripcion') }}</textarea>
            @else
                <textarea class="form-control" name="descripcion" id="summernote" rows="4" placeholder="" >{{ $proyecto->descripcion }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Cercano A (Texto Ubicación)</label>
            @if(!isset($proyecto->cercanoA))
                <textarea class="form-control" name="cercanoA" id="summernote2" rows="2" placeholder="" >{{ old('cercanoA') }}</textarea>
            @else
                <textarea class="form-control" name="cercanoA" id="summernote2" rows="2" placeholder="" >{{ $proyecto->cercanoA }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label></label>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12" style="text-align:center">
            @if(!isset($proyecto->idDestacado))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="idDestacado1" type="checkbox" class="custom-control-input" id="customSwitch4" {{ (Input::old("idDestacado") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Destacar proyecto</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="idDestacado1" type="checkbox" class="custom-control-input" id="customSwitch4" {{ ( $proyecto->idDestacado == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Destacar proyecto</label>
                </div>
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12" style="text-align:center">
            @if(!isset($proyecto->entregaInmediata))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="entregaInmediata1" type="checkbox" class="custom-control-input" id="customSwitch5" {{ (Input::old("entregaInmediata") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch5">Entrega Inmediata</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="entregaInmediata1" type="checkbox" class="custom-control-input" id="customSwitch5" {{ ( $proyecto->entregaInmediata == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch5">Entrega Inmediata</label>
                </div>
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <select name="creadoPor" id="creadoPor" class="form-control" required>
                @if(!isset($proyecto->creadoPor))
                    <option value="" >Seleccione experto</option>
                    @foreach ($expertosVendedores as $experto)
                        <option value="{{ $experto->id }}" >{{ $experto->name }} {{ $experto->apellido }}</option>
                    @endforeach
                @else
                    <option value="" >Seleccione experto</option>
                    @foreach ($expertosVendedores as $experto)
                        <option value="{{ $experto->id }}" {{ ($experto->id == $proyecto->creadoPor) ? 'selected' : ''}}>{{ $experto->name }} {{ $experto->apellido }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/properties" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bxs-home font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        