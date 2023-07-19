<div class="card-body">
    <div class="row">
        <div class="col-6">
            <label>Plan Activado</label>
            @if(!isset($plan->activo))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="activo" type="checkbox" class="custom-control-input" id="customSwitch7" {{ (Input::old("activo") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch7">Plan Activado</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="activo" type="checkbox" class="custom-control-input" id="customSwitch7" {{ ( $plan->activo == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch7">Plan Activado</label>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Nombre Plan</label>
            @if(!isset($plan->nombre))
                <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" placeholder="Nombre" required>
            @else
                <input type="text" name="nombre" value="{{ $plan->nombre }}" class="form-control" placeholder="Nombre" required>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <label>Comision Corretaje</label>
            @if(!isset($plan->comisionCorretaje))
                <input type="text" name="comisionCorretaje" value="{{old('comisionCorretaje')}}" class="form-control" placeholder="Comision Corretaje" required >
            @else
                <input type="text" name="comisionCorretaje" value="{{ $plan->comisionCorretaje }}" class="form-control" placeholder="Comision Corretaje" required >
            @endif
        </div>
        <div class="col-6">
            <label>IVA Corretaje</label>
            @if(!isset($plan->ivaCorretaje))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="ivaCorretaje" type="checkbox" class="custom-control-input" id="customSwitch4" {{ (Input::old("ivaCorretaje") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">IVA Corretaje</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="ivaCorretaje" type="checkbox" class="custom-control-input" id="customSwitch4" {{ ( $plan->ivaCorretaje == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch4">IVA Corretaje</label>
                </div>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <label>Comision de administración</label>
            @if(!isset($plan->comisionAdministracion))
                <input type="text" name="comisionAdministracion" value="{{old('comisionAdministracion')}}" class="form-control" placeholder="Comision Administracion" required >
            @else
                <input type="text" name="comisionAdministracion" value="{{ $plan->comisionAdministracion }}" class="form-control" placeholder="Comision Administracion" required >
            @endif
        </div>
        <div class="col-6">
            <label>IVA administración</label>
            @if(!isset($plan->ivaAdministracion))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="ivaAdministracion" type="checkbox" class="custom-control-input" id="customSwitch3" {{ (Input::old("ivaAdministracion") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch3">IVA Administración</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="ivaAdministracion" type="checkbox" class="custom-control-input" id="customSwitch3" {{ ( $plan->ivaAdministracion == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch3">IVA Administración</label>
                </div>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Elementos dentro del plan:</label>
            <br>
            @if(!isset($asignadas))
                @if($caracteristicas)
                @foreach($caracteristicas as $caracteristica)
                    <input type="checkbox" name="options[]" value="{{ $caracteristica->idCaracteristica }}"/> {{ $caracteristica->nombreCaracteristica }}<br/>
                @endforeach
                @endif
            @else
                @if($asignadas->isEmpty())
                    @foreach ($caracteristicas as $caracteristica)
                        <input type="checkbox" name="options[]" value="{{ $caracteristica->idCaracteristica }}"/> {{ $caracteristica->nombreCaracteristica }}<br/>
                    @endforeach
                @else
                    @foreach ($caracteristicas as $caracteristica)
                        @php($encontrado = false)
                            @foreach ($asignadas as $asignada)
                                @if($caracteristica->idCaracteristica == $asignada->idCaracteristicaPlan)
                                    @php($encontrado = true)
                                    <input type="checkbox" name="options[]" value="{{ $caracteristica->idCaracteristica }}" checked /> {{ $caracteristica->nombreCaracteristica }}<br/>        
                                    @break
                                @endif
                            @endforeach
                        @if($encontrado == false)
                        <input type="checkbox" name="options[]" value="{{ $caracteristica->idCaracteristica }}"/> {{ $caracteristica->nombreCaracteristica }}<br/>
                        @endif
                    @endforeach
                @endif
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6">
            <label>Destacado</label>
            @if(!isset($plan->destacado))
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="destacado" type="checkbox" class="custom-control-input" id="customSwitch5" {{ (Input::old("destacado") == 'on' ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch5">Destacar</label>
                </div>
            @else
                <div class="custom-control custom-switch mb-2" dir="ltr">
                    <input name="destacado" type="checkbox" class="custom-control-input" id="customSwitch5" {{ ( $plan->destacado == 1 ? "checked":"") }} >
                    <label class="custom-control-label" for="customSwitch5">Destacar</label>
                </div>
            @endif
        </div>
        <div class="col-6">
            
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/planes" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-list-plus font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        