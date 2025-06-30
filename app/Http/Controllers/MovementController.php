<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $batchId = $request->query('batch_id');
        $vendors = Vendor::all();

        if (!$batchId) {
            return redirect()->route('movements.select-batch')->with('error', 'Please select a batch first.');
        }

        $batch = Batch::findOrFail($batchId);

        return view('batches.create', compact('batch', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'vendor_id' => 'nullable|integer',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date|before_or_equal:today',
            'expired' => 'required|date|after_or_equal:production_date',
            'note' => 'nullable|string',
            'product_id' => 'required|exists:products,id'
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
