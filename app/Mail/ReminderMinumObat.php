<?php

namespace App\Mail;

use App\Models\JadwalObatWaktu;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderMinumObat extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JadwalObatWaktu $waktuObat) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '⏰ Pengingat Minum Obat');
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reminder-minum-obat',
            with: [
                'jadwal'    => $this->waktuObat->jadwal,
                'waktu'     => $this->waktuObat->waktu,
                'namaObat'  => $this->waktuObat->jadwal->nama_obat,
                'pasien'    => $this->waktuObat->jadwal->user,
            ]
        );
    }
}