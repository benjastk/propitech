<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\UltimoDiaParaPagar as MailUltimoDiaParaPagar;
use App\EstadoPago;
use App\Cargo;
use App\Descuento;
class UltimoDiaParaPagar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $estadoPago;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($estadoPago)
    {
        $this->estadoPago = $estadoPago;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $estadoAPagar = EstadoPago::select('estados_pagos.*', 'users.email', 'users.id as idUsuario', 'users.name', 'users.apellido')
        ->join('contratos_arriendos', 'contratos_arriendos.idContratoArriendo', '=', 'estados_pagos.idContrato')
        ->join('users', 'users.id', '=', 'contratos_arriendos.idUsuarioArrendatario')
        ->where('estados_pagos.idEstadoPago', $this->estadoPago->idEstadoPago)
        ->first();
        $descuentos = Descuento::where('idEstadoPago', '=', $this->estadoPago->idEstadoPago)->get();
        $cargos = Cargo::where('idEstadoPago', '=', $this->estadoPago->idEstadoPago)->get();
        $totalDescuento = 0;
        $totalCargo = 0;
        if(isset($descuentos))
        {
            foreach($descuentos as $descuento)
            {
                $totalDescuento = $totalDescuento + $descuento->montoDescuento;
            }
        }
        if(isset($cargos))
        {
            foreach($cargos as $cargo)
            {
                $totalCargo = $totalCargo + $cargo->montoCargo;
            }
        }
        //Mail::to($estadoPago->email)
        Mail::to($estadoAPagar->email)
            ->cc(['administracion@propitech.cl'])
            ->send(new MailUltimoDiaParaPagar($estadoAPagar, $totalCargo, $totalDescuento));
    }
}
