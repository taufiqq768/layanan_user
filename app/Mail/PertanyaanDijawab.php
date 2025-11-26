<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pertanyaan;

class PertanyaanDijawab extends Mailable
{
    use Queueable, SerializesModels;

    public $pertanyaan;

    /**
     * Create a new message instance.
     */
    public function __construct(Pertanyaan $pertanyaan)
    {
        $this->pertanyaan = $pertanyaan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Jawaban untuk Pertanyaan Anda - ' . $this->pertanyaan->aplikasi;

        if ($this->pertanyaan->nomor_tiket) {
            $subject .= ' [' . $this->pertanyaan->nomor_tiket . ']';
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pertanyaan-dijawab',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
