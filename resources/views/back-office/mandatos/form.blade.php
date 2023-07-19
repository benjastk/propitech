<div class="card-body">
    <legend  class="w-auto">Datos del Contrato</legend>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Desde</label>
            @if(!isset($mandato->desde))
                <input type="date" name="desde" id="desde" value="{{ old('desde') }}" class="form-control" required >
            @else
                <input type="date" name="desde" id="desde"class="form-control" value="{{ $mandato->desde }}" readonly disabled>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Hasta</label>
            @if(!isset($mandato->hasta))
                <input type="date" name="hasta" id="hasta" value="{{ old('hasta') }}" class="form-control" required >
            @else
                <input type="date" name="hasta" id="hasta"class="form-control" value="{{$mandato->hasta}}" readonly disabled>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Duracion (meses)</label>
            @if(!isset($mandato->duracion))
                <input type="number" name="duracion" id="duracion" class="form-control" value="{{ old('duracion') }}" required>
            @else
                <input type="number" name="duracion" id="duracion"class="form-control" value="{{$mandato->duracion}}" readonly disabled>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Dia de Pago</label>
            <select class="form-control" id="diaPago" name="diaPago" required>
            @if(isset($mandato->diaPago))
                @if($mandato->diaPago == 5)
                    <option selected value="5">5</option>
                    <option value="10">10</option>
                @else
                    <option value="5">5</option>
                    <option selected value="10">10</option>
                @endif
            @else
                <option value="">Seleccione una opcion</option>
                <option @if(old('diaPago') == 1) selected @endif value="5">5</option>
                <option @if(old('diaPago') == 2) selected @endif value="10">10</option>
            @endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Estado Mandato</label>
            @if( !isset($mandato->idEstadoMandato))
                <select name="idEstadoMandato" class="form-control" required>
                    <option value="">Seleccione estado</option>
                    @foreach ($estadosContrato as $estadoContrato)
                        <option @if(old('idEstadoMandato') == $estadoContrato->idEstado) selected @endif value="{{ $estadoContrato->idEstado }}">{{ $estadoContrato->nombreEstado}}</option>
                    @endforeach
                </select>
            @else
                <select name="idEstadoMandato" class="form-control" required>
                    <option value="">Seleccione estado</option>
                    @foreach ($estadosContrato as $estadoContrato)
                        <option value="{{ $estadoContrato->idEstado }}" {{ ($mandato->idEstadoMandato == $estadoContrato->idEstado ) ? 'selected' :'' }}>{{ $estadoContrato->nombreEstado}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label>Plan de Administracion</label>
            @if( !isset($mandato->idPlan))
                <select name="idPlan" class="form-control" required>
                    <option value="">Seleccione plan</option>
                    @foreach ($planes as $plan)
                        <option @if(old('idPlan') == $plan->id) selected @endif value="{{ $plan->id }}">{{ $plan->nombre }} - Comision: {{ $plan->comisionAdministracion }}%</option>
                    @endforeach
                </select>
            @else
                <select name="idPlan" class="form-control" required>
                    <option value="">Seleccione plan</option>
                    @foreach ($planes as $plan)
                        <option value="{{ $plan->id }}" {{ ($mandato->idPlan == $plan->id ) ? 'selected' :'' }}>{{ $plan->nombre }} - Comision: {{ $plan->comisionAdministracion }}%</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-md-4" style="text-align:center; margin-top: 10px;">
            <label></label>
            <label></label>
            @if(!isset($mandato->seguroDeArriendo))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="seguroDeArriendo" type="checkbox" class="custom-control-input" id="customSwitch2" {{ (Input::old("seguroDeArriendo") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch2">Seguro de Arriendo</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="seguroDeArriendo" type="checkbox" class="custom-control-input" id="customSwitch2" {{ ( $mandato->seguroDeArriendo == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch2">Seguro de Arriendo</label>
                </div>
            @endif
        </div>
    </div>
    <legend  class="w-auto">Datos del Propietario</legend>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Rut</label>
            @if(!isset($mandato->rutPropietario))
                <input type="text" name="rutPropietario" id="rutPropietario" value="{{ old('rutPropietario') }}" class="form-control" required oninput="checkRut(this)" >
            @else
                <input type="text" name="rutPropietario" id="rutPropietario" class="form-control" value="{{$mandato->rutPropietario}}" required oninput="checkRut(this)">
            @endif
        </div>
        <div class="form-group col-md-4">
            <label>Nombre</label>
            @if(!isset($mandato->nombrePropietario))
                <input type="text" name="nombrePropietario" id="nombrePropietario" value="{{ old('nombrePropietario') }}" class="form-control" readonly>
            @else
                <input type="text" name="nombrePropietario" id="nombrePropietario" class="form-control" value="{{$mandato->nombrePropietario}}" readonly>
            @endif
        </div>
        <div class="form-group col-md-4">
            <label>Apellido</label>
            @if(!isset($mandato->apellidoPropietario))
                <input type="text" name="apellidoPropietario" id="apellidoPropietario" value="{{ old('apellidoPropietario') }}" class="form-control" readonly>
            @else
                <input type="text" name="apellidoPropietario" id="apellidoPropietario" class="form-control" value="{{$mandato->apellidoPropietario}}" readonly >
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Correo Electronico</label>
            @if(!isset($mandato->correoPropietario))
                <input type="text" name="correoPropietario" id="correoPropietario" value="{{ old('correoPropietario') }}" class="form-control" required readonly>
            @else
                <input type="text" name="correoPropietario" id="correoPropietario" class="form-control" value="{{$mandato->correoPropietario}}" required readonly >
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Estado Civil</label>
            @if(!isset( $mandato->estadoCivilPropietario))
                <input type="text" id="estadoCivilPropietario" name="estadoCivilPropietario" class="form-control  " value="{{ old('estadoCivilPropietario') }}" readonly >
            @else
                <input type="text" id="estadoCivilPropietario" name="estadoCivilPropietario" class="form-control  " value="{{ $mandato->estadoCivilPropietario }}" readonly >
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Nacionalidad</label>
            @if(!isset( $mandato->nacionalidadPropietario))
                <input type="text" id="nacionalidadPropietario" name="nacionalidadPropietario" class="form-control  " value="{{ old('nacionalidadPropietario') }}" readonly >
            @else
                <input type="text" id="nacionalidadPropietario" name="nacionalidadPropietario" class="form-control  " value="{{ $mandato->nacionalidadPropietario }}" readonly >
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Profesion</label>
            @if(!isset( $mandato->profesionPropietario))
                <input type="text" id="profesionPropietario" name="profesionPropietario" class="form-control" value="{{ old('profesionPropietario') }}" readonly>
            @else
                <input type="text" id="profesionPropietario" name="profesionPropietario" class="form-control" value="{{ $mandato->profesionPropietario }}" readonly >
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Direccion</label>
            @if(!isset( $mandato->direccionPropietario))
                <input type="text" id="direccionPropietario" name="direccionPropietario" class="form-control" value="{{ old('direccionPropietario') }}" readonly >
            @else
                <input type="text" id="direccionPropietario" name="direccionPropietario" class="form-control" value="{{ $mandato->direccionPropietario }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Comuna</label>
            @if(!isset( $mandato->comunaPropietario))
                <input type="text" id="comunaPropietario" name="comunaPropietario" class="form-control  " value="{{ old('comunaPropietario') }}" readonly >
            @else
                <input type="text" id="comunaPropietario" name="comunaPropietario" class="form-control  " value="{{ $mandato->comunaPropietario }}" readonly >
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Region</label>
            @if(!isset( $mandato->regionPropietario))
                <input type="text" id="regionPropietario" name="regionPropietario" class="form-control  " value="{{ old('regionPropietario') }}" readonly >
            @else
                <input type="text" id="regionPropietario" name="regionPropietario" class="form-control  " value="{{ $mandato->regionPropietario }}" readonly >
            @endif
        </div>
        <div class="form-group col-md-12">
            <label>Cuenta Bancaria</label>
            @if(!isset( $mandato->idUsuarioCuentaBancaria))
                <select class="form-control" name="cuentaBancaria" id="cuentaBancaria" required>
                    <option>Seleccione Cuenta Bancaria</option>
                </select>
            @else
                <select class="form-control" name="cuentaBancaria" id="cuentaBancaria" required>
                    @foreach ($usuariosCuentasBancarias as $usuarioCuentaBancaria)
                        <option value="{{ $usuarioCuentaBancaria->idUsuarioCuentaBancaria }}" {{ ($usuarioCuentaBancaria->idUsuarioCuentaBancaria == $mandato->idUsuarioCuentaBancaria) ? 'selected' : '' }}>{{ $usuarioCuentaBancaria->numeroCuenta }} {{ $usuarioCuentaBancaria->nombreBanco }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <legend  class="w-auto">Datos de la Propiedad</legend>
    <div class="row">
        <div class="form-group col-md-10">
            <label>Direccion Propiedad</label>
            @if(!isset( $mandato->direccionPropiedad))
                <input type="text" id="direccionPropiedad" name="direccionPropiedad" class="form-control  " value="{{ $propiedad->direccion }} {{ $propiedad->numero }}" readonly>
            @else
                <input type="text" id="direccionPropiedad" name="direccionPropiedad" class="form-control  " value="{{ $mandato->direccionPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-2">
            <label>Departamento</label>
            @if(!isset( $mandato->departamentoPropiedad))
                <input type="text" id="departamentoPropiedad" name="departamentoPropiedad" class="form-control  " value="{{ $propiedad->block }}" readonly>
            @else
                <input type="text" id="departamentoPropiedad" name="departamentoPropiedad" class="form-control  " value="{{ $mandato->departamentoPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Comuna</label>
            @if(!isset( $mandato->comunaPropiedad))
                <input type="text" id="comunaPropiedad" name="comunaPropiedad" class="form-control  " value="{{ $propiedad->nombreComuna}}" readonly>
            @else
                <input type="text" id="comunaPropiedad" name="ComunaPropiedad" class="form-control  " value="{{ $mandato->comunaPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Region</label>
            @if(!isset( $mandato->regionPropiedad))
                <input type="text" id="regionPropiedad" name="regionPropiedad" class="form-control  " value="{{ $propiedad->nombreRegion}}" readonly>
            @else
                <input type="text" id="regionPropiedad" name="regionPropiedad" class="form-control  " value="{{ $mandato->regionPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-3">
            <label>Rol</label>
            @if(!isset( $mandato->rolPropiedad))
                <input type="text" id="rolPropiedad" name="rolPropiedad" class="form-control  " value="{{ $propiedad->rolPropiedad}}" readonly >
            @else
                <input type="text" id="rolPropiedad" name="rolPropiedad" class="form-control  " value="{{ $mandato->rolPropiedad }}" readonly >
            @endif
            <input type="text" id="idPropiedad" name="idPropiedad" class="form-control" value="{{ $mandato->idPropiedad }}" readonly style="display:none">
        </div>
        <div class="form-group col-md-3">
            <label>Estado Propiedad</label>
            @if(!isset( $mandato->idPropiedad))
            <select name="idEstado" class="form-control" readonly>
                <option value="{{ $propiedad->idNivelUsoPropiedad }}" >{{ $propiedad->nombreNivelUsoPropiedad}}</option>
            </select>
            @else
            <select name="idEstado" class="form-control" readonly>
                <option value="{{ $propiedad->idNivelUsoPropiedad }}" >{{ $propiedad->nombreNivelUsoPropiedad}}</option>
            </select>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label>Corredor</label>
            @if( !isset($mandato->idCorredor))
                <select name="idCorredor" class="form-control">
                    @foreach ($usuarios as $usuario)
                        <option @if(old('idCorredor') == $usuario->idUsuario) selected @endif value="{{ $usuario->idUsuario }}">{{ $usuario->name}} {{ $usuario->apellido}}</option>
                    @endforeach
                </select>
            @else
                <select name="idCorredor" class="form-control">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->idUsuario }}" {{ ($usuario->idUsuario == $mandato->idCorredor) ? 'selected' :'' }}>{{ $usuario->name}} {{ $usuario->apellido}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-md-6" >
            <label>Fecha compromiso</label>
            @if(!isset($mandato->fechaCompromisoMandato))
                <input type="datetime-local" name="fechaCompromisoMandato" id="fechaCompromisoMandato" value="{{ old('fechaCompromisoMandato') }}" class="form-control" >
            @else
            <?php $date = new DateTime($mandato->fechaCompromisoMandato);
            $fecha = $date->format('Y').'-'.$date->format('m').'-'.$date->format('d').'T'.$date->format('H').':'.$date->format('i').':'.$date->format('s'); ?>
                <input type="datetime-local" name="fechaCompromisoMandato" id="fechaCompromisoMandato"class="form-control" value="{{$fecha}}" >
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/mandatos" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-receipt font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        