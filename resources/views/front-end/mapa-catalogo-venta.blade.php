@extends('front-end.layouts.app2')
@section('titulo')
<title>Propitech - Catalogo de propiedades en venta</title>
@endsection
@section('css')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
<style>
    .map_box_container{
        position: relative;
        height: 100% !important;
        width: 100% !important;
    }

    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 100%;
    }
    .mapboxgl-popup-content {
        padding: 0px !important;
    }
</style>
@endsection
@section('content')
<section class="position-relative" style="display: contents">
    <div class="container-fluid px-0" style="height: 100%; position: fixed; overflow-y: auto;">
        <div class="row no-gutters" style="height: 100%;">
            <div class="col-xl-5 order-1 order-xl-1" id="map-sticky">
                <div class="map_box_container">
                    <div id="map" clas="d-none d-lg-block d-md-block" style="height: 100% !important">
                    </div>
                    <div id="map1" class=".d-none .d-sm-block .d-md-none" style="height: 300px !important; position: relative: !important">
                    </div>
                </div>
            </div>
            <div class="col-xl-7 pt-7 pb-11 order-2 order-xl-2 px-3 px-xxl-8" style="overflow: scroll; height: 100%;">
                <div class="row align-items-sm-center mb-6">
                    <div class="col-md-4 col-xl-4 col-xxl-4">
                        <h3 class="text-dark mb-0" style="font-size: 24px">
                            Propiedades en Venta
                        </h3>
                    </div>
                    <div class="col-md-8 col-xl-8 col-xxl-8">
                        <form class="property-search position-relative d-none d-lg-block" action="{{ route('catalogo-propiedades')}}" method="post">
                            @csrf
                            <div class="row align-items-center ml-lg-0 py-lg-0 shadow-sm-2 rounded bg-white top-lg-n50px py-lg-0 py-6 px-3 z-index-1"
                                data-animate="fadeInDown" id="accordion-3" style="height: 30px !important">
                                <div class="col-md-6 col-lg-2" style="margin-right: 0px;padding-right: 0px;">
                                    <input type="radio" id="venta" name="tipoVenta" value="1" style="display:none">
                                    <label for="venta" id="botonVenta" style="float: right; padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-left-radius: 13px; border-bottom-left-radius: 13px;">Venta</label><br>
                                </div>
                                <div class="col-md-6 col-lg-2" style="margin-left: 0px;padding-left: 0px; padding-right: 5px; padding-left: 5px;">
                                    <input type="radio" id="arriendo" name="tipoVenta" value="2" style="display:none">
                                    <label for="arriendo" id="botonArriendo" style="padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-right-radius: 13px; border-bottom-right-radius: 13px;">Arriendo</label><br>
                                </div>
                                <div class="col-md-6 col-lg-3 order-1" style="padding-right: 5px; padding-left: 5px;">
                                    <select class="form-control" name="region" id="region">
                                        <option value="" >Región</option>
                                        @foreach($regiones as $region)
                                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-3 order-2" style="padding-right: 5px; padding-left: 5px;">
                                    <select class="form-control" name="comuna" id="comuna">
                                        <option value="" >Comuna</option>
                                        @foreach($comunas as $comuna)
                                            <option value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-lg-2 order-4" style="padding: 0px !important">
                                    <button type="submit" class="btn btn-primary shadow-none fs-16 font-weight-600 w-100 py-lg-3" style="padding-top: 0px !important; padding-bottom: 0px !important; width: 100% !important; margin: auto; background-color: #2db5ff !important">
                                        <i class="fal fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mx-lg-n2">
                @if(count($propiedadesEnVenta))
                @foreach($propiedadesEnVenta as $propiedadVenta)
                <div class="col-lg-4 col-sm-6 pb-6 px-lg-2" data-animate="fadeInUp" >
                    <div class="card border-0 hover-change-image" style="border: 2px solid #2db5ff !important; border-radius: 6px; padding: 0px !important; height: 100%;">
                        <div class="bg-overlay-gradient-1 bg-hover-overlay-gradient-3 rounded-lg card-img">
                            <img src="/img/propiedad/{{ $propiedadVenta->fotoPrincipal }}" style="height: 160px; width: 100%;"alt="Villa on Hollywood Boulevard">
                            <div class="card-img-overlay d-flex flex-column justify-content-between h-100">
                            <div>
                                <span class="badge badge-orange mr-2">Venta</span>
                            </div>
                            <ul class="list-inline mb-0 hover-image text-center">
                            </ul>
                            <ul class="list-inline d-flex mb-0 flex-wrap px-2 mr-n5">
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="{{ $propiedadVenta->habitacion }} Bedroom">
                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-bedroom"></use>
                                </svg>
                                {{ $propiedadVenta->habitacion }} Habitaciones
                                </li>
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="{{ $propiedadVenta->bano }} Bathrooms">
                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-shower"></use>
                                </svg>
                                {{ $propiedadVenta->bano }} Baños
                                </li>
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="Size">
                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-square"></use>
                                </svg>
                                {{ $propiedadVenta->mTotal }} MT
                                </li>
                            </ul>
                            </div>
                        </div>
                        <div class="card-body" style="adding-right: 17px !important; padding-left: 17px !important; padding-top: 0px !important; padding-bottom: 10px !important;">
                            <h2 class="my-0 mt-1"><a href="/propiedad-venta/{{ $propiedadVenta->id }}" class="fs-16 text-dark hover-primary lh-2">{{ $propiedadVenta->nombrePropiedad }}</a>
                            </h2>
                            <p class="text-gray-light font-weight-500 mb-1">{{ $propiedadVenta->direccion }} {{ $propiedadVenta->numero }}, {{ $propiedadVenta->nombreComuna }} </p>
                            <p class="fs-17 font-weight-bold text-heading mb-0">
                            UF {{ number_format($propiedadVenta->precio, 0, ",", ".") }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@section('jss')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-70.64827, -33.45694],
        zoom: 10
    });
    $('.mapboxgl-canvas').css('height', '100%');
    map.resize();
          
    @if(count($propiedadesEnVenta))
    @foreach($propiedadesEnVenta as $propiedadVenta)
        const popup{{ $propiedadVenta->id }} = new mapboxgl.Popup({ offset: 25 }).setHTML(
            `<div class="mappopupdiv">
                <div > 
                    <img src="/img/propiedad/{{ $propiedadVenta->fotoPrincipal }}" style="height: 160px; width: 100%;"alt="">
                </div>
                <div style="padding: 10px 10px 15px !important">
                    <div > 
                        <h6 style="font-family: 'Poppins', sans-serif;">{{ $propiedadVenta->direccion }} {{ $propiedadVenta->numero }}, {{ $propiedadVenta->nombreComuna }}</h6> 
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <svg class="icon icon-bedroom fs-18 text-primary mr-2">
                                <use xlink:href="#icon-bedroom"></use>
                            </svg>
                            {{ $propiedadVenta->habitacion }}
                        </div>
                        <div class="col-4">
                            <svg class="icon icon-shower fs-18 text-primary mr-2">
                                <use xlink:href="#icon-shower"></use>
                            </svg>
                            {{ $propiedadVenta->bano }}
                        </div>
                        <div class="col-4">
                            <svg class="icon icon-square fs-18 text-primary mr-2">
                                <use xlink:href="#icon-square"></use>
                            </svg>
                            {{ $propiedadVenta->mTotal }}
                        </div>
                    </div>
                    <div >
                        <h5 style="margin-bottom: 0px !important; text-align: right; margin-top: 7px; color: #096ba0 !important; font-weight: bolder; font-family: 'Poppins', sans-serif;">UF {{ number_format($propiedadVenta->precio, 0, ",", ".") }}</h5>
                    </div>
                </div>
            </div>`
        );
        var marker{{ $propiedadVenta->id }} = new mapboxgl.Marker({ color: '#2db5ff' })
        .setLngLat([{{ $propiedadVenta->longitud }}, {{ $propiedadVenta->latitud }}])
        .addTo(map)
        .setPopup(popup{{ $propiedadVenta->id }});
    @endforeach
    @endif
</script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
    var map = new mapboxgl.Map({
        container: 'map1',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-70.64827, -33.45694],
        zoom: 10
    });
    $('.mapboxgl-canvas').css('height', '100%');
    map.resize();
          
    @if(count($propiedadesEnVenta))
    @foreach($propiedadesEnVenta as $propiedadVenta)
        const popup{{ $propiedadVenta->id }} = new mapboxgl.Popup({ offset: 25 }).setHTML(
            `<div class="mappopupdiv">
                <div > 
                    <img src="/img/propiedad/{{ $propiedadVenta->fotoPrincipal }}" style="height: 160px; width: 100%;"alt="">
                </div>
                <div style="padding: 10px 10px 15px !important">
                    <div > 
                        <h6 style="font-family: 'Poppins', sans-serif;">{{ $propiedadVenta->direccion }} {{ $propiedadVenta->numero }}, {{ $propiedadVenta->nombreComuna }}</h6> 
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <svg class="icon icon-bedroom fs-18 text-primary mr-2">
                                <use xlink:href="#icon-bedroom"></use>
                            </svg>
                            {{ $propiedadVenta->habitacion }}
                        </div>
                        <div class="col-4">
                            <svg class="icon icon-shower fs-18 text-primary mr-2">
                                <use xlink:href="#icon-shower"></use>
                            </svg>
                            {{ $propiedadVenta->bano }}
                        </div>
                        <div class="col-4">
                            <svg class="icon icon-square fs-18 text-primary mr-2">
                                <use xlink:href="#icon-square"></use>
                            </svg>
                            {{ $propiedadVenta->mTotal }}
                        </div>
                    </div>
                    <div >
                        <h5 style="margin-bottom: 0px !important; text-align: right; margin-top: 7px; color: #096ba0 !important; font-weight: bolder; font-family: 'Poppins', sans-serif;">UF {{ number_format($propiedadVenta->precio, 0, ",", ".") }}</h5>
                    </div>
                </div>
            </div>`
        );
        var marker{{ $propiedadVenta->id }} = new mapboxgl.Marker({ color: '#2db5ff' })
        .setLngLat([{{ $propiedadVenta->longitud }}, {{ $propiedadVenta->latitud }}])
        .addTo(map)
        .setPopup(popup{{ $propiedadVenta->id }});
    @endforeach
    @endif
</script>
<script src="{{ asset('front/js/maps.js') }}"></script>
@endsection