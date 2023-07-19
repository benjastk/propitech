<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MandatoAdministracion extends Model
{
    protected $table = 'mandatos_propiedad';
    protected $primaryKey = 'idMandatoPropiedad';
    protected $fillable = [
        'idPropietario',
        'diaPago',
        'porcentajeComision',
        'garantiaPesos',
        'seguroDeArriendo',
        'nombrePropietario',
        'apellidoPropietario',
        'rutPropietario',
        'nacionalidadPropietario',
        'estadoCivilPropietario',
        'profesionPropietario',
        'correoPropietario',
        'direccionPropietario',
        'comunaPropietario',
        'regionPropietario',
        'idArrendatario',
        'rutArrendatario',
        'nombreArrendatario',
        'apellidoArrendatario',
        'correoArrendatario',
        'telefonoArrendatario',
        'idContrato',
        'idPropiedad',
        'direccionPropiedad',
        'departamentoPropiedad',
        'comunaPropiedad',
        'regionPropiedad',
        'desde',
        'hasta',
        'cuentaPropietario',
        'bancoPropietario',
        'tokenMandato',
        'fechaCompromisoMandato',
        'idEstadoMandato',
        'duracion',
        'idCorredor',
        'arriendoGarantizado',
        'idUsuarioCuentaBancaria',
        'imagenFirmaEmpresa',
        'fechaFirmaEmpresa',
        'imagenFirmaInversionista',
        'fechaFirmaInversionista',
        'idNotaria',
        'creadoPor',
        'numeroDeCertificado',
        'notarizado',
        'conTraspaso',
        'mandatoMesVencido',
        'idPlan',
        'created_at',
        'updated_at'
    ];
}
