<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class BatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('batches.index');
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

        if (!$productId) {
            return redirect()->route('batches.select-product')->with('error', 'Please select a product first.');
        }

        $product = Product::findOrFail($productId);

        return view('batches.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
