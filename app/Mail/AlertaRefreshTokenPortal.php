<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertaRefreshTokenPortal extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->from('contacto@propitech.cl')
                ->subject('Alerta: fallo al refrescar token de Portal Inmobiliario')
                ->view('emails.alertaRefreshTokenPortal');
    }
}
