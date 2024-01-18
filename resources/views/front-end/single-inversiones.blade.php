@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech Inversiones - Proyecto {{ $proyecto->nombreProyecto }} - {{ $proyecto->nombreComuna }} </title>
@endsection
@section('meta')
<meta name="description" content="{{ $proyecto->direccion }} {{ $proyecto->nombreComuna }}, {{ $proyecto->nombreRegion }} - Invierte en propiedades">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
<style>
    .slick-prev:before {
        content: "<";
        color: #00a8ff;
        font-size: 30px;
    }

    .slick-next:before {
        content: ">";
        color: #00a8ff;
        font-size: 30px;
    }
    .fa-angle-right:before {
        content: "" !important;
    }
    .fa-angle-left:before {
        content: "" !important;
    }
</style>
@endsection
@section('content')
<main id="content">
    <div class="primary-content bg-gray-01">
        <div class="row pt-5" style="background-color: #2db5ff26 !important; margin: 0px !important">
            <article class="col-lg-12" style="max-width: 1200px; margin: auto;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="d-md-flex justify-content-md-between mb-1">
                            <ul class="list-inline d-sm-flex align-items-sm-center mb-0">
                                @if($proyecto->entregaInmediata)<li class="list-inline-item badge badge-orange mr-2">ENTREGA INMEDIATA</li>@endif
                                <li class="list-inline-item badge badge-primary mr-3">VENTA</li>
                            </ul>
                        </div>
                        <div class="d-md-flex justify-content-md-between">
                            <div>
                                <h2 class="fs-35 font-weight-600 lh-15 text-heading" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important">Proyecto {{ $proyecto->nombreProyecto }}</h2>
                                <p class="mb-0"><i class="fal fa-map-marker-alt mr-2"></i>{{ $proyecto->direccion }} {{ $proyecto->numero}}, {{ $proyecto->nombreComuna }}, 
                                            @if($proyecto->idRegion == 13)
                                            Región {{ $proyecto->nombreRegion }}
                                            @else
                                            Región de {{ $proyecto->nombreRegion }}
                                            @endif</p>
                            </div>
                            <div class="mt-2 text-md-right">
                                <p class="fs-22 text-heading font-weight-bold mb-0" style="line-height: normal">DESDE</p>
                                <p class="text-heading font-weight-bold mb-0" style="font-family: 'Gordita'; font-size: 30px">{{ number_format($proyecto->valorUFDesde, 0, ",", ".") }} UF</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <section class="shadow-5">
        <div class="container">
            <div class="galleries position-relative">
                <div class="tab-content p-0 shadow-none">
                    <div class="tab-pane fade show active" id="image" role="tabpanel">
                        <div>
                            <div class="box">
                                <div class="item item-size-3-2">
                                    <div class="card p-0">
                                        <a href="#" class="card-img" style="background-image:url('/img/proyecto/{{ $proyecto->fotoProyecto}}')">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="primary-content bg-gray-01 pb-7">
        <div class="row" style="background-color: #2db5ff26 !important; margin: 0px !important">
            <article class="col-lg-12" style="max-width: 1200px; margin: auto;">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <section class="pb-8 px-6 pt-5 rounded-lg">
                            <h4 class="fs-22 text-heading mb-2" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important">Acerca del Proyecto</h4>
                            <p class="mb-0 lh-214">{!! $proyecto->descripcion !!}</p>
                        </section>
                        <section class="mt-2 pb-3 px-6 pt-5 rounded-lg">
                            <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important">Características Principales</h4>
                            <div class="row">
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-family fs-32 text-primary">
                                                <use xlink:href="#icon-family"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Tipo</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $proyecto->nombreTipoPropiedad }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-heating fs-32 text-primary">
                                                <use xlink:href="#icon-building"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Cantidad Dptos.</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $proyecto->cantidadDepartamentos }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-price fs-32 text-primary">
                                                <use xlink:href="#icon-price"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Tamaños</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">Desde {{ $proyecto->metrosDesde }} a {{ $proyecto->metrosHasta }} MTS2</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-bedroom fs-32 text-primary">
                                                <use xlink:href="#icon-bedroom"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Habitaciones</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $proyecto->dormitoriosDesde }} / {{ $proyecto->dormitoriosHasta}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-sofa fs-32 text-primary">
                                                <use xlink:href="#icon-shower"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Baños</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $proyecto->baniosDesde }} / {{ $proyecto->baniosHasta }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-status fs-32 text-primary">
                                                <use xlink:href="#icon-status"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Estado</h5>
                                            @if($proyecto->entregaInmediata)
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">Entrega Inmediata</p>
                                            @else
                                            
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <aside class="col-lg-12 primary-sidebar sidebar-sticky">
                            <div class="primary-sidebar-inner">
                                <div class="card mb-4" style="background-color: transparent; border: 0px !important">
                                    <div class="card-body px-6 py-4 text-center">
                                    <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >¡Quiero saber mas de este proyecto!</h4>
                                        <form action="{{ route('formulario-contacto-inversiones')}}" method="post" >
                                        @csrf
                                            <div class="form-group mb-2">
                                                <label for="name" class="sr-only">Nombre</label>
                                                <input type="text" name="nombre" class="form-control form-control-lg border-0 shadow-none" id="nombre" placeholder="Nombre">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="phone" class="sr-only">Telefono</label>
                                                <input type="text" name="telefono" class="form-control form-control-lg border-0 shadow-none" id="telefono" placeholder="Telefono">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="email" class="sr-only">Correo Electrónico</label>
                                                <input type="text" name="email" class="form-control form-control-lg border-0 shadow-none" id="email" placeholder="Correo Electrónico">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="message" class="sr-only">Mensaje</label>
                                                <textarea class="form-control border-0 shadow-none" id="mensaje" name="mensaje">Hola, Estoy interesado en el proyecto {{ $proyecto->nombreProyecto }}</textarea>
                                                <input type="hidden" name="id_formulario" value="9">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none">¡Quiero mas información!
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <section class="mt-2 pb-7 px-6 pt-5 rounded-lg">
                                <h4 class="fs-22 text-heading mb-4" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Amenidades</h4>
                                <ul class="list-unstyled mb-0 row no-gutters">
                                    @if(count($amenidades))
                                    @foreach($amenidades as $amenidad)
                                        <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>{{ $amenidad->nombreCaracteristica }}
                                        </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </section>
                        </aside>
                    </div>
                </div>
            </article>
        </div>
        <div class="container">
            <div class="row">   
                <article class="col-lg-12">         
                    <section class="pb-7 pt-7">
                        <center><h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Plantas</h4></center>
                        <div class="container">
                            <div class="row galleries">
                                @if($tipologias)
                                @foreach($tipologias as $tipologia)
                                <div class="col-sm-6 col-lg-4 mb-6">
                                    <div class="item item-size-4-3">
                                        <div class="card p-0 hover-zoom-in">
                                            <a href="/img/tipologia/{{ $tipologia->fotoTipologia }}" class="card-img d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04" data-gtf-mfp="true" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(/img/tipologia/{{ $tipologia->fotoTipologia }});">
                                                <p class="fs-48 font-weight-600 lh-1 mb-4" style="color: #26719e !important;" >{{ $tipologia->descripcionTipologia }}</p>    
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12">
                                    <h6>Dejanos tus datos y te entregaremos mas información del proyecto</h6>
                                </div>
                                @endif
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>
        @if(count($fotos))
        <section>
            <div class="container">
                <center><h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Fotos del proyecto</h4></center>
                <div class="row galleries">
                    @foreach($fotos as $foto)
                    <div class="col-sm-6 col-lg-4 mb-6">
                        <div class="item item-size-4-3">
                            <div class="card p-0 hover-zoom-in">
                                <a href="/img/proyecto/{{ $foto->nombreArchivo }}" class="card-img" data-gtf-mfp="true" data-gallery-id="{{ $foto->id }}" style="background-image:url('/img/proyecto/{{ $foto->nombreArchivo }}')">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <div class="pb-7" style="background-color: #2db5ff26 !important;">
            <div class="row" style="margin: 0px !important">
                <div class="col-12">
                    <center><h4 class="fs-22 text-heading mt-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Ubicación</h4></center>
                </div>
            </div>
            <div class="row" style="margin: 0px !important">              
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding: 0px !important">
                    <br>
                    <div class="position-relative">
                        <div id="map" style="height: 386px; !important;">
                        </div>
                        <p class="mb-0 p-3 bg-white shadow rounded-lg position-absolute pos-fixed-bottom mb-4 ml-4 lh-17 z-index-2">{{ $proyecto->direccion }} {{ $proyecto->numero }} <br/>
                            {{ $proyecto->nombreComuna }}, {{ $proyecto->nombreRegion }}</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <br>
                    @if(count($fotosCercanas))
                    <div class="galleries position-relative" style="height: auto; !important">
                        <div class="tab-content p-0 shadow-none">
                            <div class="slick-slider" data-slick-options='{"slidesToShow": 1, "autoplay":true, "dots":false,"arrows":false, "infinite": true}'>
                                @foreach($fotosCercanas as $fotoCercana)
                                <div class="box">
                                    <div class="item item-size-3-2">
                                        <div class="card p-0">
                                            <a href="#" class="card-img" style="background-image:url('/img/cercana/{{ $fotoCercana->nombreArchivo}}')">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    @endif
                </div>
            </div>
        </div>
        @if(count($otrosProyectos))
        <div class="container">
            <div class="row">   
                <article class="col-lg-12">
                    <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                        <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Otros Proyectos</h4>
                        <div class="slick-slider" data-slick-options='{"slidesToShow": 3, "autoplay":true,"dots":false,"arrows":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":4}},{"breakpoint": 992,"settings": {"slidesToShow":3}},{"breakpoint": 768,"settings": {"slidesToShow": 3}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                            @foreach($otrosProyectos as $otroProyecto)
                            <div class="col-xxl-12 col-lg-12 col-md-12 mb-6">
                                <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image">
                                    <img src="/img/proyecto/{{ $otroProyecto->fotoProyecto}}" class="card-img" alt="">
                                    <a href="/proyectos-venta/{{ $otroProyecto->idProyecto }}">
                                        <div class="card-img-overlay d-flex flex-column position-relative-sm">
                                            <div class="d-flex">
                                                <div class="mr-auto h-24 d-flex">
                                                    <span class="badge badge-primary mr-2">Venta</span>
                                                    @if($otroProyecto->idDestacado)
                                                    <span class="badge badge-warning mr-2">Entrega Inmediata</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-auto px-2">
                                                <p class="fs-17 font-weight-bold text-white mb-0 lh-13">Desde {{ number_format($otroProyecto->valorUFDesde, 0, ",", ".") }} UF</p>
                                                <h4 class="mt-0 mb-2 lh-1" style="color: white">{{ $otroProyecto->nombreProyecto }}</h4>
                                                <div class="border-top border-white-opacity-03 pt-2">
                                                    <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Habitaciones">
                                                            <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                                <use xlink:href="#icon-bedroom"></use>
                                                            </svg>
                                                            {{ $otroProyecto->dormitoriosDesde }} / {{ $otroProyecto->dormitoriosHasta }}
                                                        </li>
                                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Baños">
                                                            <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                                <use xlink:href="#icon-shower"></use>
                                                            </svg>
                                                            {{ $otroProyecto->baniosDesde }} / {{ $otroProyecto->baniosHasta }}
                                                        </li>
                                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Tamaño">
                                                            <svg class="icon icon-square fs-18 text-primary mr-1">
                                                                <use xlink:href="#icon-square"></use>
                                                            </svg>
                                                            Desde {{ $otroProyecto->metrosDesde }} Hasta {{ $otroProyecto->metrosHasta }} MT2
                                                        </li>
                                                        <!--<li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Estacionamiento">
                                                            <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                                <use xlink:href="#icon-Garage"></use>
                                                            </svg>
                                                            1 Gr
                                                        </li>-->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
                </article>
            </div>
        </div>
        @endif
    </div>
    <section>
        <div class="d-flex bottom-bar-action bottom-bar-action-01 py-2 px-4 bg-gray-01 align-items-center position-fixed fixed-bottom d-sm-none">
            <div class="media align-items-center">
                <img src="/img/usuarios/{{ $proyecto->avatarImg }}" alt="{{ $proyecto->name }} {{ $proyecto->apellido }}" class="mr-4 rounded-circle">
                <div class="media-body">
                    <a href="#" class="d-block text-dark fs-15 font-weight-500 lh-15">{{ $proyecto->name }} {{ $proyecto->apellido }}</a>
                    <span class="fs-13 lh-2">Experto Inmobiliario</span>
                </div>
            </div>
            <div class="ml-auto">
                <a href="https://wa.me/56{{ $proyecto->telefono }}" type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none" ><i class="fal fa-comment"></i></a>
                <a href="tel:+56{{ $proyecto->telefono }}" class="btn btn-primary fs-18 p-2 lh-1 mb-1 shadow-none" target="_blank"><i class="fal fa-phone"></i></a>
            </div>
        </div>
    </section>
    <section class="d-none d-lg-block d-md-block d-sm-none" >
        <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/invertirCasa.jpg); min-height: 80vh !important">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                    </div>
                    <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                        <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">Conoce mas sobre nuestros proyectos</h3>
                        <br>
                        <form action="{{ route('formulario-contacto-inversiones')}}" method="post" >
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <select class="form-control form-control border-0" name="idRentaMensual" id="idRentaMensual">
                                            <option value="">Seleccione renta mensual</option>
                                            @foreach($rentas as $renta)
                                            <option value="{{ $renta->idRentaMensual }}">{{ $renta->nombreRentaMensual }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <textarea class="form-control border-0" placeholder="Mensaje" name="mensaje" rows="2"></textarea>
                                <input type="hidden" name="id_formulario" value="8">
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
    <section class="d-sm-block d-xl-none d-md-none" >
        <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/invertirCasaMobile.png); min-height: 80vh !important">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                    </div>
                    <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                        <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">Conoce mas sobre nuestros proyectos</h3>
                        <br>
                        <form action="{{ route('formulario-contacto-inversiones')}}" method="post" >
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <select class="form-control form-control border-0" name="idRentaMensual" id="idRentaMensual">
                                            <option value="">Seleccione renta mensual</option>
                                            @foreach($rentas as $renta)
                                            <option value="{{ $renta->idRentaMensual }}">{{ $renta->nombreRentaMensual }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <textarea class="form-control border-0" placeholder="Mensaje" name="mensaje" rows="2"></textarea>
                                <input type="hidden" name="id_formulario" value="8">
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
</main>
@endsection
@section('jss')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I&callback=initMap" async defer></script>
<script>
    var map;
    var lat = {{ $proyecto->latitud }};
    var lng = {{ $proyecto->longitud }};
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lng, lat },
            zoom: 16,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            styles: [
                {
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#242f3e"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#746855"
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#242f3e"
                        }
                    ]
                },
                {
                    "featureType": "administrative.land_parcel",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#d59563"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#d59563"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#263c3f"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#6b9a76"
                    }
                    ]
                },
                {
                    "featureType": "poi.place_of_worship",
                    "elementType": "labels",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#38414e"
                    }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                    {
                        "color": "#212a37"
                    }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#9ca5b3"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#746855"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                    {
                        "color": "#1f2835"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#f3d19c"
                    }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "labels",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#2f3948"
                    }
                    ]
                },
                {
                    "featureType": "transit.station",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#d59563"
                    }
                    ]
                },
                {
                    "featureType": "transit.station.bus",
                    "elementType": "labels",
                    "stylers": [
                    {
                        "visibility": "off"
                    }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                    {
                        "color": "#17263c"
                    }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.fill",
                    "stylers": [
                    {
                        "color": "#515c6d"
                    }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                    {
                        "color": "#17263c"
                    }
                    ]
                }
                ]
        });
        var myLatlng = new google.maps.LatLng(lat, lng);
        var marker = new google.maps.Marker({
            position: myLatlng,
            icon: {url:'/front/marker.png', scaledSize: new google.maps.Size(50, 70)}
        });
        marker.setMap(map);
    }        
</script>
@endsection
        