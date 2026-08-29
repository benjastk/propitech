<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table = 'propiedades';
    protected $fillable = [
        'id',
        'idNivelUsoPropiedad',
        'idTipoComercial',
        'mostrarTituloAutomatico',
        'nombrePropiedad',
        'tituloExtendido',
        'rut',
        'numeroClienteAgua',
        'numeroClienteLuz',
        'numeroClienteGas',
        'idTipoPropiedad',
        'rolPropiedad',
        'precio',
        'valorArriendo',
        'tasacion',
        'tasacionFinal',
        'gastosComunes',
        'contribucion',
        'tieneDeuda',
        'mDeuda',
        'valorHipoteca',
        'idBanco',
        'banco',
        'idPais',
        'idRegion',
        'idProvincia',
        'idComuna',
        'direccion',
        'numero',
        'block',
        'mostrarDireccionExacta',
        'mTotal',
        'mConstruido',
        'mTerraza',
        'bano',
        'habitacion',
        'numeroPisos',
        'latitud',
        'longitud',
        'POI',
        'descripcion',
        'descripcion2',
        'notaInterna',
        'idEstado',
        'creador',
        'fecha',
        'fotoPrincipal',
        'fotoPrincipalDetalle',
        'estacionamiento',
        'usoGoceEstacionamiento',
        'codigoEstacionamiento',
        'tandem',
        'usoGoceTandem',
        'bodega',
        'usoGoceBodega',
        'codigoBodega',
        'score',
        'urlMatterport',
        'urlVideo',
        'idDestacado',
        'publicarEnTiendaEvento',
        'idCorredor',
        'idUsuarioExpertoVendedor',
        'idProyecto',
        'idConDescuento',
        'cantidadDescuento',
        'idConDescuento2',
        'cantidadDescuento2',
        'codigoEmpresa',
        'notaEnTienda',
        'contratoConExclusividad',
        'idTipoCustodia',
        'nombreNotariaCustodia',
        'fechaRecepcionPropiedad',
        'idMoneda',
        'antiguedad',
        'idTipoOrientacion',
        'mascotas',
        'nombreEdificioComunidad',
        'numeroCandado',
        'claveCandado',
        'orientacion',
        'urlPortalInmobiliario',
        'urlYapo',
        'idExterno',
        'captador',
        'comisionPropiedad',
        'valorCyber',
        'esBuyDepa',
        'idBuyDepa',
        'skuBuyDepa',
        'marcaDeAgua',
        'correoPropiedad',
        'created_at',
        'updated_at'
    ];

    public function getDescripcionLimpiaAttribute()
    {
        $text = str_replace(['<br>', '<br/>', '<br />', '</p>', '</h1>', '</li>', '</div>'], "\n", $this->descripcion);
        $text = str_replace(['<li>', '<ul>', '<ol>'], "\n- ", $text);
        $text = preg_replace('/-(?:\s|&nbsp;){2,}/', "\n- ", $text);
        $text = str_replace(['–', '—'], "\n- ", $text);
        $textoPlano = strip_tags($text);
        $textoPlano = html_entity_decode($textoPlano);
        $textoPlano = str_replace(["\xC2\xA0", "\u{00A0}"], ' ', $textoPlano);
        $textoPlano = str_replace(['“', '”', '„'], '"', $textoPlano);
        $textoPlano = str_replace(['‘', '’'], "'", $textoPlano);
        $textoPlano = str_replace('…', '...', $textoPlano);
        $textoPlano = preg_replace('/\n{2,}/', "\n", $textoPlano);
        return trim($textoPlano);
    }
}
