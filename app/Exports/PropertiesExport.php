<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Propiedad;

class PropertiesExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'NOMBRE PROPIEDAD',
            'TIPO PROPIEDAD',
            'PROYECTO ASIGNADO',
            'TIPO COMERCIAL',
            'DIRECCION',
            'NUMERO',
            'DEPARTAMENTO',
            'COMUNA',
            'REGION',
            'PROVINCIA',
            'VALOR ARRIENDO',
            'PRECIO',
            'ESTADO',
            'HABITACIONES',
            'BAÑOS',
            'ESTACIONAMIENTO',
            'BODEGA',
            'METROS TOTALES',
            'METROS CONSTRUIDOS',
            'METROS TERRAZA'
        ];
    }
    public function collection()
    {
        $propiedades = Propiedad::select('propiedades.nombrePropiedad', 'tipos_propiedades.nombreTipoPropiedad', 'propiedades.nombreEdificioComunidad', 
        'tipos_comerciales.nombreTipoComercial', 'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'comuna.nombre as nombreComuna',
        'region.nombre as nombreRegion', 'provincia.nombre as nombreProvincia', 'propiedades.valorArriendo', 'propiedades.precio',
        'estadoPropiedad.nombreEstado', 'propiedades.habitacion', 'propiedades.bano', 'propiedades.usoGoceEstacionamiento', 'propiedades.usoGoceBodega',
        'propiedades.mTotal', 'propiedades.mConstruido', 'propiedades.mTerraza')
       	->join('estados as estadoPropiedad', 'propiedades.idEstado', '=', 'estadoPropiedad.idEstado')
        ->join('tipos_comerciales', 'tipos_comerciales.idTipoComercial', '=', 'propiedades.idTipoComercial')
        ->join('tipos_propiedades', 'propiedades.idTipoPropiedad', '=', 'tipos_propiedades.idTipoPropiedad')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('provincia', 'provincia.id', '=', 'propiedades.idProvincia')
        ->leftjoin('mandatos_propiedad', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
        ->leftjoin('users', 'users.id', '=', 'mandatos_propiedad.idPropietario')
        ->orderBy('propiedades.nombrePropiedad', 'ASC')
        ->get();
        $listadoPropiedades = collect();
        foreach ($propiedades as $propiedad)
        {
                $listadoPropiedades->push($propiedad);
        }
        return $listadoPropiedades;
    }
}
