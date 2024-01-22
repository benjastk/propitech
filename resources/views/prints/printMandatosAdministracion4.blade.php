<html>
    <head>
        <style>
            @page {
                margin: 80px 100px;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
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
            <p style="text-align: center;"><span style="text-decoration: underline;"><strong>MANDATO DE ADMINISTRACI&Oacute;N CON ARRIENDO SEGURO</strong></span></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            @php
            $rutPropiterario1 = explode( "-", $mandatoAdministracion->rutPropietario );
            $rutPropietario = number_format( $rutPropiterario1[0], 0, "", ".") . '-' . $rutPropiterario1[1];
            @endphp
            @php(setlocale(LC_TIME, 'spanish'))
            <p>En Santiago de Chile, a {{ strftime("%d de %B de %Y", strtotime($mandatoAdministracion->fechaCompromisoMandato)) }}, {{ $mandatoAdministracion->nombrePropietario }} 
            {{ $mandatoAdministracion->apellidoPropietario }}, de nacionalidad {{ $mandatoAdministracion->nacionalidadPropietario }}, estado civil 
            {{ $mandatoAdministracion->estadoCivilPropietario}}, de profesi&oacute;n {{ $mandatoAdministracion->profesionPropietario}}, C&eacute;dula 
            de identidad N&deg; {{ $rutPropietario }}, correo <a href="mailto:{{ $mandatoAdministracion->correoPropietario }}">
            {{ $mandatoAdministracion->correoPropietario}},</a> con domicilio en {{ $mandatoAdministracion->direccionPropietario }} {{ $mandatoAdministracion->numeroPropietario }}, 
            comuna de {{ $mandatoAdministracion->comunaPropietario }}, Regi&oacute;n {{ $mandatoAdministracion->regionPropietario }}, en adelante &ldquo;<strong>El MANDANTE&rdquo;</strong>; 
            y por la otra parte comparece don <strong>GUSTAVO ENRIQUE CISTERNAS P&Eacute;REZ</strong>, chileno, c&eacute;dula nacional de identidad 
            n&uacute;mero once millones ochocientos cincuenta y siete mil ochocientos veintis&eacute;is guion cero, corredor de propiedades, casado, 
            quien lo hace en representaci&oacute;n de <strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C SpA</strong>, sociedad del giro de su 
            denominaci&oacute;n, Rol &Uacute;nico Tributario n&uacute;mero setenta y siete millones ciento treinta y cinco mil trescientos dos guion 
            nueve, en adelante el &ldquo;<strong>MANDATARIO&rdquo;</strong>, ambos con domicilio para estos efectos en Avenida Providencia 
            n&uacute;mero mil doscientos ocho, oficina n&uacute;mero doscientos siete, Comuna de Providencia, Regi&oacute;n Metropolitana, quienes 
            se&ntilde;alan que han convenido el siguiente contrato de mandato para administraci&oacute;n de inmuebles:</p>
            <p>&nbsp;</p>
            <p><strong><u>PRIMERO:</u></strong><strong> ANTECEDENTES DE (LOS) INMUEBLE (S). </strong></p>
            <p>Que por el presente instrumento procede a conferir un poder especial a <strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C SpA</strong>, 
            Rol &Uacute;nico Tributario setenta y siete millones ciento treinta y cinco mil trescientos dos guion nueve, en adelante &ldquo;<strong>
            EL MANDATARIO&rdquo; </strong>para administrar la siguiente(s) propiedad(es) de la cual la compareciente declara ser propietaria, y que se 
            encuentra ubicada en <strong>{{ $mandatoAdministracion->direccion }} {{ $mandatoAdministracion->numero }} @if($mandatoAdministracion->block) dpto. 
            {{ $mandatoAdministracion->block }} @endif</strong>, comuna de <strong>{{ $mandatoAdministracion->nombreComuna}}</strong>, Regi&oacute;n 
            {{ $mandatoAdministracion->nombreRegion }}., rol de aval&uacute;o fiscal n&uacute;mero {{ $mandatoAdministracion->rolPropiedad }}.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p><strong><u>SEGUNDO:</u></strong><strong> DURACI&Oacute;N DEL MANDATO.</strong></p>
            <p>La duraci&oacute;n del presente mandato ser&aacute; a contar de <strong>{{ strftime("%d de %B de %Y", strtotime($mandatoAdministracion->desde)) }}</strong>, 
            hasta el <strong>{{ strftime("%d de %B de %Y", strtotime($mandatoAdministracion->hasta )) }}</strong>, pudiendo renovarse de forma &nbsp;t&aacute;cita, 
            continua y sucesiva por periodos iguales, mientras el &ldquo;<strong>MANDANTE&rdquo; </strong>no manifieste, por carta certificada&nbsp; enviada 
            al domicilio del &ldquo;<strong>MANDATARIO&rdquo;</strong>, o por correo electr&oacute;nico, su voluntad en orden de que el presente Mandato no 
            contin&uacute;e.</p>
            <p>&nbsp;</p>
            <p><strong><u>TERCERO:</u></strong><strong> FACULTADES Y PODERES. </strong></p>
            <p>En el ejercicio de este mandato, &nbsp;<strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C SpA</strong> estar&aacute; facultado para:</p>
            <p><strong><u>Facultades Generales</u></strong>:</p>
            <ol>
            <li>Celebrar contrato de arrendamiento y ponerles t&eacute;rmino, pudiendo convenir y modificar toda clase de pactos y estipulaciones, 
            est&eacute;n o no contemplados especialmente por las leyes y sean de su esencia, de su naturaleza o meramente accidentales; fijas precios, 
            intereses, rentas, honorarios, remuneraciones, reajustes, indemnizaciones, plazos, condiciones, deberes, atribuciones, &eacute;pocas y 
            forma de pago y de entrega, cabidas, deslindes, entre otros aspectos;</li>
            <li>Firmar recibos, finiquitos o cancelaciones, y en general, suscribir, otorgar, firmar, extender, refrendar y modificar toda clase de 
            documentos p&uacute;blicos y/o privados relacionados con la administraci&oacute;n del inmueble, pudiendo formular en ellos todas las 
            declaraciones que estime necesarias o convenientes;</li>
            <li>Cobrar y percibir las rentas de arrendamiento de la(s) propiedad(es), y gestionar en dichos inmuebles las reparaciones que estime 
            conveniente para su buena conservaci&oacute;n y rentabilidad, previa autorizaci&oacute;n del propietario por escrito o v&iacute;a 
            correo electr&oacute;nico;</li>
            <li>En general, todas aquellas facultades y atribuciones que sean necesarias para la correcta ejecuci&oacute;n de este Mandato.</li>
            </ol>
            <p style="page-break-after: always;">
            <p>&nbsp;</p>
            <p><strong><u>Facultades Especiales (PLAN {{ $mandatoAdministracion->nombrePlan }})</u></strong>:</p>
            <p>&nbsp;</p>
            <ol>
            <li>Realizar sesiones de fotos y videos de la(s) propiedad(es) individualizadas en la cl&aacute;usula primera del presente contrato;</li>
            <li>Publicaci&oacute;n de la propiedad y de las im&aacute;genes obtenidas, en los principales medios, portales y redes sociales del <strong>MANDATARIO</strong>;</li>
            <li>Mostrar la propiedad, en relaci&oacute;n los t&eacute;rminos que pacte con los clientes, seg&uacute;n lo estipulado en la letra A) de la presente cl&aacute;usula;</li>
            <li>Realizar un an&aacute;lisis de Cr&eacute;dito Riguroso: a trav&eacute;s de la obtenci&oacute;n y an&aacute;lisis de Certificado DICOM Platinum 360&ordm;;</li>
            <li>Gestionar los contratos de compraventa y arriendo en Notar&iacute;a, y en caso de ser necesario, de la inscripciones en el respectivo Conservador de Bienes Ra&iacute;ces;</li>
            <li>Revisar semestralmente el estado de arriendo de la propiedad, realizando un seguimiento de los pagos de las rentas de arriendo, gastos comunes, servicios b&aacute;sicos y cualquier otro gasto especial pactado en el Contrato de Arriendo respectivo.</li>
            <li>Gestionar los da&ntilde;os en la(s) propiedad(es) individualizadas en la cl&aacute;usula primera del presente contrato, que incluye: i) <strong>servicios de pintura</strong>: pintura al agua, solo con color blanco, incluye materiales; ii) <strong>servicios de gasfiter&iacute;a</strong>: para remplazo de flexibles, reparaci&oacute;n de paso de agua y mantenimiento de inodoro (no incluye materiales); iii) <strong>servicios de cerrajer&iacute;a</strong>: mantenimiento de puertas y ventanas (no incluye materiales); iv) <strong>servicios de limpieza de alfombras</strong>: solo mano de obra, no incluye materiales; v) <strong>limpieza de piso flotante</strong>: solo mano de obra, no incluye materiales; vi) <strong>Cambio de vidrier&iacute;a en mal estado</strong>: solo mano de obra, no incluye materiales; vii) <strong>Asesor&iacute;a para mantenci&oacute;n de aire acondicionado</strong>: no incluye valores de mantenci&oacute;n ni cambio en todo o parte del aire acondicionado.</li>
            </ol>
            <p>&nbsp;</p>
            <p><strong><u>CUARTO:</u></strong><strong> REMUNERACI&Oacute;N.</strong></p>
            <p>&nbsp;</p>
            <p>El<strong> MANDATARIO </strong>ser&aacute; remunerado por la ejecuci&oacute;n de este mandato. Para esto efectos el
            <strong> MANDANTE</strong>, pagar&aacute; a el<strong> MANDATARIO</strong>, la siguiente remuneraci&oacute;n:</p>
            <p>&nbsp;</p>
            <ol>
            <li><strong>Comisi&oacute;n de Corretaje</strong>: un <strong>pago &uacute;nico</strong> por un {{ $comisionCorretajePalabras }} por ciento del monto de un 
            mes de arriendo, m&aacute;s IVA;</li>
            </ol>
            <p>&nbsp;</p>
            <ol>
            <li><strong>Comisi&oacute;n por Administraci&oacute;n</strong>: <strong>pagos mensuales</strong> de un {{ $porcentajeAdministracionPalabras }} por ciento del 
            arriendo, m&aacute;s IVA, por concepto de arrendamiento de(l) inmueble(es) materia de este contrato.</li>
            </ol>
            <p>&nbsp;</p>
            <ol>
            <li><strong>Comisi&oacute;n por Venta</strong>: un monto del cuatro por ciento del valor de la propiedad, correspondiendo al 
            <strong>MANDATE</strong> pagar un total del dos por ciento m&aacute;s IVA, y de su contraparte el saldo restante.</li>
            </ol>
            <p>&nbsp;</p>
            <p style="page-break-after: always;">
            <p>El pago de la remuneraci&oacute;n se efectuar&aacute; al<strong> MANDANTE </strong>dentro de los <strong>{{ $diasEnPalabras }} primeros d&iacute;as 
            de cada mes</strong>, en caso de que el día 10 sea inhábil se pagará al día hábil siguiente, sin perjuicio de que la parte arrendataria no haya cancelado el arriendo. Para estos efectos del dep&oacute;sito 
            de sus dineros, el<strong> MANDANTE </strong>declara como cuenta corriente apta para dicho dep&oacute;sito la cuenta N&deg; 
            <strong>{{ $mandatoAdministracion->numeroCuenta}}</strong>, del Banco <strong>{{ $mandatoAdministracion->nombreBanco}}</strong>, mail 
            <a href="mailto:{{ $mandatoAdministracion->correoPropietario }}"><strong>{{ $mandatoAdministracion->correoPropietario }}</strong>,</a> 
            Rut., <strong>{{ $rutPropietario }}</strong>.-</p>
            <p>&nbsp;</p>
            <p>Queda expresamente autorizado <strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C SpA</strong> para que, de las rentas o sumas 
            que perciba, se reembolse de la comisi&oacute;n o retribuci&oacute;n se&ntilde;alada, y de todo gasto en que incurra en la 
            administraci&oacute;n y/o reparaci&oacute;n de los bienes, como asimismo custodiar el monto de la garant&iacute;a entregado por el 
            arrendatario para gestionar los arreglos necesarios para arrendar nuevamente la propiedad en &oacute;ptimas condiciones.</p>
            <p>&nbsp;</p>
            <p><strong><u>QUINTO:</u></strong><strong> ARRIENDO SEGURO.</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p>El <strong>MANDATARIO, </strong>garantiza el pago de las rentas de arrendamiento al<strong> MANDANTE </strong>en tanto el arrendatario 
            del inmueble se encuentre usando el inmueble en virtud del contrato de arrendamiento que celebre con el <strong>&nbsp;MANDATARIO,</strong> 
            con un tope de <strong>tres meses</strong>. El beneficio se activar&aacute; autom&aacute;ticamente y le ser&aacute; informado al 
            <strong>MANDANTE</strong> cuando comience a operar. El arriendo seguro no incluye el pago de los gastos comunes, deterioros o destrozos 
            en el inmueble y tampoco las cuentas b&aacute;sicas adeudadas por el arrendatario. El<strong> MANDATARIO</strong>, no estar&aacute; 
            obligado a cubrir las rentas de arrendamiento cuando el inmueble se encuentre desocupado, es decir sin arrendatarios.</p>
            <p>&nbsp;</p>
            <p><strong><u>SEXTO:</u></strong><strong> COMPETENCIA.</strong></p>
            <p>Las partes declaran que para todos los efectos legales derivados de este contrato fijan su domicilio en la comuna y ciudad de Santiago, 
            otorgando competencia a los respectivos Tribunales Civiles.</p>
            <p>&nbsp;</p>
            <p><strong><u>S&Eacute;PTIMO:</u></strong><strong> COPIAS. </strong></p>
            <p>El presente instrumento se suscribe en un ejemplar que contar&aacute; con Firma Electr&oacute;nica Avanzada, o por medio de 
            Notar&iacute;a que ser&aacute; legalizado y digitalizado y enviado por mail a las partes.</p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>OCTAVO</u></strong><strong>: NOTIFICACIONES Y DOMICILIO.</strong></p>
            <p>Para efecto de las notificaciones y comunicaci&oacute;n entre las partes, estas expresan que sus respectivos contactos son:</p>
            <ol>
            <li><strong>MANDANTE</strong>:</li>
            </ol>
            <ul>
            <li>Domicilio: {{ $mandatoAdministracion->direccionPropietario }} {{ $mandatoAdministracion->numeroPropietario }}, Comuna de {{ $mandatoAdministracion->comunaPropietario }}, Región
                {{ $mandatoAdministracion->regionPropietario }}.</li>
            <li>N&uacute;mero de Tel&eacute;fono: +56 {{ $mandatoAdministracion->telefono }}</li>
            <li>Correo Electr&oacute;nico: <a href="mailto:{{ $mandatoAdministracion->correoPropietario }}">{{ $mandatoAdministracion->correoPropietario }}</a></li>
            </ul>
            <ol>
            <li><strong>MANDATARIO</strong>:</li>
            </ol>
            <ul>
            <li>Domicilio: Avenida Providencia n&uacute;mero mil doscientos ocho, oficina n&uacute;mero doscientos siete, Comuna de Providencia, 
            Ciudad de Santiago.</li>
            <li>N&uacute;mero de Tel&eacute;fono: +56956790356</li>
            <li>Correo Electr&oacute;nico: <a href="mailto:contacto@propitech.cl">contacto@propitech.cl</a></li>
            </ul>
            <p>En caso de que cualquiera de las partes cambie su domicilio, tel&eacute;fono y/o correo indicado en la presente cl&aacute;usula durante 
            la vigencia del presente contrato de mandato, deber&aacute; notificar formalmente y por escrito a la otra de dicha modificaci&oacute;n. 
            En caso contrario, se entender&aacute; como correcta la notificaci&oacute;n y/o comunicaci&oacute;n que se realice, liberando de cualquier 
            responsabilidad que se genere por la incorrecta notificaci&oacute;n.</p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>NOVENO</u></strong><strong>: DECLARACI&Oacute;N.</strong></p>
            <p>El <strong>MANDANTE</strong> declara haber le&iacute;do los T&eacute;rminos y Condiciones y Pol&iacute;ticas de Privacidad contenidas 
            en la p&aacute;gina web <a href="http://www.propitech.cl">www.propitech.cl</a>, y estar de acuerdo con cada una de las cl&aacute;usulas contenidas en ellas.</p>
            <p>&nbsp;</p>
            <p><strong><u>D&Eacute;CIMO</u></strong><strong>: RENDICI&Oacute;N DE CUENTAS</strong>.</p>
            <p>El <strong>MANDANTE</strong> declara expresamente liberar al <strong>MANDATARIO</strong> de rendir cuentas del presente mandato y 
            sus sucesivas renovaciones.</p>
            <p><strong>&nbsp;</strong></p>
            <p><strong><u>D&Eacute;CIMO PRIMERO</u></strong><strong>: PERSONER&Iacute;A</strong>. La personer&iacute;a de don <strong>GUSTAVO ENRIQUE 
            CISTERNAS P&Eacute;REZ</strong>, para actuar en representaci&oacute;n de la sociedad <strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C 
            SpA</strong>, consta en <strong>Certificado de Estatutos Actualizados</strong> del Registro de Empresas y Sociedades del Ministerio de 
            Econom&iacute;a, Fomento y Turismo. El certificado no se inserta, a ruego de las partes por ser consideradas por &eacute;stas y del 
            Notario que autoriza.</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <table>
            <tbody>
            <tr>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>
            <p style="text-align: center;"><strong>__________________________________________</strong></p>
            <p style="text-align: center;"><strong>MANDANTE</strong></p>
            <p style="text-align: center;"><strong>{{ $mandatoAdministracion->nombrePropietario }} {{ $mandatoAdministracion->apellidoPropietario }}</strong></p>
            <p style="text-align: center;"><strong>&nbsp;C.I. N&ordm; {{ $rutPropietario }}</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <p><strong>&nbsp;</strong></p>
            <table>
            <tbody>
            <tr>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>
            <p style="text-align: center;"><strong>__________________________________________</strong></p>
            <p style="text-align: center;"><strong>MANDATARIO</strong></p>
            <p style="text-align: center;"><strong>INVERSIONES Y SERVICIOS PROFESIONALES B&amp;C SpA</strong></p>
            <p style="text-align: center;"><strong>RUT N&ordm; 77.135.302-9</strong></p>
            <p style="text-align: center;"><strong> pp. GUSTAVO ENRIQUE CISTERNAS P&Eacute;REZ</strong></p>
        </main>
    </body>
</html>