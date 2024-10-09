<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @page { margin: 0px; }
    body { margin: 0px; }
  </style>
</head>
    <body style="font-family: sans-serif !important;">
        <div style="width: 100%; position: absolute">
            <img src="{{ base_path() }}/public/front/fondo.png" alt="" width="100%" >
        </div>
        @php($totalCargos = 0)
        @if(count($cargos))
        @foreach($cargos as $cargoVariable)
            @php($totalCargos = $totalCargos + $cargoVariable->montoCargo)
        @endforeach
        @endif
        <!-- fin calculo cargos -->
        <!-- calculo deudas y descuentos-->
        @php($total = 0)
        @if(count($descuentos))
        @foreach($descuentos as $descuento)
            @php($total = $total + $descuento->montoDescuento)
        @endforeach
        @endif
        <div class="wrapper" style="width: 720px; font-size: 11px; margin-left: 30px; margin-right: 30px; z-index: 9999999; margin-top: 30px">
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <table style="height: 110px; width: 600px; color: white">
                    <tbody>
                        <tr>
                        @php(setlocale(LC_TIME, 'spanish'))
                            <td style="width: 400px; text-align: left;"> <img src="{{ base_path() }}/public/front/LOGOPROPITECHby.png" alt="" width="60%" ></td>
                        </tr>
                        <tr>
                            <td style="width: 369px; text-align: left;"><p style="margin-left: 10px !important"><strong>Inversiones y Servicios Profesionales B y C Spa.<br />Av. Providencia 1208 OF 207<br />Providencia - Santiago<br />Telefono: +56956790356<br />Email: administracion@propitech.cl <br />www.propitech.cl</strong></p></td>
                        </tr>
                    </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <table style="height: 23px; width: 720px;">
                    <tbody>
                        <tr style="height: 13.4688px;">
                            <td style="width: 600px; height: 13.4688px;" ><span style="color: #000000;"><h2 ><center><strong>COMPROBANTE DE PAGO A PROPIETARIO #{{ $estadoPagoMandato->idEstadoPagoMandato }}</strong></center></h2></span>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                    <br>
                    <br>
                    <table style="height: 23px; width: 720px;" >
                    <tbody>
                        <tr style="height: 13.4688px;">
                            <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;INFORMACION DEL PROPIETARIO</span></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <table style="height: 24px; width: 720px;" >
            <tbody>         
                <tr style="height: 3px;">
                    <td style="width: 175px; height: 3px;"><strong>NOMBRE</strong></td>
                    <td style="width: 175px; height: 3px;">{{ $estadoPagoMandato->nombre }} {{ $estadoPagoMandato->apellido }}</td>
                    <td style="width: 175px; height: 3px;"><strong>RUT</strong></td>
                    <td style="width: 175px; text-align: left; height: 3px;">{{$estadoPagoMandato->rutPropietario}}</td>
                </tr>
                <tr style="height: 3px;">
                    <td style="width: 175px; height: 3px;"><strong>CORREO</strong></td>
                    <td style="width: 175px; height: 3px;">{{$estadoPagoMandato->correo}}</td>
                    <td style="width: 175px; height: 3px;"><strong>TELEFONO</strong></td>
                    <td style="width: 175px; text-align: left; height: 3px;">{{$estadoPagoMandato->telefono}}</td>
                </tr>
            </tbody>
            </table>
            &nbsp;<br />
            <table style="height: 23px; width: 720px;">
            <tbody>
                <tr style="height: 13.4688px;">
                    <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;DETALLES DE LA PROPIEDAD</span></td>
                </tr>
            </tbody>
            </table>
            </center>
            <table style="width: 720px; height: 100px;">
            <tbody>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>DIRECCION</strong></td>
                    <td style="width: 175px; height: 13px;">{{$estadoPagoMandato->direccion}} {{$estadoPagoMandato->numero}}</td>
                    <td style="width: 175px; height: 13px;"><strong>DEPARTAMENTO</strong></td>
                    <td style="width: 175px; height: 13px;">{{$estadoPagoMandato->block}}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>COMUNA</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->nombreComuna }}</td>
                    <td style="width: 175px; height: 13px;"><strong>REGION</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->nombreRegion}}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>N° MANDATO</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->idMandatoPropiedad }}</td>
                    <td style="width: 175px; height: 13px;"><strong>N° CONTRATO</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->idContrato }}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>COMISIÓN ADMINISTRACIÓN</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->comisionAdministracion }}%</td>
                    <td style="width: 175px; height: 13px;"><strong>FECHA DE PAGO</strong></td>
                    <td style="width: 175px; height: 13px;">{{ $estadoPagoMandato->fechaDePago }}</td>
                </tr>
            </tbody>
            </table>
            <table style="height: 23px; width: 720px;">
            <tbody>
                <tr style="height: 13.4688px;">
                    <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;DETALLES DE PAGO</span></td>
                </tr>
            </tbody>
            </table>
            </center>
            <table style="width: 720px; height: 137px;">
            <tbody>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>VALOR ARRIENDO</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $estadoPagoMandato->montoAPagar, 0, '', '.')}}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>ABONOS (+)</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $totalCargos, 0, '', '.')}}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>DESCUENTOS (-)</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $total, 0, '', '.')}}</td>
                </tr>
                <!--<tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>GARANTIA (+)</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $estadoPagoMandato->garantia, 0, '', '.')}}</td>
                </tr>-->
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;" colspan="2"><strong>HONORARIOS ADMINISTRACION (-)</strong></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $estadoPagoMandato->montoComision, 0, '', '.')}}</td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>COMISION CORRETAJE (-)</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $estadoPagoMandato->comisionCorretaje, 0, '', '.')}}</td>
                </tr>
                <tr style="height: 13.4688px;">
                    <td colspan="4" style="width: 720px; height: 13.4688px;"><hr></td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>MONTO A LIQUIDAR</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right"><strong>${{ number_format( $estadoPagoMandato->montoALiquidarPropietario, 0, '', '.')}}</strong></td>
                </tr>
                <tr style="height: 13px;">
                    <td style="width: 175px; height: 13px;"><strong>GARANTIA (+)</strong></td>
                    <td style="width: 175px; height: 13px"></td>
                    <td style="width: 175px; height: 13px;"></td>
                    <td style="width: 175px; height: 13px; text-align: right">${{ number_format( $estadoPagoMandato->garantia, 0, '', '.')}}</td>
                </tr>
            </tbody>
            </table>
            <table style="height: 21px; width: 720px;" >
            <tbody>
            <tr style="height: 13.4688px;">
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp; DETALLE DE ABONOS</span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            </tr>
            @if(count($cargos))
            @foreach($cargos as $cargo)
            <tr style="height: 13.4688px;">
                <td style="width: 175px; height: 13px;">DESCRIPCION</td>
                <td style="width: 175px; height: 13px;">{{$cargo->nombreCargo}}</td>
                <td style="width: 175px; height: 13px;">MONTO</td>
                <td style="width: 175px; height: 13px;">${{ number_format($cargo->montoCargo, 0, '', '.')}}</td>
            </tr>
            @endforeach
            @else
            <tr style="height: 13.4688px;">
                <td style="width: 175px; height: 13px;">Sin movimientos</td>
                <td style="width: 175px; height: 13px;"> - </td>
                <td style="width: 175px; height: 13px;"> - </td>
                <td style="width: 175px; height: 13px;"> - </td>
            </tr>
            @endif
            </tbody>
            </table>
            <table style="height: 21px; width: 720px;" >
            <tbody>
            <tr style="height: 13.4688px;">
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp; DETALLE DE DESCUENTOS</span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
            </tr>
            @if(count($descuentos))
            @foreach($descuentos as $descuento)
            <tr style="height: 13.4688px;">
                <td style="width: 175px; height: 13px;">DESCRIPCION</td>
                <td style="width: 175px; height: 13px;">{{$descuento->nombreDescuento}}</td>
                <td style="width: 175px; height: 13px;">MONTO</td>
                <td style="width: 175px; height: 13px;">${{ number_format($descuento->montoDescuento, 0, '', '.')}}</td>
            </tr>
            @endforeach
            @else
            <tr style="height: 13.4688px;">
                <td style="width: 175px; height: 13px;">Sin movimientos</td>
                <td style="width: 175px; height: 13px;"> - </td>
                <td style="width: 175px; height: 13px;"> - </td>
                <td style="width: 175px; height: 13px;"> - </td>
            </tr>
            @endif
            </tbody>
            </table>
            <p>&nbsp;</p>
            </div>
            </div>
            <br>
            <div class="row">&nbsp;</div>
        </div>
    </body>
</html>

