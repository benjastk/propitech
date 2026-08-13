@if($propiedad->idEstado == 42)
<span class="badge badge-success">{{ $propiedad->nombreEstado }}</span><br>
@elseif($propiedad->idEstado == 43)
<span class="badge badge-warning">{{ $propiedad->nombreEstado }}</span><br>
@elseif($propiedad->idEstado == 44)
<span class="badge badge-success">{{ $propiedad->nombreEstado }}</span><br>
@elseif($propiedad->idEstado == 45)
<span class="badge badge-info">{{ $propiedad->nombreEstado }}</span><br>
@elseif($propiedad->idEstado == 46)
<span class="badge badge-danger">{{ $propiedad->nombreEstado }}</span><br>
@else
<span class="badge badge-dark">{{ $propiedad->nombreEstado }}</span><br>
@endif
<span class="badge badge-soft-dark">{{ $propiedad->nombreNivelUsoPropiedad }}</span>
<br>
@if($propiedad->idTipoComercial == 1)
<span class="badge badge-info">VENTA</span>
@elseif($propiedad->idTipoComercial == 2)
<span class="badge badge-info">ARRIENDO</span>
@else
<span class="badge badge-info">SIN CATEGORIA</span>
@endif
