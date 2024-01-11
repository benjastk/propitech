@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech Inversiones - Proyecto en  </title>
@endsection
@section('meta')
<meta name="description" content=" ">
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
                                <li class="list-inline-item badge badge-orange mr-2">ENTREGA INMEDIATA</li>
                                <li class="list-inline-item badge badge-primary mr-3">VENTA</li>
                            </ul>
                        </div>
                        <div class="d-md-flex justify-content-md-between mb-6">
                            <div>
                                <h2 class="fs-35 font-weight-600 lh-15 text-heading">Villa on Hollywood Boulevard</h2>
                                <p class="mb-0"><i class="fal fa-map-marker-alt mr-2"></i>398 Pete Pascale Pl, New York</p>
                            </div>
                            <div class="mt-2 text-md-right">
                                <p class="fs-22 text-heading font-weight-bold mb-0" style="line-height: normal">DESDE</p>
                                <p class="text-heading font-weight-bold mb-0" style="font-family: 'Gordita'; font-size: 30px">UF 3.500</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <section class="pb-7 shadow-5">
        <div class="container">
            <div class="galleries position-relative">
                <div class="tab-content p-0 shadow-none">
                    <div class="tab-pane fade show active" id="image" role="tabpanel">
                        <div class="slick-slider dots-white arrow-inner" data-slick-options='{"slidesToShow": 1, "autoplay":false}'>
                            <div class="box">
                                <div class="item item-size-3-2">
                                    <div class="card p-0">
                                        <a href="/front/images/single-property-lg-1.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="03" style="background-image:url('/front/images/single-property-lg-4.jpg')">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="item item-size-3-2">
                                    <div class="card p-0">
                                        <a href="/front/images/single-property-lg-4.jpg" class="card-img" data-gtf-mfp="true" data-gallery-id="03" style="background-image:url('/front/images/single-property-lg-4.jpg')">
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
                            <p class="mb-0 lh-214">Massa tempor nec feugiat nisl pretium. Egestas fringilla phasellus
                                faucibus scelerisque eleifend donec. Porta nibh venenatis cras sed felis eget velit aliquet.
                                Neque volutpat ac tincidunt vitae semper quis lectus. Turpis in eu mi bibendum neque egestas
                                congue quisque. Sed elementum tempus egestas sed sed risus pretium quam. Dignissim sodales ut eu
                                sem. Nibh mauris cursus mattis molestie a iaculis at erat pellentesque. Id interdum velit
                                laoreet
                                id donec ultrices tincidunt.</p>
                        </section>
                        <section class="mt-2 pb-3 px-6 pt-5 rounded-lg">
                            <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important">Características Principales</h4>
                            <div class="row">
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-family fs-32 text-primary">
                                                <use xlink:href="#icon-family"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Type</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">Single Family</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-year fs-32 text-primary">
                                                <use xlink:href="#icon-year"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">year built</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">2020</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-heating fs-32 text-primary">
                                                <use xlink:href="#icon-heating"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">heating</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">Radiant</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-price fs-32 text-primary">
                                                <use xlink:href="#icon-price"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">SQFT</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">979.0</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-bedroom fs-32 text-primary">
                                                <use xlink:href="#icon-bedroom"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Bedrooms</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">3</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-sofa fs-32 text-primary">
                                                <use xlink:href="#icon-sofa"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">bathrooms</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">2</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-Garage fs-32 text-primary">
                                                <use xlink:href="#icon-Garage"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">GARAGE</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">1</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-4 mb-6">
                                    <div class="media">
                                        <div class="p-2 shadow-xxs-1 rounded-lg mr-2">
                                            <svg class="icon icon-status fs-32 text-primary">
                                                <use xlink:href="#icon-status"></use>
                                            </svg>
                                        </div>
                                        <div class="media-body">
                                            <h5 class="my-1 fs-14 text-uppercase letter-spacing-093 font-weight-normal">Status</h5>
                                            <p class="mb-0 fs-13 font-weight-bold text-heading">Active</p>
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
                                        <form>
                                            <div class="form-group mb-2">
                                                <label for="name" class="sr-only">Name</label>
                                                <input type="text" class="form-control form-control-lg border-0 shadow-none" id="name" placeholder="First Name, Last Name">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="email" class="sr-only">Email</label>
                                                <input type="text" class="form-control form-control-lg border-0 shadow-none" id="email" placeholder="Your email">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="phone" class="sr-only">Phone</label>
                                                <input type="text" class="form-control form-control-lg border-0 shadow-none" id="phone" placeholder="Your phone">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="message" class="sr-only">Message</label>
                                                <textarea class="form-control border-0 shadow-none" id="message">Mensaje</textarea>
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
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Balcony
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Fireplace
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Fireplace
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Basement
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Cooling
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Cooling
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dining room
                                    </li>
                                    <li class="col-sm-6 col-6 mb-2"><i class="far fa-check mr-2 text-primary"></i>Dishwasher
                                    </li>
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
                                <div class="col-sm-6 col-lg-4 mb-6">
                                    <div class="item item-size-4-3">
                                        <div class="card p-0 hover-zoom-in">
                                            <a href="/front/images/single-property-lg-11.jpg" class="card-img d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04" data-gtf-mfp="true" data-gallery-id="05" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(/front/images/single-property-11.jpg);">
                                                <p class="fs-48 font-weight-600 lh-1 mb-4" style="color: #26719e !important;" >TIPO A</p>    
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 mb-6">
                                    <div class="item item-size-4-3">
                                        <div class="card p-0 hover-zoom-in">
                                            <a href="/front/images/single-property-lg-12.jpg" class="card-img d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04" data-gtf-mfp="true" data-gallery-id="05" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(/front/images/single-property-11.jpg);">
                                                <p class="fs-48 font-weight-600 lh-1 mb-4" style="color: #26719e !important;">TIPO B</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 mb-6">
                                    <div class="item item-size-4-3">
                                        <div class="card p-0 hover-zoom-in">
                                            <a href="/front/images/single-property-lg-13.jpg" class="card-img d-flex flex-column align-items-center justify-content-center hover-image bg-dark-opacity-04" data-gtf-mfp="true" data-gallery-id="05" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(/front/images/single-property-11.jpg);">
                                            <p class="fs-48 font-weight-600 lh-1 mb-4" style="color: #26719e !important;">TIPO C</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>
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
                        <p class="mb-0 p-3 bg-white shadow rounded-lg position-absolute pos-fixed-bottom mb-4 ml-4 lh-17 z-index-2">62 Gresham St, Victoria Park <br/>
                            WA 6100, Australia</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <br>
                    <div class="galleries position-relative" style="height: auto; !important">
                        <div class="tab-content p-0 shadow-none">
                            <div class="slick-slider" data-slick-options='{"slidesToShow": 1, "autoplay":true, "dots":false,"arrows":false, "infinite": true}'>
                                <div class="box">
                                    <div class="item item-size-3-2">
                                        <div class="card p-0">
                                            <a href="#" class="card-img" style="background-image:url('/front/images/manquehue.jpg')">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="item item-size-3-2">
                                        <div class="card p-0">
                                            <a href="#" class="card-img" style="background-image:url('/front/images/parque-araucano.jpg')">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">   
                <article class="col-lg-12">
                    <section class="mt-2 pb-7 px-6 pt-6 bg-white rounded-lg">
                        <h4 class="fs-22 text-heading mb-6" style="font-family: FeltThat,sans-serif !important; font-size: 45px !important" >Otros Proyectos</h4>
                        <div class="slick-slider otros" data-slick-options='{"slidesToShow": 3, "autoplay":true, "dots":false,"arrows":true, "infinite": true,"responsive":[{"breakpoint": 1200,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 992,"settings": {"slidesToShow":2}},{"breakpoint": 768,"settings": {"slidesToShow": 1}},{"breakpoint": 576,"settings": {"slidesToShow": 1}}]}'>
                            <div class="box">
                                <div class="card shadow-hover-2">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                                        <img src="/front/images/properties-grid-38.jpg" alt="Home in Metric Way">
                                        <div class="card-img-overlay p-2 d-flex flex-column">
                                            <div>
                                                <span class="badge mr-2 badge-primary">for Sale</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <h2 class="card-title fs-16 lh-2 mb-0"><a href="single-property-1.html" class="text-dark hover-primary">Home in Metric Way</a></h2>
                                        <p class="card-text font-weight-500 text-gray-light mb-2">1421 San Pedro St, Los Angeles</p>
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n4">
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bedroom">
                                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                3 Br
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bathrooms">
                                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                3 Ba
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="Size">
                                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                2300 Sq.Ft
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="1 Garage">
                                                <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-Garage"></use>
                                                </svg>
                                                1 Gr
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-17 font-weight-bold text-heading mb-0">$1.250.000</p>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="card shadow-hover-2">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                                        <img src="/front/images/properties-grid-06.jpg" alt="Garden Gingerbread House">
                                        <div class="card-img-overlay p-2 d-flex flex-column">
                                            <div>
                                                <span class="badge mr-2 badge-primary">for Sale</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                    <h2 class="card-title fs-16 lh-2 mb-0">
                                        <a href="single-property-1.html" class="text-dark hover-primary">Garden Gingerbread House</a>
                                    </h2>
                                    <p class="card-text font-weight-500 text-gray-light mb-2">1421 San Pedro St, Los Angeles</p>
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n4">
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bedroom">
                                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                3 Br
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bathrooms">
                                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                3 Ba
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="Size">
                                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                2300 Sq.Ft
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="1 Garage">
                                                <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-Garage"></use>
                                                </svg>
                                                1 Gr
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-17 font-weight-bold text-heading mb-0">$550<span class="text-gray-light font-weight-500 fs-14"> / month</span>
                                    </p>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="card shadow-hover-2">
                                    <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                                        <img src="/front/images/properties-grid-02.jpg" alt="Affordable Urban House">
                                        <div class="card-img-overlay p-2 d-flex flex-column">
                                            <div>
                                                <span class="badge mr-2 badge-primary">for Sale</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3">
                                        <h2 class="card-title fs-16 lh-2 mb-0"><a href="single-property-1.html" class="text-dark hover-primary">Affordable Urban House</a></h2>
                                        <p class="card-text font-weight-500 text-gray-light mb-2">1421 San Pedro St, Los Angeles</p>
                                        <ul class="list-inline d-flex mb-0 flex-wrap mr-n4">
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bedroom">
                                                <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-bedroom"></use>
                                                </svg>
                                                3 Br
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="3 Bathrooms">
                                                <svg class="icon icon-shower fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-shower"></use>
                                                </svg>
                                                3 Ba
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-4" data-toggle="tooltip" title="Size">
                                                <svg class="icon icon-square fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-square"></use>
                                                </svg>
                                                2300 Sq.Ft
                                            </li>
                                            <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5" data-toggle="tooltip" title="1 Garage">
                                                <svg class="icon icon-Garage fs-18 text-primary mr-1">
                                                    <use xlink:href="#icon-Garage"></use>
                                                </svg>
                                                1 Gr
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">
                                        <p class="fs-17 font-weight-bold text-heading mb-0">$1.250.000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
    <section>
        <div class="d-flex bottom-bar-action bottom-bar-action-01 py-2 px-4 bg-gray-01 align-items-center position-fixed fixed-bottom d-sm-none">
            <div class="media align-items-center">
                <img src="/front/images/irene-wallace.png" alt="Irene Wallace" class="mr-4 rounded-circle">
                <div class="media-body">
                    <a href="#" class="d-block text-dark fs-15 font-weight-500 lh-15">Irene Wallace</a>
                    <span class="fs-13 lh-2">Sales Excutive</span>
                </div>
            </div>
            <div class="ml-auto">
                <button type="button" class="btn btn-primary fs-18 p-2 lh-1 mr-1 mb-1 shadow-none" data-toggle="modal" data-target="#modal-messenger"><i class="fal fa-comment"></i></button>
                <a href="tel:(+84)2388-969-888" class="btn btn-primary fs-18 p-2 lh-1 mb-1 shadow-none" target="_blank"><i class="fal fa-phone"></i></a>
            </div>
        </div>
        <div class="modal fade" id="modal-messenger" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <h4 class="modal-title text-heading" id="exampleModalLabel">Contact Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-6">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control form-control-lg border-0" placeholder="First Name, Last Name">
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" class="form-control form-control-lg border-0" placeholder="Your Email">
                        </div>
                        <div class="form-group mb-2">
                            <input type="tel" class="form-control form-control-lg border-0" placeholder="Your phone">
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control border-0" rows="4">Hello, I'm interested in Villa Called Archangel</textarea>
                        </div>
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="exampleCheck3">
                            <label class="form-check-label fs-13" for="exampleCheck3">Egestas fringilla phasellus faucibus
                                scelerisque eleifend donec.</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block rounded">Request Info</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
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
</main>
@endsection
@section('jss')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzyDN_wIGU_xsKCYm-0L7pF54cuR2sq5I&callback=initMap" async defer></script>
<script>
    var map;
    var lat = -33.45;
    var lng = -70.666667;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lng, lat },
            zoom: 14,
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
        