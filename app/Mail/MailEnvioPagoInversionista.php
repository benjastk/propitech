<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailEnvioPagoInversionista extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $pdf)
    {
        $this->id = $id;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $informacion = $this->id;
        return $this->from(['contacto@propitech.cl', 'Propitech'])
                    ->subject('Comprobante de Pago a Propietario de Propitech.cl')
                    ->view('emails.envioDeComprobanteDePagoInversionista', compact('informacion'))
                    ->attachData($this->pdf->output(), 'document.pdf');
    }
}
