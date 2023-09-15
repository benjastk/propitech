@extends('front-end.layouts.app4')
@section('titulo')
<title>Propitech - Pago Online</title>
@endsection
@section('meta')
<meta name="description" content="Paga tu arriendo 100% online">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
    @if($rut)
        @if($estadoPago)
            <section class="d-flex flex-column">
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">Tu deuda actual</h2>
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
                                            <th scope="row">{{ strftime("%d de %B de %Y", strtotime($estadoPago->fechaVencimiento)) }}</th>
                                            <td>{{ $estadoPago->rut }}</td>
                                            <td>{{ $estadoPago->idEstadoPago }}</td>
                                            <th scope="row">@if($estadoPago->saldo > 0) 
                                                ${{ number_format($estadoPago->saldo, 0, '', '.')}} 
                                                @else 
                                                ${{ number_format($estadoPago->subtotal, 0, '', '.')}} 
                                                @endif</th>
                                        </tr>               
                                    </tbody>
                                </table>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="d-flex flex-column">
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">No existe deuda</h2>
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
        <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/images/bg-home-6.jpg)">
            <div class="container py-8 py-lg-12">
                <div class="card border-0 mxw-470 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown">
                    <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                        <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">¡Paga tu arriendo aquí!</h2>
                        <p class="card-text text-center">Digita tu rut y paga tu arriendo fácil y rápido</p>
                        <form action="{{ url('/pago-online')}}" method="get" >
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
                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-none">¡Pagar Ahora!</button>
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
    </section>
    @endif
@endsection
@section('jss')

@endsection