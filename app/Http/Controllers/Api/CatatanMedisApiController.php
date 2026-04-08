<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatatanMedisApiController extends Controller
{
    // ================================================================
    // GET /api/catatan
    // Dokter  : semua catatan (bisa filter by kode_pasien)
    // User    : hanya catatan milik sendiri
    // ================================================================
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'dokter') {
            $catatan = $this->getCatatanUntukDokter($request);
        } else {
            $catatan = $this->getCatatanUntukUser($user);
        }

        return $this->successResponse('Data catatan medis berhasil diambil.', $catatan);
    }

    // ================================================================
    // POST /api/catatan
    // Hanya dokter yang bisa tambah catatan
    // ================================================================
    public function store(Request $request)
    {
        $user = $request->user(); // ← ganti ini

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }   
        if ($user->role != 'dokter') {
            return $this->forbiddenResponse('Hanya dokter yang dapat menambah catatan.');
        }

        $validator = $this->validateCatatan($request, withUserId: true);
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $dokterId = $user->role == 'dokter';
        if (!$dokterId) {
            return $this->errorResponse('Data dokter tidak ditemukan untuk akun ini.', 422);
        }

        $catatan = CatatanMedis::create([
            'user_id'         => $request->user_id,
            'dokter_id'       => $dokterId,
            'diagnosa'        => $request->diagnosa,
            'keluhan'         => $request->keluhan,
            'deskripsi'       => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        $catatan->load(['user', 'dokter']);

        return $this->successResponse('Catatan medis berhasil ditambahkan.', $this->formatCatatan($catatan), 201);
    }

    // ================================================================
    // GET /api/catatan/{id}
    // Dokter  : bisa lihat semua
    // User    : hanya milik sendiri
    // ================================================================
    public function show(Request $request, $id)
    {
        $user    = $request->user();
        $catatan = CatatanMedis::with(['user', 'dokter'])->find($id);

        if (!$catatan) {
            return $this->notFoundResponse('Catatan tidak ditemukan.');
        }

        if ($user->role === 'user' && $catatan->user_id !== $user->id) {
            return $this->forbiddenResponse('Akses ditolak.');
        }

        return $this->successResponse('Detail catatan medis.', $this->formatCatatan($catatan));
    }

    // ================================================================
    // PUT /api/catatan/{id}
    // Hanya dokter yang bisa edit catatan
    // ================================================================
    public function update(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'dokter') {
            return $this->forbiddenResponse('Hanya dokter yang dapat mengedit catatan.');
        }

        $catatan = CatatanMedis::find($id);
        if (!$catatan) {
            return $this->notFoundResponse('Catatan tidak ditemukan.');
        }

        $validator = $this->validateCatatan($request, withUserId: false);
        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $catatan->update([
            'diagnosa'        => $request->diagnosa,
            'keluhan'         => $request->keluhan,
            'deskripsi'       => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        $catatan->load(['user', 'dokter']);

        return $this->successResponse('Catatan medis berhasil diperbarui.', $this->formatCatatan($catatan));
    }

    // ================================================================
    // DELETE /api/catatan/{id}
    // Hanya dokter yang bisa hapus catatan
    // ================================================================
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if ($user->role !== 'dokter') {
            return $this->forbiddenResponse('Hanya dokter yang dapat menghapus catatan.');
        }

        $catatan = CatatanMedis::find($id);
        if (!$catatan) {
            return $this->notFoundResponse('Catatan tidak ditemukan.');
        }

        $catatan->delete();

        return $this->successResponse('Catatan medis berhasil dihapus.');
    }


    // ================================================================
    // PRIVATE HELPERS
    // ================================================================

    // Ambil semua catatan untuk dokter (bisa filter kode_pasien)
    private function getCatatanUntukDokter(Request $request)
    {
        $query = CatatanMedis::with(['user', 'dokter']);

        if ($request->filled('kode_pasien')) {
            $pasien = User::where('kode_pasien', $request->kode_pasien)->first();

            if (!$pasien) {
                return null; // ditangani di index()
            }

            $query->where('user_id', $pasien->id);
        }

        return $query->latest('tanggal_catatan')->get()
                     ->map(fn($c) => $this->formatCatatan($c));
    }

    // Ambil catatan milik user sendiri
    private function getCatatanUntukUser($user)
    {
        return CatatanMedis::with(['user', 'dokter'])
            ->where('user_id', $user->id)
            ->latest('tanggal_catatan')
            ->get()
            ->map(fn($c) => $this->formatCatatan($c));
    }

    // Validasi input catatan
    private function validateCatatan(Request $request, bool $withUserId)
    {
        $rules = [
            'diagnosa'        => 'required|in:Ringan,Sedang,Berat',
            'keluhan'         => 'required|string',
            'deskripsi'       => 'nullable|string',
            'tanggal_catatan' => 'required|date',
        ];

        $messages = [
            'diagnosa.required'        => 'Diagnosa wajib diisi.',
            'diagnosa.in'              => 'Diagnosa harus Ringan, Sedang, atau Berat.',
            'keluhan.required'         => 'Keluhan wajib diisi.',
            'tanggal_catatan.required' => 'Tanggal catatan wajib diisi.',
            'tanggal_catatan.date'     => 'Format tanggal tidak valid.',
        ];

        // Tambah validasi user_id kalau store (bukan update)
        if ($withUserId) {
            $rules['user_id']             = 'required|exists:users,id';
            $messages['user_id.required'] = 'Pasien wajib dipilih.';
            $messages['user_id.exists']   = 'Pasien tidak ditemukan.';
        }

        return Validator::make($request->all(), $rules, $messages);
    }

    // Format struktur data catatan untuk response
    private function formatCatatan(CatatanMedis $c): array
    {
        return [
            'id'              => $c->id,
            'diagnosa'        => $c->diagnosa,
            'keluhan'         => $c->keluhan,
            'deskripsi'       => $c->deskripsi,
            'tanggal_catatan' => $c->tanggal_catatan,
            'pasien' => [
                'id'          => $c->user->id,
                'name'        => $c->user->name,
                'kode_pasien' => $c->user->kode_pasien,
            ],
            'dokter' => $c->dokter ? [
                'id'   => $c->dokter->id,
                'nama' => $c->dokter->nama,
            ] : null,
            'created_at' => $c->created_at,
            'updated_at' => $c->updated_at,
        ];
    }


    // ================================================================
    // RESPONSE HELPERS — biar response konsisten di semua method
    // ================================================================

    private function successResponse(string $message, $data = null, int $status = 200)
    {
        $response = ['success' => true, 'message' => $message];
        if (!is_null($data)) $response['data'] = $data;
        return response()->json($response, $status);
    }

    private function errorResponse(string $message, int $status)
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }

    private function forbiddenResponse(string $message)
    {
        return $this->errorResponse($message, 403);
    }

    private function notFoundResponse(string $message)
    {
        return $this->errorResponse($message, 404);
    }

    private function validationErrorResponse($validator)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal.',
            'errors'  => $validator->errors(),
        ], 422);
    }
}