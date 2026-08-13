<h5 class="text-truncate font-size-14" style="white-space: normal !important;"><a href="#" class="text-dark">{{ $propiedad->tituloExtendido }}</a>
    <br>
    <span class="badge badge-soft-primary">{{ $propiedad->nombreTipoPropiedad}}</span>

</h5>
@if($propiedad->idDestacado == 1)
    <span class="badge badge-success" style="color:black; background-color: yellow"><i class="mdi mdi-star mr-1"></i>Destacado</span>
@endif
@if($propiedad->urlPortalInmobiliario)
    <span class="badge badge-info" style="color:black;"><i class="mdi mdi-star mr-1"></i>Portal Inmobiliario</span>
@endif
@if($propiedad->esBuyDepa == 1)
    <span class="badge badge-primary" style="color:white; background-color: blue"><i class="mdi mdi-star mr-1"></i>BuyDepa</span>
@endif
<p class="text-muted mb-0 text-truncate" style="max-width: 380px;">{{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }}</p>
@if($propiedad->idExterno)
    ID Ext: {{ $propiedad->idExterno }} -
@endif
    DEPARTAMENTO: {{ $propiedad->block }}
