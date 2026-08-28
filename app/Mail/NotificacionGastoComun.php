<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionGastoComun extends Mailable
{
    use Queueable, SerializesModels;

    public $contrato;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrato)
    {
        $this->contrato = $contrato;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $informacion = $this->contrato;
        return $this->from(['contacto@propitech.cl', 'Propitech'])
                    ->subject('Aviso de Gastos Comunes Pendientes - Propitech')
                    ->view('emails.notificacionGastoComun', compact('informacion'));
    }
}
