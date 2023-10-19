@extends('front-end.layouts.app2')
@section('titulo')
<title>Propitech - Catalogo de propiedades en arriendo</title>
@endsection
@section('meta')
<meta name="description" content="Propiedades en arriendo">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
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
    .gm-style-iw
    {
        padding: 0px !important;
    }
    .gm-style-iw-d
    {
        overflow: initial !important;
        padding: 0px !important;
        width: 100% !important;
    }
</style>
@endsection
@section('content')
<section class="position-relative" style="display: contents">
    <div class="container-fluid px-0" style="height: 100%; position: fixed; overflow-y: auto;">
        <div class="row no-gutters" style="height: 100%;">
            <div class="col-xl-5 order-1 order-xl-1" id="map-sticky">
                <div class="map_box_container">
                    <div clas="d-block d-sm-none">
                        <div id="map" style="height: 100% !important">
                        </div>
                    </div>
                    <div class="d-block" >
                        <div id="map1" style="height: 300px; position: relative: !important">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 pt-7 pb-11 order-2 order-xl-2 px-3 px-xxl-8" style="overflow: scroll; height: 100%;">
            <div class="row align-items-sm-center mb-6">
                    <div class="col-md-4 col-xl-4 col-xxl-4">
                        <h3 class="text-dark mb-0" style="font-size: 24px">
                            Propiedades en Arriendo
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
                @if($propiedadesEnArriendo)
                @foreach($propiedadesEnArriendo as $propiedadArriendo)
                <div class="col-lg-4 col-sm-6 pb-6 px-lg-2" >
                    <div class="card border-0 hover-change-image cardPropiedades" style="border: 2px solid #2db5ff !important; border-radius: 6px; padding: 0px !important; height: 100%;">
                        <div class="bg-overlay-gradient-1 bg-hover-overlay-gradient-3 rounded-lg card-img">
                            @if($propiedadArriendo->valorCyber)
                            <div style="position: absolute; width: 100%">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" style="float: right" >
                                    <g>
                                        <path fill-rule="evenodd" clip-rule="evenodd" class="oferta-verde" d="M0,0h41.4L100,58.6V100L0,0z"/>
                                        <text x="20" y="38" transform="rotate(45 48 48)" class="texto-oferta-verde">OFERTA</text>  
                                    </g>
                                    <g>  
                                        <path fill-rule="evenodd" clip-rule="evenodd" class="triangulo" d="M100,0v59L41,0H100z"/>
                                        <text x="30" y="11" transform="rotate(45 48 48)" class="texto-triangulo">CYBER</text>
                                        <!--<text x="57" y="11" transform="rotate(45 48 48)" class="texto-descuento">%</text>-->
                                    </g>
                                </svg>
                            </div>
                            @endif
                            <img src="/img/propiedad/{{ $propiedadArriendo->fotoPrincipal }}" style="height: 160px; width: 100%;"alt="">
                            <div class="card-img-overlay d-flex flex-column justify-content-between h-100">
                            <div>
                                <span class="badge badge-orange mr-2">Arriendo</span>
                            </div>
                            <ul class="list-inline mb-0 hover-image text-center">
                            </ul>
                            <ul class="list-inline d-flex mb-0 flex-wrap px-2 mr-n5">
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="{{ $propiedadArriendo->habitacion }} Habitacion">
                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-bedroom"></use>
                                </svg>
                                {{ $propiedadArriendo->habitacion }} Habitaciones
                                </li>
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="{{ $propiedadArriendo->bano }} Baños">
                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-shower"></use>
                                </svg>
                                {{ $propiedadArriendo->bano }} Baños
                                </li>
                                <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5"
                                                data-toggle="tooltip" title="Tamaño">
                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-square"></use>
                                </svg>
                                {{ $propiedadArriendo->mTotal }} MT
                                </li>
                            </ul>
                            </div>
                        </div>
                        <div class="card-body" style="adding-right: 17px !important; padding-left: 17px !important; padding-top: 0px !important; padding-bottom: 10px !important;">
                            <h2 class="my-0 mt-1"><a href="/propiedad-arriendo/{{ $propiedadArriendo->id }}" class="fs-16 text-dark hover-primary lh-2">{{ $propiedadArriendo->nombrePropiedad }}</a>
                            </h2>
                            <p class="text-gray-light font-weight-500 mb-1">{{ $propiedadArriendo->direccion }} {{ $propiedadArriendo->numero }}, {{ $propiedadArriendo->nombreComuna }} </p>
                            @if($propiedadArriendo->valorCyber)
                            <del style="color: grey !important" ><p class="fs-17 font-weight-bold text-heading mb-0 lh-1" style="color: grey !important" >
                                $ {{ number_format($propiedadArriendo->valorCyber, 0, ",", ".") }}
                            </p></del>
                            @endif
                            <p class="fs-17 font-weight-bold text-heading mb-0" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;">
                            $ {{ number_format($propiedadArriendo->valorArriendo, 0, ",", ".") }}
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I&callback=initMap" async defer></script>
<script>
    var map;
    var str = String({{ $coordenada }});
    var str_array = str.split(',');
    var lat = parseFloat(str_array[1]);
    var lng = parseFloat(str_array[0]);
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lng, lat },
            zoom: 14,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        });
        @if($propiedadesEnArriendo)
        @foreach($propiedadesEnArriendo as $propiedadArriendo)
            var contentString = 
                `<div class="mappopupdiv" style="width: 100%">
                    <div > 
                        <img src="/img/propiedad/{{ $propiedadArriendo->fotoPrincipal }}" style="height: 160px; width: 100%;"alt="">
                    </div>
                    <div style="padding: 10px 10px 15px !important">
                        <div > 
                            <h6 style="font-family: 'Poppins', sans-serif;">{{ $propiedadArriendo->direccion }} {{ $propiedadArriendo->numero }}, {{ $propiedadArriendo->nombreComuna }}</h6> 
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <svg class="icon icon-bedroom fs-18 text-primary mr-2">
                                    <use xlink:href="#icon-bedroom"></use>
                                </svg>
                                {{ $propiedadArriendo->habitacion }}
                            </div>
                            <div class="col-4">
                                <svg class="icon icon-shower fs-18 text-primary mr-2">
                                    <use xlink:href="#icon-shower"></use>
                                </svg>
                                {{ $propiedadArriendo->bano }}
                            </div>
                            <div class="col-4">
                                <svg class="icon icon-square fs-18 text-primary mr-2">
                                    <use xlink:href="#icon-square"></use>
                                </svg>
                                {{ $propiedadArriendo->mTotal }}
                            </div>
                        </div>
                        <div >
                            <h5 style="margin-bottom: 0px !important; text-align: right; margin-top: 7px; color: #096ba0 !important; font-weight: bolder; font-family: 'Gordita', sans-serif;">$ {{ number_format($propiedadArriendo->valorArriendo, 0, ",", ".") }}</h5>
                        </div>
                    </div>
                </div>`;
            var infowindow{{ $propiedadArriendo->id }} = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 250
            });
            var myLatlng{{ $propiedadArriendo->id }} = new google.maps.LatLng( {{ $propiedadArriendo->latitud }}, {{ $propiedadArriendo->longitud }});
            var marker{{ $propiedadArriendo->id }} = new google.maps.Marker({
                position: myLatlng{{ $propiedadArriendo->id }},
                icon: {url:'/front/marker.png', scaledSize: new google.maps.Size(50, 70)}
            });
            marker{{ $propiedadArriendo->id }}.addListener("click", () => {
                infowindow{{ $propiedadArriendo->id }}.open({
                    anchor: marker{{ $propiedadArriendo->id }},
                    map,
                });
            });
            marker{{ $propiedadArriendo->id }}.setMap(map);
        @endforeach
        @endif
    }
</script>
@endsection