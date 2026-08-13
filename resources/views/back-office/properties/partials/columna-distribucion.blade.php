@if($propiedad->habitacion > 0)<i class="bx bx-bed"></i> {{ $propiedad->habitacion }} @else <i class="bx bx-bed"></i> Estudio @endif -
    <i class="bx bx-bath"></i> {{ $propiedad->bano }}<br>
    @if($propiedad->estacionamiento)<i class="bx bx-car"></i> {{ $propiedad->estacionamiento }} - @endif
    @if($propiedad->bodega)<i class="bx bx-box"></i> {{ $propiedad->bodega }}@endif
