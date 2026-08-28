<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionGastoComun;
use App\ContratoArriendo;

class NotificarGastoComunJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $idContratoArriendo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idContratoArriendo)
    {
        $this->idContratoArriendo = $idContratoArriendo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $contrato = ContratoArriendo::select('contratos_arriendos.*', 'propiedades.direccion', 'propiedades.numero',
                'propiedades.block', 'region.nombre as nombreRegionPropiedad', 'comuna.nombre as nombreComunaPropiedad',
                'user1.name as nombreArrendatario', 'user1.apellido as apellidoArrendatario', 'user1.email as correoArrendatario')
                ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
                ->join('region', 'region.id', '=', 'propiedades.idRegion')
                ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
                ->join('users as user1', 'user1.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
                ->where('contratos_arriendos.idContratoArriendo', '=', $this->idContratoArriendo)
                ->first();

            $contrato->direccionPropiedad = trim($contrato->direccion . ' ' . $contrato->numero);

            Mail::to($contrato->correoArrendatario)
                ->cc(['administracion@propitech.cl'])
                ->send(new NotificacionGastoComun($contrato));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
