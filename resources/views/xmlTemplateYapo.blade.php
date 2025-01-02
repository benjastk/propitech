<?xml version="1.0" encoding="UTF-8"?>
    <import>
        <settings>
            <language><![CDATA[ es ]]></language>
        </settings>
        <items>
            @foreach($propiedades as $propiedad)
            <item>
                <required>
                    <ad>
                        <sourceid><![CDATA[{{ $propiedad->id }}]]></sourceid>
                        <countryid><![CDATA[5247]]></countryid>
                        @if($propiedad->idTipoComercial == 1)
                            @if($propiedad->idTipoPropiedad == 1)
                            <categoryid><![CDATA[173]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 2)
                            <categoryid><![CDATA[179]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 3)
                            <categoryid><![CDATA[178]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 4)
                            <categoryid><![CDATA[179]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 5)
                            <categoryid><![CDATA[178]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 6)
                            <categoryid><![CDATA[179]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 7)
                            <categoryid><![CDATA[179]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 8)
                            <categoryid><![CDATA[171]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 9)
                            <categoryid><![CDATA[179]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 10)
                            <categoryid><![CDATA[172]]></categoryid>
                            @endif
                        @else
                            @if($propiedad->idTipoPropiedad == 1)
                            <categoryid><![CDATA[157]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 2)
                            <categoryid><![CDATA[156]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 3)
                            <categoryid><![CDATA[1458]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 4)
                            <categoryid><![CDATA[156]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 5)
                            <categoryid><![CDATA[1458]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 6)
                            <categoryid><![CDATA[156]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 7)
                            <categoryid><![CDATA[156]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 8)
                            <categoryid><![CDATA[160]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 9)
                            <categoryid><![CDATA[156]]></categoryid>
                            @elseif($propiedad->idTipoPropiedad == 10)
                            <categoryid><![CDATA[159]]></categoryid>
                            @endif
                        @endif
                        <regionid><![CDATA[{{ $propiedad->codigoComuna }}]]></regionid>
                        @if($propiedad->idTipoComercial == 1)
                            @if($propiedad->idTipoPropiedad == 1)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 2)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 3)
                            <type><![CDATA[lot]]></type>
                            @elseif($propiedad->idTipoPropiedad == 4)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 5)
                            <type><![CDATA[lot]]></type>
                            @elseif($propiedad->idTipoPropiedad == 6)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 7)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 8)
                            <type><![CDATA[comercial_sale]]></type>
                            @elseif($propiedad->idTipoPropiedad == 9)
                            <type><![CDATA[property]]></type>
                            @elseif($propiedad->idTipoPropiedad == 10)
                            <type><![CDATA[comercial_sale]]></type>
                            @endif
                        @else
                            @if($propiedad->idTipoPropiedad == 1)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 2)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 3)
                            <type><![CDATA[lot]]></type>
                            @elseif($propiedad->idTipoPropiedad == 4)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 5)
                            <type><![CDATA[lot]]></type>
                            @elseif($propiedad->idTipoPropiedad == 6)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 7)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 8)
                            <type><![CDATA[comercial]]></type>
                            @elseif($propiedad->idTipoPropiedad == 9)
                            <type><![CDATA[rent]]></type>
                            @elseif($propiedad->idTipoPropiedad == 10)
                            <type><![CDATA[comercial]]></type>
                            @endif
                        @endif
                        <title><![CDATA[{{ $propiedad->nombrePropiedad }}]]></title>
                        @if($propiedad->idTipoComercial == 1)
                        <currency><![CDATA[CLF]]></currency>
                        @else
                        <currency><![CDATA[CLP]]></currency>
                        @endif
                        @if($propiedad->idTipoComercial == 1)
                        <price><![CDATA[{{ $propiedad->precio }}]]></price>
                        @else
                        <rent><![CDATA[{{ $propiedad->valorArriendo }}]]></rent>
                        @endif
                        <rooms><![CDATA[ {{$propiedad->habitacion}} ]]></rooms>
                        <bath><![CDATA[ {{ $propiedad->bano}} ]]></bath>
                        <square><![CDATA[ {{ $propiedad->mTotal }}]]></square>
                        @if($propiedad->usoGoceEstacionamiento == 1)
                        <parking><![CDATA[1]]></parking>
                        @else
                        <parking><![CDATA[0]]></parking>
                        @endif
                        <advertiser><![CDATA[Agente]]></advertiser>
                    </ad>
                        <contact>
                        <email><![CDATA[gcisternas@propitech.cl]]></email>
                        <phone><![CDATA[956790356]]></phone>
                        <contact><![CDATA[Propitech By Cirobu]]></contact>
                        <city><![CDATA[Santiago, Región Metropolitana]]></city>
                    </contact>
                </required>
                <optional>
                    <ad>
                        <descr><![CDATA[{!! $propiedad->descripcion2 !!}]]></descr>
                        <picture><![CDATA[https://propitech.cl/img/propiedad/{{ $propiedad->fotoPrincipal }}]]></picture>
                        @foreach($propiedad->fotos as $foto)
                        <picture><![CDATA[https://propitech.cl/img/propiedad/{{ $foto->nombreArchivo }}]]></picture>
                        @endforeach
                        @if($propiedad->gastosComunes)
                        <maintenance><![CDATA[{{$propiedad->gastosComunes}}]]></maintenance>
                        @endif
                        <location-lat><![CDATA[{{ $propiedad->latitud }}]]></location-lat>
                        <location-long><![CDATA[{{ $propiedad->longitud }}]]></location-long>
                    </ad>
                </optional>
            </item>
            @endforeach
        </items>
    </import>