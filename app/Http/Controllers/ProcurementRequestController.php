<?php

namespace App\Http\Controllers;

use App\Models\ProcurementRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProcurementRequestRequest;
use App\Http\Requests\UpdateProcurementRequestRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProcurementRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'manager') {
            $requests = ProcurementRequest::with('material', 'requester', 'approver')->latest()->paginate(20);
        } else {
            // procurement atau user biasa: lihat request sendiri
            $requests = ProcurementRequest::with('material')->where('requested_by', $user->id)->latest()->paginate(20);
        }

        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        $materials = Inventory::all();
        return view('requests.create', compact('materials'));
    }

    public function store(StoreProcurementRequestRequest $request)
    {
        $data = $request->validated();
        $data['requested_by'] = Auth::id();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('procurement_photos', 'public');
            $data['photo'] = $path;
        }

        $proc = ProcurementRequest::create($data);

        return redirect()->route('requests.index')->with('success', 'Request submitted.');
    }

    public function show(ProcurementRequest $request)
    {
        $request->load('material', 'requester', 'approver');
        return view('requests.show', ['request' => $request]);
    }

    public function edit(ProcurementRequest $request)
    {
        // hanya owner dan status pending boleh edit
        $this->authorizeEdit($request);
        $materials = Inventory::all();
        return view('requests.edit', compact('request', 'materials'));
    }

    public function update(UpdateProcurementRequestRequest $req, ProcurementRequest $request)
    {
        $this->authorizeEdit($request);
        $data = $req->validated();

        if ($req->hasFile('photo')) {
            // hapus file lama jika ada
            if ($request->photo) Storage::disk('public')->delete($request->photo);
            $data['photo'] = $req->file('photo')->store('procurement_photos', 'public');
        }

        $request->update($data);
        return redirect()->route('requests.index')->with('success', 'Request updated.');
    }

    public function destroy(ProcurementRequest $request)
    {
        $this->authorizeEdit($request);
        if ($request->photo) Storage::disk('public')->delete($request->photo);
        $request->delete();
        return back()->with('success', 'Request deleted.');
    }

    // Approve (manager only)
    public function approve(ProcurementRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'manager') abort(403);

        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $request->status = 'approved';
        $request->approved_by = $user->id;
        $request->save();

        // jika restock -> update inventory stock
        if ($request->type_request === 'restock' && $request->material) {
            $inv = $request->material;
            $inv->stock = ($inv->stock ?? 0) + $request->quantity;
            $inv->save();
        }

        // jika new_request -> optional: buat entry di inventory
        if ($request->type_request === 'new_request') {
            // opsi: otomatis masukkan ke inventory
            Inventory::create([
                'material_name' => $request->item_name,
                'material_code' => 'AUTO-' . time(),
                'stock' => $request->quantity,
                'unit' => 'pcs', // sesuaikan
            ]);
        }

        return back()->with('success', 'Request approved.');
    }

    // Reject
    public function reject(ProcurementRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'manager') abort(403);

        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $request->status = 'rejected';
        $request->approved_by = $user->id;
        $request->save();

        return back()->with('success', 'Request rejected.');
    }

    protected function authorizeEdit(ProcurementRequest $request)
    {
        $user = Auth::user();
        if ($request->requested_by !== $user->id || $request->status !== 'pending') {
            abort(403);
        }
    }

    // ProcurementRequestController.php
public function indexApproval()
{
    $user = Auth::user();

    if (!in_array($user->role, ['Procurement', 'Manager'])) {
        abort(403);
    }

    $requests = ProcurementRequest::with('material', 'requester', 'approver')
        ->latest()
        ->paginate(20);

    return view('procurement.index', compact('requests'));
}

}
