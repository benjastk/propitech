@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Blog de propiedades</title>
@endsection
@section('css')
@endsection
@section('content')
<section class="pt-13 pb-12">
    <div class="container">
        <div class="row ml-xl-0 mr-xl-n6">
        <div class="col-lg-8 mb-6 mb-lg-0 pr-xl-6 pl-xl-0">
            <div class="position-relative">
                <img class="rounded-lg d-block" src="/img/noticias/{{ $noticia->imagenNoticia }}" alt="">
                <!--<a href="#"
                        class="badge text-white bg-dark-opacity-04 fs-13 font-weight-500 bg-hover-primary hover-white m-2 position-absolute letter-spacing-1 pos-fixed-bottom">
                    rental
                </a>-->
            </div>
            <ul class="list-inline mt-4">
                <li class="list-inline-item mr-4"><img class="mr-1" src="/img/usuarios/{{ $noticia->avatarImg }}" style="width: 50px" alt="">{{ $noticia->name }} {{ $noticia->apellido }}
                </li>
                <li class="list-inline-item mr-4"><i class="far fa-calendar mr-1"></i> {{ $noticia->fechaPublicacion }}</li>
            </ul>
            <h3 class="fs-md-32 text-heading lh-141 mb-2">
                {{ $noticia->titulo }}
            </h3>
            <div class="lh-214 mb-9">
                <p>
                    {!! $noticia->texto !!}
                </p>
            </div>
            <div class="row pb-7 mb-6 border-bottom">

            <div class="col-sm-12 text-right text-sm-right">
                <span class="d-inline-block text-heading text-right font-weight-500 lh-17 mr-1">Compartir esta publicacion</span>
                <button type="button" class="btn btn-primary rounded-circle w-52px h-52 fs-20 d-inline-flex align-items-center justify-content-center"
                    data-container="body"
                    data-toggle="popover" data-placement="top" data-html="true" data-content='<ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                                                            class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item ">
                            <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                                                            class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                                                            class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-muted fs-15 hover-dark lh-1 px-2"><i
                                                            class="fab fa-youtube"></i></a>
                        </li>
                    </ul>
                    '>
                <i class="fad fa-share-alt"></i>
            </button>
            </div>
        </div>
        <h3 class="fs-22 text-heading lh-15 mb-6">Dejanos tu mensaje</h3>
        <form action="{{ route('formulario-contacto-propiedades')}}" method="post">
            @csrf
            <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                <input type="text" placeholder="Tu nombre" name="nombre" class="form-control form-control-lg border-0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                <input placeholder="Tu correo electronico" class="form-control form-control-lg border-0" type="email" name="email">
                </div>
            </div>
            </div>
            <div class="form-group mb-6">
                <textarea class="form-control border-0" placeholder="Tu mensaje" name="mensaje" rows="5"></textarea>
                <input type="hidden" name="id_formulario" value="5">
            </div>
            <button type="submit" class="btn btn-lg btn-primary px-9">Enviar</button>
        </form>
        </div>
        <div class="col-lg-4 pl-xl-6 pr-xl-0 primary-sidebar sidebar-sticky" id="sidebar">
        <div class="primary-sidebar-inner">
            <div class="card mb-4">
                <div class="card-body px-6 pt-5 pb-6">
                    <h4 class="card-title fs-16 lh-2 text-dark mb-3">Ultimas publicaciones</h4>
                    <ul class="list-group list-group-flush">
                        @if($noticias)
                        @foreach($noticias as $noticasAntes)
                        <li class="list-group-item px-0 pt-0 pb-3">
                            <div class="media">
                            <div class="position-relative mr-3">
                                <a href="/blog/{{ $noticasAntes->idNoticia }}"
                                                    class="d-block w-100px rounded pt-11 bg-img-cover-center"
                                                    style="background-image: url(/img/noticias/{{ $noticasAntes->imagenNoticia }})">
                                </a>
                                <!--<a href="blog-grid-with-sidebar.html"
                                                    class="badge text-white bg-dark-opacity-04 m-1 fs-13 font-weight-500 bg-hover-primary hover-white position-absolute pos-fixed-top">
                                creative
                                </a>-->
                            </div>
                            <div class="media-body">
                                <h4 class="fs-14 lh-186 mb-1">
                                    <a href="/blog/{{ $noticasAntes->idNoticia }}" class="text-dark hover-primary">
                                    {{ $noticasAntes->titulo }}
                                    </a>
                                </h4>
                                <div class="text-gray-light">
                                {{ $noticasAntes->fechaPublicacion }}
                                </div>
                            </div>
                            </div>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</section>
@endsection
@section('jss')

@endsection