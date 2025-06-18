<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('products.index', [
            'title' => 'Products',
            'products' => Product::with(['category', 'price'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create',['title'=> 'Products'])->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedProducts = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'nullable|string|max:1000',
            'category_id'=> 'required|exists:categories,id',
            'photo'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'modal'=> 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0|gte:modal',
        ],[
            'sell_price.gte' => 'Harga jual harus lebih besar',
            'photo.max'=> 'Maximal ukuran file 2 MB'
        ]);

        if ($request->file('photo')) {
            $validatedProducts['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        $productData = $validatedProducts;
        unset($productData['sell_price'], $productData['modal']);
        
        $productData['user_id'] = Auth::user()->id;
        $productData['operator_name'] = Auth::user()->name;

        $product = Product::create($productData);
        $product->price()->create([
            'sell_price' => $validatedProducts['sell_price'],
            'modal' => $validatedProducts['modal'],
            'profit' => $validatedProducts['sell_price'] - $validatedProducts['modal'],
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $product->load('category'); 
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $product = Product::with('price')->findOrFail($id);
        $categories = Category::all();

        return view('products.edit', [
            'title' => 'Edit ',
            'product' => $product,
            'categories' => $categories,
        ]);
    }

/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
    {
        $product = Product::with('price')->findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'modal' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0|gte:modal',
        ], [
            'sell_price.gte' => 'Harga jual harus lebih besar',
            'photo.max'=> 'Maximal ukuran file 2 MB'
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($product->photo && Storage::disk('public')->exists($product->photo)) {
                Storage::disk('public')->delete($product->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('uploads', 'public');
        }

        // Update data produk (kecuali harga)
        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'photo' => $validatedData['photo'] ?? $product->photo,
        ]);

        // Update harga
        $product->price->update([
            'modal' => $validatedData['modal'],
            'sell_price' => $validatedData['sell_price'],
            'profit' => $validatedData['sell_price'] - $validatedData['modal'],
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->photo && Storage::disk('public')->exists($product->photo)) {
            Storage::disk('public')->delete($product->photo);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted');
        
    }
}
