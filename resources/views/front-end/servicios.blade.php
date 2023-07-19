@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Nuestros servicios</title>
@endsection
@section('css')
@endsection
@section('content')
<section class="pt-2 pb-10 pb-lg-17 page-title bg-overlay bg-img-cover-center" style="background-image: url('/front/images/BG3.jpg');">
    <div class="container">
        <!--<nav aria-label="breadcrumb">
            <ol class="breadcrumb text-light mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pages</li>
            </ol>
        </nav>-->
        <h1 class="fs-22 fs-md-42 mb-0 text-white font-weight-normal text-center lh-15 px-lg-16" style="padding: 20px !important;" data-animate="fadeInDown">
        
        </h1>
    </div>
</section>
<section class="bg-patten-05 mb-13">
    <div class="container">
        <div class="card mt-n13 z-index-3 pt-10 border-0">
            <div class="card-body p-0">
                <h2 class="text-dark lh-1625 text-center mb-2">Nuestros servicios</h2>
                <p class="mxw-751 text-center mb-8 px-8">Contamos con servicios que tu necesitas para ayudarte a vender o arrendar tu propiedad.
                </p>
            </div>
        </div>
        <div class="row mb-9">
        <div class="col-sm-6 col-lg-4 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1">
                            <svg class="icon icon-e4"><use xlink:href="#icon-e4"></use></svg>
                        </span>
                    </div>
                    <div class="card-body px-0 pt-6 pb-0 text-center">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Venta de propiedades</h4>
                        <p class="card-text px-2">
                            Nos encargamos de vender tu propiedad publicandola en los mejores portales inmobiliarios.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1"><svg class="icon icon-e1"><use
                                                xlink:href="#icon-e1"></use></svg></span>
                        </div>
                    <div class="card-body px-0 pt-6 pb-0 text-center">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Administración de propiedades</h4>
                        <p class="card-text px-2">
                            Buscamos a tus nuevos arrendatarios, nos ocupamos del proceso de arriendo y cuidamos tu propiedad como si fuera nuestra.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1">
                            <svg class="icon icon-e3"><use xlink:href="#icon-e3"></use></svg>
                        </span>
                    </div>
                    <div class="card-body px-0 pt-6 text-center pb-0">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Servicios de asesorias</h4>
                        <p class="card-text px-2">
                            Te asesoramos en el proceso de compra y venta de tu propiedad, tambien te ofrecemos los mejores precios del mercado en arriendos.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1">
                            <svg class="icon icon-e6"><use xlink:href="#icon-e6"></use></svg>
                        </span>
                    </div>
                    <div class="card-body px-0 pt-6 text-center pb-0">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Documentos de la propiedad</h4>
                        <p class="card-text px-2">
                            Trabajamos en el papeleo de tu propiedad tanto para venderla como para arrendarla.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1">
                            <svg class="icon icon-e2"><use xlink:href="#icon-e2"></use></svg>
                        </span>
                    </div>
                    <div class="card-body px-0 pt-6 pb-0 text-center">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Mejores precios</h4>
                        <p class="card-text px-2">
                            Contamos con los mejores precios del mercado en el rubro inmobiliario, contamos con propiedades exclusivas.
                        </p>
                    </div>
                </div>
            </div>
            <!--<div class="col-sm-6 col-lg-4 mb-6">
                <div class="card border-hover shadow-hover-lg-1 px-7 pb-6 pt-4 h-100 bg-transparent bg-hover-white">
                    <div class="card-img-top d-flex align-items-end justify-content-center">
                        <span class="text-primary fs-90 lh-1">
                            <svg class="icon icon-e5"><use xlink:href="#icon-e5"></use></svg>
                        </span>
                    </div>
                    <div class="card-body px-0 pt-6 pb-0 text-center">
                        <h4 class="card-title fs-18 lh-17 text-dark mb-2">Home Selling</h4>
                        <p class="card-text px-2">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna
                        </p>
                    </div>
                </div>
            </div>-->
        </div>
        <div class="container">
            <h1 class="fs-30 lh-1 mb-0 text-heading font-weight-600 mb-6">Planes de administración</h1>
        </div>
        <div class="container">
            <h4 class="mb-2 fs-22 lh-15 text-heading">Te ofrecemos los mejores planes del mercardo con la mejor administración:</h4>
            <div class="row">
                @if($planes)
                @foreach($planes as $plan)
                <div class="col-xl-4 col-sm-6 mb-6">
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
                        <a href="#" class="btn btn-primary btn-block h-52 pl-4 pr-3 d-flex justify-content-between align-items-center">¡Lo quiero!
                        <i class="far fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <hr class="mb-11">
        <h2 class="text-heading mb-2 fs-22 fs-md-32 text-center lh-16 mxw-571 px-lg-8">
            ¿Estas interesado en alguno de nuestros servicios? ¡Contactanos!
        </h2>
        <!--<p class="text-center mxw-670 mb-8">
            Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem ipsum dolor sit ametcipsum
            psumg consec tetur cing elitelit.
        </p>-->
        <form class="mxw-774" action="{{ route('formulario-contacto-propiedades')}}" method="post" >
        @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" placeholder="Nombre" class="form-control form-control-lg border-0" name="nombre">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input placeholder="Correo electronico" class="form-control form-control-lg border-0" type="email" name="email">
                    </div>
                </div>
                <div class="col-md-6 px-2">
                    <div class="form-group">
                        <input type="text" placeholder="Telefono" name="telefono" class="form-control form-control-lg border-0">
                    </div>
                </div>
            </div>
            <div class="form-group mb-6">
                <textarea class="form-control border-0" placeholder="Mensaje" name="mensaje" rows="5"></textarea>
                <input type="hidden" name="id_formulario" value="4">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary px-9">Enviar</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('jss')

@endsection