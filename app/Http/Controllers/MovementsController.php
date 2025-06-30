<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Vendor;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function selectBatch(){
        $batches = Batch::with('product')->latest()->get();

        // Group batches berdasarkan production_date - expired
        $groupedBatches = $batches->groupBy(function($batch) {
            $prod = $batch->production_date ? \Carbon\Carbon::parse($batch->production_date)->format('d-m-Y') : '-';
            $exp = $batch->expired ? \Carbon\Carbon::parse($batch->expired)->format('d-m-Y') : '-';
            return "{$prod} - {$exp}";
        });

        return view('stocks.select-batch', [
            'groupedBatches' => $groupedBatches
        ]);
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

        $batch = Batch::with('product')->findOrFail($batchId);
        $product = $batch->product;

        return view('stocks.create', compact('batch', 'product', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'vendor_id' => 'nullable|integer',
            'type'      => 'required|in:in,out',
            'quantity'  => 'required|integer|min:1',
            'note'      => 'nullable|string',
            'batch_id'  => 'required|exists:batches,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $vendorId = $validated['vendor_id'] == 0 ? null : $validated['vendor_id'];

        $batch = Batch::with('product')->findOrFail($validated['batch_id']);

        if ($batch->product_id != $validated['product_id']) {
            return back()->withErrors(['product_id' => 'Batch tidak sesuai dengan produk.'])->withInput();
        }

        if ($validated['type'] === 'in') {
            $batch->stock += $validated['quantity'];
        } else {
            if ($batch->stock < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Stock tidak mencukupi untuk movement OUT.'])->withInput();
            }
            $batch->stock -= $validated['quantity'];
        }

        $batch->save();

        Movement::create([
            'vendor_id'     => $vendorId,
            'batch_id'      => $batch->id,
            'type'          => $validated['type'],
            'quantity'      => $validated['quantity'],
            'note'          => $validated['note'] ?? null,
            'user_id'       => Auth::id(),
            'operator_name' => Auth::user()->name,
        ]);

        return redirect()
            ->route('batches.index')
            ->with('success', 'Movement berhasil disimpan ke Batch: ' . $batch->batch_code);

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
