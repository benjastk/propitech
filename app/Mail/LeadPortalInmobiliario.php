<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadPortalInmobiliario extends Mailable
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
                ->subject('Nuevo contacto - Portal Inmobiliario / Mercado Libre')
                ->view('emails.leadPortalInmobiliario');
    }
}
