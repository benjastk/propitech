<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\ContratoArriendo;
use DB;
class ContratosExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'NOMBRE CONTRATO',
            'TIPO CONTRATO',
            'DESDE',
            'HASTA',
            'TIEMPO CONTRATO(MESES)',
            'ESTADO',
            'ARRIENDO MENSUAL',
            'GARANTIA',
            'REGION',
            'COMUNA',
            'DIRECCION',
            'NUMERO',
            'DEPARTAMENTO',
            'NOMBRE ARRENDATARIO',
            'RUT ARRENDATARIO',
            'TELEFONO ARRENDATARIO',
            'CORREO ARRENDATARIO',
            'NOMBRE PROPIETARIO',
            'RUT PROPIETARIO',
            'TELEFONO PROPIETARIO',
            'CORREO PROPIETARIO',
            'NOMBRE CODEUDOR',
            'RUT CODEUDOR',
            'TELEFONO CODEUDOR',
            'CORREO CODEUDOR',
        ];
    }
    public function collection()
    {
        $contratos = ContratoArriendo::select('contratos_arriendos.nombreContrato', 'tipo_contrato.descripcion as nombreTipoContrato', 'contratos_arriendos.desde',
        'contratos_arriendos.hasta', 'contratos_arriendos.tiempoContrato', 'estadoContrato.nombreEstado', 'contratos_arriendos.arriendoMensual',
        'contratos_arriendos.garantia', 'comuna.nombre as nombreComuna', 'region.nombre as nombreRegion','propiedades.direccion as direccionPropiedad', 
        'propiedades.numero as numeroPropiedad', 'propiedades.block as dpto', DB::raw('CONCAT(user1.name, user1.apellido) AS nombreArrendatario'), 'user1.rut as rutArrendatario', 
        'user1.email as correoArrendatario', 'user1.telefono as telefonoArrendatario', DB::raw('CONCAT(user2.name, user2.apellido) AS nombrePropietario'), 
        'user2.rut as rutPropietario', 'user2.email as correoPropietario', 'user2.telefono as telefonoPropietario', DB::raw('CONCAT(user3.name, user3.apellido) AS 
        nombreCodeudor'), 'user3.rut as rutCodeudor', 'user3.email as correoCodeudor', 'user3.telefono as telefonoCodeudor')
       	->join('estados as estadoContrato', 'contratos_arriendos.idEstado', '=', 'estadoContrato.idEstado')
        ->join('tipo_contrato', 'contratos_arriendos.idTipoContrato', '=', 'tipo_contrato.idTipoContrato')
        ->join('propiedades', 'propiedades.id', '=', 'contratos_arriendos.idPropiedad')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('users as user1', 'contratos_arriendos.idUsuarioArrendatario', '=', 'user1.id')
        ->join('users as user2', 'contratos_arriendos.idUsuarioPropietario', '=', 'user2.id')
        ->leftjoin('users as user3', 'contratos_arriendos.idUsuarioCodeudor', '=', 'user3.id')
        ->orderBy('propiedades.nombrePropiedad', 'ASC')
        ->get();
        $listadoContratos = collect();
        foreach ($contratos as $contrato)
        {
                $listadoContratos->push($contrato);
        }
        return $listadoContratos;
    }
}
