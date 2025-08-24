<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    public function index()
    {
        $cutis = Cuti::where('user_id', Auth::id())->get();
        return view('cuti.index', compact('cutis'));
    }

    public function create()
    {
        return view('cuti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:255',
        ]);

        Cuti::create([
            'user_id' => Auth::id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diajukan');
    }

    // HR: lihat semua cuti
public function indexAll()
{
    $cutis = Cuti::with('user')->latest()->get();
    return view('hr.management', compact('cutis'));
}

public function approve($id)
{
    $cuti = Cuti::findOrFail($id);
    $cuti->update(['status' => 'approved']);

    return back()->with('success', 'Cuti berhasil disetujui.');
}

public function reject($id)
{
    $cuti = Cuti::findOrFail($id);
    $cuti->update(['status' => 'rejected']);

   return back()->with('success', 'Cuti ditolak.');
}

}
