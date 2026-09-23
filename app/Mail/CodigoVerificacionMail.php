<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoVerificacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $codigo)
    {
    }

    public function build()
    {
        return $this->subject('Tu código de verificación')
                    ->view('emails.codigo-verificacion');
    }
}