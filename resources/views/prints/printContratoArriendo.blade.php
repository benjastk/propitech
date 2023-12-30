<html>
    <head>
        <style>
            @page {
                margin: 70px 100px;
                font-size: 13px;
            }

            header {
                position: fixed;
                top: -50px;
                left: 0px;
                right: 0px;
                height: 50px;
                background-color: white;
                color: white;
                text-align: center;
                line-height: 35px;
                width: 615px;
            }

            footer {
                position: fixed; 
                bottom: -20px; 
                left: 0px; 
                right: 0px;
                height: 20px; 
                background-color: white;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            th, td {
                height: 12px !important;
            }
            p
            {
                padding: 0px !important;
                margin: 0px !important;
            }
        </style>
    </head>
    <body style="text-align: justify;">
        <header>
            <img src="{{ base_path() }}/public/front/011.png" alt="" title="" style="width: 140px; height: 45px; float: right"/>
        </header>
        <footer>
        </footer>
        <main>
            <p style="text-align: center"><strong><u>CONTRATO DE ARRIENDO </u></strong></p>
            <br>
            <p style="text-align: center"><strong>ANEXO DE CONDICIONES PARTICULARES DE CONTRATO DE ARRIENDO</strong></p>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr>
                    <td width="225">
                        <p>I.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FECHA DE FIRMA DEL CONTRATO 
                    </td>
                    <td width="225">
                        <p>{{ $contratoArriendo->fechaCompromiso }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p><strong>II.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Propiedad:</strong></p>
                    </td>
                    <td width="225">
                        
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Direcci&oacute;n:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->direccion }} {{ $contratoArriendo->numero }}
                            @if($contratoArriendo->block)
                            , Departamento {{ $contratoArriendo->block }}
                            @endif
                            {{ $contratoArriendo->nombreComuna }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    </td> 
                    <td width="225">
                        <p>Región {{ $contratoArriendo->nombreRegion }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Numero de departamento:</p>
                    </td> 
                    <td width="225">
                        <p>
                            @if($contratoArriendo->block)
                            Departamento {{ $contratoArriendo->block }}
                            @else
                            N/A
                            @endif
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Numero de Bodega:</p>
                    </td> 
                    <td width="225">
                        <p>
                            @if($contratoArriendo->usoGoceBodega)
                             {{ $contratoArriendo->codigoBodega }}
                            @else
                            NO
                            @endif
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Numero de estacionamiento:</p>
                    </td> 
                    <td width="225">
                        <p>
                            @if($contratoArriendo->usoGoceEstacionamiento)
                             {{ $contratoArriendo->codigoEstacionamiento }}
                            @else
                            NO
                            @endif
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Uso:</p>
                    </td> 
                    <td width="225">
                        <p>Habitacional.</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; N&deg; de Habitaciones:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->habitacion }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; N&deg; de Ba&ntilde;os:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->bano }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; N&deg; de personas que habitaran:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->maximoHabitantes }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>III.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Informaci&oacute;n Arrendador:</strong></p>
                    </td>
                    <td width="225">
                        
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Nombre Completo:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->nombrePropietario }} {{ $contratoArriendo->apellidoPropietario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; RUT</p>
                    </td> 
                    <td width="225">
                        @php
                        $rutPropietario1 = explode( "-", $contratoArriendo->rutPropietario );
                        $rutPropietario = number_format( $rutPropietario1[0], 0, "", ".") . '-' . $rutPropietario1[1];
                        @endphp
                        <p>{{ $rutPropietario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Domicilio:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->direccionPropietario }} {{ $contratoArriendo->numeroPropietario }}, {{ $contratoArriendo->comunaPropietario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Correo:</p>
                    </td> 
                    <td width="225">
                        <p>administracion@propitech.cl</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p></p>
                    </td> 
                    <td width="225">
                        <p></p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Representante legal:</strong></p>
                    </td>
                    <td width="225">
                        
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Nombre Completo:</p>
                    </td> 
                    <td width="225">
                        <p>Inversiones y Servicios Profesionales B&C Spa.</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; RUT</p>
                    </td> 
                    <td width="225">
                        <p>77.-135.202-9</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Dirección:</p>
                    </td> 
                    <td width="225">
                        <p>Av. Providencia 1208 Of. 207.</p>
                    </td>
                </tr>
                <tr>
                    <td width="225" colspan="2">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Se deja constancia que el 
                            arrendador actúa representado en la forma indicada en el Número XVII siguiente.</p>
                    </td> 
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>IV.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Informaci&oacute;n Arrendatario:</p>
                    </td>
                    <td width="225">
                        
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Nombre Completo:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->nombreArrendatario }} {{ $contratoArriendo->apellidoArrendatario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; RUT</p>
                    </td> 
                    <td width="225">
                        @php
                        $rutArrendatario1 = explode( "-", $contratoArriendo->rutArrendatario );
                        $rutArrendatario = number_format( $rutArrendatario1[0], 0, "", ".") . '-' . $rutArrendatario1[1];
                        @endphp
                        <p>{{ $rutArrendatario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Domicilio:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->direccionArrendatario }} {{ $contratoArriendo->numeroArrendatario }}, {{ $contratoArriendo->comunaArrendatario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Telefono:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->telefonoArrendatario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Correo:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->correoArrendatario }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Información Codeudor:</p>
                    </td> 
                    <td width="225">

                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Nombre Completo:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->nombreCodeudor }} {{ $contratoArriendo->apellidoCodeudor }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; RUT</p>
                    </td> 
                    <td width="225">
                        @if($contratoArriendo->idUsuarioCodeudor)
                        @php
                        $rutCodeudor1 = explode( "-", $contratoArriendo->rutCodeudor );
                        $rutCodeudor = number_format( $rutCodeudor1[0], 0, "", ".") . '-' . $rutCodeudor1[1];
                        @endphp
                        <p>{{ $rutCodeudor }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Domicilio:</p>
                    </td> 
                    <td width="225">
                        @if($contratoArriendo->idUsuarioCodeudor)
                        <p>{{ $contratoArriendo->direccionCodeudor }} {{ $contratoArriendo->numeroCodeudor }}, {{ $contratoArriendo->comunaCodeudor }}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Telefono:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->telefonoCodeudor }}</p>
                    </td>
                </tr>
                <tr>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Correo:</p>
                    </td> 
                    <td width="225">
                        <p>{{ $contratoArriendo->correoCodeudor }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>V.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>N&uacute;mero de personas que pueden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>
                    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Habitar la propiedad:</strong></p>
                    </td>
                    <td width="225">
                        <p>{{ $contratoArriendo->maximoHabitantes }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>V.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Fecha de inicio de vigencia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></p>
                    <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de contrato:</strong></p>
                    </td>
                    <td width="225">
                        @php(setlocale(LC_TIME, 'spanish'))
                        <p>{{ strftime("%d de %B de %Y", strtotime($contratoArriendo->desde)) }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>VII.&nbsp;&nbsp; <strong>Duraci&oacute;n de contrato:</strong></p>
                    </td>
                    <td width="225">
                        <p>{{ $contratoArriendo->tiempoContrato }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <p style="page-break-after: always;">
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>VIII.&nbsp; <strong>Renovaci&oacute;n autom&aacute;tica:</strong><p>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; O por periodos de:</p>
                    </td>
                    <td width="225">
                        <p>@if($contratoArriendo->renovacionAutomatica == 1) Si @else No @endif</p>
                        <p>12 meses.</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                    <p>IX.&nbsp;&nbsp; <strong>Fecha de termino de contrato:</strong></p>
                    </td>
                    <td width="225">
                        @php(setlocale(LC_TIME, 'spanish'))
                        <p>{{ strftime("%d de %B de %Y", strtotime($contratoArriendo->hasta)) }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>X.&nbsp;&nbsp; <strong>Renta:</strong></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp; En pesos chilenos.</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp; Reajuste de rentas:</p>
                    </td>
                    <td width="225">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <p>${{ number_format($contratoArriendo->arriendoMensual, 0, '', '.')}}</p>
                        <p>Anual según IPC</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>XI.&nbsp; <strong>La renta indicada incluye el cobro</strong></p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>de gastos comunes que le corresponde al inmueble.</strong></p>
                    </td>
                    <td width="225">
                        <p>No</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>XII.&nbsp; <strong>Garant&iacute;a:</strong></p>
                    </td>
                    <td width="225">
                        <p>${{ number_format($contratoArriendo->garantia, 0, '', '.')}}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>XIII.&nbsp; <strong>Comunicaciones &ndash; correos electr&oacute;nicos</strong></p>
                        <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; para notificar.</strong></p>
                    </td>
                    <td width="225">
                        <p><a href="mailto:administracion@propitech.cl">administracion@propitech.cl</a></p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>XIV.&nbsp; <strong>Prohibiciones:</strong></p>
                    </td>
                    <td width="225">
                        <p>{{ $contratoArriendo->prohibiciones }}</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:5px">
                    <td width="225">
                        <p>XV.&nbsp; Comisiones por corretaje.</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Arrendador:</p>
                    </td>
                    <td width="225">
                        <p></p>
                        <p>50% de un mes de arriendo + IVA.</p>
                    </td>
                </tr>
            </tbody>
            </table>
            <br>
            <table style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px black solid;" >
            <tbody>
                <tr style="heigth:1px">
                    <td width="225" >
                    </td>
                    <td width="225" >
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                        <p>XVI. <strong>&nbsp;Informaci&oacute;n del Representante del Arrendador para la celebraci&oacute;n del contrato de Arriendo:</strong></p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                        <p><strong>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</strong>Se deja constancia que el Arrendador act&uacute;a representado por Servicios profesionales B&amp;C Spa. En virtud del poder especial otorgado por el Arrendador para celebrar el contrato de arrendamiento respecto del inmueble.</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Fecha del Poder: 1 de abril 2023</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Nombre del Apoderado: Inversiones y Servicios Profesionales B&amp; C Spa.</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Rut del Apoderado: 77.135.302-9</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Domicilio del Apoderado: Av. Providencia 1208, of. 207, Providencia, Santiago.</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp; Representante del Apoderado: Gustavo Enrique Cisternas P&eacute;rez, Rut 11.857.826-0, ambos</p>
                    </td>
                </tr>
                <tr style="heigth:5px">
                    <td width="225" colspan="2">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ubicados en la misma direcci&oacute;n del Apoderado.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    </td>
                </tr>
            </tbody>
            </table>

            <p>&nbsp;</p>
            <p>Don <strong>{{ $contratoArriendo->nombrePropietario }} {{ $contratoArriendo->apellidoPropietario }}</strong><strong>, </strong>
            Rut {{ $rutPropietario }}, Estado civil {{ $contratoArriendo->estadoCivilPropietario }}<strong>, </strong>
            de profesi&oacute;n {{ $contratoArriendo->profesionPropietario }}, domiciliado en {{ $contratoArriendo->direccionPropietario }}, 
            Comuna {{ $contratoArriendo->comunaPropietario }}, en adelante el <strong>ARRENDADOR </strong>o la parte arrendadora y por la otra, 
            Don <strong>{{ $contratoArriendo->nombreArrendatario }} {{ $contratoArriendo->apellidoArrendatario }}</strong>, Rut {{ $rutArrendatario }}, 
            Estado civil {{ $contratoArriendo->estadoCivilArrendatario }}, con domicilio actual en {{ $contratoArriendo->direccionArrendatario }}, {{ $contratoArriendo->numeroArrendatario }}, 
            comuna de {{ $contratoArriendo->comunaArrendatario }}, de profesi&oacute;n {{ $contratoArriendo->profesionArrendatario }} @if($contratoArriendo->idUsuarioCodeudor) 
            y su <strong>CODEUDOR</strong>, Don {{ $contratoArriendo->nombreCodeudor }}, Rut {{ $rutCodeudor }}, Estado civil {{ $contratoArriendo->estadoCivilCodeudor }}, 
            con domicilio actual {{ $contratoArriendo->domicilioCodeudor }} comuna {{ $contratoArriendo->comunaCodeudor }}, de profesi&oacute;n {{ $contratoArriendo->profesionCodeudor }} @endif, 
            quienes har&aacute; uso de la propiedad, en calidad de en adelante el <strong>ARRENDATARIO</strong> o <strong>PARTE ARRENDATARIA</strong>, quienes acreditan
             su identidad con las respectivas c&eacute;dulas, y que han convenido en el siguiente contrato:</p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>PRIMERO</u></strong><strong>: PROPIEDAD: </strong>Por el presente instrumento, el arrendador da en arrendamiento al arrendatario, 
            quien arrienda para s&iacute;, sin facultad de subarrendar, con destino Habitacional, la propiedad ubicada con frente a calle 
            <strong>{{ $contratoArriendo->direccion }} {{ $contratoArriendo->numero }} @if($contratoArriendo->block )depto. {{ $contratoArriendo->block}} @endif</strong>,
             del conjunto habitacional denominado &ldquo;<strong>EDIFICIO {{ $contratoArriendo->nombreEdificioComunidad }}</strong>&rdquo; ubicado en la comuna de <strong> {{ $contratoArriendo->nombreComuna}}</strong>,
            Regi&oacute;n {{ $contratoArriendo->nombreRegion }}. Rol aval&uacute;o n&uacute;mero<strong> {{ $contratoArriendo->rolPropiedad }}</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>SEGUNDO</u></strong><strong>:</strong> <strong>PLAZO<em>:</em></strong> El presente contrato rige a contar del d&iacute;a 
            @php(setlocale(LC_TIME, 'spanish')) {{ strftime("%d de %B de %Y", strtotime($contratoArriendo->desde)) }} al {{ strftime("%d de %B de %Y", strtotime($contratoArriendo->hasta)) }} 
            y tendr&aacute; Vigencia {{ $contratoArriendo->tiempoContrato }} meses. Confirmando las partes que contin&uacute;an con la relaci&oacute;n 
            comercial, se renueva autom&aacute;ticamente, a menos que alguna de las partes, manifieste a la otra su intenci&oacute;n de no perseverar en 
            el contrato mediante aviso enviado por carta certificada o carta simple, (correo electr&oacute;nico individualizado en condiciones particulares), 
            enviada a lo menos 30 d&iacute;as de anticipaci&oacute;n al vencimiento del plazo o cualquiera de sus prorrogas. Las partes podr&aacute;n de 
            com&uacute;n acuerdo en cualquier momento durante la vigencia del contrato, acordar su pr&oacute;rroga por los periodos y t&eacute;rminos que 
            en cada oportunidad establezca.</p>
            <p style="page-break-after: always;">
            <p><strong><u>TERCERO</u></strong><strong>: RENTA </strong></p>
            <p>La renta de arriendo se pagar&aacute; mensualmente, de manera anticipada, a m&aacute;s tardar el d&iacute;a {{ $contratoArriendo->diaPago }} 
            de cada mes y tendr&aacute; un valor de <strong>${{ number_format($contratoArriendo->arriendoMensual, 0, '', '.')}}.- ({{ $arriendoEnLetra }}).</strong></p>
            <p>&nbsp;</p>
            <p>En caso de mora o simple retardo en el pago de la renta de arrendamiento, se deber&aacute; pagar el equivalente al 1% de la renta pactada por 
            cada d&iacute;a de atraso. Si como consecuencia del retardo, se le encarga a un abogado la cobranza judicial, el &ldquo;Arrendatario&rdquo; 
            deber&aacute; pagar, adem&aacute;s, el honorario de esta cobranza.</p>
            <p>&nbsp;</p>
            <p>Sin perjuicio de lo anterior, en el evento que el Arrendatario se retrase el pago de dos o m&aacute;s rentas de arrendamiento, sean o&nbsp;
            no consecutivas en una a&ntilde;o calendario, el Arrendador podr&aacute; poner t&eacute;rmino ipso facto al presente contrato, exigir el pago 
            del total de las rentas de arrendamiento que correspond&iacute;an ser pagadas hasta el vencimiento del contrato o de la pr&oacute;rroga que 
            estuviere vigente y exigir la restituci&oacute;n inmediata de la propiedad arrendada, de conformidad a las reglas establecidas en el presente 
            contrato.(Ley n&deg;21.461.-)</p>
            <p>&nbsp;</p>
            <p>La Renta se pagar&aacute; por la plataforma digital Otrospagos.com.</p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>CUARTO:</u></strong><strong> REAJUSTE.</strong></p>
            <p>&nbsp;</p>
            <p>La renta se reajustar&aacute; durante toda la vigencia del arrendamiento; reajuste que se har&aacute; cada doce meses en la misma 
                proporci&oacute;n o porcentaje en que haya podido variar el &Iacute;ndice de Precios al Consumidor (IPC) determinado por el Instituto
             Nacional de Estad&iacute;sticas o por el organismo que lo reemplace, en la relaci&oacute;n al per&iacute;odo que medie entre el &uacute;ltimo 
             d&iacute;a del mes que ante&nbsp;precede&nbsp;al que empieza a regir este contrato y el &uacute;ltimo d&iacute;a del mes ante precedente a 
             aquel en que debe comenzar a regir el reajuste respectivo. Si durante alg&uacute;n per&iacute;odo resulta un IPC negativo o menor al 1%, se 
             reajustar&aacute; este &uacute;ltimo porcentaje.</p>
            <p>&nbsp;</p>
            <p>Comunicaciones. Todas las comunicaciones entre las partes deber&aacute;n dirigirse a las direcciones de correo electr&oacute;nico que se 
                se&ntilde;alan en las condiciones Particulares.</p>
            <p>&nbsp;</p>
            <br>
            <p><strong><u>QUINTO</u></strong><strong>: OBLIGACIONES Y RESPONSABILIDAD</strong> No obstante la obligaci&oacute;n que emana para la arrendataria 
            de la naturaleza de este contrato y los que usualmente se entienden pertenecerles son obligaciones de la arrendataria las siguientes: a) Mantener 
            en perfecto estado de funcionamiento las llaves de los artefactos, las llaves de paso, las v&aacute;lvulas y flotadores de los excusados, los 
            enchufes, timbres e interruptores de la instalaci&oacute;n el&eacute;ctrica, repar&aacute;ndolos y cambi&aacute;ndolos sin derecho a rembolso. b) 
            Conservar la propiedad arrendada en perfecto estado de aseo y conservaci&oacute;n general, esto es, en estado de servir para el fin que ha sido 
            arrendada. c) Efectuar oportunamente y a su costo todas las reparaciones adecuadas para la conservaci&oacute;n y buen funcionamiento de la 
            propiedad arrendada. d) Exhibir los recibos que acredite el pago, hasta el &uacute;ltimo d&iacute;a que ocupe el inmueble, de los consumos de luz, 
            agua potable, extracci&oacute;n de basura, tel&eacute;fono, gastos comunes, etc. e) Restituir el inmueble en la fecha en que termine este contrato, mediante la desocupaci&oacute;n total de la propiedad, poni&eacute;ndola a disposici&oacute;n del arrendador y entreg&aacute;ndole las llaves. f) Dar las facilidades necesarias para que el arrendador o quien lo represente pueda visitar el inmueble, y, en caso de que desee venderlo, permitir su visita, g) Suscribir el inventario conjuntamente con la suscripci&oacute;n de este contrato, el que da cuenta del estado de la propiedad, especies o artefactos que indique el arrendador. Para todos los efectos legales, las partes declaran que se han elevado las obligaciones de la parte arrendataria a la calidad de esenciales y por ello cualquier infracci&oacute;n que acontezca se estimar&aacute; necesariamente como grave incumplimiento del contrato de arrendamiento, y dar&aacute; en forma inmediata al arrendador la facultad de ponerle t&eacute;rmino.</p>
            <p>Destino del Inmueble y N&uacute;mero de Residentes. El arrendatario declara que el inmueble arrendado deber&aacute; ser destinado y usado 
                exclusivamente habitacional por el arrendatario, durante el periodo que dure este contrato. El hecho de destinarse la referida propiedad a 
                una finalidad diferente a la pactada, faculta al arrendador para poner t&eacute;rmino ipso facto al presente Contrato.</p>
            <p>El arrendatario se obliga a no superar el n&uacute;mero de personas indicadas en las condiciones particulares, como residentes de la vivienda 
                objeto del arrendamiento. El incumplimiento de esta cl&aacute;usula, lo cual podr&aacute; ser revisada con el administrador donde se ubica 
                el inmueble, o mediante una inspecci&oacute;n personal por parte del arrendador o mandatario designado, constituir&aacute; prueba suficiente, 
                salvo autorizaci&oacute;n escrita por parte del arrendador, ser&aacute; origen de justa causa de desahucio, por convenirlo as&iacute; ambas 
                partes de manera expresa.</p>
            <p>&nbsp;</p>
            <p style="page-break-after: always;">
            <p><strong><u>SEXTO</u></strong><strong>: &nbsp;PROHIBICIONES</strong>: Queda prohibido a la arrendataria: a) Destinar el inmueble a un objeto 
            distinto al se&ntilde;alado en este contrato. b) Ceder en todo o parte y a cualquier t&iacute;tulo el contrato de arrendamiento o subarrendar en 
            forma total o parcial el inmueble sin el consentimiento previo del arrendador. La cesi&oacute;n del arrendamiento o subarrendamiento con 
            infracci&oacute;n de esta prohibici&oacute;n determinar&aacute; que el arrendatario adquiera la calidad de codeudor solidario responsable de todos 
            los perjuicios que de ello puedan derivarse para el arrendador. c) No mantener la propiedad arrendada en buen estado de conservaci&oacute;n. d) 
            Retrasar el pago de las cuentas de los servicios b&aacute;sicos, tales como luz, agua potable, tel&eacute;fono, gastos comunes, extracci&oacute;n 
            de basuras, etc. e) Imputar la garant&iacute;a al pago de la renta de arrendamiento u otros pagos, ni aun trat&aacute;ndose del &uacute;ltimo mes 
            de arrendamiento. f) Hacer mejoras o variaciones en la propiedad arrendada sin el consentimiento previo del arrendador. g) Clavar o agujerear 
            paredes, causar molestias a los vecinos, introducir materiales explosivos inflamables o de mal olor en la propiedad arrendada. La infracci&oacute;n 
            de cualquiera de estas prohibiciones importar&aacute;, adem&aacute;s del t&eacute;rmino anticipado del contrato de arrendamiento, una multa 
            equivalente a un mes de renta de arrendamiento a favor del arrendador, que las partes aval&uacute;an anticipadamente por concepto de los perjuicios 
            ocasionados por dicha contravenci&oacute;n. &ndash;</p>
            <p>&nbsp;</p>
            <p><strong><u>SEPTIMO</u></strong><strong>: VISITAS AL INMUEBLE</strong>: La arrendataria se obliga a otorgar las facilidades necesarias para que 
            el arrendador sea personalmente o a trav&eacute;s de mandatarios designados PROPITECH a visitar el inmueble cuando lo desee. Asimismo, 
            en caso de que su propietario desee vender el inmueble, se obliga a permitir sus visitas, a lo menos tres d&iacute;as en cada mes, durante dos 
            horas, en horario comprendido entre las diecis&eacute;is: cero cero y las dieciocho: cero cero horas, a su elecci&oacute;n.</p>
            <p>&nbsp;</p>
            <p><strong><u>OCTAVO</u></strong><strong>: MEJORAS</strong>: El arrendador no tendr&aacute; obligaci&oacute;n de hacer mejoras &uacute;tiles en 
            la propiedad arrendada. Las mejoras que pueda efectuar el arrendatario quedar&aacute;n a beneficio de la propiedad desde el momento mismo en que 
            sean ejecutadas, sin que el arrendador deba pagar suma alguna por ellas, cualquiera sea su car&aacute;cter, naturaleza o monto, sin perjuicio de 
            que pueda convenirse otra norma por escrito. Toda transformaci&oacute;n en el inmueble deber&aacute; contar con la aprobaci&oacute;n previa y 
            escrita del arrendador.</p>
            <p>&nbsp;</p>
            <p><strong><u>NOVENO:</u></strong><strong> MANTENCI&Oacute;N DEL INMUEBLE</strong>: Ser&aacute; obligaci&oacute;n del arrendador a efectuar las 
            mejoras necesarias con el objeto de mantener la propiedad arrendada en estado de servir para el fin a que ha sido arrendada, haciendo durante el 
            arrendamiento las reparaciones que sean necesarias para tal objeto, a excepci&oacute;n de las &ldquo;reparaciones locativas&rdquo; que 
            ser&aacute;n de cargo del arrendatario. Se entender&aacute; por &ldquo;reparaciones locativas&rdquo; aquellas que seg&uacute;n la costumbre son 
            normalmente de cargo de los arrendatarios y en general, la reparaci&oacute;n de los deterioros o desperfectos que se producen por culpa del 
            arrendatario o de las personas por las cuales &eacute;ste responde. Especialmente, se considerar&aacute;n &ldquo;reparaciones locativas&rdquo; 
            las siguientes: las relativas a la mantenci&oacute;n en perfecto estado de funcionamiento de las llaves de los artefactos, llaves de paso, 
            v&aacute;lvulas y flotadores de los excusados, enchufes, timbres, alarma e interruptores de la instalaci&oacute;n el&eacute;ctrica; trabajos 
            normales de mantenci&oacute;n y funcionamiento de los servicios de calefacci&oacute;n y agua caliente si los hubiere, repar&aacute;ndolos y 
            cambi&aacute;ndolos por su cuenta. El arrendatario deber&aacute; siempre informar al arrendador las reparaciones locativas que haya efectuado. 
            El Arrendatario deber&aacute; coordinar y realizar mantenci&oacute;n del aire acondicionado dos veces al a&ntilde;o comprobables, se 
            reemplazar&aacute; equipo por parte de Arrendador, y en el caso, que el equipo sea da&ntilde;ado por alguno de los Arrendatarios o no sean 
            realizadas las mantenciones, el equipo puede ser sustituido por Arrendador, pero con un costo del 50% del equipo de cargo al arrendatario.</p>
            <p>&nbsp;</p>
            
            <p><strong><u>DECIMO</u></strong><strong>: GARANT&Iacute;A DE ARRIENDO. </strong>El <strong>&ldquo;Arrendatario&rdquo; </strong>entrega en este 
            acto la suma de &nbsp;<strong>${{ number_format($contratoArriendo->garantia, 0, '', '.')}}.- ({{ $garantiaEnLetra }}),</strong> 
            que corresponde a&nbsp; {{ $contratoArriendo->cantidadGarantias }} de garant&iacute;a, a fin de garantizar la conservaci&oacute;n de la propiedad y su restituci&oacute;n en el 
            mismo estado en que la recibe; la devoluci&oacute;n y conservaci&oacute;n de las especies y artefactos que se indicar&aacute;n en el inventario; 
            el pago de los perjuicios y deterioros que se causen en la propiedad arrendada, sus servicios e instalaciones y en general, para responder 
            del fiel cumplimiento de las estipulaciones de este contrato de arrendamiento. El &ldquo;<strong>Arrendador&rdquo;</strong> se obliga a devolver 
            la garant&iacute;a, debidamente reajustada en la misma forma y/o en los mismos porcentajes en que se reajuste la renta de arrendamiento, 
            dentro de los 45 d&iacute;as siguientes a la restituci&oacute;n de la propiedad arrendada, quedando desde luego autorizada la parte arrendadora 
            para descontar de la cantidad mencionada el valor efectivo de los deterioros, perjuicios y lucro cesante producto, de deterioros y perjuicios 
            que se hayan ocasionado, como asimismo el valor de cuentas pendientes de servicios b&aacute;sicos, aseo, lavado y deterioros de pisos, muros, 
            cielos e inventarios.</p>
            <p style="page-break-after: always;">
            <p>&nbsp;</p>
            <p><strong><u>DECIMO PRIMERO</u></strong><strong>: ROBOS Y PERJUICIOS</strong>: El arrendador no responder&aacute; en caso alguno por robos que 
            puedan ocurrir en la propiedad o por perjuicios que puedan producirse por incendios, inundaciones, filtraciones, rotura de ca&ntilde;er&iacute;as, 
            efectos de humedad y calor, y otros hechos de fuerza mayor o caso fortuito, lo cual se hace extensivo al Corredor de Propiedades a cargo de la 
            administraci&oacute;n de la propiedad arrendada. Queda estipulado, que tanto el arrendador como su mandatario, esto es, PROPITECH, no 
            responder&aacute;n en caso alguno por los eventuales litigios o dificultades de cualquier naturaleza, que puedan haber afectado al anterior 
            arrendatario del inmueble arrendado.</p>
            <p>&nbsp;</p>
            <p><strong><u>D&Eacute;CIMO SEGUNDO</u></strong><strong>: OBLIGACIONES IMPUESTAS POR LA AUTORIDAD</strong>: Ser&aacute;n de cargo de la 
            arrendataria los gastos que pueda ocasionar el cumplimiento de &oacute;rdenes o disposiciones que, en cualquier tiempo, pueda impartir la 
            autoridad en raz&oacute;n del uso a que se destinar&aacute; el inmueble, sean estas exigencias relativas a condiciones sanitarias, 
            higi&eacute;nicas, ambientales, municipales o reglamentarias.</p>
            <p>&nbsp;</p>
            <p><strong><u>D&Eacute;CIMO TERCERO:</u></strong><strong> RESTITUCION DEL INMUEBLE</strong>: El arrendatario se obliga a restituir la propiedad 
            inmediatamente que expire o termine este contrato, en el mismo estado que la recibi&oacute;, tomando en consideraci&oacute;n el uso y desgaste 
            natural de la propiedad. Se obliga a efectuar su restituci&oacute;n mediante la desocupaci&oacute;n total de la propiedad, poni&eacute;ndola a 
            disposici&oacute;n del arrendador y entreg&aacute;ndole las llaves. Se obliga, asimismo, a entregar al arrendador en la misma oportunidad los 
            recibos o comprobantes que acrediten que la propiedad no registra deudas, por concepto de gastos comunes o servicios especiales, como 
            tambi&eacute;n suministros de energ&iacute;a el&eacute;ctrica, agua potable, gas, extracci&oacute;n de basura y otros similares no incluidos en 
            los gastos comunes o servicios especiales. La falta de entrega oportuna por parte del arrendatario har&aacute; devengar a favor del arrendador, 
            adem&aacute;s de la renta del mes completo, una multa moratoria equivalente al cincuenta por ciento de la suma referida, sin perjuicio de los 
            derechos del arrendador para iniciar las acciones legales que procedan en su contra a fin de exigir la restituci&oacute;n del inmueble. Asimismo, 
            el arrendatario se obliga a comunicar por escrito el d&iacute;a y la hora en que abandonar&aacute; la propiedad, ya sea en forma voluntaria o 
            mediante notificaci&oacute;n judicial del desalojo.</p>
            <p>&nbsp;</p>
            <p><strong><u>DECIMO CUARTO:</u></strong><strong> SOLVENCIA.</strong> La parte arrendataria declara expresamente contar con la renta necesaria 
            para pagar la renta pactada y gastos adicionales como los gastos comunes y de servicios y sus reajustes.</p>
            <p>&nbsp;</p>
            <p><strong><u>DECIMO QUINTO:</u></strong><strong> EJEMPLARES DE ESTE CONTRATO. </strong>&nbsp;El presente contrato se otorga en dos ejemplares 
            del mismo tenor, quedando dos en poder de cada parte y otro para archivo.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p><strong><u>D&Eacute;CIMO SEPTO</u></strong><strong>: DOMICILIO. </strong>Para todos los efectos legales derivados del presente contrato, 
            las partes fijan su domicilio en la ciudad de Santiago y se someten a la competencia de sus tribunales ordinarios de justicia.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;"><strong>__________________________________________</strong></p>
            <p style="text-align: center;"><strong>GUSTAVO ENRIQUE CISTERNAS PEREZ</strong></p>
            <p style="text-align: center;"><strong>REPRESENTANTE LEGAL.</strong></p>
            <p style="text-align: center;"><strong>RUT 11.857.826-0</strong></p>
            <!-- firma -->
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;"><strong>__________________________________________</strong></p>
            <p style="text-align: center;"><strong>{{ $contratoArriendo->nombreArrendatario }} {{ $contratoArriendo->apellidoArrendatario }}</strong></p>
            <p style="text-align: center;"><strong>ARRENDATARIO</strong></p>
            <p style="text-align: center;"><strong>RUT {{ $rutArrendatario }}</strong></p>
            <!-- firma -->
            @if($contratoArriendo->idUsuarioCodeudor)
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: center;"><strong>__________________________________________</strong></p>
            <p style="text-align: center;"><strong>{{ $contratoArriendo->nombreCodeudor }} {{ $contratoArriendo->apellidoCodeudor }}</strong></p>
            <p style="text-align: center;"><strong>CODEUDOR</strong></p>
            <p style="text-align: center;"><strong>RUT {{ $rutCodeudor }}</strong></p>
            @endif
        </main>
    </body>
</html>