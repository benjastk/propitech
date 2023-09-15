@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Publica tu propiedad</title>
@endsection
@section('meta')
<meta name="description" content="Publica tu propiedad con nosotros">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
<section class="bg-patten-05 mb-13 mt-5">
    <div class="container">
        <h2 class="text-heading mb-2 fs-22 fs-md-32 text-center lh-16 mxw-571 px-lg-8">
            Publica tu propiedad con nosotros
        </h2>
        <p class="text-center mxw-670 mb-8">
        Dejanos tus datos y el de tu propiedad y uno de nuestros asesores te contactará para ayudarte a vender o arrendar tu propiedad en simples pasos.
        </p>
        <form class="mxw-774" action="{{ route('formulario-publica-tu-propiedad')}}" method="post" >
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" placeholder="Nombre" class="form-control form-control-lg border-0" name="nombrePropietario" style="border:2px solid #e3e2e2 !important" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input placeholder="Correo electronico" class="form-control form-control-lg border-0" type="email" required name="correoPropietario" style="border:2px solid #e3e2e2 !important">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" placeholder="Telefono" name="telefonoPropietario" class="form-control form-control-lg border-0" required style="border:2px solid #e3e2e2 !important">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" placeholder="Direccion" class="form-control form-control-lg border-0" name="direccionPropiedad" required style="border:2px solid #e3e2e2 !important">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select placeholder="Tipo de operación" name="tipoOperacion" class="form-control form-control-lg border-0" required style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                            <option value="">Seleccione tipo de operacion</option>
                            @foreach($tiposComerciales as $tipo2)
                            <option value="{{ $tipo2->idTipoComercial }}">{{ $tipo2->nombreTipoComercial }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select placeholder="Tipo propiedad" name="tipoPropiedad" class="form-control form-control-lg border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                            <option value="">Seleccione tipo de propiedad</option>
                            @foreach($tiposPropiedades as $tipo)
                            <option value="{{ $tipo->idTipoPropiedad }}">{{ $tipo->nombreTipoPropiedad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-6">
                <textarea class="form-control border-0" placeholder="Mensaje" name="mensaje" rows="5" style="border:2px solid #e3e2e2 !important"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-primary px-9">Enviar</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('jss')

@endsection