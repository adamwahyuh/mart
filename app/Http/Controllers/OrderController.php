<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
         $search = $request->query('q');

        $orders = Order::query()
            ->when($search, function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('operator_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders', 'search'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function create(Request $request)
    {
        $query = $request->query('q');

        $products = Product::with('category', 'price')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                ->orWhereHas('category', function ($q2) use ($query) {
                    $q2->where('name', 'like', '%' . $query . '%');
                });
            })
            ->get();

        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems = $cart ? $cart->cartItems()->with('product')->get() : collect();

        return view('orders.create', compact('products', 'cart', 'cartItems', 'query'));
    }


    public function addToCart(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['total' => 0]
        );

        $price = $product->price()->latest()->first()?->sell_price ?? 0;
        $qty = $request->qty ?? 1;
        $subtotal = $price * $qty;

        // Tambah atau update CartItem
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->qty += $qty;
            $item->subtotal += $subtotal;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ]);
        }

        // Update total cart
        $cart->total = CartItem::where('cart_id', $cart->id)->sum('subtotal');
        $cart->save();

        return redirect()->route('orders.create')->with('success', 'Product added to cart.');
    }

    public function removeCartItem($id)
    {
        $item = CartItem::findOrFail($id);
        $cart = $item->cart;

        $item->delete();

        $cart->total = CartItem::where('cart_id', $cart->id)->sum('subtotal');
        $cart->save();

        return redirect()->route('orders.create')->with('success', 'Item removed.');
    }

    public function placeOrder(Request $request)
    {
        DB::transaction(function () {
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();
            $cartItems = CartItem::where('cart_id', $cart->id)->get();

            if ($cartItems->count() === 0) {
                abort(400, 'Cart is empty.');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'operator_name' => Auth::user()->name,
                'payment' => 'tunai', // sementara default, bisa diganti pakai $request
                'status' => 'process',
                'total' => $cart->total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // kosongkan cart
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->total = 0;
            $cart->save();
        });

        return redirect()->route('orders.create')->with('success', 'Order placed successfully!');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:process,done,cancel',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status berhasil diupdate.');
    }
}
