@extends('front-end.layouts.app3')
@section('titulo')
<title>Propitech - Preguntas frecuentes</title>
@endsection
@section('meta')
<meta name="description" content="Preguntas frecuentes de nuestros servicios de corretaje">
<meta name="author" content="benjaminperez.cl">
<meta name="generator" content="LaravelV7">
@endsection
@section('css')
@endsection
@section('content')
<section class="pt-4 pt-lg-12">
    <h2 class="fs-32 lh-16 mb-8 text-dark text-center">Preguntas frecuentes</h2>
    <div class="collapse-tabs">
        <ul class="tabs-01 nav nav-tabs justify-content-center text-uppercase d-none d-md-flex" role="tablist">
        <li class="nav-item">
            <a href="#selling1" class="nav-link active rounded-0 lh-2 fs-13 bg-white py-1 px-6 shadow-none"
                data-toggle="tab" role="tab">
            Preguntas de Arrendatarios
            </a>
        </li>
        <li class="nav-item">
            <a href="#renting1" class="nav-link rounded-0 lh-2 fs-13 bg-white py-1 px-6 shadow-none"
                data-toggle="tab" role="tab">
            Preguntas de Propietarios
            </a>
        </li>
        <!--<li class="nav-item dropdown">
            <a href="#question1" class="nav-link rounded-0 lh-2 fs-13 bg-white py-1 px-6 shadow-none"
                data-toggle="tab" role="tab">
            Otras preguntas
            </a>
        </li>-->
        </ul>
        <div class="tab-content shadow-none rounded-0 pt-8 pt-md-10 pb-10 pb-md-12 px-0 bg-gray-01">
        <div id="collapse-tabs-accordion-01">
            <div class="tab-pane tab-pane-parent fade show active container " id="selling1" role="tabpanel">
            <div class="card border-0 bg-transparent">
                <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1"
                            id="headingSelling-01">
                <h5 class="mb-0">
                    <button class="btn lh-2 fs-18 bg-white py-1 px-6 shadow-none w-100 collapse-parent border"
                                    data-toggle="collapse"
                                    data-target="#selling-collapse-01"
                                    aria-expanded="true"
                                    aria-controls="selling-collapse-01">
                    Preguntas de Arrendatarios
                    </button>
                </h5>
                </div>
                <div id="selling-collapse-01" class="collapse show collapsible" aria-labelledby="headingSelling-01" data-parent="#collapse-tabs-accordion-01">
                    <div id="accordion-style-01" class="accordion accordion-01 row my-7 my-md-0 mx-3 mx-md-0">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0 rounded-top" id="heading_1">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0"
                                                            data-toggle="collapse" data-target="#collapse_1"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_1">
                                                            ¿Cómo y cuándo se firma el contrato de arriendo?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_1" class="collapse show" aria-labelledby="heading_1"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <p>Una vez que hayas realizado el pago de la reserva y seas aprobado por la corredora y el propietario, 
                                        se procederá a firmar el contrato de renta. Primero se envía el contrato al propietario para su firma 
                                        y posteriormente al arrendatario o se puede firmar en notaria de forma presencial. Luego de que se 
                                        realice el pago del primer mes de renta, se coordinará la entrega de la propiedad. 
                                    </p>
                                    <p>La firma del contrato de renta es completamente online y no debes pagar nada adicional (menos ir a una 
                                        notaría y pagarle a un notario). 
                                    </p>
                                    <p>Te llegará un email con un link para iniciar el proceso, el cuál es el siguiente:</p>

                                    <p> 1.- Debes revisar y aprobar el contrato de arriendo y sus condiciones específicas. </p>
                                    <p> 2.- Debes subir una foto de tu cédula de identidad por ambos lados. </p>
                                    <p> 3.- El notario público validará la firma que dibujes en el contrato con tu cédula de identidad.</p>
                                    <p> 4.- Debes aprobar que estás de acuerdo con la firma del contrato de arriendo por una segunda vez.</p>
                                    <p> 5.- Una vez termines ese proceso, quedarás a la espera de que todos los que participen en el contrato
                                            firmen (tus coarrendatarios si es que tienes y también el propietario). Luego de que pagues lo 
                                            correspondiente a la garantía y primer mes de arriendo, el contrato firmado será enviado a todas las 
                                            partes.
                                    </p>
                                </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0" id="heading_2">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                            data-toggle="collapse" data-target="#collapse_2"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_2">
                                                            Cuánto debo pagar a la hora de firmar el contrato de arriendo?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_2" class="collapse" aria-labelledby="heading_2"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <p>Una vez que hayas firmado el contrato de arriendo, te llegará los datos de la corredora, en el cual deberás 
                                    pagar lo siguiente:</p>

                                    <p>Casos para arriendo que parten entre el día 1 y 25 del mes: </p>

                                    <p> * Garantía correspondiente a 1er mes de arriendo.</p>
                                    <p> * Días proporcionales del mes. Por ejemplo, si el contrato inició el día 5 y el mes tiene 30 días, 
                                        deberás pagar (30 – 5) /30 por 1 mes de arriendo.</p>
                                    <p>Casos para arriendo que parten desde el día 25 del mes en adelante:</p>

                                    <p>Garantía correspondiente a 1er mes de arriendo. </p>
                                    <p>Días restantes del mesproporcional al valor de 1 mes de arriendo más 1 mes de arriendo por adelantado. 
                                        Por ejemplo, si el contrato inicia el día 26 en un mes de 30 días, deberás pagar los 4 días restantes 
                                        (4/30 por 1 mes de arriendo) más 1 mes de arriendo por adelantado.
                                    </p>
                                    <p>Este monto puedes pagarlo con cualquier medio de pago electrónico, incluyendo tarjetas de crédito 
                                        [¡acumularás puntos con tu banco!].
                                    </p>
                                    <p>Importante: para iniciar el proceso de coordinación de entrega de la propiedad se deberá haber pagado 
                                        los montos descritos anteriormente.
                                    </p>
                                </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-xxs-2 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0" id="heading_3">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                            data-toggle="collapse" data-target="#collapse_3"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_3">
                                    Cuando ya eres Arrendatario Propitech - ¿A quién le corresponde los arreglos en la propiedad?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_3" class="collapse" aria-labelledby="heading_3"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <p>Los inmuebles, así como otras estructuras y objetos que utilizamos con frecuencia, presentan problemas y requieren mantenimientos. Entendemos que muchas veces no está claro quién es el responsable de costear los arreglos o mejoras de la propiedad arrendada, si es el Arrendatario o Propietario. Es por esto que creamos los siguientes lineamientos que se aplican a los contratos administrados por Propitech y que se detallan a continuación.</p>
                                    <p><strong>Es importante recordar: </strong></p>
                                    <ul>
                                    <li>En cualquier momento del arriendo, problemas ocasionados al inmueble arrendado o al mobiliario que lo guarnece por el mal uso de los Arrendatarios y moradores serán de responsabilidad y cargo del Arrendatario.</li>
                                    <li>Los problemas no ocasionados por un mal uso, pero que aún sean de responsabilidad del Arrendatario de conformidad al Contrato de Arrendamiento, estos lineamientos o la legislación vigentes, deben ser reparados para evitar el agravamiento de la situación y dejarlos en correcto estado de funcionamiento tal como fueren recibidos y en la forma en que se da cuenta en el acta de entrega del Inmueble, bajo responsabilidad y cargo del Arrendatario.</li>
                                    <li>Los problemas de responsabilidad del Propietario deben ser comunicados a la Ejecutiva de Administración de Propitech vía correo electrónico <a href="mailto:contacto@propitech.cl">contacto@propitech.cl</a> por el Arrendatario, de forma que Propitech pueda intermediar en la determinación de a quién corresponde efectuar la reparación del mismo. El Arrendatario deberá comunicar estos problemas a la Ejecutiva de Administración de Propitech dentro de las 72 horas siguientes a que se haya presentado el problema. De lo contrario, el Arrendatario será responsable de efectuar dichas reparaciones a su costo y riesgo, quedando sujeto al cobro de las reparaciones al final del arrendamiento si no las hubiera realizado con anterioridad y a satisfacción del Propietario, pudiendo a este efecto usarse el monto que el Arrendatario haya dado en garantía y si no hubiera más dinero disponible de dicho monto para realizar los arreglos, el Arrendatario deberá cubrir la diferencia. El Propietario podrá perseguir dicho pago aún después de que el Arrendatario abandone el Inmueble.</li>
                                    <li>Todo problema encontrado en la inspección del inmueble, ya sea estético o funcional, debe ser registrado en el acta de entrega para que no haya cobro por dichos desperfectos al final del contrato. </li>
                                    <li>Descuentos en arriendos relativos a reparaciones y mejoras se llevarán a cabo sólo cuando estén informadas al Ejecutivo de Administración y aprobadas por el Propietario.</li>
                                    <li>Sabemos que algunas veces el problema es más grave de lo que aparenta, siendo originado en la estructura del inmueble y por lo tanto de responsabilidad del Propietario. Si crees que ese es el caso, a partir de la presentación del diagnóstico de un profesional, podremos reevaluar y dirigir la resolución de la forma más adecuada. </li>
                                    </ul>
                                    <p><strong>Responsabilidades según el tiempo que ha transcurrido desde la firma del Contrato:</strong></p>
                                    <ol>
                                    <li><strong>I) Inicio del arriendo: Primeros 30 días. </strong></li>
                                    </ol>
                                    <p><span><u>Reparaciones de responsabilidad del Propietario. </u></span></p>
                                    <p>Entendemos que algunos problemas sólo se identifican con el uso diario del inmueble. A veces, un equipo estaba en funcionamiento, pero ya muy pronto a fallar. Por eso, adoptamos 30 días como un plazo razonable para que servicios anteriores al arrendamiento se manifiesten. </p>
                                    <p>Dentro del plazo de 30 días el Propietario se hará cargo de las reparaciones relativas a:</p>
                                    <ul>
                                    <li>Mal funcionamiento de grifos, sifones, registros, duchas higiénicas, inodoros. </li>
                                    <li>Sello ineficiente de lavamanos, fregaderos, tinas. </li>
                                    <li>Mal funcionamiento de los interruptores y puntos de luz. </li>
                                    <li>Problemas en el aire acondicionado y los electrodomésticos. </li>
                                    <li>Problemas en el calefón, calentador de gas y eléctrico. </li>
                                    <li>Mal funcionamiento de las persianas externas. </li>
                                    </ul>
                                    <p>El Propietario será responsable de las reparaciones de los objetos recién mencionados, siempre y cuando los desperfectos o arreglos requeridos no hayan sido causados por el mal uso, negligencia o actuación dolosa del Arrendatario.</p>
                                    <p>&nbsp;</p>
                                    <p><span><strong>El Arrendatario dentro de los primeros 30 días del Contrato de Arrendamiento tendrá derecho a proponer:</strong></span></p>
                                    <p><span>reparaciones o mejoras en el Inmueble, si dichos reparos o mejoras hubiesen sido registrados en el acta de entrega del Inmueble. Sin perjuicio de lo anterior, el Propietario no estará obligado a hacerse cargo de dichas reparaciones o mejoras, quedando sujetas a la negociación respectiva entre las partes. Las reparaciones o mejoras a que se refiere este párrafo son, taxativamente, las siguientes:</span></p>
                                    <ul>
                                    <li>Intercambio de interruptores. </li>
                                    <li>Mal funcionamiento de puertas, manijas y ventanas. </li>
                                    <li>Compra de llaves para puertas internas. </li>
                                    <li>Sustitución de cristales quebrados. </li>
                                    <li>Fijación de pies de puertas. </li>
                                    <li>Mal funcionamiento de persianas internas/externas. </li>
                                    </ul>
                                    <ol>
                                    <li><strong>II) Después de los primeros 30 días de arriendo. </strong></li>
                                    </ol>
                                    <p><span>Serán de responsabilidad y cargo del Arrendatario, entre otras que le pudieran corresponder en virtud del Contrato de Arrendamiento y la legislación vigente, las siguientes Reparaciones de responsabilidad del Arrendatario:</span></p>
                                    <ul>
                                    <li>Mal funcionamiento de grifos, sifones, registros, duchas higiénicas, inodoros. </li>
                                    <li>Sello ineficiente de lavamanos, fregaderos y tinas. </li>
                                    <li>Mal funcionamiento de interruptores y puntos de luz. </li>
                                    <li>Problemas en el aire acondicionado y los electrodomésticos. </li>
                                    <li>Mantenimiento preventivo en el calefón o calentador de gas o eléctrico (como cambio de pilas o filtro, limpieza, regulación). </li>
                                    <li>Mal funcionamiento de persianas internas/externas. </li>
                                    </ul>
                                    <p><strong>III) Durante todo el arriendo. </strong></p>
                                    <p>Serán de responsabilidad y cargo del Propietario las siguientes (siempre y cuando los desperfectos no se deban al actuar culposo, negligente o doloso del Arrendatario en el mantenimiento del Inmueble y los muebles que lo guarnecen):</p>
                                    <ul>
                                    <li></li>
                                    <li>Problemas hidráulicos que requieren roturas de paredes (reparaciones en tuberías). </li>
                                    <li>Problemas en el cableado eléctrico y en el tablero eléctrico. </li>
                                    <li>Fugas de gas. </li>
                                    <li>Problemas en el calefón o calentador de gas y eléctrico, con excepción de los arreglados por mantenimientos preventivos. En caso de ser ocasionados por falta de mantención, estos serán de responsabilidad del Arrendatario. </li>
                                    <li>Ventanas con hoja suelta o entrada de agua por el marco. </li>
                                    <li>Caída de fregaderos, lavamanos y muebles fijados en paredes. </li>
                                    <li>Estufa / desprendimiento de revestimientos de paredes y pisos. </li>
                                    <li>Problemas en tejados, rieles y caja de agua. </li>
                                    </ul>
                                    <p><span>Adicionalmente, durante toda la vigencia del Contrato de Arrendamiento, el Arrendatario podrá plantear al Propietario realizar las mejoras listadas a continuación, las que el Propietario pagará en todo o en parte sólo si hubiera un acuerdo entre él y el Arrendatario con anterioridad a efectuar dichas reparaciones o mejoras. El Propietario no se encuentra obligado a aceptar ninguna de las siguientes mejoras, pero deberá sostener conversaciones con el Arrendatario en vistas a ver la factibilidad de ejecutar las mismas y la manera de distribuir los costos en caso de acceder a ellas:</span></p>
                                    <ul>
                                    <li>Acristalamiento de balcón. </li>
                                    <li>Instalación de redes de protección. </li>
                                    <li></li>
                                    <li>Instalación de cerraduras especiales.
                                    </li>
                                    </ul>
                                    <p>Las demás reparaciones y mejoras que no se encuentren reguladas expresamente en el Contrato de Arrendamiento o en este documento, serán de cargo y de responsabilidad del Arrendatario a menos que la legislación vigente estableciera expresamente lo contrario y no se pudiere pactar entre las partes en forma distinta. </p>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pt-md-0 pt-6">
                            <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0 rounded-top" id="heading_4">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                            data-toggle="collapse" data-target="#collapse_4"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_4">
                                                            ¿Cuáles son los requisitos y documentos necesarios para arrendar una propiedad en Propitech?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_4" class="collapse" aria-labelledby="heading_4"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <table width="926">
                                    <tbody>
                                    <tr>
                                    <td width="188">
                                    <p>Dependientes</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="188">
                                    <p>&nbsp;</p>
                                    <p>&gt;  Carnet de Identidad Chileno vigente por ambos lados.</p>
                                    <p>&gt;  Certificado de antigüedad laboral o copia del contrato de trabajo vigente 
                                        <br>e indefinido.</p>
                                    <p>&gt;  3 últimas liquidaciones de renta. * (Demuestra un ingreso mensual líquido <br> 3 veces el valor del arriendo)</p>
                                    <p>&gt;  Últimas 12 cotizaciones de AFP con Rut del empleador pagador.</p>
                                    <p>&gt;  Se podrán complementar los ingresos de las personas que vivirán en la <br> propiedad.</p>
                                    <p>&gt;  Certificado Dicom Equifax</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <table width="926">
                                    <tbody>
                                    <tr>
                                    <td width="188">
                                    <p>Independientes</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="188">
                                    <p>&nbsp;</p>
                                    <p>&gt;  Carnet de Identidad Chileno vigente por ambos lados.</p>
                                    <p>&gt;  Boletas de Honorarios 12 meses</p>
                                    <p>&gt;  Declaración de pago de impuestos mensual. (F29)</p>
                                    <p>&gt;  Declaración de impuestos sobre la renta. (F22)</p>
                                    <p>&gt;  Demuestra un ingreso mensual líquido 3 veces el valor del arriendo</p>
                                    <p>&gt;  Se podrán complementar los ingresos de las personas que vivirán en la <br> propiedad.</p>
                                    <p>&gt;  Certificado Dicom Equifax</p>
                                    <p>&nbsp;</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <table width="926">
                                    <tbody>
                                    <tr>
                                    <td width="184">
                                    <p>Pensionado</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="184">
                                    <p>&nbsp;</p>
                                    <p>&gt;  Carnet de Identidad Chileno vigente por ambos lados.</p>
                                    <p>&gt;  3 últimos comprobantes pago de pensión. * (Demuestra un ingreso 
                                        <br>mensual líquido 3 veces el valor del arriendo)</p>
                                    <p>&gt;  Demuestra un ingreso mensual líquido 3 veces el valor del arriendo.</p>
                                    <p>&gt;  Se podrán complementar los ingresos de las personas que vivirán en la 
                                        <br>propiedad.</p>
                                    <p>&gt;  Certificado Dicom Equifax</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <table width="926">
                                    <tbody>
                                    <tr>
                                    <td width="175">
                                    <p>Empleados Público</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="175">
                                    <p>&nbsp;</p>
                                    <p>&gt;  Carnet de Identidad Chileno vigente por ambos lados.</p>
                                    <p>&gt;  3 últimas liquidaciones de renta. * (Demuestra un ingreso mensual líquido
                                        <br> 3 veces el valor del arriendo)</p>
                                    <p>&gt;  Certificado de empleado público</p>
                                    <p>&gt;  Se podrán complementar los ingresos de las personas que vivirán en la 
                                        <br>propiedad.</p>
                                    <p>&gt;  Certificado Dicom Equifax</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <table width="926">
                                    <tbody>
                                    <tr>
                                    <td width="190">
                                    <p>Persona Jurídica</p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td width="190">
                                    <p>&nbsp;</p>
                                    <p>&gt;  Carnet de Identidad vigente por ambos lados del representante legal.</p>
                                    <p>&gt;  Escritura de Constitución de la Sociedad y sus modificaciones</p>
                                    <p>&gt;  Certificado que acredite vigencia de la sociedad.</p>
                                    <p>&gt;  Certificado que acredite vigencia del representante legal de la Sociedad</p>
                                    <p>&gt;  Rut de la Sociedad</p>
                                    <p>&gt;  Dirección del domicilio donde se ejerce el giro como persona jurídica.</p>
                                    <p>&gt;  Últimas dos declaraciones de renta y últimos seis pagos de IVA.</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0" id="heading_5">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                            data-toggle="collapse" data-target="#collapse_5"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_5">
                                                            ¿La reserva me garantiza el arriendo de la propiedad?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_5" class="collapse" aria-labelledby="heading_5"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <p>El arriendo de la propiedad sólo está garantizado después de que ambas partes firman el contrato, por lo que realizar la reserva no garantiza que el propietario acepte y se proceda a la firma del contrato.</p>
                                </div>
                                </div>
                            </div>
                            <div class="card border-0 shadow-xxs-2 rounded-top overflow-hidden">
                                <div class="card-header border-0 p-0" id="heading_6">
                                <h5 class="mb-0">
                                    <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                            data-toggle="collapse" data-target="#collapse_6"
                                                            aria-expanded="true"
                                                            aria-controls="collapse_6">
                                                            ¿Por cuánto tiempo es válida mi reserva?
                                    </button>
                                </h5>
                                </div>
                                <div id="collapse_6" class="collapse" aria-labelledby="heading_6"
                                                    data-parent="#accordion-style-01">
                                <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                    <p>No solicitamos el pago anticipado de reserva.</p>
                                    <p>La reserva se realizará solo una vez que este aprobado el perfil del arrendatario por el departamento de evaluaciones y el propietario. El proceso tendrá una duración de 48 horas.</p>
                                    <p><strong>Si desistes del arriendo de la propiedad antes de la entrega o durante, solo se devolverá el mes de arriendo + mes de garantía. Solo quedará retenido la reserva en su totalidad.</strong> </p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="tab-pane tab-pane-parent fade container" id="renting1" role="tabpanel">
                <div class="card border-0 bg-transparent">
                    <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1" id="headingRenting-01">
                        <h5 class="mb-0">
                            <button class="btn lh-2 fs-18 bg-white py-1 px-6 shadow-none w-100 collapse-parent border collapsed"
                                            data-toggle="collapse"
                                            data-target="#renting-collapse-01"
                                            aria-expanded="true"
                                            aria-controls="renting-collapse-01">
                            Preguntas de Propietarios
                            </button>
                        </h5>
                    </div>
                    <div id="renting-collapse-01" class="collapse collapsible" aria-labelledby="headingRenting-01" data-parent="#collapse-tabs-accordion-01">
                        <div id="accordion-style-01-2" class="accordion accordion-01 row my-7 my-md-0 mx-3 mx-md-0">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0 rounded-top" id="heading_10">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0"
                                                                data-toggle="collapse" data-target="#collapse_10"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_10">
                                                                Sobre el proceso de arriendo y visitas- ¿Cuándo recibo el pago del arriendo y cuánto me depositan?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_10" class="collapse show" aria-labelledby="heading_10"
                                                        data-parent="#accordion-style-01-2">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        <p>Existen 2 formas de pago de arriendo, que dependen del plan que escojas. Los planes son:</p>
                                        <p><strong>Plan Básico:</strong></p>
                                        <p><u>En el inicio del contrato:</u> (depende del día en que se firma el contrato)</p>
                                        <ul>
                                        <li>Antes del día 25 del mes: Días proporcionales que le falta al mes + garantía de un mes – corretaje (50% del arriendo + IVA)</li>
                                        <li>Después del día 26 del mes:  Días proporcionales que le falta al mes + 1 mes de arriendo + garantía de un mes – corretaje (50% del arriendo + IVA)</li>
                                        </ul>
                                        <p>&nbsp;</p>
                                        <p><u>En régimen:</u> </p>
                                        <p>El pago del arriendo se realiza a través de Otrospagos.com, por lo que recibirás tu arriendo en tu cuenta bancaria dentro de los próximos 2 días bancarios hábiles desde la realización del pago por parte del arrendatario.</p>
                                        <p>&nbsp;</p>
                                        <p><strong>Plan </strong><strong>Raulí:</strong></p>
                                        <p><u>En el inicio del contrato:</u> </p>
                                        <p>Gastos legales – corretaje (50% del arriendo + IVA)</p>
                                        <p>El siguiente día 5 del mes te pagaremos:  días proporcionales que le faltaban al mes – el valor del plan contratado.</p>
                                        <p>&nbsp;</p>
                                        <p><u>En régimen:</u> </p>
                                        <p>Los días 5 de cada mes se te pagará el arriendo correspondiente al mes. </p>
                                        <p>&nbsp;</p>
                                        <p>Ejemplo:</p>
                                        <p><u>Plan </u><u>Raulí</u></p>
                                        <p>Si entra un arrendatario el día 10 de febrero a tu departamento (inicio de contrato), el 12 de febrero se te pagará mes de garantía menos ½ Mes + IVA de comisión Propitech. Luego el día 5 de marzo se te paga el proporcional de los días. </p>
                                        <p>Después en los meses siguientes, se paga los días 5 de cada mes el arriendo del mes anterior. </p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_11">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_11"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_11">
                                                                ¿Qué documentos y requisitos necesito para poder vender una propiedad?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_11" class="collapse" aria-labelledby="heading_11"
                                                        data-parent="#accordion-style-01-2">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        <p>Para poder publicar y empezar el proceso de venta se agendará una cita con uno de nuestro asesor inmobiliario, quien tomará fotos de la propiedad y la publicará en los principales portales inmobiliarios del país.</p>
                                        <p>Luego, al momento de existir un interesado en comprar la propiedad y realizar la venta, te solicitaremos los siguientes documentos: </p>
                                        <ol>
                                        <li>Certificado de Dominio Vigente de tu propiedad.</li>
                                        <li>Certificado de Hipotecas y Gravámenes.</li>
                                        <li>Certificado de Interdicciones y Prohibiciones de Enajenar.</li>
                                        <li>Certificado de Avalúo Fiscal.</li>
                                        </ol>
                                        <p>Pero no te preocupes, para todo este proceso te ayudaremos con lo que necesites.</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pt-md-0 pt-6">
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0 rounded-top" id="heading_7">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_7"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_7">
                                                                ¿Cómo funciona la comisión de venta?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_7" class="collapse" aria-labelledby="heading_7"
                                                        data-parent="#accordion-style-01-2">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        <p>El vendedor paga el 2% + IVA del valor de la propiedad por el servicio de corretaje. </p>
                                        <p>Además, obtiene asesoría de nuestros ejecutivos, reportes, gestión de la firma de promesa y seguimiento a la escritura e inscripción de la propiedad en el Conservador de Bienes Raíces. Siempre estará acompañado de uno de nuestros asesores para hacer el proceso fácil y agradable.</p>
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_8">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_8"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_8">
                                                                ¿Cómo se evalúan a los compradores?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_8" class="collapse" aria-labelledby="heading_8"
                                                        data-parent="#accordion-style-01-2">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        <p>Los compradores son calificados desde el momento en que llega su contacto, se perfilan, se realizan las visitas.</p>
                                        <p>Posteriormente realizan oferta y en caso de ser aceptada se les pide un certificado de crédito aprobado o respaldo de tener el dinero para pago al contado.</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="tab-pane tab-pane-parent fade container" id="question1" role="tabpanel">
                <div class="card border-0 bg-transparent">
                    <div class="card-header border-0 d-block d-md-none bg-transparent px-0 py-1" id="headingOther-01">
                    <h5 class="mb-0">
                        <button class="btn lh-2 fs-18 bg-white py-1 px-6 shadow-none w-100 collapse-parent border collapsed"
                                        data-toggle="collapse"
                                        data-target="#other-collapse-01"
                                        aria-expanded="true"
                                        aria-controls="other-collapse-01">
                        Other question
                        </button>
                    </h5>
                    </div>
                    <div id="other-collapse-01" class="collapse collapsible" aria-labelledby="headingOther-01" data-parent="#collapse-tabs-accordion-01">
                        <div id="accordion-style-01-3" class="accordion accordion-01 row my-7 my-md-0 mx-3 mx-md-0">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_14">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0"
                                                                data-toggle="collapse" data-target="#collapse_14"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_14">
                                        How do I delete my account?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_14" class="collapse show" aria-labelledby="heading_14"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0 rounded-top" id="heading_13">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_13"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_13">
                                        How can we help?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_13" class="collapse" aria-labelledby="heading_13"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_15">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_15"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_15">
                                        Do you store any of my information?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_15" class="collapse" aria-labelledby="heading_15"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 pt-md-0 pt-6">
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0 rounded-top" id="heading_16">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_16"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_16">
                                        I’ve got a problem, how do I contact support?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_16" class="collapse" aria-labelledby="heading_16"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 mb-6 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_17">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_17"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_17">
                                        How do I delete my account?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_17" class="collapse" aria-labelledby="heading_17"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-xxs-2 rounded-top overflow-hidden">
                                    <div class="card-header border-0 p-0" id="heading_18">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link font-weight-500 pl-6 pr-7 py-3 fs-16 position-relative w-100 text-left rounded-0 collapsed"
                                                                data-toggle="collapse" data-target="#collapse_18"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_18">
                                        What is cloud backup?
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapse_18" class="collapse" aria-labelledby="heading_18"
                                                        data-parent="#accordion-style-01-3">
                                    <div class="card-body fs-13 lh-2 pl-6 pr-7 pb-6">
                                        GrandHome is intended to be highly responsive and customizable for site
                                        building
                                        process. Thanks to its devoted, fastidious, and compact design, Mitech
                                        can be
                                        considered among plenty of unique themes that serve to create highly
                                        responsive
                                        websites.
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
        </div>
    </div>
    </section>
@endsection
@section('jss')

@endsection