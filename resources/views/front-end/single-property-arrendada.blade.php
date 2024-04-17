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
<style>
    div .fondo{
        position:relative;
        margin:100px auto;
        width:300px;
        height:400px;
        background:#ccc;
        overflow:hidden;
    }
    span .letrero {
        position:absolute;
        color:#fff;
        width: 20px;
        height: 30px;
        right:-72px;
        top:-57px;
        
        padding:100px 100px 5px 50px;
        background: grey;
        transform:rotate(45deg);
    }

</style>
@endsection
@section('content')
<main id="content">
    <div class="primary-content bg-gray-01 pb-12">
        <div class="container">
            <div class="d-block d-lg-none">
                <div class="row">
                    <div style="position: fixed;width: 100%;z-index: 9999999999999;" class="header-sticky header-sticky-smart">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" style="float: right;" >
                            <g>
                                <path fill-rule="evenodd" clip-rule="evenodd" class="oferta-verde" style="fill: black !important;" d="M0,0h41.4L100,58.6V100L0,0z"/>
                                <text x="20" y="38" transform="rotate(45 48 48)" class="texto-oferta-verde">ARRENDADA</text>  
                            </g>
                            <g>  
                                <path fill-rule="evenodd" clip-rule="evenodd" class="triangulo" d="M100,0v59L41,0H100z"/>
                                <text x="30" y="11" transform="rotate(45 48 48)" class="texto-triangulo"></text>
                                <!--<text x="57" y="11" transform="rotate(45 48 48)" class="texto-descuento">%</text>-->
                            </g>
                        </svg>
                    </div>
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
                        @if($propiedad->valorCyber)
                            @if($propiedad->idTipoComercial == 2)
                            <del style="color: grey !important" ><p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="color:grey !important">$ {{ number_format($propiedad->valorCyber, 0, ",", ".") }}</p></del>
                            @else
                            <del style="color: grey !important" ><p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="color:grey !important">UF {{ number_format($propiedad->valorCyber, 0, ",", ".") }}</p></del>
                            @endif
                        @endif
                        <br>
                        @if($propiedad->idTipoComercial == 2)
                            <h3 class="fs-17 font-weight-bold text-heading mb-0" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >$ {{ number_format($propiedad->valorArriendo, 0, ",", ".") }}</h3>
                        @else
                            <h3 class="fs-17 font-weight-bold text-heading mb-0" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >UF {{ number_format($propiedad->precio, 0, ",", ".") }}</h3>
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
                        <div class="slick-slider slider-for-01 arrow-haft-inner mx-0" data-slick-options='{"slidesToShow": 1, "autoplay":true, "dots":false,"arrows":false,"asNavFor": ".slider-nav-01"}'>
                            <div class="box px-0">
                                <div class="item item-size-3-2">
                                    <div class="card p-0 hover-change-image">
                                        <a href="/img/propiedad/{{ $propiedad->fotoPrincipal }}" class="card-img" data-gtf-mfp="true" data-gallery-id="04" style="background-image:url('/img/propiedad/{{ $propiedad->fotoPrincipal }}')">
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                    <div class="card border-0">
                    <div class="card-body p-0">
                        <h4 class="fs-22 text-heading mb-4" style="font-family: FeltThat,sans-serif !important; font-size: 38px !important; color: #2db5ff !important;" >Contáctanos</h4>
                        <form action="{{ route('formulario-contacto-propiedades')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <input placeholder="Tu nombre" class="form-control form-control-lg border-0" type="text" name="nombre" required >
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <input type="text" placeholder="Telefono de contacto" name="telefono" class="form-control form-control-lg border-0" required>
                            </div>
                            </div>
                        </div>
                        <div class="form-group mb-6">
                            <textarea class="form-control form-control-lg border-0" placeholder="Tu mensaje" name="mensaje" rows="2">Hola, estoy buscando una propiedad similar a la ubicada en {{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }} - ID:{{ $propiedad->id }}
                            </textarea>
                            <input type="hidden" name="id_formulario" value="3">
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary px-10">Contactar</button>
                        </form>
                    </div>
                    </div>
                </section>
                <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                    <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 38px !important; color: #2db5ff !important;" >Propiedades similares</h4>
                    <div class="slick-slider" data-slick-options='{"slidesToShow": 2, "autoplay":true, "infinite":true, "dots":false,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                        @if($propiedadesDestacadas1)
                        @foreach($propiedadesDestacadas1 as $similar)
                        <div class="box">
                            <div class="card shadow-hover-2 =">
                            <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                            @if($similar->valorCyber)
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
                                <img src="/img/propiedad/{{ $similar->fotoPrincipal }}" alt="" style="height: 200px;width: 100% !important;">
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
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="{{ $similar->habitacion }} Habitacion">
                                        <svg class="icon icon-bedroom fs-18 text-primary mr-1"><use xlink:href="#icon-bedroom"></use></svg>{{ $similar->habitacion }}
                                    </li>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title=" {{ $similar->bano }} Baños">
                                        <svg class="icon icon-shower fs-18 text-primary mr-1"><use xlink:href="#icon-shower"></use></svg>{{ $similar->bano }}
                                    </li>
                                    <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="Tamaño">
                                        <svg class="icon icon-square fs-18 text-primary mr-1"><use xlink:href="#icon-square"></use></svg>{{ $similar->mTotal }}
                                    </li>
                                    <!--<li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="1 Garage">
                                        <svg class="icon icon-Garage fs-18 text-primary mr-1"><use xlink:href="#icon-Garage"></use></svg>1 Gr
                                    </li>-->
                                </ul>
                            </div>
                            @if($similar->valorCyber)
                            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3" style="padding-bottom: 4px !important; padding-top: 8px !important; border-bottom: 0px" >
                                <del style="color: grey !important">
                                @if($similar->idTipoComercial == 2)
                                    <p class="fs-17 font-weight-bold text-heading mb-0">$ {{ number_format($similar->valorCyber, 0, ",", ".") }}</p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0">UF {{ number_format($similar->valorCyber, 0, ",", ".") }}</p>
                                @endif
                                </del>
                            </div>
                            @endif
                            <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                @if($similar->idTipoComercial == 2)
                                    <p class="fs-17 font-weight-bold text-heading mb-0" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >$ {{ number_format($similar->valorArriendo, 0, ",", ".") }}</p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >UF {{ number_format($similar->precio, 0, ",", ".") }}</p>
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
                <div style="z-index: 9999999999999;">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" style="float: right;" >
                        <g>
                            <path fill-rule="evenodd" clip-rule="evenodd" class="oferta-verde" style="fill: black !important;" d="M0,0h41.4L100,58.6V100L0,0z"/>
                            <text x="20" y="38" transform="rotate(45 48 48)" class="texto-oferta-verde">ARRENDADA</text>  
                        </g>
                        <g>  
                            <path fill-rule="evenodd" clip-rule="evenodd" class="triangulo" d="M100,0v59L41,0H100z"/>
                            <text x="30" y="11" transform="rotate(45 48 48)" class="texto-triangulo"></text>
                            <!--<text x="57" y="11" transform="rotate(45 48 48)" class="texto-descuento">%</text>-->
                        </g>
                    </svg>
                </div>
            <div class="primary-sidebar-inner">
                <div class="bg-white rounded-lg py-lg-6 pl-lg-6 pr-lg-3 p-4">
                @if($propiedad->valorCyber)
                <div>
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
                <div class="align-items-center">
                    @if($propiedad->valorCyber)
                        @if($propiedad->idTipoComercial == 2)
                            <del><p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="color:grey !important">$ {{ number_format($propiedad->valorCyber, 0, ",", ".") }}</p></del>
                        @else
                            <del><p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="color:grey !important">UF {{ number_format($propiedad->valorCyber, 0, ",", ".") }}</p></del>
                        @endif
                    @endif
                    @if($propiedad->idTipoComercial == 2)
                        <p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;">$ {{ number_format($propiedad->valorArriendo, 0, ",", ".") }}</p>
                    @else
                        <p class="fs-22 text-heading font-weight-bold mb-0 mr-6" style="font-family: 'Gordita'; font-size: 22px ! important; color:grey !important;" >UF {{ number_format($propiedad->precio, 0, ",", ".") }}</p>
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
                    @if($propiedad->avatarImg)
                    <img src="/img/usuarios/{{ $propiedad->avatarImg }}" alt="" class="mr-4 rounded-circle">
                    @else
                    <img src="/front/images/my-profile.png" alt="" class="mr-4 rounded-circle">
                    @endif
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
                        <img src="/front/images/my-profile.png" alt="" class="mr-4 rounded-circle">
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
                            <input type="text" name="nombre" class="form-control form-control-lg border-0" placeholder="Tu Nombre" required>
                        </div>
                        <div class="form-group mb-2">
                            <input type="tel" name="telefono" class="form-control form-control-lg border-0" placeholder="Tu Telefono" required>
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" name="email" class="form-control form-control-lg border-0" placeholder="Tu correo electronico">
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control border-0" name="mensaje" rows="2">Hola, estoy buscando una propiedad similar a la ubicada en {{ $propiedad->direccion }} {{ $propiedad->numero }}, {{ $propiedad->nombreComuna }} - ID:{{ $propiedad->id }}</textarea>
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
@endsection