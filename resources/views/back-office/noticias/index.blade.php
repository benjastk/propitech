@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Lista de publicaciones</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <a href="/noticias/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-user-plus font-size-16 align-middle mr-2"></i> Crear Publicación
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 70px;">#</th>
                                                <th scope="col">Titulo</th>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Publicada</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($noticias as $noticia )
                                            <tr>
                                                <td>
                                                    <img src="/img/noticias/{{ $noticia->imagenNoticia}}" width="120px" height="100px">
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1"><a href="#" class="text-dark">{{ $noticia->titulo }} </a></h5>
                                                </td>
                                                <td>{{ $noticia->name }} {{ $noticia->apellido }}</td>
                                                <td>
                                                    <div>
                                                        @if($noticia->deleteOf == 1)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">No Activa</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">Activa</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="badge badge-dark">{{ $noticia->fechaPublicacion }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item px-2">
                                                            <a href="/noticias/edit/{{ $noticia->idNoticia }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <form id="form1" action="{{ url('/noticias/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $noticia->idNoticia }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/noticias/edit/{{ $noticia->id }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                    {{ $noticias->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Propitech.
                    </div>
                    <div class="col-sm-6">
                        <!--<div class="text-sm-right d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>-->
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
@endsection
        