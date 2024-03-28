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
  <!-- calculo de cargos -->
    @php($totalCargos = 0)
    @if(count($cargos))
    @foreach($cargos as $cargoVariable)
        @php($totalCargos = $totalCargos + $cargoVariable->montoCargo)
    @endforeach
    @endif
    <!-- fin calculo cargos -->
    <!-- calculo deudas y descuentos-->
    @php($total = 0)
    @if(count($deudas))
    @foreach($deudas as $deudaVariable)
        @php($total = $total + $deudaVariable->valorCuota)
    @endforeach
    @endif
    @if(count($descuentos))
    @foreach($descuentos as $descuento)
        @php($total = $total + $descuento->montoDescuento)
    @endforeach
    @endif
    <!-- fin calculo deudas y descuentos -->
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
      <td style="width: 600px; height: 13.4688px;" ><span style="color: #000000;"><h2 ><center><strong>LIQUIDACION DE INVERSIONISTA</strong></center></h2></span>
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
        <td style="width: 350px; height: 3px;">NOMBRE</td>
        <td style="width: 350px; height: 3px;">{{$estadoPagoMandato->nombre}} {{$estadoPagoMandato->apellido}}</td>
        </tr>
        <tr style="height: 3px;">
        <td style="width: 350px; height: 3px;">RUT</td>
        <td style="width: 350px; height: 3px;">{{$estadoPagoMandato->rutPropietario}} </td>
        </tr>
        <tr style="height: 3px;">
        <td style="width: 350px; height: 3px;">CORREO</td>
        <td style="width: 350px; height: 3px;">{{$estadoPagoMandato->correo}}</td>
        </tr>
        <tr style="height: 3px;">
        <td style="width: 350px; height: 3px;">TELEFONO</td>
        <td style="width: 350px; height: 3px;">{{$estadoPagoMandato->telefono}}</td>
        </tr>
      </tbody>
      </table>
      &nbsp;<br />
      <table style=" width: 700px; font-size: 12px">
    <tbody>
    <tr style="height: 13.4688px;">
    <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp; DETALLES DE LA PROPIEDAD</span></td>
    <td style="height: 13.4688px; background-color: #808080;"><span style="background-color: #808080;"></span></td>
    </tr>
    <tr style="height: 13px;">
    <td style="width: 350px; height: 13px;">DIRECCION</td>
    <td style="width: 350px; height: 13px;">{{$estadoPagoMandato->direccion}} {{$estadoPagoMandato->numero}}, {{ $estadoPagoMandato->nombreComuna }}, región {{ $estadoPagoMandato->nombreRegion}}</td>
    </tr>
    <tr style="height: 13px;">
    <td style="width: 350px; height: 13px;">DEPARTAMENTO</td>
    <td style="width: 350px; height: 13px;">{{$estadoPagoMandato->block}}</td>
    </tr>
    </tbody>
    </table>
    <br>
    @php(setlocale(LC_TIME, 'spanish'))
    <center><strong><p style="font-size: 16px">DETALLE DE ARRIENDO {{ strtoupper(strftime("%B de %Y", strtotime($estadoPagoMandato->fechaDePago ))) }}</p></strong></center>
    <br>
    <table style="width: 690px; font-size: 12px; border: 2px solid black;">
        <tr style="border: 2px solid black;">
            <td style="width: 345px; border-bottom: 2px solid black; border-right: 2px solid black; vertical-align:top;"><center><h4 >INGRESOS</h4></center></td>
            <td style="width: 340px; border-bottom: 2px solid black; "><center><h4 >EGRESO</h4></center></td>
        </tr>
        <tr style="border: 2px solid black;">
            <td style="width: 345px; border-bottom: 0px !important; border-right: 2px solid black; vertical-align:top;">
            <table style="width: 345px; font-size: 12px;  border: 0px !important;">
            <tbody>
            <tr>
                <td style="width: 245px; border: 0px !important; ">Arriendo</td>
                <td style="width: 100px; text-align: right; border: 0px !important">${{ number_format(($estadoPagoMandato->montoALiquidarPropietario + $total + $estadoPagoMandato->montoComision) - $totalCargos + $estadoPagoMandato->valorSeguroArriendo , 0, '', '.')}}</td>
            </tr>
            @if(count($cargos))
            @foreach($cargos as $cargo)
            <tr >
                <td style="width: 245px; border: 0px !important">{{$cargo}}</td>
                <td style="width: 100px; border: 0px !important; text-align: right;">${{ number_format($cargo, 0, '', '.')}}</td>
            </tr>
            @endforeach
            @endif
            </tbody>
            </table>
            </td>
            <td style="width: 340px; border-bottom: 0px !important; vertical-align:top;">
            <table style="width: 340px; font-size: 12px;  border: 0px !important;">
            <tbody>
                <tr>
                    <td style="width: 240px; border: 0px !important;">Honorarios de Administracion</td>
                    <td style="width: 100px; border: 0px !important; text-align: right;"> ${{ number_format($estadoPagoMandato->montoComision , 0, '', '.')}}</td>
                </tr>
                <tr>
                    <td style="width: 240px; border: 0px !important;">Costo seguro arriendo</td>
                    <td style="width: 100px; border: 0px !important; text-align: right;"> ${{ number_format($estadoPagoMandato->valorSeguroArriendo, 0, '', '.')}}</td>
                </tr>
                @if(count($deudas))
                @foreach($deudas as $deuda)
                <tr >
                    <td style="width: 240px; border: 0px !important">{{$deuda}}</td>
                    <td style="width: 100px; border: 0px !important; text-align: right;">${{ number_format($deuda, 0, '', '.')}}</td>
                </tr>
                @endforeach
                @endif
                @if(count($descuentos))
                @foreach($descuentos as $descuento)
                <tr >
                    <td style="width: 240px; border: 0px !important">{{$descuento}}</td>
                    <td style="width: 100px; border: 0px !important; text-align: right;">${{ number_format($descuento, 0, '', '.')}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            </table>
            </td>
        </tr>
        <tr style="border: 2px solid black !important;">
            <td style="width: 345px; border-top: 2px solid black; border-right: 2px solid black;">
            <table style="width: 345px; font-size: 12px;  border: 0px !important;">
            <tbody>
                <tr >
                    <td style="width: 245px; border: 0px !important"><strong>TOTAL INGRESOS</strong></td>
                    <td style="width: 100px; border: 0px !important; text-align: right;"><strong>${{ number_format(($estadoPagoMandato->montoALiquidarPropietario + $total + $estadoPagoMandato->montoComision) + $estadoPagoMandato->valorSeguroArriendo, 0, '', '.')}}</strong></td>
                </tr>
            </tbody>
            </table>
            </td>
            <td style="width: 340px; border-top: 2px solid black;">
            <table style="width: 340px; font-size: 12px;  border: 0px !important;">
            <tbody>
                <tr >
                    <td style="width: 240px; border: 0px !important"><strong>TOTAL EGRESO</strong></td>
                    <td style="width: 100px; border: 0px !important; text-align: right;"><strong>${{ number_format($total + $estadoPagoMandato->montoComision + $estadoPagoMandato->valorSeguroArriendo, 0, '', '.')}}</strong></td>
                </tr>
            </tbody>
            </table>
            </td>
            </strong>
        </tr>
    </table>
    &nbsp;<br/>
    <table style="height: 21px; width: 700px; font-size: 12px">
    <tbody>
    <tr style="height: 13.4688px; font-size: 16px">
        <td style="width: 350px; height: 13px;"><strong></strong></td>
        <td style="width: 350px; height: 13px;"><strong>LIQUIDO A PAGAR ${{ number_format( $estadoPagoMandato->montoALiquidarPropietario, 0, '', '.')}}</strong></td>
    </tr>
    </tbody>
    </table>
    </strong>
    <!--<p>sin otro particular, se despide cordialmente</p>
    <strong><p>Isabel Sainz
        <br>
    Lider Rentas Inmobiliarias
    <br>
    isabel.sainz@atotal.cl</p></strong>-->
  </div>
</body>
</html>
