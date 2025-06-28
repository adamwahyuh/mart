<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Batch;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Movement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->search;

        $batches = Batch::with(['product', 'movements'])
            ->search($search)
            ->latest()
            ->get();

        return view('batches.index', [
            'title' => 'Daftar Batches',
            'batches' => $batches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function selectProduct()
    {
        $categories = Category::with('products')->get();

        return view('batches.select-product', compact('categories'));
    }

    public function create(Request $request)
    {
        //
        $productId = $request->query('product_id');
        $vendors = Vendor::all();

        if (!$productId) {
            return redirect()->route('batches.select-product')->with('error', 'Please select a product first.');
        }

        $product = Product::findOrFail($productId);

        return view('batches.create', compact('product', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|integer',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'production_date' => 'required|date|before_or_equal:today',
            'expired' => 'required|date|after_or_equal:production_date',
            'note' => 'nullable|string',
            'product_id' => 'required|exists:products,id'
        ]);

        $vendorId = $validated['vendor_id'] == 0 ? null : $validated['vendor_id'];

        // cari batch yang existing (berdasarkan product_id + production_date + expired)
        $batch = Batch::where('product_id', $validated['product_id'])
            ->whereDate('prdouction_date', $validated['production_date'] ?? null)
            ->whereDate('expired', $validated['expired'] ?? null)
            ->first();

        if ($batch) {
            // Batch sudah ada → update stock
            if ($validated['type'] == 'in') {
                $batch->stock += $validated['quantity'];
            } else {
                $batch->stock -= $validated['quantity'];
                if ($batch->stock < 0) {
                    return back()->withErrors(['quantity' => 'Stock tidak mencukupi untuk movement OUT.']);
                }
            }
            $batch->save();

        } else {
            // Batch belum ada → create baru
            $batch = Batch::create([
                'product_id' => $validated['product_id'],
                'batch_code' => '', // sementara kosong, diisi di bawah
                'stock' => $validated['quantity'],
                'prdouction_date' => $validated['production_date'] ?? null,
                'expired' => $validated['expired'] ?? null,
            ]);
        }

        // create movement record
        $movement = Movement::create([
            'vendor_id' => $vendorId,
            'batch_id' => $batch->id,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
            'user_id' => Auth::id(),
            'operator_name' => Auth::user()->name,
        ]);

        // generate batch_code (kalau masih kosong saja)
        if (empty($batch->batch_code)) {
            $product = Product::findOrFail($validated['product_id']);

            $monthYear = now()->format('mY');
            if (!empty($validated['production_date'])) {
                $monthYear = \Carbon\Carbon::parse($validated['production_date'])->format('mY');
            }

            $batchCode = sprintf(
                '%s-%s-%s-%d',
                Str::studly(str_replace(' ', '', $product->name)),
                strtoupper($validated['type']),
                $monthYear,
                $batch->id
            );

            $batch->update(['batch_code' => $batchCode]);
        }

        return redirect()
            ->route('batches.index')
            ->with('success', 'Movement berhasil disimpan ke Batch: ' . $batch->batch_code);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $batch = Batch::with(['product', 'movements.vendor', 'movements.user'])
            ->findOrFail($id);

        return view('batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
        return view('batches.edit', [
            'title' => 'Edit Batch',
            'batch' => $batch,
            'vendors' => Vendor::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        //
        $request->validate([
            // 'quantity' => 'required|integer|min:0',
            'prdouction_date' => 'required|date|before_or_equal:today',
            'expired' => 'required|date|after_or_equal:prdouction_date',
            // 'note' => 'nullable|string',
        ]);

        // ambil movement pertama yang terkait batch
        // $movement = $batch->movements()->first();

        // if ($movement) {
        //     $movement->update([
        //         'quantity' => $request->quantity,
        //         'note' => $request->note,
        //     ]);
        // }

        // update batch stock juga biar sinkron
        $batch->update([
            'prdouction_date' => $request->prdouction_date,
            'expired' => $request->expired,
            // 'stock' => $request->quantity,
        ]);

        return redirect()->route('batches.index')->with('success', 'Batch berhasil diupdate!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        //
        try {
            $batch->delete();

            return redirect()
                ->route('batches.index')
                ->with('success', 'Batch berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('batches.index')
                ->with('error', 'Terjadi kesalahan saat menghapus batch: ' . $e->getMessage());
        }
    }
}
