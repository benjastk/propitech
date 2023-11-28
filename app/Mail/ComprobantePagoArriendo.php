<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobantePagoArriendo extends Mailable
{
    use Queueable, SerializesModels;
    public $idPago;
    public $descuentos;
    public $cargos;
    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idPago, $descuentos, $cargos, $pdf)
    {
        $this->idPago = $idPago;
        $this->descuentos = $descuentos;
        $this->cargos = $cargos;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $informacion = $this->idPago;
        $descuentos = $this->descuentos;
        $cargos = $this->cargos;
        return $this->from(['contacto@propitech.cl', 'Propitech'])
                    ->subject('Comprobante de arriendo de Propitech.cl')
                    ->view('emails.envioDeComprobanteDePago', compact('informacion', 'descuentos', 'cargos'))
                    ->attachData($this->pdf->output(), 'document.pdf');
    }
}
