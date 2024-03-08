<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $correo;

    /**
     * Create a new message instance.
     */
    public function __construct($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Reserva realizada correctamente');
    }
}
