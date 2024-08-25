<div class="card-body">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label>Propiedad</label>
            @if(!isset($venta->idPropiedad))
                <select name="idPropiedad" id="idPropiedad" class="form-control">
                    <option value="">Seleccione propiedad si corresponde</option>
                    @foreach ($propiedades as $propiedad)
                        <option value="{{ $propiedad->id }}">
                           {{ $propiedad->direccion }} {{ $propiedad->numero }}
                            @if($propiedad->block)
                            - Dpto. {{ $propiedad->block }}
                            @endif
                        </option>
                    @endforeach
                </select>
            @else
                <select name="idPropiedad" id="idPropiedad" class="form-control">
                    <option value="">Seleccione propiedad si corresponde</option>
                    @foreach ($propiedades as $propiedad)
                        <option value="{{ $propiedad->id }}" {{ ($propiedad->id == $venta->idPropiedad) ? 'selected' :'' }}>
                            {{ $propiedad->direccion }} {{ $propiedad->numero }}
                            @if($propiedad->block)
                            - Dpto. {{ $propiedad->block }}
                            @endif
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Direccion</label>
            @if(!isset($venta->direccion))
                <input type="text" name="direccion" id="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion" required >
            @else
                <input type="text" name="direccion" id="direccion" value="{{ $venta->direccion }}" class="form-control" placeholder="Direccion" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Numero</label>
            @if(!isset($venta->numero))
                <input type="text" name="numero" id="numero" value="{{old('numero')}}" class="form-control" placeholder="Numero" required >
            @else
                <input type="text" name="numero" id="numero" value="{{ $venta->numero }}" class="form-control" placeholder="Numero" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Block</label>
            @if(!isset($venta->block))
                <input type="text" name="block" id="departamento" value="{{old('block')}}" class="form-control" placeholder="Block" >
            @else
                <input type="text" name="block" id="departamento" value="{{ $venta->block }}" class="form-control" placeholder="Block" >
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
                        @if(!isset($venta->idPais))
                            <option value="" >Pais</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->idPais }}" {{ (Input::old("idPais") == $pais->idPais ? "selected":"") }} >{{ $pais->nombrePais }}</option>
                            @endforeach
                        @else
                            <option>Pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPais }}" {{ ($pais->idPais == $venta->idPais) ? 'selected' : ''}}>{{ $pais->nombrePais}}</option>
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
                    @if(!isset($venta->idRegion))
                        <option value="" >Seleccione</option>
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" >{{ $region->nombre}}</option>
                        @endforeach
                    @else
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" {{ ($region->id == $venta->idRegion) ? 'selected' : ''}}>{{ $region->nombre}}</option>
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
                        @if(!isset($venta->idProvincia))
                            <option value="" >Provincia</option>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" >{{ $provincia->nombre}}</option>
                            @endforeach
                        @else
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" {{ ($provincia->id == $venta->idProvincia) ? 'selected' : ''}}>{{ $provincia->nombre}}</option>
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
                        @if(!isset($venta->idComuna))
                            <option value="" >Comuna</option>
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" >{{ $comuna->nombre}}</option>
                            @endforeach
                        @else
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" {{ ($comuna->id == $venta->idComuna) ? 'selected' : ''}}>{{ $comuna->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Fecha Inicio Operación</label>
            @if(!isset($venta->fechaInicio))
                <input type="date" name="fechaInicio" id="fechaInicio" value="{{ old('fechaInicio') }}" class="form-control" required >
            @else
                <input type="date" name="fechaInicio" id="fechaInicio"class="form-control" value="{{ $venta->fechaInicio }}" required>
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Fecha Cierre Operación</label>
            @if(!isset($venta->fechaCierre))
                <input type="date" name="fechaCierre" id="fechaCierre" value="{{ old('fechaCierre') }}" class="form-control" >
            @else
                <input type="date" name="fechaCierre" id="fechaCierre"class="form-control" value="{{ $venta->fechaCierre }}" >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Estado Operación</label>
            <select name="idEstado" id="idEstado" class="form-control" required>
                @if(!isset($venta->idEstado))
                    <option value="" >Seleccione</option>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" >{{ $estado->nombreEstado }}</option>
                    @endforeach
                @else
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $venta->idEstado) ? 'selected' : ''}}>{{ $estado->nombreEstado }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Precio Venta</label>
            @if(!isset($venta->precioVenta))
                <input type="number" name="precioVenta" value="{{old('precioVenta')}}" class="form-control" >
            @else
                <input type="number" name="precioVenta" value="{{ $venta->precioVenta }}" class="form-control" >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Porcentaje Comision Vendedor</label>
            @if(!isset($venta->porcentajeComisionVendedor))
                <input type="number" name="porcentajeComisionVendedor" value="{{old('porcentajeComisionVendedor')}}" class="form-control" step="0.01" >
            @else
                <input type="number" name="porcentajeComisionVendedor" value="{{ $venta->porcentajeComisionVendedor }}" class="form-control" step="0.01" >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Porcentaje Comision Comprador</label>
            @if(!isset($venta->porcentajeComisionComprador))
                <input type="number" name="porcentajeComisionComprador" value="{{old('porcentajeComisionComprador')}}" class="form-control" step="0.01" >
            @else
                <input type="number" name="porcentajeComisionComprador" value="{{ $venta->porcentajeComisionComprador }}" class="form-control" step="0.01" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Nombre Comprador</label>
            @if(!isset($venta->nombreComprador))
                <input type="text" name="nombreComprador" value="{{old('nombreComprador')}}" class="form-control" required >
            @else
                <input type="text" name="nombreComprador" value="{{ $venta->nombreComprador }}" class="form-control" required >
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Apellido Comprador</label>
            @if(!isset($venta->apellidoComprador))
                <input type="text" name="apellidoComprador" value="{{old('apellidoComprador')}}" class="form-control" required >
            @else
                <input type="text" name="apellidoComprador" value="{{ $venta->apellidoComprador }}" class="form-control" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Rut Comprador</label>
            @if(!isset($venta->rutComprador))
                <input type="text" name="rutComprador" value="{{old('rutComprador')}}" class="form-control" required >
            @else
                <input type="text" name="rutComprador" value="{{ $venta->rutComprador }}" class="form-control" required >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Correo Electronico Comprador</label>
            @if(!isset($venta->emailComprador))
                <input type="text" name="emailComprador" value="{{old('emailComprador')}}" class="form-control" required >
            @else
                <input type="text" name="emailComprador" value="{{ $venta->emailComprador }}" class="form-control" required >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Telefono Comprador</label>
            @if(!isset($venta->telefonoComprador))
                <input type="text" name="telefonoComprador" value="{{old('telefonoComprador')}}" class="form-control" >
            @else
                <input type="text" name="telefonoComprador" value="{{ $venta->telefonoComprador }}" class="form-control" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Notas Internas</label>
            @if(!isset($venta->notasInternas))
                <textarea class="form-control" name="notasInternas" id="summernote" rows="4" placeholder="Ingrese notas internas de la operación" >{{ old('notasInternas') }}</textarea>
            @else
                <textarea class="form-control" name="notasInternas" id="summernote" rows="4" placeholder="Ingrese notas internas de la operación" >{{ $venta->notasInternas }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label>Ejecutivo de venta</label>
            @if(!isset($venta->idUsuarioVendedor))
                <select name="idUsuarioVendedor" id="idUsuarioVendedor" class="form-control">
                    <option value="">Seleccione </option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                           {{ $usuario->name }} {{ $usuario->apellido }}
                        </option>
                    @endforeach
                </select>
            @else
                <select name="idUsuarioVendedor" id="idUsuarioVendedor" class="form-control">
                    <option value="">Seleccione </option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ ($usuario->id == $venta->idUsuarioVendedor) ? 'selected' :'' }}>
                            {{ $usuario->name }} {{ $usuario->apellido }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12">
            <center>
                <a href="/ventas" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                    <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
                </a>
                <button type="submit" class="btn btn-success waves-effect waves-light">
                    <i class="bx bx-list-plus font-size-16 align-middle mr-2"></i> Guardar
                </button>
            </center>
        </div>
    </div>
</div>

