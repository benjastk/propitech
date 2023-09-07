@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Nosotros</title>
@endsection
@section('meta')
<meta name="description" content="Empresa dedicada al corretaje y a la administración de propiedades, nuestro equipo esta dispuesto para ayudar y asesorarte en encontrar esa propiedad que tanto buscas.">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
<section style="background-image: url('/front/images/bg-home-03.jpg')" class="bg-img-cover-center py-10 pt-md-16 pb-md-17 bg-overlay">
    <div class="container position-relative z-index-2 text-center">
        <!--<a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="d-inline-block m-auto position-relative play-animation" data-gtf-mfp="true" data-mfp-options='{"type":"iframe"}'>
            <span class="text-white bg-primary w-78px h-78 rounded-circle d-flex align-items-center justify-content-center">
                <i class="fas fa-play"></i>
            </span>
        </a>
        <div class="mxw-751">
            <h1 class="text-white fs-30 fs-md-42 lh-15 font-weight-normal mt-4 mb-10" data-animate="fadeInRight">Creemos que las propiedades son una fuerza poderosa para el bien.</h1>
        </div>-->
    </div>
</section>

<section class="bg-patten-03 bg-gray-01 pb-13">
    <div class="container">
        <div class="card border-0 mt-n13 z-index-3 mb-6">
            <div class="card-body p-6 px-lg-8 py-lg-8">
                <p class="letter-spacing-263 text-uppercase text-primary mb-6 font-weight-500 text-center">Bienvenido a Propitech</p>
                <h2 class="text-heading mb-4 fs-22 fs-md-32 text-center lh-16 px-6">Somos Propitech</h2>
                <p class="text-center px-lg-11 fs-15 lh-17 mb-11">
                Propitech, es una empresa dedicada al corretaje y a la administración de propiedades. El éxito se debe principalmente al 
                arduo trabajo, con el objetivo de proporcionar a los clientes un servicio dinámico y satisfactorio en el negocio de corretaje de 
                propiedades.
                </p>
            </div>
        </div>
        <h2 class="text-dark lh-1625 text-center mb-2 fs-22 fs-md-32">Nuestros servicios</h2>
        <p class="mxw-751 text-center mb-1 px-8">Tenemos todo lo que necesitas para ayudarte con tu propiedad.</p>
        <div class="row mt-8">
            <div class="col-md-4 mb-6 mb-lg-0">
                <div class="card shadow-2 px-7 pb-6 pt-4 h-100 border-0">
                <div class="card-img-top d-flex align-items-end justify-content-center">
                    <span class="text-primary fs-90 lh-1"><svg class="icon icon-e1"><use
                                        xlink:href="#icon-e1"></use></svg></span>
                </div>
                <div class="card-body px-0 pt-6 pb-0 text-center">
                    <h4 class="card-title fs-18 lh-17 text-dark mb-2">Administracion de propiedades</h4>
                    <p class="card-text px-2">
                        Administramos tu propiedad y nos encargamos de publicarla en los mejores portales para buscar al arrendatario
                        que buscas.
                    </p>
                </div>
                </div>
            </div>
            <div class="col-md-4 mb-6 mb-lg-0">
                <div class="card shadow-2 px-7 pb-6 pt-4 h-100 border-0">
                <div class="card-img-top d-flex align-items-end justify-content-center">
                    <span class="text-primary fs-90 lh-1">
                    <svg class="icon icon-e2"><use xlink:href="#icon-e2"></use></svg>
                    </span>
                </div>
                <div class="card-body px-0 pt-6 pb-0 text-center">
                    <h4 class="card-title fs-18 lh-17 text-dark mb-2">Venta de inmuebles</h4>
                    <p class="card-text px-2">
                        Nos encargamos de la venta de tu propiedad desde inicio a fin para que tu comprador quede satisfecho con su nuevo hogar.
                    </p>
                </div>
                </div>
            </div>
            <div class="col-md-4 mb-6 mb-lg-0">
                <div class="card shadow-2 px-7 pb-6 pt-4 h-100 border-0">
                <div class="card-img-top d-flex align-items-end justify-content-center">
                    <span class="text-primary fs-90 lh-1">
                    <svg class="icon icon-e3"><use xlink:href="#icon-e3"></use></svg>
                    </span>
                </div>
                <div class="card-body px-0 pt-6 text-center pb-0">
                    <h4 class="card-title fs-18 lh-17 text-dark mb-2">Asesorias en ventas y arriendos</h4>
                    <p class="card-text px-2">
                    Contáctanos y te ofreceremos soluciones acordes a las que necesitas para vender o arrendar tu propiedad.
                    </p>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-8">
    <div class="container">
        <h2 class="text-dark lh-1625 text-center mb-2 fs-22 fs-md-32">Nuestro equipo</h2>
        <p class="mxw-751 text-center mb-1 px-8">Tenemos al mejor equipo de expertos en asesoría inmobiliaria</p>
        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-sm-0 mb-7">
                <div class="card border-0 our-team text-center">
                <div class="rounded overflow-hidden bg-hover-overlay d-inline-block">
                    <img class="card-img" src="/front/GUSTAVO1.png"
                                alt="Gustavo Cisternas">
                    <ul class="list-inline text-gray-lighter position-absolute w-100 m-0 p-0 z-index-2">
                        <!--<li class="list-inline-item m-0">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-instagram"></i></a>
                        </li>-->
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#" class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                            class="fab fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-5">
                    <h3 class="fs-16 text-heading mb-1 lh-2">
                    <a href="#" class="text-heading hover-primary">Gustavo Cisternas</a>
                    </h3>
                    <p>Líder de Ventas Inmobiliarias</p>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-sm-0 mb-7">
                <div class="card border-0 our-team text-center">
                <div class="rounded overflow-hidden bg-hover-overlay d-inline-block">
                    <img class="card-img" src="/front/TRIANA33.png"
                                alt="Triana Bustos">
                    <ul class="list-inline text-gray-lighter position-absolute w-100 m-0 p-0 z-index-2">
                        <!--<li class="list-inline-item m-0">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-instagram"></i></a>
                        </li>-->
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-5">
                    <h3 class="fs-16 text-heading mb-1 lh-2">
                    <a href="#" class="text-heading hover-primary">Triana Bustos</a>
                    </h3>
                    <p>Líder de Operaciones Inmobiliarias</p>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-sm-0 mb-7">
                <div class="card border-0 our-team text-center">
                <div class="rounded overflow-hidden bg-hover-overlay d-inline-block">
                    <img class="card-img" src="/front/ISABEL2.jpg" style="border-radius: 290px !important; height: 365px; width: 90% !important"
                                alt="Isabel Sainz">
                    <ul class="list-inline text-gray-lighter position-absolute w-100 m-0 p-0 z-index-2">
                        <!--<li class="list-inline-item m-0">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-instagram"></i></a>
                        </li>-->
                        <li class="list-inline-item mr-0 ml-2">
                            <a href="#"
                                        class="w-32px h-32 rounded shadow-xxs-3 bg-hover-primary bg-white hover-white text-body d-flex align-items-center justify-content-center"><i
                                            class="fab fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-5">
                    <h3 class="fs-16 text-heading mb-1 lh-2">
                    <a href="https://www.linkedin.com/in/isabelmargaritasainz/" class="text-heading hover-primary">Isabel Sainz</a>
                    </h3>
                    <p>Líder de Administración Inmobiliaria</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h2 class="text-heading mb-4 fs-22 fs-md-32 text-center lh-16 px-md-13">
            Nuestro Proposito
        </h2>
        <p class="text-center px-md-17 fs-15 lh-17 mb-8">
            Entregar asesoría de calidad, con gran enfoque en la atención a nuestros clientes, facilitando a los usuarios la compra, 
            venta y arriendo del inmueble, ya que contamos con personal capacitado en el área. Entregamos, además, asistencia y orientación 
            en cuanto a la obtención de créditos, trámites, apoyo en documentación, revisión de antecedentes financieros de potenciales clientes.
        </p>
        <br>
        <p class="text-center px-md-17 fs-15 lh-17 mb-8">
        Experimenta nuestra innovación y únete al cambio
        </p>
        <div class="text-center mb-11">
            <a href="/trabaja-con-nosotros" class="btn btn-lg btn-primary">Trabaja con nosotros</a>
        </div>
    </div>
    </section>
@endsection
@section('jss')

@endsection