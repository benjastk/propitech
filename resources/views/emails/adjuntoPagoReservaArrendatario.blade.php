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
      <td style="width: 600px; height: 13.4688px;" ><span style="color: #000000;"><h2 ><center><strong>COMPROBANTE DE PAGO DE RESERVA #{{$estadosDePago->idPago}}</strong></center></h2></span>
      </td>
      </tr>
      </tbody>
      </table>
      <br>
      <br>
      <table style="height: 23px; width: 720px;" >
      <tbody>
      <tr style="height: 13.4688px;">
      <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;INFORMACION DE RESERVA</span></td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>
      <table style="height: 24px; width: 720px;" >
      <tbody>
      <tr style="height: 24px;">
      <td style="width: 175px; height: 24px;"><strong>DATOS DE LA PROPIEDAD</strong></td>
      <td style="width: 175px; height: 24px;">&nbsp;</td>
      <td style="width: 175px; height: 24px;"><strong>DATOS DEL ARRENDATARIO</strong></td>
      <td style="width: 175px; text-align: left; height: 24px;">&nbsp;</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">PROPIEDAD</td>
      <td style="width: 175px; height: 3px;">{{ $estadosDePago->direccion }} {{ $estadosDePago->numero }}</td>
      <td style="width: 175px; height: 3px;">ARRENDATARIO</td>
      <td style="width: 175px; text-align: left; height: 3px;">{{ $estadosDePago->nombre }} {{ $estadosDePago->apellido }}</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">DIRECCION</td>
      <td style="width: 175px; height: 3px;">{{$estadosDePago->direccion}} Nro. {{$estadosDePago->numero}}</td>
      <td style="width: 175px; height: 3px;">CONTACTO ARRENDATARIO</td>
      <td style="width: 175px; text-align: left; height: 3px;">{{ $estadosDePago->telefono }}</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">DEPARTAMENTO</td>
      <td style="width: 175px; height: 3px;">@if($estadosDePago->departamento) {{$estadosDePago->departamento}} @else - @endif</td>
      <td style="width: 175px; height: 3px;">IDENTIFICADOR</td>
      <td style="width: 175px; text-align: left; height: 3px;">{{ $estadosDePago->rut }}</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">COMUNA</td>
      <td style="width: 175px; height: 3px;">{{ $estadosDePago->nombreComuna }}</td>
      <td style="width: 175px; height: 3px;">EMAIL</td>
      <td style="width: 175px; text-align: left; height: 3px;">{{ $estadosDePago->email }}</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">CIUDAD</td>
      <td style="width: 175px; height: 3px;">{{ $estadosDePago->nombreComuna }}</td>
      <td style="width: 175px; height: 3px;">&nbsp;</td>
      <td style="width: 175px; text-align: left; height: 3px;">&nbsp;</td>
      </tr>
      <tr style="height: 29.4688px;">
      <td style="width: 175px; height: 29.4688px;"><strong>DATOS DE RESERVA</strong></td>
      <td style="width: 175px; height: 29.4688px;">&nbsp;</td>
      <td style="width: 175px; height: 29.4688px;"><strong>DATOS COMPROBANTE</strong></td>
      <td style="width: 175px; text-align: left; height: 29.4688px;">&nbsp;</td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 13px;">VALOR RESERVA</td>
      <td style="width: 175px; height: 13px;">${{ number_format($estadosDePago->valorReserva, 0, '', '.')}}</td>
      <td style="width: 175px; height: 3px;">FECHA EMISION</td>
      <td style="width: 175px; text-align: left; height: 3px;"><?php echo date("d/m/Y"); ?></td>
      </tr>
      <tr style="height: 3px;">
      <td style="width: 175px; height: 3px;">METODO DE PAGO</td>
      <td style="width: 175px; height: 3px;">{{ $estadosDePago->nombreMetodoPago }}</td>
      <td style="width: 175px; height: 3px;">IDENTIFICADOR UNICO</td>
      <td style="width: 175px; text-align: left; height: 3px;">{{ $estadosDePago->token }}</td>
      </tr>
      </tbody>
      </table>
      &nbsp;<br />
      <table style="height: 23px; width: 720px;">
      <tbody>
      <tr style="height: 13.4688px;">
      <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;DETALLES RESERVA</span></td>
      </tr>
      </tbody>
      </table>
      </center>
      <table style="width: 720px; height: 137px;">
      <tbody>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">VALOR RESERVA</td>
      <td style="width: 175px; height: 13px;">${{ number_format($estadosDePago->valorReserva, 0, '', '.')}}</td>
      <td style="width: 175px; height: 13px;"><strong>FECHA DE VENCIMIENTO</strong></td>
      <td style="width: 175px; height: 13px;">{{ strftime("%d-%m-%Y", strtotime($estadosDePago->fechaDePago)) }}</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"><strong>FECHA DE PAGO</strong></td>
      <td style="width: 175px; height: 13px;">{{ strftime("%d-%m-%Y", strtotime($estadosDePago->fechaDePago)) }}</td>
      </tr>
      <!--<tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">OTROS GASTOS</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">TOTAL MULTA ARRIENDO</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>-->
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"><strong>NUMERO DE TRANSACCION</strong></td>
      <td style="width: 175px; height: 13px;">{{ $estadosDePago->numeroTransaccion }}</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"><strong>NUMERO INTERNO</strong></td>
      <td style="width: 175px; height: 13px;">{{ $estadosDePago->secuenciaTransaccion }}</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      <td style="width: 175px; height: 13px;"></td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;"><strong>TOTAL A PAGAR</strong></td>
      <td style="width: 175px; height: 13px;"><strong>${{ number_format($estadosDePago->valorReserva, 0, '', '.')}}</strong></td>
      <td style="width: 175px; height: 13px;"><strong>TOTAL PAGADO</strong></td>
      <td style="width: 175px; height: 13px;"><strong>${{ number_format($estadosDePago->montoPago, 0, '', '.')}}</strong></td>
      </tr>
      <!--</table>
      <table style="height: 23px; width: 720px;">
      <tbody>
      <tr style="height: 13.4688px;">
      <td style="width: 720px; height: 13.4688px; background-color: #808080;"><span style="background-color: #808080; color: #ffffff;">&nbsp;TOTAL A PAGAR: ${{ number_format($estadosDePago->subtotal, 0, '', '.')}}</span></td>
      </tr>
      </tbody>
      </table>
      <table style="height: 23px; width: 720px;">
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>-->
      <tr style="height: 13.4688px;">
      <td style="width: 175px; height: 13.4688px;">&nbsp;</td>
      <td style="width: 175px; height: 13.4688px;">&nbsp;</td>
      <td style="width: 175px; height: 13.4688px;">&nbsp;</td>
      <td style="width: 175px; height: 13.4688px;">&nbsp;</td>
      </tr>
      <!--<tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">OBSERVACIONES ARRIENDO</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>
      <tr style="height: 13px;">
      <td style="width: 175px; height: 13px;">OBSERVACIONES MULTA</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      <td style="width: 175px; height: 13px;">&nbsp;</td>
      </tr>-->
      </tbody>
      </table>
      <p>*NOTA: Al realizar el pago de la reserva el cliente acepta los términos y condiciones establecidos en nuestra página web</p>
      </div>
      </div>
      <br>
      <div class="row">&nbsp;</div>
  </div>
</body>
</html>
