<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CitaReservadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cita;

    public function __construct($cita)
    {
        $this->cita = $cita;
    }

    public function build()
    {
        return $this->subject('Confirmación de Cita')
                    ->view('emails.cita-reservada')
                    ->with(['cita' => $this->cita]);
    }
}
