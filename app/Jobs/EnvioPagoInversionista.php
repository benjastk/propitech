<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailEnvioPagoInversionista;
use App\EstadosPagosMandatarios;
use App\Descuento;
use App\Cargo;
class EnvioPagoInversionista implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $estadoDePagoFinal = EstadosPagosMandatarios::select('estados_pagos_mandatarios.*', 'users.email as correo', 'users.name as nombre', 'users.apellido', 
            'propiedades.direccion', 'propiedades.numero', 'propiedades.block', 'users.numero as numeroPropietario', 'users.telefono',
            'users.rut as rutPropietario', 'comuna.nombre as nombreComuna', 'region.nombre as nombreRegion', 'planes.comisionAdministracion')
            ->join('estados', 'estados_pagos_mandatarios.idEstado', '=', 'estados.idEstado')
            ->join('mandatos_propiedad', 'estados_pagos_mandatarios.idMandatoPropiedad', '=', 'mandatos_propiedad.idMandatoPropiedad')
            ->join('propiedades', 'mandatos_propiedad.idPropiedad', '=', 'propiedades.id')
            ->join('users', 'mandatos_propiedad.idPropietario', '=', 'users.id')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->join('planes', 'planes.id', '=', 'mandatos_propiedad.idPlan')
            ->where('estados_pagos_mandatarios.idEstadoPagoMandato', '=', $this->id)
            ->first();
            $cargos = Cargo::where('idEstadoPago', $estadoDePagoFinal->idEstadoPago)
            ->where('correspondeA', 1)
            ->get();
            $descuentos = Descuento::where('idEstadoPago', $estadoDePagoFinal->idEstadoPago)->get();
            $deudas = [];
            $documentos = '';
            $estadoDePagoArrendatario = '';
            $diasNoArrendado = '';
            $mes = '';
            $comisionCorretaje = '';
            $pdf = \PDF::loadView('emails.adjuntoPagoInversionista', [ 'estadoPagoMandato' => $estadoDePagoFinal, 'cargos' => $cargos, 'descuentos' => $descuentos, 'deudas' => $deudas, 'documentos' => $documentos, 'estadoDePagoArrendatario' => $estadoDePagoArrendatario, 'diasNoArrendado' => $diasNoArrendado, 'mes' => $mes, 'comisionCorretaje' => $comisionCorretaje]);
            
            Mail::to($estadoDePagoFinal->correo)
            //Mail::to(['beenjaahp@hotmail.com', 'beenjaahp@gmail.com'])
            ->cc(['administracion@propitech.cl'])
            //->bcc(['admin@benjaminperez.cl'])
            ->send(new MailEnvioPagoInversionista($estadoDePagoFinal, $pdf));
        }
        catch(\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }
}
