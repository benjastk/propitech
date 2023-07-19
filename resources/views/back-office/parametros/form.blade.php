<div class="card-body">
    <div class="row">
        <div class="col-12">
            <label>Nombre Parametro</label>
            @if(!isset($parametroGeneral->parametroGeneral))
                <input type="text" name="parametroGeneral" value="{{old('parametroGeneral')}}" class="form-control" placeholder="Parametro General" readonly>
            @else
                <input type="text" name="parametroGeneral" value="{{ $parametroGeneral->parametroGeneral }}" class="form-control" placeholder="Parametro General" readonly>
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Valor Parametro</label>
            @if(!isset($parametroGeneral->valorParametro))
                <input type="text" name="valorParametro" value="{{old('valorParametro')}}" class="form-control" placeholder="Valor Parametro">
            @else
                <input type="text" name="valorParametro" value="{{ $parametroGeneral->valorParametro }}" class="form-control" placeholder="Valor Parametro">
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Texto Valor Parametro</label>
            @if(!isset($parametroGeneral->textoValorParametro))
                <input type="text" name="textoValorParametro" value="{{old('textoValorParametro')}}" class="form-control" placeholder="Texto Valor Parametro">
            @else
                <input type="text" name="textoValorParametro" value="{{ $parametroGeneral->textoValorParametro }}" class="form-control" placeholder="Texto Valor Parametro">
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <label>Notas Parametro</label>
            @if(!isset($parametroGeneral->notas))
                <input type="text" name="notas" value="{{old('notas')}}" class="form-control" placeholder="Nota Parametro">
            @else
                <input type="text" name="notas" value="{{ $parametroGeneral->notas }}" class="form-control" placeholder="Nota Parametro">
            @endif
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12" style="text-align:center">
            <a href="/parametros" class="btn btn-danger waves-effect waves-light" style="margin-right: 10px">
                <i class="bx bx-arrow-back font-size-16 align-middle mr-2"></i> Volver
            </a>
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="bx bx-wrench font-size-16 align-middle mr-2"></i> Guardar
            </button>
        </div>
    </div>
</div>
            
        