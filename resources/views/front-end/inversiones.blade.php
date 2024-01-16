@extends('front-end.layouts.app5')
@section('titulo')
<title>Propitech Inversiones - Hacemos tu sueño realidad</title>
@endsection
@section('meta')
<meta name="description" content="Propitech te entrega la mejor forma de invertir en propiedades, te regalos el pie y puedes acceder a multiples descuentos en propiedades.">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
<style>
    .navegadorrr{
        font-weight: 400;
        text-align: left;
        font-family: '"Helvetica Neue",Helvetica,Arial,sans-serif';
        font-size: 14px;
        line-height: 1.42857143;
        color: '#333';
        box-sizing: border-box;
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        background-color: transparent;
        padding: 0;
        width: 100%;
        margin: 1em auto;
        border-radius: .25em;
        clear: both;
        border-bottom: none;
    }
    .activoss{
        font-weight: 400;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        list-style: none;
        box-sizing: border-box;
        display: block;
        position: relative;
        padding: 0;
        margin: 4px 4px 4px 0;
        width: 19.6%;
        float: left;
        text-align: center;
    }
    .activoss a{
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        list-style: none;
        text-align: center;
        box-sizing: border-box;
        transition: all 0.2s;
        text-decoration: none;
        display: block;
        margin-right: 2px;
        line-height: 1.42857143;
        border-radius: 4px 4px 0 0;
        position: relative;
        padding: 1em .8em .8em 2.5em;
        cursor: default;
        border: 1px solid #ddd;
        opacity: 1;
        font-size: 14px;
        color: #fff !important;
        background-color: #2c3f4c !important;
        border-color: #2c3f4c !important;
        border-bottom: none !important;
        padding-top: 15px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    .navegadorrr li
    {
        font-weight: 400;
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        list-style: none;
        box-sizing: border-box;
        display: block;
        position: relative;
        padding: 0;
        margin: 4px 4px 4px 0;
        width: 19.6%;
        float: left;
        text-align: center;
        background-color: grey;
    }
    .completed a
    {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        list-style: none;
        text-align: center;
        box-sizing: border-box;
        transition: all 0.2s;
        text-decoration: none;
        display: block;
        margin-right: 2px;
        line-height: 1.42857143;
        border-radius: 4px 4px 0 0;
        position: relative;
        padding: 1em .8em .8em 2.5em;
        cursor: default;
        border: 1px solid #ddd;
        opacity: 1;
        font-size: 14px;
        color: #fff !important;
        background-color: green !important;
        border-color: #2c3f4c !important;
        border-bottom: none !important;
        padding-top: 15px;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
    .hacerZoom:hover {
        transform: scale(1.1);
    }
</style>
@endsection
@section('content')
    <section>
        @if(count($proyectosDestacados))
        <div class="slick-slider mx-0 custom-arrow-center" data-slick-options='{"slidesToShow": 1, "infinite":true, "autoplay":true,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 992,"settings": {"slidesToShow":1,"arrows":false,"dots":false}},{"breakpoint": 768,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":false}}]}'>
            @foreach($proyectosDestacados as $proyectoDestacado)
            <div class="box px-0 d-flex flex-column" style="display: flex" >
                <div class="row" style="margin: 0px !important">
                    <div class="bg-cover d-flex align-items-center custom-vh-02" style="background-image: url('img/proyecto/{{ $proyectoDestacado->fotoProyecto}}'); width: 50%">
                        
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
                                    @if($proyectoDestacado->idDestacado)
                                    <p class="text-white fs-22 font-weight-500 letter-spacing-367 text-uppercase mt-7 mb-4">Entrega Inmediata</p>
                                    @endif
                                    <h2 class="lh-12 mb-4" style="font-family: FeltThat,sans-serif !important;">
                                        <a href="/proyectos-venta/{{ $proyectoDestacado->idProyecto }}" class="text-white fs-md-60 fs-48">
                                            {{ $proyectoDestacado->nombreComuna }}, 
                                            @if($proyectoDestacado->idRegion == 13)
                                            Región {{ $proyectoDestacado->nombreRegion }}
                                            @else
                                            Región de {{ $proyectoDestacado->nombreRegion }}
                                            @endif
                                        </a>
                                    </h2>
                                    <p class="text-white fs-22 font-weight-500">{{ $proyectoDestacado->direccion }} {{ $proyectoDestacado->numero }}</p>
                                    <p class="text-white fs-32 font-weight-600 lh-16" style="font-family: 'Gordita';">DESDE {{ number_format($proyectoDestacado->valorUFDesde, 0, ",", ".") }} UF</p>
                                </div>
                                <div class="col-lg-1 col-md-1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="d-none d-xl-block d-md-block">
            <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos " id="contactanos" style="background-image: url(/front/coomingsoon.jpg); min-height: 100vh !important">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 pb-7 pb-lg-0">
                            
                        </div>
                        <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                            <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 45px !important;">
                                Próximamente a la Venta: Descubre Nuestros Futuros Proyectos Inmobiliarios
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-sm-block d-xl-none d-md-none d-lg-none">
            <div class="bg-cover d-flex align-items-center custom-vh-100 contactanos" id="contactanos" style="background-image: url(/front/commingSoonMobile.jpg); min-height: 80vh !important">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 pb-7 pb-lg-0">
                            <h3 class="text-heading mb-4 fs-22 lh-15 pr-6" style="color: white !important; font-weight: bolder; text-align: center; font-style: italic;font-family: 'Gordita';font-size: 33px !important;">
                                Próximamente a la Venta: Descubre Nuestros Futuros Proyectos Inmobiliarios
                            </h3>
                        </div>
                        <div class="col-md-6 col-sm-12 pb-7 pb-lg-0">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
    <section class="pt-lg-8 pt-8 pb-8">
        <div class="container container-xxl">
            <div class="row flex-lg-row flex-cloumn">
                <div class="col-lg-12 col-xxl-12">
                    <center>
                    <h2 class="text-heading">Proyectos en Venta</h2>
                    <span class="heading-divider"></span>
                    <p class="mb-7">Revisa los mejores proyectos que tenemos para ti</p>
                    </center>
                </div>
            </div>
            <div class="row">
            @if(count($proyectos))
                @foreach($proyectos as $proyecto)
                <div class="col-xxl-6 col-lg-6 col-md-6 mb-6" data-animate="zoomIn">
                    <div class="card border-0 bg-overlay-gradient-3 rounded-lg hover-change-image">
                        <img src="img/proyecto/{{ $proyecto->fotoProyecto}}" class="card-img" alt="">
                        <a href="/proyectos-venta/{{ $proyecto->idProyecto }}">
                            <div class="card-img-overlay d-flex flex-column position-relative-sm">
                                <div class="d-flex">
                                    <div class="mr-auto h-24 d-flex">
                                        <span class="badge badge-primary mr-2">Venta</span>
                                        @if($proyecto->idDestacado)
                                        <span class="badge badge-warning mr-2">Entrega Inmediata</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-auto px-2">
                                    <p class="fs-17 font-weight-bold text-white mb-0 lh-13">Desde {{ number_format($proyecto->valorUFDesde, 0, ",", ".") }} UF</p>
                                    <h4 class="mt-0 mb-2 lh-1" style="color: white">{{ $proyecto->nombreProyecto }}</h4>
                                    <div class="border-top border-white-opacity-03 pt-2">
                                        <ul class="list-inline d-flex mb-0 flex-wrap mt-2 mt-lg-0 mr-n5">
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Habitaciones">
                                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                {{ $proyecto->dormitoriosDesde }} / {{ $proyecto->dormitoriosHasta}}
                                            </li>
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Baños">
                                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                {{ $proyecto->baniosDesde }} / {{ $proyecto->baniosHasta }}
                                            </li>
                                            <li class="list-inline-item text-white font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="Tamaño">
                                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                Desde {{ $proyecto->metrosDesde }} Hasta {{ $proyecto->metrosHasta }} MT2
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
            @else
            <div class="col-12">
                <center><h6 style="text-align:center">Próximamente contaremos con ofertas exclusivas para ti, dejanos tus datos y un ejecutivo te contactará</h6></center>
            </div>
            @endif
            </div>
        </div>
    </section>
    <section class="pb-11">
        <div class="row" style="margin: 0px">
            <div class="col-12" style="margin: 0px !important; padding: 0px !important">
                <center>
                <h2 class="text-heading">¿Como lo hacemos?</h2>
                <span class="heading-divider"></span>
                <p class="mb-7">Contamos con un proceso simple y rápido, nuestros ejecutivos te asesorarán en todo momento.</p>
                </center>
            </div>
        </div>
        <div class="row" style="margin: 0px !important; color: white !important">
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                    Revisa nuestros proyectos y elige el que más te guste
                </div>
            </div>
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12 mt-2">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                    Envianos tus datos para ser contactado por un ejecutivo
                </div>
            </div>
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12 mt-2">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                Te enviamos la cotización de los proyectos que te interesen
                </div>
            </div>
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12 mt-2">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                    Visita el proyecto y aclara tus dudas con nosotros
                </div>
            </div>
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12 mt-2">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                Tomamos tu crédito hipotecario y ayudamos con la gestión
                </div>
            </div>
            <div class="col-lx-2 col-lg-2 col-md-12 col-sm-12 mt-2">
                <div style="background-color: green; height: 100%; padding: 15px; border-radius: 9px; box-shadow: rgb(38, 57, 77) 0px 20px 30px">
                    Entregamos tu propiedad arrendada en caso de lo que necesites
                </div>
            </div> 
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
@endsection
@section('jss')
<script>
    $('.navegadorrr li').click(function() {
        $(this).prevAll().addClass("completed");
        $(this).nextAll().removeClass("completed");
    });
</script>
@endsection