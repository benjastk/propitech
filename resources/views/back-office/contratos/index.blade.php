@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Lista de Contratos de arriendo</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>
                                <a href="/contratos/create" class="btn btn-info waves-effect waves-light" style="margin-right: 10px">
                                    <i class="bx bx-user-plus font-size-16 align-middle mr-2"></i> Crear Contrato de arriendo
                                </a>-->
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
                                                <th scope="col">Fecha de contrato</th>
                                                <th scope="col">Fecha de Termino</th>
                                                <th scope="col">Arrendatario</th>
                                                <th scope="col">Propiedad</th>
                                                <th scope="col">Valor Mensual</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Nota</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php(setlocale(LC_TIME, 'spanish'))
                                            @foreach($contratosArriendos as $contrato )
                                            <tr>
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($contrato->desde)) }}
                                                </td>
                                                <td>
                                                    {{ strftime("%d de %B de %Y", strtotime($contrato->hasta)) }}
                                                </td>
                                                <td>{{ $contrato->nombreArrendatario }} {{ $contrato->apellidoArrendatario }}</td>
                                                <td>{{ $contrato->direccion }} {{ $contrato->numero }}
                                                     @if($contrato->block) , Dpto. {{ $contrato->block }} @endif
                                                </td>
                                                <td>${{ number_format($contrato->arriendoMensual, 0, '', '.')}}</td>
                                                <td>
                                                    <div>
                                                        @if($contrato->idEstado == 61)
                                                        <a href="#" class="badge badge-soft-success font-size-11 m-1">{{ $contrato->nombreEstado }}</a>
                                                        @elseif($contrato->idEstado == 62)
                                                        <a href="#" class="badge badge-soft-danger font-size-11 m-1">{{ $contrato->nombreEstado }}</a>
                                                        @else
                                                        <a href="#" class="badge badge-soft-primary font-size-11 m-1">{{ $contrato->nombreEstado }}</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $contrato->nota }}</td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item px-2">
                                                            <a href="/estados-pagos/mostrar/{{ $contrato->idContratoArriendo }}" data-toggle="tooltip" data-placement="top" title="Estados de pago"><i class="bx bxs-dollar-circle"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="/contratos/edit/{{ $contrato->idContratoArriendo }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <form id="form1" action="{{ url('/contratos/destroy') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $contrato->idContratoArriendo }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                            <!--<a href="/contratos/edit/{{ $contrato->idContratoArriendo }}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="bx bxs-trash-alt"></i></a>-->
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
                                    {{ $contratosArriendos->links() }}
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
        