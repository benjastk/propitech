@extends('front-end.layouts.app5')
@section('titulo')
<title>Propitech Inversiones - Hacemos tu sueño realidad</title>
@endsection
@section('meta')
<meta name="description" content="Propitech">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
<style>
    .nav-tabs.wizard {
        background-color: transparent;
        padding: 0;
        width: 100%;
        margin: 1em auto;
        border-radius: .25em;
        clear: both;
        border-bottom: none;
    }

    .nav-tabs.wizard li {
        width: 100%;
        float: none;
        margin-bottom: 3px;
    }

    .nav-tabs.wizard li>* {
        position: relative;
        padding: 1em .8em .8em 2.5em;
        color: #999999;
        background-color: #dedede;
        border-color: #dedede;
    }

    .nav-tabs.wizard li.completed>* {
        color: #fff !important;
        background-color: #96c03d !important;
        border-color: #96c03d !important;
        border-bottom: none !important;
    }

    .nav-tabs.wizard li.active>* {
        color: #fff !important;
        background-color: #2c3f4c !important;
        border-color: #2c3f4c !important;
        border-bottom: none !important;
    }

    .nav-tabs.wizard li::after:last-child {
        border: none;
    }

    .nav-tabs.wizard > li > a {
        opacity: 1;
        font-size: 14px;
    }

    .nav-tabs.wizard a:hover {
        color: #fff;
        background-color: #2c3f4c;
        border-color: #2c3f4c
    }

    span.nmbr {
        display: inline-block;
        padding: 10px 0 0 0;
        background: #ffffff;
        width: 35px;
        line-height: 100%;
        height: 35px;
        margin: auto;
        border-radius: 50%;
        font-weight: bold;
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        text-align: center;
    }

    @media(min-width:992px) {
        .nav-tabs.wizard li {
            position: relative;
            padding: 0;
            margin: 4px 4px 4px 0;
            width: 19.6%;
            float: left;
            text-align: center;
        }
        .nav-tabs.wizard li.active a {
            padding-top: 15px;
        }
        .nav-tabs.wizard li::after,
        .nav-tabs.wizard li>*::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 100%;
            height: 0;
            width: 0;
            border: 45px solid transparent;
            border-right-width: 0;
            /*border-left-width: 20px*/
        }
        .nav-tabs.wizard li::after {
            z-index: 1;
            -webkit-transform: translateX(4px);
            -moz-transform: translateX(4px);
            -ms-transform: translateX(4px);
            -o-transform: translateX(4px);
            transform: translateX(4px);
            border-left-color: #fff;
            margin: 0
        }
        .nav-tabs.wizard li>*::after {
            z-index: 2;
            border-left-color: inherit
        }
        .nav-tabs.wizard > li:nth-of-type(1) > a {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .nav-tabs.wizard li:last-child a {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .nav-tabs.wizard li:last-child {
            margin-right: 0;
        }
        .nav-tabs.wizard li:last-child a:after,
        .nav-tabs.wizard li:last-child:after {
            content: "";
            border: none;
        }
        span.nmbr {
            display: block;
        }
    }
</style>
@endsection
@section('content')
    <section>
        <div class="slick-slider mx-0 custom-arrow-center" data-slick-options='{"slidesToShow": 1, "infinite":true, "autoplay":true,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 992,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}}]}'>
            <div class="box px-0 d-flex flex-column" style="display: flex" >
                <div class="row" style="margin: 0px !important">
                    <div class="bg-cover d-flex align-items-center custom-vh-02" style="background-image: url('front/images/bg-slider-01.jpg'); width: 50%">
                        
                    </div>
                    <div class="bg-cover d-flex align-items-center custom-vh-02" style="background: linear-gradient(90deg, rgba(8,107,196,1) 0%, rgba(16,133,193,1) 38%, rgba(45,181,255,1) 100%); width: 50%">
                        <div class="container">
                            <div class="row py-8" data-animate="zoomIn">
                                <div class="col-lg-1 col-md-1">
                                </div>
                                <!--<div class="col-lg-5 col-md-6 d-md-block d-none">
                                    <a href="single-property-1.html" class="d-inline-block">
                                        <img src="front/images/single-image-05.png" class="rounded-lg" alt="Villa on Hollywood Boulevard">
                                    </a>
                                </div>-->
                                <div class="col-lg-7 col-md-6">
                                    <p class="text-white fs-22 font-weight-500 letter-spacing-367 text-uppercase mt-7 mb-4">Entrega Inmediata</p>
                                    <h2 class="lh-12 mb-4" style="font-family: FeltThat,sans-serif !important;"><a href="single-property-1.html" class="text-white fs-md-60 fs-48">Villa on Hollywood Boulevard</a></h2>
                                    <p class="text-white fs-22 font-weight-500">070 Ruecker Knolls Suite 132</p>
                                    <p class="text-white fs-32 font-weight-600 lh-16" style="font-family: 'Gordita';">DESDE $1.000 UF</p>
                                </div>
                                <div class="col-lg-1 col-md-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="box px-0 d-flex flex-column" style="background-color: #1477ad !important">
                <div class="bg-cover d-flex align-items-center custom-vh-02" style="background-image: url('front/images/bg-slider-02.jpg'); width: 50%">
                    <div class="container">
                        <div class="row py-8" data-animate="zoomIn">
                            <div class="col-lg-5 col-md-6 d-md-block d-none">
                                <a href="single-property-1.html" class="d-inline-block">
                                    <img src="front/images/single-image-06.jpg" class="rounded-lg" alt="Villa on Hollywood Boulevard">
                                </a>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <p class="text-white fs-22 font-weight-500 letter-spacing-367 text-uppercase mt-7 mb-4">For sale</p>
                                <h2 class="lh-12 mb-4"><a href="single-property-1.html" class="text-white fs-md-60 fs-48">Villa on Hollywood Boulevard</a></h2>
                                <p class="text-white fs-22 font-weight-500">070 Ruecker Knolls Suite 132</p>
                                <p class="text-white fs-32 font-weight-600 lh-16">DESDE $1.250.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box px-0 d-flex flex-column" style="background-color: #1477ad !important">
                <div class="bg-cover d-flex align-items-center custom-vh-02" style="background-image: url('front/images/bg-slider-03.jpg'); width: 50%">
                    <div class="container">
                        <div class="row py-8" data-animate="zoomIn">
                            <div class="col-lg-5 col-md-6 d-md-block d-none">
                                <a href="single-property-1.html" class="d-inline-block">
                                    <img src="front/images/single-image-07.jpg" class="rounded-lg" alt="Villa on Hollywood Boulevard">
                                </a>
                            </div>
                            <div class="col-lg-7 col-md-6">
                                <p class="text-white fs-22 font-weight-500 letter-spacing-367 text-uppercase mt-7 mb-4">For sale</p>
                                <h2 class="lh-12 mb-4">
                                    <a href="single-property-1.html" class="text-white fs-md-60 fs-48">Villa on Hollywood Boulevard</a>
                                </h2>
                                <p class="text-white fs-22 font-weight-500">070 Ruecker Knolls Suite 132</p>
                                <p class="text-white fs-32 font-weight-600 lh-16">DESDE $1.250.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </section>
    <section class="pt-lg-8 pt-8 pb-8">
        <div class="container container-xxl">
            <div class="row flex-lg-row flex-cloumn">
                <div class="col-lg-12 col-xxl-12">
                    <center>
                    <h2 class="text-heading">Proyectos en Venta</h2>
                    <span class="heading-divider"></span>
                    <p class="mb-7">Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscipit</p>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-6 col-lg-6 col-md-6 mb-6" data-animate="zoomIn">
                    <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image">
                        <img src="front/images/properties-grid-08.jpg" class="card-img" alt="Villa on Hollywood Boulevard">
                        <div class="card-img-overlay d-flex flex-column position-relative-sm">
                            <div class="d-flex">
                                <div class="mr-auto h-24 d-flex">
                                    <span class="badge badge-primary mr-2">For Sale</span>
                                </div>
                            </div>
                            <div class="mt-auto px-2">
                                <p class="fs-17 font-weight-bold text-white mb-0 lh-13">$1.250.000</p>
                                <h4 class="mt-0 mb-2 lh-1"><a href="single-property-1.html" class="fs-16 text-white">Villa on Hollywood Boulevard</a></h4>
                                <div class="border-top border-white-opacity-03 pt-2">
                                    <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-bedroom"></use>
                                            </svg>
                                            3 Br
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-shower"></use>
                                            </svg>
                                            3 Ba
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-square fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-square"></use>
                                            </svg>
                                            2300 Sq.Ft
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-Garage"></use>
                                            </svg>
                                            1 Gr
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-lg-6 col-md-6 mb-6" data-animate="zoomIn">
                    <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image">
                        <img src="front/images/properties-grid-08.jpg" class="card-img" alt="Villa on Hollywood Boulevard">
                        <div class="card-img-overlay d-flex flex-column position-relative-sm">
                            <div class="d-flex">
                                <div class="mr-auto h-24 d-flex">
                                    <span class="badge badge-primary mr-2">For Sale</span>
                                </div>
                            </div>
                            <div class="mt-auto px-2">
                                <p class="fs-17 font-weight-bold text-white mb-0 lh-13">$1.250.000</p>
                                <h4 class="mt-0 mb-2 lh-1"><a href="single-property-1.html" class="fs-16 text-white">Villa on Hollywood Boulevard</a></h4>
                                <div class="border-top border-white-opacity-03 pt-2">
                                    <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-bedroom"></use>
                                            </svg>
                                            3 Br
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-shower"></use>
                                            </svg>
                                            3 Ba
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-square fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-square"></use>
                                            </svg>
                                            2300 Sq.Ft
                                        </li>
                                        <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="3 Bedroom">
                                            <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                <use xlink:href="#icon-Garage"></use>
                                            </svg>
                                            1 Gr
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="tabbable">
            <ul class="nav nav-tabs wizard">
                <li class="active"><a href="#i9" data-toggle="tab" aria-expanded="false"><span class="nmbr">1</span>Step 01</a></li>
                <li><a href="#w4" data-toggle="tab" aria-expanded="false"><span class="nmbr">2</span>Step 02</a></li>
                <li><a href="#stateinfo" data-toggle="tab" aria-expanded="false"><span class="nmbr">3</span>Step 03</a></li>
                <li><a href="#companydoc" data-toggle="tab" aria-expanded="false"><span class="nmbr">4</span>Step 04</a></li>
                <li><a href="#finish" data-toggle="tab" aria-expanded="true"><span class="nmbr">5</span>Step 05</a></li>
            </ul>
        </div>
    </section>
    <section>
        <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/movil.jpg); min-height: 80vh !important">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-12 pb-7 pb-lg-0">
                        <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">Dejanos tus datos e invierte en propiedades para tu futuro</h3>
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
@endsection
@section('jss')
<script>
    $('.wizard li').click(function() {
        $(this).prevAll().addClass("completed");
        $(this).nextAll().removeClass("completed")

    });
</script>
@endsection