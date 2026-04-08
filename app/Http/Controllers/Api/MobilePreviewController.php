<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\Jadwal;

class MobilePreviewController extends Controller
{
    public function home()
    {
        $jadwal = Jadwal::with(['dokter.spesialisasi', 'waktuObat'])
            ->latest()
            ->limit(6)
            ->get()
            ->map(function (Jadwal $item) {
                return [
                    'id' => $item->id,
                    'nama_obat' => $item->nama_obat,
                    'deskripsi' => $item->deskripsi,
                    'tanggal_mulai' => optional($item->tanggal_mulai)->format('Y-m-d') ?? (string) $item->tanggal_mulai,
                    'tanggal_selesai' => optional($item->tanggal_selesai)->format('Y-m-d') ?? (string) $item->tanggal_selesai,
                    'status' => $item->status,
                    'status_pengingat' => (bool) $item->status_pengingat,
                    'dokter' => [
                        'id' => $item->dokter?->id,
                        'nama' => $item->dokter?->nama ?? 'Dokter belum tersedia',
                        'spesialisasi' => [
                            'nama_spesialisasi' => $item->dokter?->spesialisasi?->nama_spesialisasi ?? 'Spesialisasi belum tersedia',
                        ],
                    ],
                    'waktu_obat' => $item->waktuObat->map(function ($waktu) {
                        return [
                            'waktu' => $waktu->waktu ?? $waktu->jam ?? $waktu->nama_waktu ?? '-',
                        ];
                    })->values(),
                ];
            })
            ->values();

        $catatan = CatatanMedis::with(['user', 'dokter'])
            ->latest('tanggal_catatan')
            ->limit(6)
            ->get()
            ->map(function (CatatanMedis $item) {
                return [
                    'id' => $item->id,
                    'diagnosa' => $item->diagnosa,
                    'keluhan' => $item->keluhan,
                    'deskripsi' => $item->deskripsi,
                    'tanggal_catatan' => optional($item->tanggal_catatan)->format('Y-m-d') ?? (string) $item->tanggal_catatan,
                    'pasien' => [
                        'id' => $item->user?->id,
                        'name' => $item->user?->name ?? 'Pasien',
                        'kode_pasien' => $item->user?->kode_pasien ?? '-',
                    ],
                    'dokter' => [
                        'id' => $item->dokter?->id,
                        'nama' => $item->dokter?->nama ?? 'Dokter belum tersedia',
                    ],
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Data preview mobile berhasil diambil.',
            'data' => [
                'summary' => [
                    'total_jadwal_preview' => $jadwal->count(),
                    'total_catatan_preview' => $catatan->count(),
                ],
                'jadwal' => $jadwal,
                'catatan' => $catatan,
            ],
        ]);
    }
}
