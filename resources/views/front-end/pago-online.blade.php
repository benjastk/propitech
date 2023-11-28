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
<style>
    body
    {
        font-family: 'Gordita';
    }
</style>
@endsection
@section('content')
@if(session()->has('url'))
    <script>
        var redirectWindow = window.open('/', "_blank");
        redirectWindow.location;
    </script>
@endif
    @if($rut)
        @if($estadoPago)
            <section class="d-flex flex-column">
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/pay1.jpg)">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mxw-470 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown" style="margin-left: 0px !important; box-shadow: 10px 10px 12px -1px rgba(0,0,0,0.54) !important">
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
                                            <th>{{ strftime("%d de %B de %Y", strtotime($estadoPago->fechaVencimiento)) }}</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Identificador</th>
                                            <th>{{ $estadoPago->rut }}</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Numero de Documento</th>
                                            <th>{{ $estadoPago->token }}</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" style="font-weight: 800">Total a Pagar</th>
                                            <th style="font-weight: 800">@if($estadoPago->saldo > 0) 
                                                ${{ number_format($estadoPago->saldo, 0, '', '.')}} 
                                                @else 
                                                ${{ number_format($estadoPago->subtotal, 0, '', '.')}} 
                                                @endif</th>
                                        </tr>
                                    </thead>
                                    <!--<tbody>
                                        <tr>
                                            <th scope="row">{{ strftime("%d de %B de %Y", strtotime($estadoPago->fechaVencimiento)) }}</th>
                                            <td>{{ $estadoPago->rut }}</td>
                                            <td>{{ $estadoPago->token }}</td>
                                            <th scope="row">@if($estadoPago->saldo > 0) 
                                                ${{ number_format($estadoPago->saldo, 0, '', '.')}} 
                                                @else 
                                                ${{ number_format($estadoPago->subtotal, 0, '', '.')}} 
                                                @endif</th>
                                        </tr>               
                                    </tbody>-->
                                </table>
                                <br>
                                <br>
                                <form action="{{ route('ir-a-pagar-online')}}" method="post" target="_blank">
                                    @csrf
                                    <input type="hidden" name="rut" id="rut" value="{{ $estadoPago->rut }}">
                                    <center><button class="btn btn-primary btn-block rounded" style="width: 50%">Pagar</button></center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="d-flex flex-column">
                <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/pay1.jpg)">
                    <div class="container py-8 py-lg-12">
                        <div class="card border-0 mxw-470 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown" style="margin-left: 0px !important; box-shadow: 10px 10px 12px -1px rgba(0,0,0,0.54) !important" >
                            <div class="card-body pt-7 pb-6 px-7 shadow-lg-4" style="text-align: center">
                                <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">No existe deuda</h2>
                                <!--<p class="card-text text-center">Digita tu rut y paga tu arriendo fácil y rápido</p>-->
                                <p style="margin:auto">Cliente no registra deuda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @else
    <section class="d-flex flex-column">
        <div class="bg-cover d-flex align-items-center custom-vh-100" style="background-image: url(front/pay1.jpg)">
            <div class="container py-8 py-lg-12">
                <div class="card border-0 mxw-470 mx-auto mr-md-0 my-lg-3" data-animate="fadeInDown" style="margin-left: 0px !important; box-shadow: 10px 10px 12px -1px rgba(0,0,0,0.54) !important">
                    <div class="card-body pt-7 pb-6 px-7 shadow-lg-4">
                        <h2 class="card-title text-heading fs-30 text-center font-weight-600 lh-173 m-0">¡Paga tu arriendo aquí!</h2>
                        <p class="card-text text-center">Digita tu rut y paga tu arriendo fácil y rápido</p>
                        <form action="{{ url('/pago-online')}}" method="get" >
                            @csrf
                            <div class="form-row">
                                <br>
                                <br>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control form-control-lg border-0 shadow-none" name="rut" placeholder="Rut" style="border: 1px solid #80808061 !important;">
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
@if($estadoPago)
<script>
    $(function() 
    {
        let pagoValidado = false;
        let infoDelPago;
        function cron() {
            $.ajax({
                method: "POST",
                url: "/api/pago-arriendo-exitoso",
                data: {
                    'tokenEstadoPago': '{{ $estadoPago->token }}',
                    'idEstadoPago': '{{ $estadoPago->idEstadoPago }}'
                }
            }).done(function(msg) {
                console.log(msg.estado);
                if(msg.estado == 1)
                {
                    pagoValidado = true;
                    infoDelPago = msg.pago;
                    console.log(infoDelPago.numeroTransaccion);
                }
            });
        }
        function formatearNumero(numero){
            return new Intl.NumberFormat("es-CL").format(numero);
        }
        var intervalo = setInterval(function() 
        {
            if(pagoValidado == false)
            {
                cron();
            }
            else
            {
                clearInterval(intervalo);
                Swal.fire({
                    title: '<strong>Pago realizado exitosamente</strong>',
                    icon: 'success',
                    html:
                        '<table class="table">'+
                            '<tbody>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Identificador:</th>'+
                                    '<td style="text-align: left;font-size: 14px;">{{ $estadoPago->rut }}</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Documento:</th>'+
                                    '<td style="text-align: left;font-size: 14px;" >{{ $estadoPago->token }}</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Fecha de Vencimiento:</th>'+
                                    '<td style="text-align: left;font-size: 14px;" >{{ strftime("%d-%m-%Y", strtotime($estadoPago->fechaVencimiento)) }}</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Comprobante Nro°:</th>'+
                                    '<td style="text-align: left;font-size: 14px;" >' + infoDelPago.secuenciaTransaccion +'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Numero Transaccion:</th>'+
                                    '<td style="text-align: left;font-size: 14px;" >' + infoDelPago.numeroTransaccion +'</td>'+
                                '</tr>'+
                                '<tr>'+
                                    '<th style="text-align: left;font-size: 14px;" scope="row">Monto Pagado:</th>'+
                                    '<td style="text-align: left;font-size: 14px;" >$' + formatearNumero(infoDelPago.montoPago) +'</td>'+
                                '</tr>'+
                            '</tbody>'+
                        '</table>',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    showCloseButton: false,
                    confirmButtonText:
                        '<i href="/" class="fa fa-thumbs-up"></i> Perfecto!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = `/`
                    }
                });
            }
        }, 5000);
    });
</script>
@endif
@endsection