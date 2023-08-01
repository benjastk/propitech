<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\MandatoAdministracion;
use DB;

class MandatosExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'REGION',
            'COMUNA',
            'DIRECCION',
            'NUMERO',
            'DEPARTAMENTO',
            'NOMBRE PROPIETARIO',
            'RUT PROPIETARIO',
            'TELEFONO PROPIETARIO',
            'CORREO PROPIETARIO',
            'ESTADO CIVIL PROPITERARIO',
            'PROFESION PROPIETARIO',
            'DESDE',
            'HASTA',
            'ESTADO',
            'DIA DE PAGO',
            'PORCENTAJE DE COMISION',
            'BANCO',
            'TIPO DE CUENTA',
            'NUMERO DE CUENTA',
            'SEGURO',
            'PLAN'
        ];
    }
    public function collection()
    {
        $mandatos = MandatoAdministracion::select('region.nombre as nombreRegion', 'comuna.nombre as nombreComuna', 'propiedades.direccion', 'propiedades.numero',
        'propiedades.block', DB::raw('CONCAT(user1.name, user1.apellido) AS nombrePropietario'), 'user1.rut as rutPropietario', 'user1.telefono as 
        telefonoPropietario', 'user1.email as correoPropietario', 'user1.estadoCivil', 'user1.profesion', 'mandatos_propiedad.desde', 'mandatos_propiedad.hasta',
        'estadoContrato.nombreEstado', 'mandatos_propiedad.diaPago', 'mandatos_propiedad.porcentajeComision', 'bancos.nombreBanco', 'tipos_cuentas_bancos.nombreTipoCuenta', 
        'ucb.numeroCuenta', 'mandatos_propiedad.seguroDeArriendo', 'planes.nombre as nombrePlan')
       	->join('estados as estadoContrato', 'mandatos_propiedad.idEstadoMandato', '=', 'estadoContrato.idEstado')
        ->join('propiedades', 'propiedades.id', '=', 'mandatos_propiedad.idPropiedad')
        ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
        ->join('region', 'region.id', '=', 'propiedades.idRegion')
        ->join('users as user1', 'mandatos_propiedad.idPropietario', '=', 'user1.id')
        //->join('users as user2', 'contratos_arriendos.idUsuarioPropietario', '=', 'user2.id')
        ->join('usuarios_cuentas_bancarias as ucb', 'ucb.idUsuarioCuentaBancaria', '=', 'mandatos_propiedad.idUsuarioCuentaBancaria')
        ->join('bancos', 'ucb.idBanco', '=', 'bancos.idbanco')
        ->join('tipos_cuentas_bancos', 'ucb.idTipoCuenta', '=', 'tipos_cuentas_bancos.idTipoCuenta')
        ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
        ->orderBy('propiedades.nombrePropiedad', 'ASC')
        ->get();
        $listadoMandatos = collect();
        foreach ($mandatos as $mandato)
        {
                $listadoMandatos->push($mandato);
        }
        return $listadoMandatos;
    }
}
