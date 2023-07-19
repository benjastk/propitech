@extends('back-office.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Listado de cuentas Bancarias de Usuario</h4>

                            <div class="page-title-right">
                                <!--<ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contactos</a></li>
                                    <li class="breadcrumb-item active">Lista de usuarios</li>
                                </ol>-->
                                <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg">
                                <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Crear Cuenta Bancaria
                                </button>
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
                                                <th scope="col">Banco</th>
                                                <th scope="col">Tipo de cuenta</th>
                                                <th scope="col">Numero de cuenta</th>
                                                <th scope="col">Correo Asociado</th>
                                                <th scope="col">Observaciones</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuentasBancarias as $cuentaBancaria )
                                            <tr>
                                                <td>{{ $cuentaBancaria->nombreBanco }}</td>
                                                <td>
                                                    <p class="text-muted mb-0">{{ $cuentaBancaria->nombreTipoCuenta }}</p>
                                                </td>
                                                <td>{{ $cuentaBancaria->numeroCuenta }}</td>
                                                <td>{{ $cuentaBancaria->correoAsociado }}</td>
                                                <td>{{ $cuentaBancaria->observaciones }}</td>
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <!--<li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Message"><i class="bx bx-message-square-dots"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <a href="" data-toggle="tooltip" data-placement="top" title="Profile"><i class="bx bx-user-circle"></i></a>
                                                        </li>-->
                                                        <li class="list-inline-item px-2">
                                                            <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg{{ $cuentaBancaria->idUsuarioCuentaBancaria }}" data-placement="top" title="Editar"><i class="bx bxs-edit-alt"></i></a>
                                                        </li>
                                                        <li class="list-inline-item px-2">
                                                            <form action="{{ url('/users/cuentas-bancarias/delete') }}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $cuentaBancaria->idUsuarioCuentaBancaria }}"/>
                                                                <button style="border: 0px; background-color: white;" type="submit"><i class="bx bxs-trash-alt"></i></button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div style="text-align:center">
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
        <!--  Modal Caracteristicas -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Nueva Cuenta Bancaria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" style="padding:20px !important">
                                <form action="{{ url('/users/cuentas-bancarias/store') }}" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Banco</label>
                                            <select name="idBanco" class="form-control">
                                                <option value="">Seleccione Banco</option>
                                                @foreach ($bancos as $banco)
                                                    <option value="{{ $banco->idBanco }}">{{ $banco->nombreBanco }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Tipo de cuenta</label>
                                            <select name="idTipoCuenta" class="form-control">
                                                <option value="">Seleccione tipo de cuenta</option>
                                                @foreach ($tiposCuentasBancarias as $tipo)
                                                    <option value="{{ $tipo->idTipoCuenta }}">{{ $tipo->nombreTipoCuenta }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Numero de cuenta</label>
                                            <input id="numeroCuenta" name="numeroCuenta" type="text" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Correo asociado</label>
                                            <input id="correoAsociado" name="correoAsociado" type="text" class="form-control">
                                        </div>
                                        <div class="col-12" style="display:none">
                                            <input id="idUsuario" name="idUsuario" type="text" value="{{ $usuario->id }}" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Observaciones</label>
                                            <input id="observaciones" name="observaciones" type="text" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-sm-3">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                            <button class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($cuentasBancarias)
        @foreach($cuentasBancarias as $modalesCuentas)
        <div class="modal fade bs-example-modal-lg{{ $modalesCuentas->idUsuarioCuentaBancaria }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{ $modalesCuentas->idUsuarioCuentaBancaria }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Editar Cuenta Bancaria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12" style="padding:20px !important">
                                <form action="{{ url('/users/cuentas-bancarias/update/'.$modalesCuentas->idUsuarioCuentaBancaria) }}" method="POST" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12">
                                            <label>Banco</label>
                                            <select name="idBanco" class="form-control">
                                                <option value="">Seleccione Banco</option>
                                                @foreach ($bancos as $banco)
                                                    <option value="{{ $banco->idBanco }}" {{ ($banco->idBanco == $modalesCuentas->idBanco) ? 'selected' :'' }} >{{ $banco->nombreBanco }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Tipo de cuenta</label>
                                            <select name="idTipoCuenta" class="form-control">
                                                <option value="">Seleccione tipo de cuenta</option>
                                                @foreach ($tiposCuentasBancarias as $tipo)
                                                    <option value="{{ $tipo->idTipoCuenta }}" {{ ($tipo->idTipoCuenta == $modalesCuentas->idTipoCuenta) ? 'selected' :'' }} >{{ $tipo->nombreTipoCuenta }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Numero de cuenta</label>
                                            <input id="numeroCuenta" name="numeroCuenta" value="{{ $modalesCuentas->numeroCuenta }}" type="text" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Correo asociado</label>
                                            <input id="correoAsociado" name="correoAsociado" type="text" value="{{ $modalesCuentas->correoAsociado }}" class="form-control">
                                        </div>
                                        <div class="col-12" style="display:none">
                                            <input id="idUsuario" name="idUsuario" type="text" value="{{ $modalesCuentas->idUsuario }}" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <label>Observaciones</label>
                                            <input id="observaciones" name="observaciones" value="{{ $modalesCuentas->observaciones }}" type="text" class="form-control">
                                        </div>
                                        <br>
                                        <div class="col-sm-3">
                                            <p style="margin-bottom: 5px">&nbsp;</p>
                                            <button class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <!-- end main content-->
@endsection
        