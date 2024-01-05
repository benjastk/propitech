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

@endsection
@section('content')
    <section>
        <div class="slick-slider mx-0 custom-arrow-center" data-slick-options='{"slidesToShow": 1, "infinite":true, "autoplay":true,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 992,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}}]}'>
            <div class="box px-0 d-flex flex-column" style="display: flex" >
                <div class="row">
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
    <section class="pt-11">
        <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/movil.jpg); min-height: 80vh !important">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-12 pb-7 pb-lg-0">
                        <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">Dejanos tus datos e invierte en propiedades para tu futuro</h3>
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
                                <input type="hidden" name="id_formulario" value="3">
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

@endsection