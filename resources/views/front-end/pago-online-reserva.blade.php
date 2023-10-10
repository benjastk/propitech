@extends('front-end.layouts.app4')
@section('titulo')
<title>Propitech - Pago Reserva Online</title>
@endsection
@section('meta')
<meta name="description" content="Paga tu reserva 100% online">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
    @if($rut)
        @if($reserva)
            <section class="d-flex flex-column">
                <!--<div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">-->
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-color: #2db5ff !important">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">Tu reserva de departamento</h2>
                                <!--<p class="card-text text-center">Digita tu rut y paga tu arriendo fácil y rápido</p>-->
                                <br>
                                <br>
                                @php(setlocale(LC_TIME, 'spanish'))
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col">Fecha de Vencimiento</th>
                                        <th scope="col">Identificador</th>
                                        <th scope="col">Numero de Documento</th>
                                        <th scope="col">Total a Pagar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ strftime("%d de %B de %Y", strtotime($reserva->fechaDePago)) }}</th>
                                            <td>{{ $reserva->rut }}</td>
                                            <td>{{ $reserva->identificadorUnico }}</td>
                                            <th scope="row">${{ number_format($reserva->valorReserva, 0, '', '.')}}</th>
                                        </tr>               
                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <form action="{{ route('ir-a-pagar-reserva-online')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="rut" id="rut" value="{{ $reserva->rut }}">
                                    <center><button class="btn btn-primary btn-block rounded" style="width: 50%">Pagar</button></center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="d-flex flex-column">
                <!--<div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">-->
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-color: #2db5ff !important">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">No existe reserva a pagar</h2>
                                <!--<p class="card-text text-center">Digita tu rut y paga tu arriendo fácil y rápido</p>-->
                                <p>Cliente no registra deuda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @else
    <section class="d-flex flex-column">
        <!--<div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">-->
        <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-color: #2db5ff !important">
            <div class="container py-8 py-lg-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <img src="/front/images/profile-img.png" alt="" style="width: 100%; float: right; position: inherit;">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card border-0 mxw-470 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">¡Paga tu reserva aquí!</h2>
                                <p class="card-text text-center">Digita tu rut y paga tu reserva de propiedad</p>
                                <form action="{{ url('/pago-reserva-online')}}" method="get" >
                                    @csrf
                                    <div class="form-row">
                                        <br>
                                        <br>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control form-control-lg border-0 shadow-none" name="rut" placeholder="Rut">
                                        </div>
                                        <p class="card-text text-center">* Ingresa tu RUT sin puntos y con guión.</p>
                                        <br>
                                        <br>
                                        <div class="col-md-12 mb-4">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none">¡Consultar Ahora!</button>
                                        </div>
                                        <!--<div class="col-md-12 ml-6 custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check10-1" name="features">
                                        <label class="custom-control-label" for="check10-1">I consent to having this website store
                                            my submitted information so they can respond to my inquiry.</label>
                                        </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
@section('jss')

@endsection