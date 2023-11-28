<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComprobantePagoReserva extends Mailable
{
    use Queueable, SerializesModels;
    
    public $idPago;
    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idPago, $pdf)
    {
        $this->idPago = $idPago;
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
        return $this->from(['contacto@propitech.cl', 'Propitech'])
                    ->subject('Comprobante de Reserva de Propitech.cl')
                    ->view('emails.envioDeComprobanteDeReserva', compact('informacion'))
                    ->attachData($this->pdf->output(), 'document.pdf');
    }
}
