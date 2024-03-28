<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        #cell {
            background-color: #000000;
            color: #ffffff;
        }

        .cell {
            background-color: #000000;
            color: #ffffff;
        }

        tr td {
            background-color: #ffffff;
        }

        tr > td {
            border-bottom: 1px solid #000000;
        }
    </style>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>DEPARTAMENTO/CASA</th>
            <th>NOMBRE PROPIETARIO</th>
            <th>APELLIDO PROPIETARIO</th>
            <th>RUT PROPIETARIO</th>
            <th>NOMBRE ARRENDATARIO</th>
            <th>APELLIDO ARRENDATARIO</th>
            <th>RUT ARRENDATARIO</th>
            <th>MONTO A PAGAR</th>
            <th>CARGOS O DESCUENTOS</th>
            <th>GARANTIA</th>
            <th>COMISION</th>
            <th>SALDOS A FAVOR</th>
            <th>MONTO PAGADO</th>
            <th>PAGOS REALIZADOS</th>
            <th>FECHA DE PAGOS REALIZADOS</th>
            <th>METODO DE PAGO</th>
            <th>COMISION CORRETAJE</th>
            <th style="background-color: green !important;" >A LIQUIDAR PROPIETARIO</th>
            <th>ESTADO</th>
            <th>BANCO</th>
            <th>NUMERO CUENTA</th>
            <th>OBSERVACIONES GENERALES</th>
            <th>CORREO ELEECTRONICO</th>
            <th>FECHA LIQUIDADO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($todosLosDatos as $estadoPagoMandato)
            <tr>
                <td >{{ $estadoPagoMandato->direccion }}</td>
                <td >{{ $estadoPagoMandato->nombrePropietario }}</td>
                <td >{{ $estadoPagoMandato->apellidoPropietario }}</td>
                <td >{{ $estadoPagoMandato->rutPropietario }}</td>
                <td >{{ $estadoPagoMandato->nombreArrendatario }}</td>
                <td >{{ $estadoPagoMandato->apellidoArrendatario }}</td>
                <td >{{ $estadoPagoMandato->rutArrendatario }}</td>
                <td >{{ $estadoPagoMandato->montoAPagar }}</td>
                <td >{{ $estadoPagoMandato->cargosAbonos }}</td>
                <td >{{ $estadoPagoMandato->garantia }}</td>
                <td >@if($estadoPagoMandato->montoComision < 0) 0 @else {{ $estadoPagoMandato->montoComision }} @endif</td>
                <td >{{ $estadoPagoMandato->saldoArrastre }}</td>
                <td >{{ $estadoPagoMandato->montoPagado }}</td>
                <td >{{ $estadoPagoMandato->pago }}</td>
                <td >@if($estadoPagoMandato->fechaCreado) {{ date("d-m-Y", strtotime($estadoPagoMandato->fechaCreado)) }} @endif</td>
                <td >{{ $estadoPagoMandato->metodoPago }}</td>
                <td >{{ $estadoPagoMandato->comisionCorretaje }}</td>
                <td style="background-color: green !important;" >{{ $estadoPagoMandato->montoALiquidarPropietario }}</td>
                <td >{{ $estadoPagoMandato->nombreEstado }}</td>
                <td >{{ $estadoPagoMandato->nombreBanco }}</td>
                <td >{{ $estadoPagoMandato->numeroCuenta }}</td>
                <td >{{ $estadoPagoMandato->observaciones }}</td>
                <td >{{ $estadoPagoMandato->correo }}</td>
                <td >{{ $estadoPagoMandato->fechaLiquidado }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>