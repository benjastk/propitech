@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Propiedad en {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }} </title>
@endsection
@section('meta')
<meta name="description" content="{{ $propiedad->direccion }} {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }} ">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
<main id="content">
    <div class="primary-content bg-gray-01 pb-12">
        <div class="container">
            <div class="d-block d-lg-none">
                <div class="row">
                    <article class="col-12" style="padding: 20px">
                        <ul class="list-inline d-sm-flex align-items-sm-center mb-2">
                            @if($propiedad->idDestacado > 0)
                                <li class="list-inline-item badge badge-orange mr-2">Destacada</li>
                            @endif
                            @if($propiedad->idTipoComercial == 2)
                                <li class="list-inline-item badge badge-primary mr-3">Arriendo</li>
                            @else
                                <li class="list-inline-item badge badge-primary mr-3">Venta</li>
                            @endif
                        </ul>
                        <h2 class="fs-22 text-heading pt-2">{{ $propiedad->nombrePropiedad }}</h2>
                        <p class="mb-2"><i class="fal fa-map-marker-alt mr-1"></i>{{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }}</p>
                        @if($propiedad->idTipoComercial == 2)
                            <h3 class="fs-17 font-weight-bold text-heading mb-0">$ {{ number_format($propiedad->valorArriendo, 0, ",", ".") }}</h3>
                        @else
                            <h3 class="fs-17 font-weight-bold text-heading mb-0">UF {{ number_format($propiedad->precio, 0, ",", ".") }}</h3>
                        @endif
                    </article>
                </div>
            </div>
            <div class="row">
            <article class="col-lg-8" style="top: 15px;">
                <section>
                    <div class="galleries position-relative">
                        <div class="position-absolute pos-fixed-top-right z-index-3">
                        <ul class="list-inline pt-4 pr-5">
                        </li>
                        <li class="list-inline-item">
                        </li>
                        </ul>
                    </div>
                    <div class="slick-slider slider-for-01 arrow-haft-inner mx-0" data-slick-options='{"slidesToShow": 1, "autoplay":false, "dots":false,"arrows":false,"asNavFor": ".slider-nav-01"}'>
                        <div class="box px-0">
                            <div class="item item-size-3-2">
                                <div class="card p-0 hover-change-image">
                                    <a href="/img/propiedad/{{ $propiedad->fotoPrincipal }}" class="card-img" data-gtf-mfp="true" data-gallery-id="04" style="background-image:url('/img/propiedad/{{ $propiedad->fotoPrincipal }}')">
                                </a>
                                </div>
                            </div>
                        </div>
                        @if($propiedad->fotos)
                        @foreach($propiedad->fotos as $foto1)
                            <div class="box px-0">
                                <div class="item item-size-3-2">
                                    <div class="card p-0 hover-change-image">
                                        <a href="/img/propiedad/{{ $foto1->nombreArchivo }}" class="card-img" data-gtf-mfp="true" data-gallery-id="04" style="background-image:url('/img/propiedad/{{ $foto1->nombreArchivo }}')">
                                    </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="slick-slider slider-nav-01 mt-4 mx-n1 arrow-haft-inner" data-slick-options='{"slidesToShow": 4, "infinite":true, "autoplay":false,"dots":false,"arrows":true,"asNavFor": ".slider-for-01","focusOnSelect": true,"responsive":[{"breakpoint": 768,"settings": {"slidesToShow": 4}},{"breakpoint": 576,"settings": {"slidesToShow": 2}}]}'>
                        <div class="box pb-6 px-0">
                            <div class="bg-hover-white p-1 shadow-hover-xs-3 h-100 rounded-lg">
                                <img src="/img/propiedad/{{ $propiedad->fotoPrincipal }}" alt="Gallery 01" class="h-100 w-100 rounded-lg">
                            </div>
                        </div>
                        @if($propiedad->fotos)
                        @foreach($propiedad->fotos as $foto)
                            <div class="box pb-6 px-0">
                                <div class="bg-hover-white p-1 shadow-hover-xs-3 h-100 rounded-lg">
                                    <img src="/img/propiedad/{{ $foto->nombreArchivo }}" alt="Gallery 01" class="h-100 w-100 rounded-lg">
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </section>
            <section class="pb-8 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-3">Descripcion</h4>
                <p class="mb-0 lh-214">{!! $propiedad->descripcion !!}</p>
            </section>
            <section class="mt-2 pb-3 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-6">Características de la propiedad</h4>
                <div class="row">
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-family fs-32 text-primary"><use xlink:href="#icon-family"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Tipo</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $propiedad->nombreTipoPropiedad }}</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-year fs-32 text-primary"><use xlink:href="#icon-year"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Antiguedad</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $propiedad->antiguedad}}</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-status fs-32 text-primary"><use xlink:href="#icon-status"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Estado</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $propiedad->nombreNivelUsoPropiedad }}</p>
                    </div>
                    </div>
                </div>
                @if($propiedad->mascotas > 0)
                    <div class="col-lg-3 col-sm-4 mb-6">
                        <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                            <svg class="icon icon-heart fs-32 text-primary"><use xlink:href="#icon-heart"></use></svg>
                        </div>
                        <div class="media-body">
                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Mascotas</h5>
                            <p class="mb-0 fs-13 font-weight-bold text-heading">Si</p>
                        </div>
                        </div>
                    </div>
                @else
                
                @endif
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-bedroom fs-32 text-primary"><use xlink:href="#icon-bedroom"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Habitaciones</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $propiedad->habitacion}}</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-sofa fs-32 text-primary"><use xlink:href="#icon-sofa"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Baños</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-heading">{{ $propiedad->bano }}</p>
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-my-package fs-18 text-primary mr-1">
                            <use xlink:href="#icon-my-package"></use>
                        </svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Bodega</h5>
                        @if($propiedad->usoGoceBodega > 0)
                        Si
                        @else
                        No
                        @endif
                    </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 mb-6">
                    <div class="media">
                    <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                        <svg class="icon icon-Garage fs-32 text-primary"><use xlink:href="#icon-Garage"></use></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Estacionamiento</h5>
                        @if($propiedad->usoGoceEstacionamiento > 0)
                        Si
                        @else
                        No
                        @endif
                    </div>
                    </div>
                </div>
                </div>
            </section>
            <section class="mt-2 pb-6 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-4">Detalles de la propiedad</h4>
                <div class="row">
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">ID</dt>
                        <dd>{{ $propiedad->id }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Precio</dt>
                        @if($propiedad->idTipoComercial == 2)
                            <dd>$ {{ number_format($propiedad->valorArriendo, 0, ",", ".") }}</dd>
                        @else
                            <dd>UF {{ number_format($propiedad->precio, 0, ",", ".") }}</dd>
                        @endif
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Tipo</dt>
                        <dd>{{ $propiedad->nombreTipoPropiedad }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Operacion</dt>
                        @if($propiedad->idTipoComercial == 2)
                            <dd>Arriendo</dd>
                        @else
                            <dd>Venta</dd>
                        @endif
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Habitaciones</dt>
                        <dd>{{ $propiedad->habitacion }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Baños</dt>
                        <dd>{{ $propiedad->bano }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Mts. totales</dt>
                        <dd>{{ $propiedad->mTotal }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Mts. constr.</dt>
                        <dd>{{ $propiedad->mConstruido }}</dd>
                    </dl>
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Metros terraza</dt>
                        <dd>{{ $propiedad->mTerraza }}</dd>
                    </dl>
                    @if($propiedad->orientacion)
                    <dl class="col-sm-6 mb-0 d-flex">
                        <dt class="w-110px fs-14 font-weight-500 text-heading pr-2">Orientación</dt>
                        <dd>{{ $propiedad->orientacion }}</dd>
                    </dl>
                    @endif
                </div>
            </section>
            <section class="mt-2 pb-7 px-6 pt-5 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-4">Amenidades</h4>
                <ul class="list-unstyled mb-0 row no-gutters">
                    @if($amenidades)
                    @foreach($amenidades as $amenidad)
                        <li class="col-sm-3 col-6 mb-2">{!! $amenidad->iTag !!} {{ $amenidad->nombreCaracteristica }}</li>
                    @endforeach
                    @endif
                </ul>
            </section>
            <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                <div class="card border-0">
                <div class="card-body p-0">
                    <h3 class="fs-16 lh-2 text-heading mb-4">Escribenos por esta propiedad</h3>
                    <form action="{{ route('formulario-contacto-propiedades')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                        <div class="form-group mb-4">
                            <input placeholder="Tu nombre" class="form-control form-control-lg border-0" type="text" name="nombre">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group mb-4">
                            <input type="email" placeholder="Correo electronico" name="email" class="form-control form-control-lg border-0">
                        </div>
                        </div>
                    </div>
                    <div class="form-group mb-6">
                        <textarea class="form-control form-control-lg border-0" placeholder="Tu mensaje" name="mensaje" rows="5">Hola, estoy interesado en la propiedad {{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }} - ID:{{ $propiedad->id }}
                        </textarea>
                        <input type="hidden" name="id_formulario" value="3">
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary px-10">Contactar</button>
                    </form>
                </div>
                </div>
            </section>
            <section class="mt-2 pb-6 px-6 pt-6 bg-white rounded-lg" >
                <h4 class="fs-22 text-heading mb-6">Ubicación</h4>
                <div class="position-relative">
                <div class="position-relative">
                    <div id="map" style="height: 300px; !important">
                    <p class="mb-0 p-3 bg-white shadow rounded-lg position-absolute pos-fixed-bottom mb-4 ml-4 lh-17 z-index-2">{{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }}</p>
                </div>
                </div>
            </section>
            <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                <h4 class="fs-22 text-heading mb-6">Propiedades similares</h4>
                <div class="slick-slider" data-slick-options='{"slidesToShow": 2, "autoplay":true, "infinite":true, "dots":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                    @if($propiedadesDestacadas1)
                    @foreach($propiedadesDestacadas1 as $similar)
                    <div class="box">
                        <div class="card shadow-hover-2 =">
                        <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                            <img src="/img/propiedad/{{ $similar->fotoPrincipal }}" alt="Home in Metric Way" style="height: 200px;width: 100% !important;">
                            <div class="card-img-overlay p-2 d-flex flex-column">
                                <div>
                                    @if($similar->idTipoComercial == 2)
                                    <span class="badge mr-2 badge-primary">Arriendo</span>
                                    @else
                                    <span class="badge mr-2 badge-primary">Venta</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            @if($similar->idTipoComercial == 2)
                            <h2 class="card-title fs-16 lh-2 mb-0"><a href="/propiedad-arriendo/{{ $similar->id }}" class="text-dark hover-primary">{{ $similar->nombrePropiedad }}</a></h2>
                            @else
                            <h2 class="card-title fs-16 lh-2 mb-0"><a href="/propiedad-venta/{{ $similar->id }}" class="text-dark hover-primary">{{ $similar->nombrePropiedad }}</a></h2>
                            @endif
                            <p class="card-text font-weight-500 text-gray-light mb-2">{{ $similar->direccion }} {{ $similar->numero }}, {{ $similar->nombreComuna }}</p>
                            <ul class="list-inline d-flex mb-0 flex-wrap mr-n4">
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bedroom">
                                    <svg class="icon icon-bedroom fs-18 text-primary mr-1"><use xlink:href="#icon-bedroom"></use></svg>{{ $similar->habitacion }}
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bathrooms">
                                    <svg class="icon icon-shower fs-18 text-primary mr-1"><use xlink:href="#icon-shower"></use></svg>{{ $similar->bano }}
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="Size">
                                    <svg class="icon icon-square fs-18 text-primary mr-1"><use xlink:href="#icon-square"></use></svg>{{ $similar->mTotal }}
                                </li>
                                <!--<li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="1 Garage">
                                    <svg class="icon icon-Garage fs-18 text-primary mr-1"><use xlink:href="#icon-Garage"></use></svg>1 Gr
                                </li>-->
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                            @if($similar->idTipoComercial == 2)
                                <p class="fs-17 font-weight-bold text-heading mb-0">$ {{ number_format($similar->valorArriendo, 0, ",", ".") }}</p>
                            @else
                                <p class="fs-17 font-weight-bold text-heading mb-0">UF {{ number_format($similar->precio, 0, ",", ".") }}</p>
                            @endif
                            <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                            </li>
                            <li class="list-inline-item">
                            </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </section>
            </article>
            <aside class="col-lg-4 pl-xl-4 primary-sidebar sidebar-sticky" id="sidebar" style="top: 15px;">
            <div class="primary-sidebar-inner">
                <div class="bg-white rounded-lg py-lg-6 pl-lg-6 pr-lg-3 p-4">
                <ul class="list-inline d-sm-flex align-items-sm-center mb-2">
                    @if($propiedad->idDestacado > 0)
                        <li class="list-inline-item badge badge-orange mr-2">Destacada</li>
                    @endif
                    @if($propiedad->idTipoComercial == 2)
                        <li class="list-inline-item badge badge-primary mr-3">Arriendo</li>
                    @else
                        <li class="list-inline-item badge badge-primary mr-3">Venta</li>
                    @endif
                </ul>
                <h2 class="fs-22 text-heading pt-2">{{ $propiedad->nombrePropiedad }}</h2>
                <p class="mb-2"><i class="fal fa-map-marker-alt mr-1"></i>{{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }}, {{ $propiedad->nombreRegion }}</p>
                <div class="d-flex align-items-center">
                    @if($propiedad->idTipoComercial == 2)
                        <p class="fs-22 text-heading font-weight-bold mb-0 mr-6">$ {{ number_format($propiedad->valorArriendo, 0, ",", ".") }}</p>
                    @else
                        <p class="fs-22 text-heading font-weight-bold mb-0 mr-6">UF {{ number_format($propiedad->precio, 0, ",", ".") }}</p>
                    @endif
                </div>
                <div class="row mt-5">
                    <div class="col-6 mb-3">
                    <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                        <svg class="icon icon-bedroom fs-18 text-primary"><use xlink:href="#icon-bedroom"></use></svg>
                        </div>
                        <div class="media-body">
                        <h5 class="fs-13 font-weight-normal mb-0">Habitaciones</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-dark">{{ $propiedad->habitacion }}</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-6 mb-3">
                    <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                        <svg class="icon icon-shower fs-18 text-primary"><use xlink:href="#icon-shower"></use></svg>
                        </div>
                        <div class="media-body">
                        <h5 class="fs-13 font-weight-normal mb-0">Baños</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-dark">{{ $propiedad->bano }}</p>
                        </div>
                    </div>
                    </div>
                    <div class="col-6 mb-3">
                    <div class="media">
                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                        <svg class="icon icon-square fs-18 text-primary"><use xlink:href="#icon-square"></use></svg>
                        </div>
                        <div class="media-body">
                        <h5 class="fs-13 font-weight-normal mb-0">Metros Totales</h5>
                        <p class="mb-0 fs-13 font-weight-bold text-dark">{{ $propiedad->mTotal }}</p>
                        </div>
                    </div>
                    </div>
                    @if($propiedad->usoGoceEstacionamiento)
                    <div class="col-6 mb-3">
                        <div class="media">
                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                            <svg class="icon icon-Garage fs-18 text-primary"><use xlink:href="#icon-Garage"></use></svg>
                            </div>
                            <div class="media-body">
                            <h5 class="fs-13 font-weight-normal mb-0">Estacionamiento</h5>
                            <p class="mb-0 fs-13 font-weight-bold text-dark">1</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($propiedad->usoGoceBodega)
                    <div class="col-6 mb-3">
                        <div class="media">
                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                <svg class="icon icon-my-package fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-my-package"></use>
                                </svg>
                            </div>
                            <div class="media-body">
                                <h5 class="fs-13 font-weight-normal mb-0">Bodega</h5>
                                <p class="mb-0 fs-13 font-weight-bold text-dark">1</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($propiedad->orientacion)
                    <div class="col-6 mb-3">
                        <div class="media">
                            <div class="p-2 shadow-xxs-1 rounded-lg mr-2 lh-1">
                                <svg class="icon icon-my-package fs-18 text-primary mr-1">
                                    <use xlink:href="#icon-save-search"></use>
                                </svg>
                            </div>
                            <div class="media-body">
                                <h5 class="fs-13 font-weight-normal mb-0">Orientación</h5>
                                <p class="mb-0 fs-13 font-weight-bold text-dark">{{ $propiedad->orientacion }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mr-xl-2">
                    <!--<a href="#" class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white">Schedule a Tour</a>-->
                    <a style="background-color: #0ec6d5;color: white !important;" href="#" data-toggle="modal" data-target="#modal-messenger" class="btn btn-outline-primary btn-lg btn-block rounded border text-body border-hover-primary hover-white mt-4">Necesito informacion</a>
                </div>
                </div>
            </div>
            </aside>
        </div>
        </div>
    </div>
    <section>
        <div class="d-flex bottom-bar-action bottom-bar-action-01 py-2 px-4 bg-gray-01 align-items-center position-fixed fixed-bottom d-sm-none">
            @if($propiedad->idUsuarioExpertoVendedor)
                <div class="media align-items-center">
                        <img src="/front/images/my-profile.png" alt="Irene Wallace" class="mr-4 rounded-circle">
                    <div class="media-body">
                        <a href="#" class="d-block text-dark fs-15 font-weight-500 lh-15">{{ $propiedad->name }} {{ $propiedad->apellido }}</a>
                        <span class="fs-13 lh-2">Agente Inmobiliario</span>
                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none" data-toggle="modal" data-target="#modal-messenger"><i class="fal fa-comment"></i></button>
                    <a href="tel:(+56) {{ $propiedad->telefono }}" class="btn btn-primary fs-18 p-2 lh-1 mb-1 shadow-none" target ="_blank"><i class="fal fa-phone"></i></a>
                </div>
            @else
                <div class="media align-items-center">
                        <img src="/front/images/my-profile.png" alt="Irene Wallace" class="mr-4 rounded-circle">
                    <div class="media-body">
                        <a href="#" class="d-block text-dark fs-15 font-weight-500 lh-15">Ejecutivo virtual</a>
                        <span class="fs-13 lh-2">Agente Inmobiliario</span>
                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none" ><i class="fa fa-whatsapp"></i></button>
                    <button type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none" data-toggle="modal" data-target="#modal-messenger"><i class="fal fa-comment"></i></button>
                    <a href="tel:(+56)9 8958 3599" class="btn btn-primary fs-18 p-2 lh-1 mb-1 shadow-none" target ="_blank"><i class="fal fa-phone"></i></a>
                </div>
            @endif
        </div>
        <div class="modal fade" id="modal-messenger" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h4 class="modal-title text-heading" id="exampleModalLabel">Formulario de contacto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-6">
                    <form action="{{ route('formulario-contacto-propiedades')}}" method="post">
                    @csrf
                        <div class="form-group mb-2">
                            <input type="text" name="nombre" class="form-control form-control-lg border-0" placeholder="Tu Nombre">
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" name="email" class="form-control form-control-lg border-0" placeholder="Tu correo electronico">
                        </div>
                        <div class="form-group mb-2">
                            <input type="tel" name="telefono" class="form-control form-control-lg border-0" placeholder="Tu Telefono">
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control border-0" name="mensaje" rows="4">Hola, estoy interesado en la propiedad {{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }} - ID:{{ $propiedad->id }}</textarea>
                        </div>
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="exampleCheck3">
                            <input type="hidden" name="id_formulario" value="2">
                        <label class="form-check-label fs-13" for="exampleCheck3">Acepto que me contacten para recibir informacion de la propiedad.</label>
                        </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block rounded">¡Quiero que me contacten!</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
@endsection
@section('jss')
<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmVuamFzdGsiLCJhIjoiY2xnZHYwZ2V0MG82MjNscnl6dXQxZWxsaiJ9.wLKdL8bv-Y9DKI8qSW_AZw';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [{{ $propiedad->longitud }}, {{ $propiedad->latitud }}],
        zoom: 14
    });
    $('.mapboxgl-canvas').css('height', '100%');
    map.resize();
    var marker{{ $propiedad->id }} = new mapboxgl.Marker({ color: '#2db5ff' })
    .setLngLat([{{ $propiedad->longitud }}, {{ $propiedad->latitud }}])
    .addTo(map);
</script>
@endsection