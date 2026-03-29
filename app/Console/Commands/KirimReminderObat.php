<?php

namespace App\Console\Commands;

use App\Mail\ReminderMinumObat;
use App\Models\JadwalObatWaktu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class KirimReminderObat extends Command
{
    protected $signature   = 'obat:kirim-reminder';
    protected $description = 'Kirim email reminder minum obat sesuai waktu yang dijadwalkan';

  public function handle(): void
{
    $now = Carbon::now();
    $start = $now->copy()->startOfMinute();
    $end   = $now->copy()->endOfMinute();

    $waktuList = JadwalObatWaktu::with(['jadwal.user', 'jadwal.dokter'])
        ->whereBetween('waktu', [
            $start->format('H:i:s'),
            $end->format('H:i:s')
        ])
        ->whereHas('jadwal', function ($q) {
            $today = now()->toDateString();
            $q->where('tanggal_mulai', '<=', $today)
              ->where('tanggal_selesai', '>=', $today);
        })
        ->get();

    foreach ($waktuList as $waktu) {
        $email = $waktu->jadwal->user->email ?? null;

        if (!$email) continue;

        Mail::to($email)->queue(new ReminderMinumObat($waktu));

        $this->info("Email dikirim ke {$email}");
    }

    $this->info("Total: {$waktuList->count()} reminder dikirim");
}
}