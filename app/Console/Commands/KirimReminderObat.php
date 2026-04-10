<?php

namespace App\Console\Commands;

use App\Mail\ReminderMinumObat;
use App\Models\JadwalObatWaktu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class KirimReminderObat extends Command
{
    protected $signature   = 'obat:kirim-reminder';
    protected $description = 'Kirim email reminder minum obat sesuai waktu yang dijadwalkan';

    public function handle(): int
    {
        $now = Carbon::now();
        $start = $now->copy()->startOfMinute();
        $end = $now->copy()->endOfMinute();
        $today = $now->toDateString();

        $waktuList = JadwalObatWaktu::with(['jadwal.user', 'jadwal.dokter'])
            ->whereBetween('waktu', [
                $start->format('H:i:s'),
                $end->format('H:i:s'),
            ])
            ->whereHas('jadwal', function ($q) use ($today) {
                $q->where('tanggal_mulai', '<=', $today)
                    ->where('tanggal_selesai', '>=', $today)
                    ->where('status', 'aktif');
            })
            ->get();

        $queuedCount = 0;
        $skippedCount = 0;

        foreach ($waktuList as $waktu) {
            $email = $waktu->jadwal->user->email ?? null;

            if (! $email) {
                $skippedCount++;
                continue;
            }

            Mail::to($email)->queue(
                (new ReminderMinumObat($waktu))->onQueue('mail')
            );

            $queuedCount++;
            $this->info("Reminder diantrekan ke {$email}");
        }

        Log::info('Reminder obat diproses.', [
            'queued' => $queuedCount,
            'skipped' => $skippedCount,
            'checked_at' => $now->toDateTimeString(),
        ]);

        $this->info("Total reminder diantrekan: {$queuedCount}");
        $this->info("Total reminder dilewati: {$skippedCount}");

        return self::SUCCESS;
    }
}
