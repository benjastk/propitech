<?xml version="1.0" encoding="UTF-8"?>
<listings>
    @foreach($propiedades as $propiedad)
    <listing>
        <referenceId><![CDATA[{{ $propiedad->id }}]]>
        </referenceId>
            <contact>
                <name><![CDATA[Propitech]]></name>
                <email><![CDATA[contacto@propitech.cl]]></email>
                <phones>
                    <phone whatsapp="true">
                    <![CDATA[ +56 9 2742 9764 ]]>
                    </phone>
                </phones>
                <agencyName>
                    <![CDATA[ Propitech By Cirobu ]]>
                </agencyName>
                <agencyLogo>
                    <![CDATA[ https://propitech.cl/img/usuarios/1710343483406242798_122102285768130216_4731989332340931999_n.jpg ]]>
                </agencyLogo>
                <agencyId>
                    <![CDATA[]]>
                </agencyId>
                <agencyAddress>
                    <![CDATA[ Av. Providencia 1208 Of. 207, Santiago de Chile ]]>
                </agencyAddress>
                <vendeId>
                    <![CDATA[]]>
                </vendeId>
            </contact>
            <address>
                <![CDATA[ {{ $propiedad->direccion.' '. $propiedad->numero }} ]]>
            </address>
            <commune>
                <![CDATA[ {{ $propiedad->nombreComuna }} ]]>
            </commune>
            <description><![CDATA[{!! $propiedad->descripcion2 !!}]]></description>
            <prices>
                @if($propiedad->idTipoComercial == 1)
                <price currency="CLF" operation="Venta">{{ $propiedad->precio }}</price>
                @else
                <price currency="CLP" operation="Arriendo">{{ $propiedad->valorArriendo }}</price>
                @endif
            </prices>
            @if($propiedad->idTipoPropiedad == 1)
            <propertyType><![CDATA[ Casa ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 2)
            <propertyType><![CDATA[ Departamento ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 3)
            <propertyType><![CDATA[ Terreno ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 4)
            <propertyType><![CDATA[ Departamento ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 5)
            <propertyType><![CDATA[ Terreno ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 6)
            <propertyType><![CDATA[ Terreno ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 7)
            <propertyType><![CDATA[ Casa ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 8)
            <propertyType><![CDATA[ Oficina ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 9)
            <propertyType><![CDATA[ Departamento ]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 10)
            <propertyType><![CDATA[ Local Comercial ]]></propertyType>
            @endif
            <coordinates>
                <latitude><![CDATA[{{ $propiedad->latitud }}]]></latitude>
                <longitude><![CDATA[{{ $propiedad->longitud }}]]></longitude>
            </coordinates>
            <bedrooms><![CDATA[{{ $propiedad->habitacion }}]]></bedrooms>
            <bathrooms><![CDATA[{{ $propiedad->bano }}]]></bathrooms>
            
            <floorArea unit="sqm">{{ $propiedad->mConstruido }}</floorArea>
            <plotArea unit="sqm">{{ $propiedad->mTotal }}</plotArea>
            <pictures>
                <picture>
                    <url><![CDATA[https://propitech.cl/img/propiedad/{{ $propiedad->fotoPrincipal }}
                    ]]></url>
                </picture>
                @foreach($propiedad->fotos as $foto)
                <picture>
                    <url><![CDATA[https://propitech.cl/img/propiedad/{{ $foto->nombreArchivo }}
                    ]]></url>
                </picture>
                @endforeach
            </pictures>
            <virtualTour>
                <![CDATA[ ]]>
            </virtualTour>
            @if($propiedad->usoGoceEstacionamiento == 1)
            <parkingLots>
                <![CDATA[ 1 ]]>
            </parkingLots>
            @else
            <parkingLots>
                <![CDATA[ 0 ]]>
            </parkingLots>
            @endif
            <furnished>
                <![CDATA[ true ]]>
            </furnished>
    </listing>
    @endforeach
</listings>


