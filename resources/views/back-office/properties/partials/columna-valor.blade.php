@if($propiedad->idTipoComercial == 2)
    <h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">${{ number_format($propiedad->valorArriendo, 0, ",", ".") }} </font></font></h5>
@elseif($propiedad->idTipoComercial == 1)
<h5><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">UF {{ number_format($propiedad->precio, 0, ",", ".") }} </font></font></h5>
@else
Sin Categorizacion
@endif
