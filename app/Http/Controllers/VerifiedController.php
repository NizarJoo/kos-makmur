<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;

class VerifiedController extends Controller
{
    // Tampilkan daftar kos yang perlu diverifikasi
    public function index()
    {
        $kos = Kos::with('admin')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('verified.index', compact('kos'));
    }

    // Terima kos
    public function accept(Kos $kos)
    {
        $kos->update([
            'status_verifikasi' => 'diterima',
        ]);

        return redirect()->route('verified.index')->with('success', 'Kos berhasil diterima.');
    }

    // Tolak kos
    public function reject(Kos $kos)
    {
        $kos->update([
            'status_verifikasi' => 'ditolak',
        ]);

        return redirect()->route('verified.index')->with('error', 'Kos berhasil ditolak.');
    }
}
