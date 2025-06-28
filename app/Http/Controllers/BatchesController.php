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
            'production_date' => 'nullable|date|before_or_equal:today',
            'expired' => 'nullable|date|after_or_equal:production_date',
            'note' => 'nullable|string',
            'product_id' => 'required|exists:products,id'
        ]);

        // Jika vendor_id = 0, set ke null
        $vendorId = $validated['vendor_id'] == 0 ? null : $validated['vendor_id'];

        // Buat batch baru 
        $batch = Batch::create([
            'product_id' => $validated['product_id'],
            'batch_code' => '', // placeholder sementara
            'stock' => $validated['quantity'],
            'prdouction_date' => $validated['production_date'] ?? null,
            'expired' => $validated['expired'] ?? null,
        ]);

        // Buat movement
        $movement = Movement::create([
            'vendor_id' => $vendorId,
            'batch_id' => $batch->id,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
            'user_id' => Auth::user()->id,
            'operator_name' => Auth::user()->name,
        ]);

        // Ambil product
        $product = Product::findOrFail($validated['product_id']);

        // Format bulan-tahun
        $monthYear = now()->format('mY');
        if (!empty($validated['production_date'])) {
            $monthYear = Carbon::parse($validated['production_date'])->format('mY');
        }

        // Generate batch code
        $batchCode = sprintf(
            '%s-%s-%s-%d-%d',
            Str::studly(str_replace(' ', '', $product->name)),
            strtoupper($validated['type']),
            $monthYear,
            $batch->id,
            $movement->id
        );

        // Update batch dengan batch_code
        $batch->update([
            'batch_code' => $batchCode,
        ]);

        return redirect()
            ->route('batches.index')
            ->with('success', 'Restock berhasil disimpan dengan Batch Code: ' . $batchCode);
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
