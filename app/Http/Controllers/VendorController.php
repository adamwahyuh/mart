<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('vendors.index', [
            'title' => 'Vendors',
            'vendors' => Vendor::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create', [
            'title' => 'Tambah Vendor',
        ]);
    }

    /**
     * Simpan vendor baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vendors,name',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
        ]);

        Vendor::create($validated);

        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
        return view('vendors.edit', [
            'title' => 'Edit Vendor',
            'vendor' => $vendor
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vendors,name,' . $vendor->id,
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil dihapus.');
    }

}
