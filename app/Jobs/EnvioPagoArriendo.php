<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprobantePagoArriendo;
use App\EstadoPago;
class EnvioPagoArriendo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $idPago;
    protected $cargos;
    protected $descuentos;
    protected $totalDescuento;
    protected $totalCargo;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $idPago, $cargos, $descuentos, $totalDescuento, $totalCargo)
    {
        $this->idPago = $idPago; 
        $this->cargos = $cargos; 
        $this->descuentos = $descuentos; 
        $this->totalDescuento = $totalDescuento; 
        $this->totalCargo = $totalCargo; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $estadosDePago = EstadoPago::select('estados_pagos.*', 'estados.nombreEstado', 'propiedades.nombrePropiedad', 
            'contratos_arriendos.nombreContrato', 'users.rut', 'contratos_arriendos.nombreArrendatario', 'users.email',
            'contratos_arriendos.apellidoArrendatario', 'contratos_arriendos.direccionArrendatario', 'contratos_arriendos.nombreComunaArrendatario', 
            'contratos_arriendos.nombreRegionArrendatario', 'contratos_arriendos.correoArrendatario', 'contratos_arriendos.numeroTelefonoArrendatario',
             'contratos_arriendos.direccionPropiedad', 'contratos_arriendos.nombreComunaPropiedad', 'contratos_arriendos.nombreRegionPropiedad', 
             'metodos_pagos.nombreMetodoPago', 'propiedades.direccion', 'propiedades.numero', 'tipos_monedas.nombreMoneda', 
             'contratos_arriendos.idTiempoPagoGarantia', 'pagos.montoPago', 'pagos.idPago', 'pagos.created_at as fechaPagado', 
             'users.numero as numeroTelefonoUsuario', 'paises.codigoPais', 'pagos.tokenPago', 'pagos.idMetodoPago', 'users.name', 'users.apellido',
             'comuna.nombre as nombreComuna', 'region.nombre as nombreRegion', 'users.email', 'contratos_arriendos.idContratoArriendo', 'propiedades.block', 
             'pagos.numeroTransaccion', 'contratos_arriendos.arriendoMensual as valorArriendoContrato')
            ->join('estados', 'estados_pagos.idEstado', '=', 'estados.idEstado')
            ->join('contratos_arriendos', 'estados_pagos.idContrato', '=', 'contratos_arriendos.idContratoArriendo')
            ->join('propiedades', 'contratos_arriendos.idPropiedad', '=', 'propiedades.id')
            ->join('users', 'contratos_arriendos.idUsuarioArrendatario', '=', 'users.id')
            ->join('paises', 'paises.idPais', '=', 'users.idPais')
            ->join('tipos_monedas', 'contratos_arriendos.idMoneda', '=', 'tipos_monedas.idMoneda')
            ->join('pagos', 'pagos.tokenEstadoPago', '=', 'estados_pagos.token')
            ->join('comuna', 'comuna.id', '=', 'propiedades.idComuna')
            ->join('region', 'region.id', '=', 'propiedades.idRegion')
            ->leftjoin('metodos_pagos', 'metodos_pagos.idMetodosPagos', '=', 'pagos.idMetodoPago')
            ->where('pagos.idPago', '=', $this->idPago)->first();
            //return dd($this->estadosDePago);
            $pdf = \PDF::loadView('emails.adjuntoPagoArrendatario', [ 'estadosDePago' => $estadosDePago, 'cargos' => $this->cargos, 
            'descuentos' => $this->descuentos, 'totalDescuento' => $this->totalDescuento, 'totalCargo' => $this->totalCargo]);

            $descuentos = $this->totalDescuento;
            $cargos = $this->totalCargo;
            Mail::to($estadosDePago->email)
            //Mail::to(['beenjaahp@hotmail.com', 'beenjaahp@gmail.com'])
            ->cc(['admipropitech@gmail.com'])
            ->bcc(['admin@benjaminperez.cl'])
            ->send(new ComprobantePagoArriendo($estadosDePago, $descuentos, $cargos, $pdf));
        }
        catch(\Exception $e)
        {
            Log::info($e->getMessage());
        }
    }
}
