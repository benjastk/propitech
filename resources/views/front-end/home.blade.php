@extends(($isCyber->valorParametro == 1 ? 'front-end.layouts.appCyber' : 'front-end.layouts.app' ))
@section('titulo')
<title>Propitech - Hacemos tu sueño realidad</title>
@endsection
@section('meta')
<meta name="description" content="Propitech, es una empresa dedicada al corretaje y a la administración de propiedades. Nuestra misión es ofrecerte la propiedad que buscas al momento de arrendar o vendar. También nos encargamos de administrar tu propiedad para que siempre esté segura.">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')

<style>
    .navbar-light .navbar-nav .nav-link {
        color: white !important;
    }
    .texto-triangulo {
        fill: white;
        font-size:12px;
        font-family:arial;
        letter-spacing:-1px;

    }
    .texto-descuento {
        fill: white;
        font-size:14px;
        font-family:arial;

    }
    /* fondo */
    .triangulo {
        fill: black;
        opacity:0.9;
    }
    /* css oferta */
    /* triángulo */
    .oferta-verde {
        fill:#2db5ff !important;
        /*opacity:0.9;*/

    }
    /* texto */
    .texto-oferta-verde {
        fill: white;
        font-size:14px;
    }
</style>
@endsection
@section('content')
@if($isCyber->valorParametro == 1)
<div class="slick-slider mx-0 custom-arrow-center" data-slick-options='{"slidesToShow": 1, "autoplay":true, "arrows": false, "dots": false, "infinite":true, "responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 992,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}}]}'>
    <div class="box px-0 d-flex flex-column">
        <section class="d-flex flex-column">
            <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(/front/011111.jpg)">
                <div class="container">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px !important">
                            <br>
                            <br>
                            <br>
                            <img src="/front/cyber.png" alt="" style="width: 100%; float: right; position: inherit;">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <h2 style="width: 90%; text-align: center; text-shadow: 0.1em 0.1em 0.2em black; color:white" >¡Ofertas especiales de hasta <br>el 50%  en el valor<br> de las propiedades!</h2>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <br>
                            <br>
                            <br>
                            <div class="card border-0 mxw-470 mr-md-0 my-lg-3" data-animate="fadeInDown">
                                <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                    <center><h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">¡Contáctanos!</h2></center>
                                    <br>
                                    <p class="card-text text-center">Encuentra tu nuevo hogar a un precio increíble en el Cyber Inmobiliario.</p>
                                    <form action="{{ route('formulario-contacto-propiedades')}}" method="post" >
                                    @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-2">
                                                <input type="text" class="form-control form-control-lg border-0 shadow-none" name="nombre" placeholder="Nombre" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="tel" class="form-control form-control-lg border-0 shadow-none" name="telefono" aria-label="Telefono" placeholder="Telefono" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <input type="email" class="form-control form-control-lg border-0 shadow-none" placeholder="Correo Electronico" name="email" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <!--<div class="col-md-12 mb-4">
                                                <textarea class="form-control form-control-lg border-0 shadow-none h-140" placeholder="How is your desired property?"></textarea>
                                            </div>-->
                                            <input type="hidden" class="" name="mensaje" value="mensaje desde campaña web cyberday - arriendos o ventas">
                                            <div class="col-md-12 mb-4">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none">Enviar</button>
                                            </div>
                                            <!--<div class="col-md-12 ml-6 custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check10-1" name="features">
                                                <label class="custom-control-label" for="check10-1">I consent to having this website store
                                                    my submitted information so they can respond to my inquiry.</label>
                                            </div>-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="box px-0 d-flex flex-column">
        <section class="d-flex flex-column">
            <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(/front/022222.jpg)">
                <div class="container">
                    <div class="row" style="width: 100%">
                        <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px !important">
                            <br>
                            <br>
                            <br>
                            <img src="/front/cyber.png" alt="" style="width: 100%; float: right; position: inherit; top: 30%">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <h2 style="width: 90%; text-align: center; text-shadow: 0.1em 0.1em 0.2em black; color:white; top: 18%; position: relative" >
                            ¡Simplifica tu trabajo con nuestro sistema de administración!</h2>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <br>
                            <br>
                            <br>
                            <div class="card border-0 mxw-470 mr-md-0 my-lg-3" data-animate="fadeInDown">
                                <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                    <center><h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">¡Contáctanos!</h2></center>
                                    <br>
                                    <p class="card-text text-center">¡Contáctanos y obten hasta 40% de descuento por Cyber Inmobiliario!</p>
                                    <form action="{{ route('formulario-contacto-propiedades')}}" method="post" >
                                    @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-2">
                                                <input type="text" class="form-control form-control-lg border-0 shadow-none" name="nombre" placeholder="Nombre" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <input type="tel" class="form-control form-control-lg border-0 shadow-none" name="telefono" aria-label="Telefono" placeholder="Telefono" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <input type="email" class="form-control form-control-lg border-0 shadow-none" placeholder="Correo Electronico" name="email" style="border: 1px solid #ffe7e7cc !important;">
                                            </div>
                                            <!--<div class="col-md-12 mb-4">
                                                <textarea class="form-control form-control-lg border-0 shadow-none h-140" placeholder="How is your desired property?"></textarea>
                                            </div>-->
                                            <input type="hidden" class="" name="mensaje" value="mensaje desde campaña web cyberday - administracion">
                                            <div class="col-md-12 mb-4">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none">Enviar</button>
                                            </div>
                                            <!--<div class="col-md-12 ml-6 custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check10-1" name="features">
                                                <label class="custom-control-label" for="check10-1">I consent to having this website store
                                                    my submitted information so they can respond to my inquiry.</label>
                                            </div>-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@else
<section>
    <div class="container">
    <form class="property-search position-relative d-none d-lg-block" action="{{ route('catalogo-propiedades')}}" method="post">
        @csrf
        <div class="row align-items-center ml-lg-0 py-lg-0 shadow-sm-2 rounded bg-white position-lg-absolute top-lg-n50px py-lg-0 py-6 px-3 z-index-1 w-md-100"
            data-animate="fadeInDown" id="accordion-3" style="height: 100px !important">
            <div class="col-md-6 col-lg-1" style="margin-right: 0px;padding-right: 0px;">
                <input type="radio" id="venta" name="tipoVenta" value="1" style="display:none">
                <label for="venta" id="botonVenta" style="float: right; padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-left-radius: 13px; border-bottom-left-radius: 13px;">Venta</label><br>
            </div>
            <div class="col-md-6 col-lg-1" style="margin-left: 0px;padding-left: 0px;">
                <input type="radio" id="arriendo" name="tipoVenta" value="2" style="display:none">
                <label for="arriendo" id="botonArriendo" style="padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-right-radius: 13px; border-bottom-right-radius: 13px;">Arriendo</label><br>
            </div>
            <div class="col-md-6 col-lg-3 order-1">
                <label class="text-uppercase font-weight-500 letter-spacing-093 mb-1">Región</label>
                <select class="form-control" name="region" id="region">
                    <option value="" >Seleccione región</option>
                    @foreach($regiones as $region)
                        <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-3 order-2">
                <label class="text-uppercase font-weight-500 letter-spacing-093">Comuna</label>
                <select class="form-control" name="comuna" id="comuna">
                    <option value="" >Seleccione comuna</option>
                    @foreach($comunas as $comuna)
                        <option value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2 order-3">
                <label class="text-uppercase font-weight-500 letter-spacing-093">Habitaciones</label>
                <select class="form-control" name="habitacion">
                    <option value="" >Habitaciones</option>
                    @foreach($habitaciones as $habitacion)
                        <option value="{{ $habitacion->habitacion }}">{{ $habitacion->habitacion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2 order-4" style="padding: 0px !important">
                <button type="submit" class="btn btn-primary shadow-none fs-16 font-weight-600 w-100 py-lg-3" style="padding-top: 0px !important; padding-bottom: 0px !important; width: 100% !important; margin: auto; background-color: #2db5ff !important">
                    Buscar
                </button>
            </div>
        </div>
    </form>
    <form class="property-search property-search-mobile d-lg-none py-6" action="{{ route('catalogo-propiedades')}}" method="post">
    @csrf
        <div class="row align-items-lg-center" id="accordion-3-mobile">
            <div class="col-6" style="margin-right: 0px;padding-right: 0px;">
                <input type="radio" id="venta1" name="tipoVenta" value="1" style="display:none">
                <label for="venta1" id="botonVenta1" style="float: right; padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-left-radius: 13px; border-bottom-left-radius: 13px;">Venta</label><br>
            </div>
            <div class="col-6" style="margin-left: 0px;padding-left: 0px;">
                <input type="radio" id="arriendo1" name="tipoVenta" value="2" style="display:none">
                <label for="arriendo1" id="botonArriendo1" style="padding: 8px; background-color: #2db5ff; width: 100%; text-align: center; color: white; border: 1px solid; border-top-right-radius: 13px; border-bottom-right-radius: 13px;">Arriendo</label><br>
            </div>
            <div class="col-12">
                <div class="form-group mb-0 position-relative">
                    <select class="form-control" data-style="p-0 h-24 lh-17 text-dark" name="region" id="regionMobile">
                        <option value="" >Seleccione región</option>
                        @foreach($regiones as $region)
                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <select class="form-control" data-style="p-0 h-24 lh-17 text-dark" name="comuna" id="comunaMobile">
                        <option value="" >Seleccione comuna</option>
                        @foreach($comunas as $comuna)
                            <option value="{{ $comuna->id }}">{{ $comuna->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <select class="form-control" data-style="p-0 h-24 lh-17 text-dark" name="habitacion">
                        <option value="" >Seleccione habitaciones</option>
                        @foreach($habitaciones as $habitacion)
                            <option value="{{ $habitacion->habitacion }}">{{ $habitacion->habitacion }}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="submit" class="btn btn-primary shadow-none fs-16 font-weight-600 w-100 py-lg-3" style="padding-top: 0px !important; padding-bottom: 0px !important; width: 70% !important; margin: auto; background-color: #2db5ff !important">
                        Buscar
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>
</section>
<section>
    <!--<div class="slick-slider mx-0" data-slick-options='{"slidesToShow": 1, "autoplay":true,"dots":false,"arrows":false}'>
        @if(count($propiedadesDestacadas))
        @foreach($propiedadesDestacadas as $destacada)
        
        <div class="box px-0 d-flex flex-column">
        <div class="bg-cover custom-vh-04 d-flex align-items-center" style="background-image: url('/img/propiedad/{{ $destacada->fotoPrincipal }}')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 offset-lg-7 col-md-6 offset-md-3 col-sm-8 offset-sm-2 mt-xl-1 py-8 pt-lg-12">
                            <div class="bg-white  px-7 pt-6 pb-4 rounded-lg ml-lg-n1 mb-xl-15" data-animate="flipInX">
                                <div class="mt-n7 position-absolute">
                                    @if($destacada->idTipoComercial == 2)
                                    <span class="badge badge-primary">Arriendo</span>
                                    @elseif($destacada->idTipoComercial == 1)
                                    <span class="badge badge-orange">Venta</span>
                                    @else
                                    @endif
                                </div>
                                @if($destacada->idTipoComercial == 2)
                                <h2 class="my-0"><a href="/propiedad-arriendo/{{ $destacada->id }}" class="fs-30 lh-12 text-dark hover-primary">{{ $destacada->nombrePropiedad }}</a></h2>
                                @else
                                <h2 class="my-0"><a href="/propiedad-venta/{{ $destacada->id }}" class="fs-30 lh-12 text-dark hover-primary">{{ $destacada->nombrePropiedad }}</a></h2>
                                @endif
                                <p class="my-3 font-weight-500 text-gray-light lh-15">{{ $destacada->direccion }} {{ $destacada->numero }}, {{ $destacada->nombreComuna }}, {{ $destacada->nombreRegion }}</p>
                                <p class="fs-14 font-weight-500 letter-spacing-087 text-primary text-uppercase lh-15 mb-1">
                                    For Sale</p>
                                @if($destacada->idTipoComercial == 2)
                                <p class="fs-22 font-weight-bold text-heading"s style="font-family: 'Gordita'; font-size: 30px ! important; color:grey !important;">$ {{ number_format($destacada->valorArriendo, 0, ",", ".") }}</p>
                                @elseif($destacada->idTipoComercial == 1)
                                <p class="fs-22 font-weight-bold text-heading" style="font-family: 'Gordita'; font-size: 30px ! important; color:grey !important;">UF {{ number_format($destacada->precio, 0, ",", ".") }}</p>
                                @else
                                @endif
                                <ul class="list-inline d-flex mb-0 flex-wrap border-top justify-content-between pt-4 mr-n2">
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" data-toggle="tooltip" title="Habitaciones">
                                    <svg class="icon icon-bedroom fs-18 text-primary mr-2">
                                        <use xlink:href="#icon-bedroom"></use>
                                    </svg>
                                    {{ $destacada->habitacion }} Habitaciones
                                    </li>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" data-toggle="tooltip" title="Baños">
                                    <svg class="icon icon-shower fs-18 text-primary mr-2">
                                        <use xlink:href="#icon-shower"></use>
                                    </svg>
                                    {{ $destacada->bano }} Baños
                                    </li>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2" data-toggle="tooltip" title="Metros">
                                    <svg class="icon icon-square fs-18 text-primary mr-2">
                                        <use xlink:href="#icon-square"></use>
                                    </svg>
                                    {{ $destacada->mTotal }} Mts. Totales
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>-->
    <img src="/front/frontNuevo.png">
</section>
@endif
<section class="pt-9 pb-9 pb-lg-11" style="padding-bottom: 0px !important;">
    <div class="container">
    <h2 class="text-center text-dark line-height-base">
        Propiedades en venta
    </h2>
    <span class="heading-divider mx-auto mb-7"></span>
        <div class="slick-slider custom-arrow-spacing-30"
            data-slick-options='{"slidesToShow": 3, "infinite":true, "autoplay":true,"dots":false,"responsive":[{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false,"autoplay":true}}]}'>
            @if(count($propiedadesEnVenta))
            @foreach($propiedadesEnVenta as $propiedad2)
            <div class="box">
                <div class="card cardPropiedades" data-animate="fadeInUp">
                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                        @if($propiedad2->valorCyber)
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
                        <img src="/img/propiedad/{{ $propiedad2->fotoPrincipal }}" alt="" style="height: 230px; width: 100%">
                    <div class="card-img-overlay p-2 d-flex flex-column">
                        <div class="mt-auto d-flex hover-image">
                        </div>
                    </div>
                    </div>
                    @if($propiedad2->valorCyber)
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3" style="padding-bottom: 4px !important; padding-top: 8px !important; border-bottom: 0px" >
                        <del style="color: grey !important" ><p class="fs-17 font-weight-bold text-heading mb-0 lh-1" style="color: grey !important" >UF {{ number_format($propiedad2->valorCyber, 0, ",", ".") }}</p></del>
                    </div>
                    @endif
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-1" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >UF {{ number_format($propiedad2->precio, 0, ",", ".") }}</p>
                        <span class="badge badge-primary">Venta</span>
                    </div>
                    <div class="card-body py-2">
                    <h2 class="fs-16 lh-2 mb-0">
                        <a href="/propiedad-venta/{{ $propiedad2->id }}"class="text-dark hover-primary">{{ $propiedad2->nombrePropiedad }}</a>
                    </h2>
                    <p class="font-weight-500 text-gray-light mb-0">{{ $propiedad2->direccion }} {{ $propiedad2->numero }}, {{ $propiedad2->nombreComuna }}</p>
                    </div>
                    <div class="card-footer bg-transparent pt-3 pb-4">
                    <ul class="list-inline d-flex justify-content-between mb-0 flex-wrap">
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="{{ $propiedad2->habitacion }} Habitaciones">
                        <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                            <use xlink:href="#icon-bedroom"></use>
                        </svg>
                        {{ $propiedad2->habitacion }}
                        </li>
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="{{ $propiedad2->bano }} Baños">
                        <svg class="icon icon-shower fs-18 text-primary mr-1">
                            <use xlink:href="#icon-shower"></use>
                        </svg>
                        {{ $propiedad2->bano }}
                        </li>
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Metros totales">
                        <svg class="icon icon-square fs-18 text-primary mr-1">
                            <use xlink:href="#icon-square"></use>
                        </svg>
                        {{ $propiedad2->mTotal }}
                        </li>
                        @if($propiedad2->usoGoceEstacionamiento == 1)
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Estacionamiento">
                        <svg class="icon icon-Garage fs-18 text-primary mr-1">
                            <use xlink:href="#icon-Garage"></use>
                        </svg>
                        1
                        </li>
                        @endif
                        @if($propiedad2->usoGoceBodega == 1)
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Bodega">
                        <svg class="icon icon-my-package fs-18 text-primary mr-1">
                            <use xlink:href="#icon-my-package"></use>
                        </svg>
                        1
                        </li>
                        @endif
                    </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<section class="bg-gray-02 pt-9 pb-9 pb-lg-11" style="padding-bottom: 0px !important;">
    <div class="container">
        <h2 class="text-center text-dark line-height-base">
            Propiedades en arriendo
        </h2>
        <span class="heading-divider mx-auto mb-7"></span>
        <div class="slick-slider custom-arrow-spacing-30"
            data-slick-options='{"slidesToShow": 3, "infinite":true, "autoplay":true,"dots":false,"responsive":[{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false,"autoplay":true}}]}'>
            @if(count($propiedadesEnArriendo))
            @foreach($propiedadesEnArriendo as $propiedad1)
            <div class="box">
                <div class="card cardPropiedades" data-animate="fadeInUp">
                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                        @if($propiedad1->valorCyber)
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
                        <img src="/img/propiedad/{{ $propiedad1->fotoPrincipal }}" alt="" style="height: 230px; width: 100%">
                    <div class="card-img-overlay p-2 d-flex flex-column">
                        <div class="mt-auto d-flex hover-image">
                        </div>
                    </div>
                    </div>
                    @if($propiedad1->valorCyber)
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3" style="padding-bottom: 4px !important; padding-top: 8px !important; border-bottom: 0px" >
                        <del style="color: grey !important" ><p class="fs-17 font-weight-bold text-heading mb-0 lh-1" style="color: grey !important" >$ {{ number_format($propiedad1->valorCyber, 0, ",", ".") }}</p></del>
                    </div>
                    @endif
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-1" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >$ {{ number_format($propiedad1->valorArriendo, 0, ",", ".") }}</p>
                        <span class="badge badge-primary">Arriendo</span>
                    </div>
                    <div class="card-body py-2">
                    <h2 class="fs-16 lh-2 mb-0">
                        <a href="/propiedad-arriendo/{{ $propiedad1->id }}"class="text-dark hover-primary">{{ $propiedad1->nombrePropiedad }}</a>
                    </h2>
                    <p class="font-weight-500 text-gray-light mb-0">{{ $propiedad1->direccion }} {{ $propiedad1->numero }}, {{ $propiedad1->nombreComuna }}</p>
                    </div>
                    <div class="card-footer bg-transparent pt-3 pb-4">
                    <ul class="list-inline d-flex justify-content-between mb-0 flex-wrap">
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="{{ $propiedad1->habitacion }} Habitaciones">
                        <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                            <use xlink:href="#icon-bedroom"></use>
                        </svg>
                        {{ $propiedad1->habitacion }}
                        </li>
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="{{ $propiedad1->bano }} Baños">
                        <svg class="icon icon-shower fs-18 text-primary mr-1">
                            <use xlink:href="#icon-shower"></use>
                        </svg>
                        {{ $propiedad1->bano }}
                        </li>
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Metros totales">
                        <svg class="icon icon-square fs-18 text-primary mr-1">
                            <use xlink:href="#icon-square"></use>
                        </svg>
                        {{ $propiedad1->mTotal }}
                        </li>
                        @if($propiedad1->usoGoceEstacionamiento == 1)
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Estacionamiento">
                        <svg class="icon icon-Garage fs-18 text-primary mr-1">
                            <use xlink:href="#icon-Garage"></use>
                        </svg>
                        1
                        </li>
                        @endif
                        @if($propiedad1->usoGoceBodega == 1)
                        <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-2"
                                    data-toggle="tooltip" title="Bodega">
                        <svg class="icon icon-my-package fs-18 text-primary mr-1">
                            <use xlink:href="#icon-my-package"></use>
                        </svg>
                        1
                        </li>
                        @endif
                    </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<section class="bg-single-image-03 pt-9">
    <div class="container">
        <h2 class="text-dark text-center mxw-751 px-md-8 lh-163">En propitech tenemos lo que necesitas</h2>
        <span class="heading-divider mx-auto"></span>
        <div class="row mt-7 mb-6 mb-lg-11">
            <div class="col-lg-6 mb-6 mb-lg-0">
                <a href="/catalogo-propiedades-venta">
                    <div class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100"
                            data-animate="fadeInUp">
                        <img src="front/images/group-16.png" class="mb-6 mb-sm-0 mr-sm-6">
                        <div class="media-body">
                            <h4 class="fs-20 lh-1625 text-secondary mb-1" style="font-family: FeltThat,sans-serif; font-size: 38px !important">Comprar una propiedad</h4>
                            <div class="position-relative d-flex align-items-center ml-2">
                            <span class="image text-primary position-absolute pos-fixed-left-center fs-16"><i class="fal fa-long-arrow-right"></i></span>
                            <span class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"><svg class="icon icon-long-arrow"><use xlink:href="#icon-long-arrow"></use></svg></span>
                            </div>
                        <p class="mb-0">
                            Revisa nuestra tienda y encuentra las mejores propiedades en venta.
                        </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mb-6 mb-lg-0">
                <a href="/catalogo-propiedades">
                <div class="media rounded-lg bg-white border border-hover shadow-xs-2 shadow-hover-lg-1 px-7 py-8 hover-change-image flex-column flex-sm-row h-100"
                        data-animate="fadeInUp">
                    <img src="front/images/group-17.png" class="mb-6 mb-sm-0 mr-sm-6">
                    <div class="media-body">
                        <h4 class="fs-20 lh-1625 text-secondary mb-1" style="font-family: FeltThat,sans-serif; font-size: 38px !important" >Arrendar una propiedad</h4>
                        <div class="position-relative d-flex align-items-center ml-2">
                        <span class="image text-primary position-absolute pos-fixed-left-center fs-16"><i class="fal fa-long-arrow-right"></i></span>
                        <span class="text-primary fs-42 lh-1 hover-image d-flex align-items-center"><svg class="icon icon-long-arrow"><use xlink:href="#icon-long-arrow"></use></svg></span>
                        </div>
                    
                    <p class="mb-0">
                        ¿Buscar arriendo? Tenemos los mejores precios del mercado.
                    </p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="bg-gray-02">
    <div class="container">
        <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600 mb-6">Planes</h1>
    </div>
    </section>
    <section>
        <div class="container">
            <h4 class="mb-2 fs-22 lh-15 text-heading">Te ofrecemos los mejores planes del mercado con la mejor administración</h4>
            <div class="row">
                @if($planes)
                @foreach($planes as $plan)
                <div class="col-xl-4 col-sm-12 mb-6">
                    <div class="card bg-gray-01 border-0 p-4 overflow-hidden" style="border: 2px solid #78ffe0 !important;">
                    <div class="card-header bg-transparent p-0">
                        <p class="fs-15 font-weight-bold text-heading mb-0">Plan</p>
                        <p class="fs-32 font-weight-bold text-heading lh-15 mb-1">{{ $plan->nombre }}</p>
                        <p class="fs-15 font-weight-bold text-heading mb-0" style="text-align:center">Comisión por administración:</p>
                        <p class="fs-32 font-weight-bold text-heading lh-15 mb-1" style="text-align: center;color: #0ca5b1 !important; font-size: 55px !important;">
                            {{ $plan->comisionAdministracion }} %
                            @if($plan->ivaAdministracion == 1)
                                <span style="font-size: 30px;"> + IVA</span>
                            @endif
                        </p>
                        <p class="fs-15 font-weight-bold text-heading mb-0" style="text-align:center">del valor arriendo mensual.</p>
                        @if($plan->destacado == 1)
                        <span class="fs-13 font-weight-500 text-white text-uppercase custom-packages">Popular</span>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled pt-2 mb-2" style="padding: 10px !important;">
                            @if($caracteristicasPlanes)
                            @foreach($caracteristicasPlanes as $todoLoQueHay)
                                @foreach($plan->caracteristicas as $loQueOfrece)
                                    @if($todoLoQueHay->idCaracteristica == $loQueOfrece->idCaracteristicaPlan)
                                    <li class="d-flex justify-content-between">
                                        <p class="text-gray-light mb-0"><i class="far fa-check" style="color:green" ></i> {{ $todoLoQueHay->nombreCaracteristica }}</p>
                                    </li>
                                    @endif
                                @endforeach
                            @endforeach
                            @endif
                        </ul>
                        <ul class="list-unstyled pt-2 mb-2" style="padding: 10px !important;" >
                            @if($caracteristicasPlanes)
                            @foreach($caracteristicasPlanes as $todoLoQueHayDos)
                                @foreach($plan->noCaracteristicas as $loQueNoOfrece)
                                    @if($todoLoQueHayDos->idCaracteristica == $loQueNoOfrece->idCaracteristica)
                                    <li class="d-flex justify-content-between">
                                        <p class="text-gray-light mb-0"><i class="far fa-times" style="color:red"></i> {{ $todoLoQueHayDos->nombreCaracteristica }}</p>
                                    </li>
                                    @endif
                                @endforeach
                            @endforeach
                            @endif
                        </ul>
                        <a href="/servicios-administracion-propiedades#formularioPlanes" class="btn btn-primary btn-block h-52 pl-4 pr-3 d-flex justify-content-between align-items-center">¡Lo quiero!
                        <i class="far fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="pt-11 pb-13">
        <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/5555.png); background-size: contain">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-12 pb-7 pb-lg-0">
                        <h2 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">INGRESA TUS DATOS Y ACCEDE A 3 MESES DE ADMINISTRACIÓN GRATIS</h2>
                        <br>
                        <form action="{{ route('formulario-contacto-propiedades')}}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Nombre" class="form-control form-control border-0" name="nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 px-2" style="padding-left: 15px !important">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Telefono" name="telefono" class="form-control form-control border-0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input placeholder="Correo electronico" class="form-control form-control border-0" type="email" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <textarea class="form-control border-0" placeholder="Mensaje" name="mensaje" rows="3"></textarea>
                                <input type="hidden" name="id_formulario" value="6">
                            </div>
                            <button type="submit" style="width: 100%; background-color: white; color: #0ec6d5; font-weight: 800;" class="btn btn btn-primary px-9">Enviar</button>
                        </form>
                    </div>
                    <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-10 pb-9">
        <div class="container">
        <p class="text-primary letter-spacing-263 text-uppercase lh-186 text-center mb-0">Noticias y articulos</p>
        <h2 class="text-center lh-1625 text-dark pb-1">
        Últimos artículos publicados
        </h2>
        <div class="mx-n2">
            <div class="slick-slider mt-6 mx-n1 slick-dots-mt-0" data-slick-options='{"slidesToShow": 3, "infinite":true, "autoplay":true,"arrows":true,"dots":false,"responsive":[{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true,"autoplay":true}}]}'>
                @if($noticias)
                @foreach($noticias as $noticia)
                <div class="item py-4" data-animate="fadeInUp">
                    <div class="card border-0 shadow-xxs-3" data-animate="fadeInUp" style="height: 100%;">
                    <div class="position-relative d-flex align-items-end card-img-top">
                        <a href="/blog/{{ $noticia->idNoticia }}" class="hover-shine">
                            <img src="/img/noticias/{{ $noticia->imagenNoticia }}" alt="" style="height: 240px !important; width: 100% !important">
                        </a>
                        <!--<a href="#" class="badge text-white bg-dark-opacity-04 fs-13 font-weight-500 bg-hover-primary hover-white mx-2 my-4 position-absolute pos-fixed-bottom">
                        Creative
                        </a>-->
                    </div>
                    <div class="card-body px-5 pt-3 pb-5">
                        <p class="mb-1 fs-13">{{ $noticia->fechaPublicacion }}</p>
                        <h3 class="fs-18 text-heading lh-194 mb-1">
                            <a href="/blog/{{ $noticia->idNoticia }}" class="text-heading hover-primary">{{ $noticia->titulo }}</a>
                        </h3>
                        <p class="mb-3">{{ $noticia->textoResumen }}</p>
                        <a class="text-heading font-weight-500" style="bottom: 15px;position: fixed;" href="/blog/{{ $noticia->idNoticia }}">Leer mas <i class="far fa-long-arrow-right text-primary ml-1"></i></a>
                    </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        </div>
    </section>
@endsection
@section('jss')
<script>
    $('.sliker').slick({
        slide: '.sloke',
        autoplay: true,
        dots: true,
        customPaging: function (slider, i) {
            //FYI just have a look at the object to find aviable information
            //press f12 to access the console
            //you could also debug or look in the source
            console.log(slider);
            return (i + 1) + '/' + slider.slideCount;
        }
    });
</script>


@endsection