<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprobantePagoReserva;
use App\ReservaPropiedad;
class EnviarPagoReserva implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $idPago;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idPago)
    {
        $this->idPago = $idPago;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $estadosDePago = ReservaPropiedad::select('reservas_propiedades.*', 'pagos.montoPago', 'pagos.numeroTransaccion', 'pagos.secuenciaTransaccion',
            'pagos.idMetodoPago', 'pagos.tokenPago', 'pagos.metodoPagoOtrosPagos', 'pagos.tipoPago', 'pagos.idPago', 'paises.nombrePais', 'comuna.nombre as nombreComuna',
            'region.nombre as nombreRegion')
            ->join('pagos', 'pagos.tokenReserva', '=', 'reservas_propiedades.token')
            ->join('paises', 'paises.idPais', '=', 'reservas_propiedades.idPais')
            ->join('comuna', 'comuna.id', '=', 'reservas_propiedades.idComuna')
            ->join('region', 'region.id', '=', 'reservas_propiedades.idRegion')
            ->leftjoin('metodos_pagos', 'metodos_pagos.idMetodosPagos', '=', 'pagos.idMetodoPago')
            ->where('pagos.idPago', '=', $this->idPago)
            ->first();
            //return dd($this->estadosDePago);
            $pdf = \PDF::loadView('emails.adjuntoPagoReservaArrendatario', [ 'estadosDePago' => $estadosDePago]);

            //Mail::to($estadosDePago->email)
            Mail::to(['beenjaahp@hotmail.com', 'beenjaahp@gmail.com'])
            ->send(new ComprobantePagoReserva($estadosDePago, $pdf));
        }
        catch(\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }
}
