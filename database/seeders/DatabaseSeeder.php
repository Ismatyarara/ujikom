<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Spesialisasi;
use App\Models\Obat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Spesialisasi Dokter
        $spesialisasi = [
            'Dokter Umum',
            'Dokter Anak',
            'Dokter Gigi',
            'Dokter Kandungan',
            'Dokter Mata',
            'Dokter THT',
            'Dokter Kulit',
            'Dokter Jantung',
        ];

        foreach ($spesialisasi as $nama) {
            Spesialisasi::create(['name' => $nama]);
        }

        // Seed Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Seed Dokter
        User::create([
            'name' => 'DOKTER',
            'email' => 'dokter@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'DOKTER',
            'email' => 'dokter2@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        // Seed Staff
        User::create([
            'name' => 'Staff Member 1',
            'email' => 'staff@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff Member 2',
            'email' => 'staff2@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        // Seed Regular Users
        User::create([
            'name' => 'User Test',
            'email' => 'user@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'User Test 2',
            'email' => 'user2@healtack.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Seed Obat
        $obatList = [
           [
    'kode_obat'    => 'OBT-001',
    'nama_obat'    => 'Paracetamol 500mg',
    'deskripsi'    => 'Obat untuk meredakan demam dan nyeri ringan hingga sedang',
    'aturan_pakai' => 'Diminum 3 kali sehari setelah makan, 1 tablet sekali minum',
    'efek_samping' => 'Mual, muntah, sakit perut (jarang terjadi)',
    'stok'         => 100,
    'harga'        => 2000,
    'satuan'       => 'tablet',
    'status'       => 1,
]
           
        ];

        foreach ($obatList as $obat) {
            Obat::create($obat);
        }

        // Create additional random users
        // User::factory(10)->create();
    }
}