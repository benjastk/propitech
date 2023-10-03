<?xml version="1.0" encoding="UTF-8"?>
<listings>
    @foreach($propiedades as $propiedad)
    <listing>
        <reference_id><![CDATA[{{ $propiedad->id }}]]></reference_id>
            <contact>
                <phone><![CDATA[956790356]]></phone>
                <whatsapp><![CDATA[+56927429764]]></whatsapp>
                <email><![CDATA[contacto@propitech.cl]]></email>
                <email><![CDATA[gcisternas@propitech.cl]]></email>
                <email><![CDATA[isainz@propitech.cl]]></email>
                @if($propiedad->idTipoComercial == 1)
                <name><![CDATA[Gustavo Cisternas]]></name>
                @else
                <name><![CDATA[Isabel Sainz]]></name>
                @endif
            </contact>
            <title><![CDATA[{{ $propiedad->nombrePropiedad }}]]></title>
            <description><![CDATA[{!! $propiedad->descripcion2 !!}]]></description>
            <prices>
                @if($propiedad->idTipoComercial == 1)
                <price currency="CLF" operation="sale">{{ $propiedad->precio }}</price>
                @else
                <price currency="CLP" operation="rent">{{ $propiedad->valorArriendo }}</price>
                @endif
            </prices>
            @if($propiedad->idTipoPropiedad == 1)
            <propertyType><![CDATA[house]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 2)
            <propertyType><![CDATA[apartment]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 3)
            <propertyType><![CDATA[land]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 4)
            <propertyType><![CDATA[apartment]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 5)
            <propertyType><![CDATA[land]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 6)
            <propertyType><![CDATA[land]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 7)
            <propertyType><![CDATA[house]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 8)
            <propertyType><![CDATA[office]]></propertyType>
            @elseif($propiedad->idTipoPropiedad == 9)
            <propertyType><![CDATA[apartment]]></propertyType>
            @endif
            <coordinates>
                <latitude><![CDATA[{{ $propiedad->latitud }}]]></latitude>
                <longitude><![CDATA[{{ $propiedad->longitud }}]]></longitude>
            </coordinates>
            <bedrooms><![CDATA[{{ $propiedad->habitacion }}]]></bedrooms>
            <bathrooms><![CDATA[{{ $propiedad->bano }}]]></bathrooms>
            <furnished><![CDATA[UNFURNISHED]]></furnished>
            <floorArea unit="sqm">{{ $propiedad->mContruido }}</floorArea>
            <plotArea unit="sqm">{{ $propiedad->mTotal }}</plotArea>
            <pictures>
                <url><![CDATA[https://propitech.cl/img/propiedad/{{ $propiedad->fotoPrincipal }}
                ]]></url>
                @foreach($propiedad->fotos as $foto)
                <url><![CDATA[https://propitech.cl/img/propiedad/{{ $foto->nombreArchivo }}
                ]]></url>
                @endforeach
            </pictures>
            <amenities>
                @if($propiedad->amenidades)
                    @foreach($propiedad->amenidades as $amenidad)
                        @if($amenidad->idCaracteristicaPropiedad == 1)
                        <amenity><![CDATA[air conditioning]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 4)
                        <amenity><![CDATA[built-in wardrobe]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 5)
                        <amenity><![CDATA[alarm]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 7)
                        <amenity><![CDATA[garden]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 8)
                        <amenity><![CDATA[lift]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 9)
                        <amenity><![CDATA[swimming pool]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 12)
                        <amenity><![CDATA[gym]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 15)
                        <amenity><![CDATA[terrace]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 16)
                        <amenity><![CDATA[heating]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 20)
                        <amenity><![CDATA[tennis court]]></amenity>
                        @elseif($amenidad->idCaracteristicaPropiedad == 24)
                        <amenity><![CDATA[children's area]]></amenity>
                        @endif
                    @endforeach
                    @if($propiedad->usoGoceEstacionamiento == 1)
                    <amenity><![CDATA[car park]]></amenity>
                    @endif
                @endif
            </amenities>
            <nearbys>
            </nearbys>
            <is_boosted>FALSE</is_boosted>
    </listing>
    @endforeach
</listings>


