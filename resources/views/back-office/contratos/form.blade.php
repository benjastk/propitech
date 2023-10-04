<div class="card-body">
    <legend  class="w-auto">Datos del Contrato</legend>
    <div class="row">
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Desde</label>
            @if(!isset($contrato->desde))
                <input type="date" name="desde" id="desde" value="{{ old('desde') }}" class="form-control" required >
            @else
                <input type="date" name="desde" id="desde"class="form-control" value="{{$contrato->desde}}" required>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Hasta</label>
            @if(!isset($contrato->hasta))
                <input type="date" name="hasta" id="hasta" value="{{ old('hasta') }}" class="form-control" required >
            @else
                <input type="date" name="hasta" id="hasta"class="form-control" value="{{$contrato->hasta}}" required>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Tipo contrato</label>
            @if( !isset($contrato->idTipoContrato))
                <select name="idTipoContrato" class="form-control">
                    @foreach ($tiposContratos as $tiposContrato)
                        <option value="{{ $tiposContrato->idTipoContrato }}">{{ $tiposContrato->descripcion}}</option>
                    @endforeach
                </select>
            @else
                <select name="idTipoContrato" class="form-control">
                    @foreach ($tiposContratos as $tiposContrato)
                        <option value="{{ $tiposContrato->idTipoContrato }}" {{ ($tiposContrato->idTipoContrato == $contrato->idTipoContrato) ? 'selected' :'' }}>{{ $tiposContrato->descripcion}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Estado</label>
            @if( !isset($contrato->idEstado))
                <select name="idEstado" class="form-control">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}">{{ $estado->nombreEstado }}</option>
                    @endforeach
                </select>
            @else
                <select name="idEstado" class="form-control">
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->idEstado }}" {{ ($estado->idEstado == $contrato->idEstado) ? 'selected' :'' }}>{{ $estado->nombreEstado }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Nombre contrato</label>
            @if(!isset($contrato->nombreContrato))
                <input type="text" name="nombreContrato" id="nombreContrato" value="{{ old('nombreContrato') }}" class="form-control" required >
            @else
                <input type="text" name="nombreContrato" id="nombreContrato"class="form-control" value="{{$contrato->nombreContrato}}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Maximo Habitantes</label>
            @if(!isset( $contrato->maximoHabitantes))
                <input type="number" id="maximoHabitantes" name="maximoHabitantes" class="form-control  " required>
            @else
                <input type="number" id="maximoHabitantes" name="maximoHabitantes" class="form-control  " value="{{ $contrato->maximoHabitantes }}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Dia de pago</label>
            <input type="number" name="diaPago" id="diaPago" value="{{ $diaPago->valorParametro }}" class="form-control" readonly >
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Tiempo contrato (Meses)</label>
            @if(!isset($contrato->hasta))
                <input type="number" name="tiempoContrato" id="tiempoContrato" value="{{ old('tiempoContrato') }}" class="form-control" required >
            @else
                <input type="number" name="tiempoContrato" id="tiempoContrato"class="form-control" value="{{$contrato->tiempoContrato}}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Notificar fin de contrato</label>
            @if(!isset($contrato->diaNotificacionFinContrato))
                <input type="number" name="diaNotificacionFinContrato" id="diaNotificacionFinContrato" value="{{ old('diaNotificacionFinContrato') }}" class="form-control" required >
            @else
                <input type="number" name="diaNotificacionFinContrato" id="diaNotificacionFinContrato"class="form-control" value="{{$contrato->diaNotificacionFinContrato}}" required>
            @endif
        </div>
    </div>
    <legend  class="w-auto">Datos del Arrendatario</legend>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Rut arrendatario</label>
            @if(!isset($contrato->rutArrendatario))
                <input type="text" name="rutArrendatario" id="rutArrendatario" value="{{ old('rut') }}" class="form-control" required>
            @else
                <input type="text" name="rutArrendatario" id="rutArrendatario" class="form-control" value="{{$contrato->rutArrendatario}}" required>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Nombre</label>
            @if(!isset($contrato->nombreArrendatario))
                <input type="text" name="nombreArrendatario" id="nombreArrendatario" value="{{ old('nombre') }}" class="form-control" readonly >
            @else
                <input type="text" name="nombreArrendatario" id="nombreArrendatario" class="form-control" value="{{$contrato->nombreArrendatario}}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Apellido</label>
            @if(!isset($contrato->apellidoArrendatario))
                <input type="text" name="apellidoArrendatario" id="apellidoArrendatario" value="{{ old('apellido') }}" class="form-control" readonly>
            @else
                <input type="text" name="apellidoArrendatario" id="apellidoArrendatario" class="form-control" value="{{$contrato->apellidoArrendatario}}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Correo Electronico</label>
            @if(!isset($contrato->correoArrendatario))
                <input type="text" name="correoArrendatario" id="correoArrendatario" value="{{ old('correo') }}" class="form-control" required readonly>
            @else
                <input type="text" name="correArrendatario" id="correoArrendatario" class="form-control" value="{{$contrato->correoArrendatario}}" required readonly >
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Telefono</label>
            @if(!isset( $contrato->numeroTelefonoArrendatario))
                <input type="text" id="numeroTelefonoArrendatario" name="numeroTelefonoArrendatario" class="form-control" readonly >
            @else
                <input type="text" id="numeroTelefonoArrendatario" name="numeroTelefonoArrendatario" class="form-control" value="{{ $contrato->numeroTelefonoArrendatario }}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Nacionalidad</label>
            @if(!isset( $contrato->nacionalidadArrendatario))
                <input type="text" id="nacionalidadArrendatario" name="nacionalidadArrendatario" class="form-control" readonly>
            @else
                <input type="text" id="nacionalidadArrendatario" name="nacionalidadArrendatario" class="form-control" value="{{ $contrato->nacionalidadArrendatario }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Estado Civil</label>
            @if(!isset( $contrato->estadoCivilArrendatario))
                <input type="text" id="estadoCivilArrendatario" name="estadoCivilArrendatario" class="form-control" readonly>
            @else
                <input type="text" id="estadoCivilArrendatario" name="estadoCivilArrendatario" class="form-control" value="{{ $contrato->estadoCivilArrendatario }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-12" style="display:none">
            <label>Propiedad</label>
            @if(!isset( $contrato->idPropiedad))
                <input type="text" id="idPropiedad" name="idPropiedad" class="form-control" value="{{ $propiedad->id }}" readonly>
            @else
                <input type="text" id="idPropiedad" name="idPropiedad" class="form-control" value="{{ $contrato->idPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Direccion Usuario</label>
            @if(!isset( $contrato->direccionArrendatario))
                <input type="text" id="direccionArrendatario" name="direccionArrendatario" class="form-control  " readonly>
            @else
                <input type="text" id="direccionArrendatario" name="direccionArrendatario" class="form-control  " value="{{ $contrato->direccionArrendatario }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Comuna</label>
            @if(!isset( $contrato->nombreComunaArrendatario))
                <input type="text" id="nombreComunaArrendatario" name="nombreComunaArrendatario" class="form-control  " readonly>
            @else
                <input type="text" id="nombreComunaArrendatario" name="nombreComunaArrendatario" class="form-control  " value="{{ $contrato->nombreComunaArrendatario }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Region</label>
            @if(!isset( $contrato->nombreRegionArrendatario))
                <input type="text" id="nombreRegionArrendatario" name="nombreRegionArrendatario" class="form-control  " readonly>
            @else
                <input type="text" id="nombreRegionArrendatario" name="nombreRegioArrendatario" class="form-control  " value="{{ $contrato->nombreRegioArrendatario}}" readonly>
            @endif
        </div>
    </div>
    <legend  class="w-auto">Datos del Propietario</legend>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Rut</label>
            @if(!isset($contrato->rutPropietario))
                <input type="text" name="rutPropietario" id="rutPropietario" value="{{ old('rut') }}" class="form-control" required>
            @else
                <input type="text" name="rutPropietario" id="rutPropietario" class="form-control" value="{{$contrato->rutPropietario}}" required>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Nombre</label>
            @if(!isset($contrato->nombrePropietario))
                <input type="text" name="nombrePropietario" id="nombrePropietario" value="{{ old('nombre') }}" class="form-control" readonly >
            @else
                <input type="text" name="nombrePropietario" id="nombrePropietario" class="form-control" value="{{$contrato->nombrePropietario}}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Apellido</label>
            @if(!isset($contrato->apellidoPropietario))
                <input type="text" name="apellidoPropietario" id="apellidoPropietario" value="{{ old('apellido') }}" class="form-control" readonly>
            @else
                <input type="text" name="apellidoPropietario" id="apellidoPropietario" class="form-control" value="{{$contrato->apellidoPropietario}}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Correo Electronico</label>
            @if(!isset($contrato->correoPropietario))
                <input type="text" name="correoPropietario" id="correoPropietario" value="{{ old('correo') }}" class="form-control" required readonly>
            @else
                <input type="text" name="correoPropietario" id="correoPropietario" class="form-control" value="{{$contrato->correoPropietario}}" required readonly >
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Direccion Usuario</label>
            @if(!isset( $contrato->direccionPropietario))
                <input type="text" id="direccionPropietario" name="direccionPropietario" class="form-control  " readonly>
            @else
                <input type="text" id="direccionPropietario" name="direccionPropietario" class="form-control  " value="{{ $contrato->direccionPropietario }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Telefono</label>
            @if(!isset( $contrato->numeroPropietario))
                <input type="text" id="numeroPropietario" name="numeroPropietario" class="form-control  " readonly >
            @else
                <input type="text" id="numeroPropietario" name="numeroPropietario" class="form-control  " value="{{ $contrato->numeroPropietario }}" readonly >
            @endif
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input name="codeudor" id="codeudor" class="form-check-input" type="checkbox">
            <strong><label class="form-check-label">¿ExisteCodeudor?</label></strong>
        </div>
    </div>
    <div id="formularioCodeudor" style="display: none" >
        <legend  class="w-auto">Datos del Codeudor</legend>
        <div class="row">
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Rut</label>
                @if(!isset($contrato->rutCodeudor))
                    <input type="text" name="rutCodeudor" id="rutCodeudor" value="{{ old('rut') }}" class="form-control" >
                @else
                    <input type="text" name="rutCodeudor" id="rutCodeudor" class="form-control" value="{{$contrato->rutCodeudor}}" >
                @endif
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Nombre</label>
                @if(!isset($contrato->nombreCodeudor))
                    <input type="text" name="nombreCodeudor" id="nombreCodeudor" value="{{ old('nombre') }}" class="form-control" readonly >
                @else
                    <input type="text" name="nombreCodeudor" id="nombreCodeudor" class="form-control" value="{{$contrato->nombreCodeudor}}" readonly >
                @endif
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Apellido</label>
                @if(!isset($contrato->apellidoCodeudor))
                    <input type="text" name="apellidoCodeudor" id="apellidoCodeudor" value="{{ old('apellido') }}" class="form-control" readonly >
                @else
                    <input type="text" name="apellidoCodeudor" id="apellidoCodeudor" class="form-control" value="{{$contrato->apellidoCodeudor}}" readonly >
                @endif
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Direccion</label>
                @if(!isset( $contrato->direccionCodeudor))
                    <input type="text" id="direccionCodeudor" name="direccionCodeudor" class="form-control  " readonly >
                @else
                    <input type="text" id="direccionCodeudor" name="direccionCodeudor" class="form-control  " value="{{ $contrato->direccionCodeudor }}" readonly >
                @endif
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Correo Electronico</label>
                @if(!isset($contrato->correoCodeudor))
                    <input type="text" name="correoCodeudor" id="correoCodeudor" value="{{ old('correo') }}" class="form-control" readonly  >
                @else
                    <input type="text" name="correoCodeudor" id="correoCodeudor" class="form-control" value="{{$contrato->correoCodeudor}}" readonly  >
                @endif
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                <label>Nacionalidad</label>
                @if(!isset( $contrato->nacionalidadCodeudor))
                    <input type="text" id="nacionalidadCodeudor" name="nacionalidadCodeudor" class="form-control  " readonly >
                @else
                    <input type="text" id="nacionalidadCodeudor" name="nacionalidadCodeudor" class="form-control  " value="{{ $contrato->nacionalidadCodeudor }}"  >
                @endif
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12">
                <label>Telefono</label>
                @if(!isset( $contrato->telefonoCodeudor))
                    <input type="text" id="telefonoCodeudor" name="telefonoCodeudor" class="form-control  " readonly >
                @else
                    <input type="text" id="telefonoCodeudor" name="telefonoCodeudor" class="form-control  " value="{{ $contrato->telefonoCodeudor }}" readonly >
                @endif
            </div>
        </div>
    </div>
    <legend  class="w-auto">Datos de la propiedad</legend>
    <div class="row">
        <div class="form-group col-lg-10 col-md-10 col-sm-12">
            <label>Direccion Propiedad</label>
            @if(!isset( $contrato->direccionPropiedad))
                <input type="text" id="direccionPropiedad" name="direccionPropiedad" class="form-control  " value="{{ $propiedad->direccion }} {{ $propiedad->numero }}" readonly>
            @else
                <input type="text" id="direccionPropiedad" name="direccionPropiedad" class="form-control  " value="{{ $contrato->direccionPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Departamento/Block</label>
            @if(!isset( $contrato->block))
                <input type="text" id="block" name="block" class="form-control" value="{{ $propiedad->block }}" readonly>
            @else
                <input type="text" id="block" name="block" class="form-control" value="{{ $contrato->block }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Comuna</label>
            @if(!isset( $contrato->nombreComunaPropiedad))
                <input type="text" id="nombreComunaPropiedad" name="nombreComunaPropiedad" class="form-control  " value="{{ $propiedad->nombreComuna}}" readonly>
            @else
                <input type="text" id="nombreComunaPropiedad" name="nombreComunaPropiedad" class="form-control  " value="{{ $contrato->nombreComunaPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Region</label>
            @if(!isset( $contrato->nombreRegionPropiedad))
                <input type="text" id="nombreRegionPropiedad" name="nombreRegionPropiedad" class="form-control  " value="{{ $propiedad->nombreRegion}}" readonly>
            @else
                <input type="text" id="nombreRegionPropiedad" name="nombreRegionPropiedad" class="form-control  " value="{{ $contrato->nombreRegionPropiedad }}" readonly>
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Rol</label>
            @if(!isset( $contrato->rolPropiedad))
                <input type="text" id="rolPropiedad" name="rolPropiedad" class="form-control  " value="{{ $propiedad->rolPropiedad}}" readonly >
            @else
                <input type="text" id="rolPropiedad" name="rolPropiedad" class="form-control  " value="{{ $contrato->rolPropiedad }}" readonly >
            @endif
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-12">
            <label>Moneda</label>
            @if( !isset($contrato->idMoneda))
                <select name="idMoneda" class="form-control">
                    @foreach ($tiposMonedas as $tipoMoneda)
                        <option value="{{ $tipoMoneda->idMoneda }}">{{ $tipoMoneda->nombreMoneda}}</option>
                    @endforeach
                </select>
            @else
                <select name="idMoneda" class="form-control">
                    @foreach ($tiposMonedas as $tipoMoneda)
                        <option value="{{ $tipoMoneda->idMoneda }}" {{ ($tipoMoneda->idMoneda == $contrato->idMoneda) ? 'selected' :'' }}>{{ $tipoMoneda->nombreMoneda}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Precio mensual</label>
            @if(!isset( $contrato->arriendoMensual))
                <input type="number" id="arriendoMensual" name="arriendoMensual" class="form-control" value="{{$propiedad->valorArriendo}}" readonly>
            @else
                <input type="number" id="arriendoMensual" name="arriendoMensual" class="form-control  " value="{{ $contrato->arriendoMensual }}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Cant. Garantias</label>
            @if(!isset( $contrato->cantidadGarantias))
                <input type="number" id="cantidadGarantias" name="cantidadGarantias" class="form-control" step="0.01">
            @else
                <input type="number" id="cantidadGarantias" name="cantidadGarantias" class="form-control " step="0.01" value="{{ $contrato->cantidadGarantias }}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Garantia</label>
            @if(!isset( $contrato->garantia))
                <input type="number" id="garantia" name="garantia" class="form-control  " required>
            @else
                <input type="number" id="garantia" name="garantia" class="form-control  " value="{{ $contrato->garantia }}" required>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Cuotas</label>
            @if( !isset($contrato->idTiempoPagoGarantia))
                <select name="idTiempoPagoGarantia" class="form-control">
                    @foreach ($tiemposPagosGarantias as $tiemposPagosGarantia)
                        <option value="{{ $tiemposPagosGarantia->idTiempoPagoGarantia }}">{{ $tiemposPagosGarantia->nombreTiempoPagoGaranti}}</option>
                    @endforeach
                </select>
            @else
                <select name="idTiempoPagoGarantia" class="form-control">
                    @foreach ($tiemposPagosGarantias as $tiemposPagosGarantia)
                        <option value="{{ $tiemposPagosGarantia->idTiempoPagoGarantia }}" {{ ($tiemposPagosGarantia->idTiempoPagoGarantia == $contrato->idTiempoPagoGarantia) ? 'selected' :'' }}>{{ $tiemposPagosGarantia->nombreTiempoPagoGaranti}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Tipo de Reajuste</label>
            <select name="idTipoReajuste" id="elegirReajuste" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="1">Porcentaje</option>
                <option value="2">Pesos</option>
            </select>
        </div>
        <div id="antesDeReajuste" class="form-group col-lg-2 col-md-2 col-sm-12">
            <label>Elegir reajuste</label>
            <input type="number" id="antesDeReajuste" name="antesDeReajuste" class="form-control" readonly>
        </div>
        <div id="reajustePesos" class="form-group col-lg-2 col-md-2 col-sm-12" style="display:none">
            <label>Reajuste en pesos</label>
            @if(!isset( $contrato->reajuste))
                <input type="number" id="reajuste" name="reajustePesos" class="form-control" >
            @else
                <input type="number" id="reajuste" name="reajustePesos" class="form-control" value="{{ $contrato->reajustePesos }}">
            @endif
        </div>
        <div id="reajustePorcentaje" class="form-group col-lg-2 col-md-2 col-sm-12" style="display:none">
            <label>Reajuste en porcentaje</label>
            @if(!isset( $contrato->reajuste))
                <input type="number" id="reajuste" name="reajuste" class="form-control" value="{{ $reajuste->valorParametro }}" readonly>
            @else
                <input type="number" id="reajuste" name="reajuste" class="form-control" value="{{ $contrato->reajuste }}" readonly>
            @endif
        </div>
        <div class="form-group col-md-12">
            <label>Notas internas</label>
            @if(!isset( $contrato->nota))
                <textarea class="form-control" id="nota" name="nota" rows="2" placeholder="Nota"></textarea>
            @else
                <textarea class="form-control" id="nota" name="nota" rows="2" placeholder="Nota"> {{ $contrato->nota }} </textarea>
            @endif
        </div>
        <br>
        <div class="col-12">
            <label>Prohibiciones</label>
            @if(!isset($propiedad->prohibiciones))
                <textarea class="form-control" name="prohibiciones" rows="2" placeholder="Prohibiciones" >{{ old('prohibiciones') }}</textarea>
            @else
                <textarea class="form-control" name="prohibiciones" rows="2" placeholder="Prohibiciones" >{{ $contrato->prohibiciones }}</textarea>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            <label>Corredor</label>
            @if( !isset($contrato->idCorredor))
                <select name="idCorredor" class="form-control">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->apellido}}</option>
                    @endforeach
                </select>
            @else
                <select name="idCorredor" class="form-control">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ ($usuario->id == $contrato->idCorredor) ? 'selected' :'' }}>{{ $usuario->name}} {{ $usuario->apellido}}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12" >
            <label>Estado Propiedad</label>
            @if(!isset( $contrato->idPropiedad))
            <select name="idEstadoPropiedad" class="form-control" readonly>
                <option value="{{ $propiedad->idNivelUsoPropiedad }}" >{{ $propiedad->nombreNivelUsoPropiedad}}</option>
            </select>
            @else
            <select name="idEstadoPropiedad" class="form-control" readonly>
                <option value="{{ $propiedad->idNivelUsoPropiedad }}" >{{ $propiedad->nombreNivelUsoPropiedad}}</option>
            </select>
            @endif
        </div>
        <div class="col-4" style="text-align:center">
            @if(!isset($contrato->renovacionAutomatica))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="renovacionAutomatica" type="checkbox" class="custom-control-input" id="customSwitch4" {{ (Input::old("renovacionAutomatica") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Renovación Automatica</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="renovacionAutomatica" type="checkbox" class="custom-control-input" id="customSwitch4" {{ ( $contrato->renovacionAutomatica == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">Renovación Automatica</label>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/contratos" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-receipt font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        