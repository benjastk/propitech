<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UltimoDiaParaPagar extends Mailable
{
    use Queueable, SerializesModels;
    public $estadoPago;
    public $totalCargo;
    public $totalDescuento;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($estadoPago, $totalCargo, $totalDescuento)
    {
        $this->estadoPago = $estadoPago;
        $this->totalCargo = $totalCargo;
        $this->totalDescuento = $totalDescuento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contacto@propitech.cl')
                ->subject('Ultimo dia para pagar tu arriendo en Propitech 🤝')
                ->view('emails.ultimoDia');
    }
}
