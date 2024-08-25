<div class="card-body">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Fecha de pago</label>
            @if(!isset($reserva->fechaDePago))
                <input type="date" name="fechaDePago" id="fechaDePago" value="{{ old('fechaDePago') }}" class="form-control" required >
            @else
                <input type="date" name="fechaDePago" id="fechaDePago"class="form-control" value="{{ $reserva->fechaDePago }}" required>
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Valor Reserva</label>
            @if(!isset($reserva->valorReserva))
                <input type="number" name="valorReserva" value="{{old('valorReserva')}}" class="form-control" placeholder="Valor Reserva" required>
            @else
                <input type="number" name="valorReserva" value="{{ $reserva->valorReserva }}" class="form-control" placeholder="Valor Reserva" required>
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Estado</label>
            @if(!isset($reserva->idEstado))
                <select name="idEstado" class="form-control">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}">{{ $estado->nombreEstado }}</option>
                    @endforeach
                </select>
            @else
                <select name="idEstado" class="form-control">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $reserva->idEstado) ? 'selected' :'' }}>{{ $estado->nombreEstado }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Nombres</label>
            @if(!isset($reserva->nombre))
                <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" placeholder="Nombres" required >
            @else
                <input type="text" name="nombre" value="{{ $reserva->nombre }}" class="form-control" placeholder="Nombres" required >
            @endif
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label>Apellidos</label>
            @if(!isset($reserva->apellido))
                <input type="text" name="apellido" value="{{old('apellido')}}" class="form-control" placeholder="Apellidos" required >
            @else
                <input type="text" name="apellido" value="{{ $reserva->apellido }}" class="form-control" placeholder="Apellidos" required >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Rut</label>
            @if(!isset($reserva->rut))
                <input type="text" name="rut" value="{{old('rut')}}" class="form-control" placeholder="Rut" required >
            @else
                <input type="text" name="rut" value="{{ $reserva->rut }}" class="form-control" placeholder="Rut" required >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Correo Electronico</label>
            @if(!isset($reserva->apellido))
                <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Correo Electronico" required >
            @else
                <input type="text" name="email" value="{{ $reserva->email }}" class="form-control" placeholder="Correo Electronico" required >
            @endif
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label>Telefono</label>
            @if(!isset($reserva->telefono))
                <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" placeholder="Telefono" >
            @else
                <input type="text" name="telefono" value="{{ $reserva->telefono }}" class="form-control" placeholder="Telefono" >
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label>Propiedad</label>
            @if(!isset($reserva->idPropiedad))
                <select name="idPropiedad" id="idPropiedad" class="form-control">
                    <option value="">Seleccione propiedad si corresponde</option>
                    @foreach ($propiedades as $propiedad)
                        <option value="{{ $propiedad->id }}">
                            {{ $propiedad->id }} - {{ $propiedad->direccion }} {{ $propiedad->numero }}
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
                        <option value="{{ $propiedad->id }}" {{ ($propiedad->id == $reserva->idPropiedad) ? 'selected' :'' }}>
                            {{ $propiedad->id }} - {{ $propiedad->direccion }} {{ $propiedad->numero }}
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
            @if(!isset($reserva->direccion))
                <input type="text" name="direccion" id="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion" required >
            @else
                <input type="text" name="direccion" id="direccion" value="{{ $reserva->direccion }}" class="form-control" placeholder="Direccion" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Numero</label>
            @if(!isset($reserva->numero))
                <input type="text" name="numero" id="numero" value="{{old('numero')}}" class="form-control" placeholder="Numero" required >
            @else
                <input type="text" name="numero" id="numero" value="{{ $reserva->numero }}" class="form-control" placeholder="Numero" required >
            @endif
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
            <label>Block</label>
            @if(!isset($reserva->departamento))
                <input type="text" name="departamento" id="departamento" value="{{old('departamento')}}" class="form-control" placeholder="Block" >
            @else
                <input type="text" name="departamento" id="departamento" value="{{ $reserva->departamento }}" class="form-control" placeholder="Block" >
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
                        @if(!isset($reserva->idPais))
                            <option value="" >Pais</option>
                            @foreach($paises as $pais)
                            <option value="{{ $pais->idPais }}" {{ (Input::old("idPais") == $pais->idPais ? "selected":"") }} >{{ $pais->nombrePais }}</option>
                            @endforeach
                        @else
                            <option>Pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idPais }}" {{ ($pais->idPais == $reserva->idPais) ? 'selected' : ''}}>{{ $pais->nombrePais}}</option>
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
                    @if(!isset($reserva->idRegion))
                        <option value="" >Region</option>
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" >{{ $region->nombre}}</option>
                        @endforeach
                    @else
                        @foreach ($regiones as $region)
                            <option value="{{ $region->id }}" {{ ($region->id == $reserva->idRegion) ? 'selected' : ''}}>{{ $region->nombre}}</option>
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
                        @if(!isset($reserva->idProvincia))
                            <option value="" >Provincia</option>
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" >{{ $provincia->nombre}}</option>
                            @endforeach
                        @else
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}" {{ ($provincia->id == $reserva->idProvincia) ? 'selected' : ''}}>{{ $provincia->nombre}}</option>
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
                        @if(!isset($reserva->idComuna))
                            <option value="" >Comuna</option>
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" >{{ $comuna->nombre}}</option>
                            @endforeach
                        @else
                            @foreach ($comunas as $comuna)
                                <option value="{{ $comuna->id }}" {{ ($comuna->id == $reserva->idComuna) ? 'selected' : ''}}>{{ $comuna->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/reservas" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-list-plus font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        