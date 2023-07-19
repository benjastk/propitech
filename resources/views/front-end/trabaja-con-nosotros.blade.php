@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Trabaja con nosotros</title>
@endsection
@section('css')
@endsection
@section('content')
<main id="content">
    <section class="pb-3 pt-3 page-title shadow">
        <div class="container">
            <h1 class="fs-30 lh-16 mb-1 text-dark font-weight-600">Trabaja con nosotros</h1>
        </div>
    </section>
    <section class="pb-3 pt-3">
        <div class="container" >
            <div class="row">
                <div class="col-lg-8">
                    <div class="pb-7">
                        <h2 class="text-heading mb-2 fs-22 lh-15 pr-6">Formulario de canje</h2>
                        <p class="mb-6">
                        Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem ipsum dolor sit
                        ametcipsu
                        </p>
                        <form action="{{ route('formulario-canje-propiedades')}}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Nombre corredor" class="form-control  border-0" name="nombreCorredor" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input placeholder="Correo electronico corredor" class="form-control  border-0" type="email" name="emailCorredor" style="border:2px solid #e3e2e2 !important">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Telefono corredor" name="telefonoCorredor" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input placeholder="Cantidad de propiedades" class="form-control  border-0" type="number" name="cantidadPropiedades" style="border:2px solid #e3e2e2 !important">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Tipo de operación" name="tipoOperacion" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Tipo de operación</option>
                                            @foreach($tiposComerciales as $tipo2)
                                            <option value="{{ $tipo2->idTipoComercial }}">{{ $tipo2->nombreTipoComercial }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Cuidad donde trabajas" name="ciudadCorredor" class="form-control  border-0" style="border:2px solid #e3e2e2 !important">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary px-9">Enviar</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="primary-sidebar-inner">
                        <div class="city-widget mb-4">
                            <div class="">
                                <div class="text-center pt-7 pb-6 px-0">
                                    <img src="front/images/contact-widget.jpg" alt="Want to become an Estate Agent ?">
                                        <div class="text-dark mb-6 mt-n2 font-weight-500">
                                            <p class="mb-0 fs-18">¿Quieres ser corredor Propitech?</p>
                                        </div>
                                    <!--<a href="#" class="btn btn-primary">Register</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="background-image: url('/front/images/document.jpg')" class="bg-img-cover-center py-10 pb-3 pt-3">
        <div class="row" style="width: 100%; color: white !important" >
            <div class="col-lg-6">
            </div>  
            <div class="col-lg-6">
                <div class="pt-3">
                    <h2 class="text-heading mb-2 fs-22 lh-15 pr-6" style="color: white !important">Información de contacto</h2>
                    <div class="row mt-8">
                        <div class="col-md-4 mb-6">
                            <div class="media">
                                <span class="fs-32 text-primary mr-4"><i class="fal fa-phone"></i></span>
                                <div class="media-body mt-3">
                                    <h4 class="fs-16 lh-2 mb-1 text-dark" style="color: white !important">Contacto</h4>
                                    <div class="row mb-1">
                                        <div class="col-3">
                                            <span>Office</span>
                                        </div>
                                        <div class="col-9">
                                            <a href="tel:123-900-68668" class="text-heading font-weight-500" style="color: white !important">123 900
                                            68668</a>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3">
                                            <span>Mobile</span>
                                        </div>
                                        <div class="col-9">
                                            <a href="tel:12390068098" class="text-heading font-weight-500" style="color: white !important">123 900
                                            68098</a>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3">
                                            <span>Fax</span>
                                        </div>
                                        <div class="col-9">
                                            <a href="tel:1-3239006800" class="text-heading font-weight-500" style="color: white !important">1-323 900
                                            6800</a>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3">
                                            <span >Office</span>
                                        </div>
                                        <div class="col-9">
                                            <a href="mailto:hello@homeid.com" class="text-body" style="color: white !important">hello@homeid.com</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-6">
                            <div class="media">
                                <span class="fs-32 text-primary mr-4"><i class="fal fa-clock"></i></span>
                                <div class="media-body mt-3">
                                    <h4 class="fs-16 lh-2 mb-1 text-dark" style="color: white !important">Horario de operación</h4>
                                    <div class="row mb-1">
                                        <div class="col-6">
                                            <span>Lunes a Viernes:</span>
                                        </div>
                                        <div class="col-6">
                                            <span>
                                            09:00 - 20:00
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-6">
                                            <span>Sabados y Domingos:</span>
                                        </div>
                                        <div class="col-6">
                                            <span>
                                            10:30 - 22:00
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pb-3 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="primary-sidebar-inner">
                        <div class="city-widget mb-4">
                            <div class="">
                                <div class="text-center pt-7 pb-6 px-0">
                                    <img src="front/images/profile-img.png" alt="Want to become an Estate Agent ?">
                                        <div class="text-dark mb-6 mt-n2 font-weight-500">
                                            <p class="mb-0 fs-18">¡Sé un captador de propiedad!</p>
                                        </div>
                                    <!--<a href="#" class="btn btn-primary">Register</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="pb-7">
                        <h2 class="text-heading mb-2 fs-22 lh-15 pr-6">Formulario de Captadores de propiedad</h2>
                        <p class="mb-6">
                        Lorem ipsum dolor sit amet, consec tetur cing elit. Suspe ndisse suscorem ipsum dolor sit
                        ametcipsu
                        </p>
                        <form action="{{ route('formulario-captador-propiedades')}}" method="post" >
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Nombre propietario" class="form-control  border-0" name="nombrePropietario" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input placeholder="Correo electronico propietario" class="form-control  border-0" type="email" name="correoPropietario" style="border:2px solid #e3e2e2 !important">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Telefono propietario" name="telefonoPropietario" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" id="textToDate" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" name="diaVisita" placeholder="Dia y hora de visita">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-4">
                                        <input placeholder="Direccion de la propiedad" class="form-control  border-0" type="text" name="direccionPropiedad" style="border:2px solid #e3e2e2 !important">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Tipo de operación" name="tipoOperacion" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Tipo de operación</option>
                                            @foreach($tiposComerciales as $tipo2)
                                            <option value="{{ $tipo2->idTipoComercial }}">{{ $tipo2->nombreTipoComercial }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Tipo de propiedad" name="tipoPropiedad" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Tipo de propiedad</option>
                                            @foreach($tiposPropiedades as $tipo4)
                                            <option value="{{ $tipo4->idTipoPropiedad }}">{{ $tipo4->nombreTipoPropiedad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Cantidad de dormitorios" name="dormitorios" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Cantidad de dormitorios</option>
                                            <option value="-1">Home Studio</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">Más de 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Cantidad de baños" name="banos" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Cantidad de baños</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">Más de 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Estacionamiento" name="estacionamiento" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Estacionamiento</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <select placeholder="Bodega" name="bodega" class="form-control  border-0" style="border:2px solid #e3e2e2 !important; color: #c2b3b3">
                                            <option value="">Bodega</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-check-label fs-13">Datos Captador</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Nombre Captador" name="nombreCaptador" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Rut Captador" name="rutCaptador" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <input type="text" placeholder="Telefono Captador" name="telefonoCaptador" class="form-control  border-0" style="border:2px solid #e3e2e2 !important" >
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary px-9">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('jss')
    <script>
        var dtt = document.getElementById('textToDate')
        dtt.onfocus = function (event) {
            this.type = 'datetime-local';
            this.focus();
        }
    </script>
@endsection