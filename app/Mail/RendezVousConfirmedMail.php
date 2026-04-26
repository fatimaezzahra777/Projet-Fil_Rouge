<?php

namespace App\Mail;

use App\Models\RendezVous;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RendezVousConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly RendezVous $rendezVous,
        public readonly string $lieu
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre rendez-vous',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rendezvous-confirmed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
