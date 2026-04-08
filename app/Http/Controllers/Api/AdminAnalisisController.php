<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\User;

class AdminAnalisisController extends Controller
{
    public function index()
    {
        $summary = [
            'total_dokter' => Dokter::count(),
            'total_user' => User::where('role', 'user')->count(),
            'total_staff' => User::where('role', 'staff')->count(),
            'total_obat' => Obat::count(),
            'stok_obat' => Obat::sum('stok'),
            'obat_menipis' => Obat::stokMenupis()->count(),
        ];

        $cards = [
            [
                'key' => 'total_dokter',
                'title' => 'Total Dokter',
                'value' => $summary['total_dokter'],
                'icon' => 'medical_services',
                'color' => '#3B82F6',
                'route' => '/admin/dokter',
            ],
            [
                'key' => 'total_user',
                'title' => 'Total User',
                'value' => $summary['total_user'],
                'icon' => 'groups',
                'color' => '#10B981',
                'route' => '/admin/users',
            ],
            [
                'key' => 'total_staff',
                'title' => 'Total Staff',
                'value' => $summary['total_staff'],
                'icon' => 'badge',
                'color' => '#06B6D4',
                'route' => '/admin/staff',
            ],
            [
                'key' => 'total_obat',
                'title' => 'Total Obat',
                'value' => $summary['total_obat'],
                'icon' => 'medication',
                'color' => '#F59E0B',
                'route' => '/admin/obat',
            ],
            [
                'key' => 'stok_obat',
                'title' => 'Stok Obat',
                'value' => $summary['stok_obat'],
                'icon' => 'inventory_2',
                'color' => '#6366F1',
                'route' => '/admin/obat',
            ],
            [
                'key' => 'obat_menipis',
                'title' => 'Obat Menipis',
                'value' => $summary['obat_menipis'],
                'icon' => 'warning_amber',
                'color' => '#EF4444',
                'route' => '/admin/obat',
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Data analisis admin berhasil diambil',
            'data' => [
                'summary' => $summary,
                'cards' => $cards,
            ],
        ]);
    }
}
