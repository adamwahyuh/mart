<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Batch;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    //
    public function index(){
        $totalProduct = Product::count();
        $totalBatch = Batch::count();
        $operators = User::whereHas('orders')
            ->with(['orders' => function ($query) {
                $query->latest();
            }])
            ->get();

        $totalTodayOrder = Order::whereDate('created_at', Carbon::today())->count();
        $totalOrder = Order::count();
        $totalWeekOrder = Order::whereBetween('created_at', [
            Carbon::now()->subDays(6)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();

        $totalMonthOrder = Order::whereBetween('created_at', [
            Carbon::now()->subDays(29)->startOfDay(),
            Carbon::now()->endOfDay()
        ])->count();

        // 
       $latestMovements = Movement::with(['vendor', 'batch', 'user'])
        ->latest()
        ->paginate(10);

        $vendors = Vendor::latest()->paginate(10);

        return view('dashboard.index', compact('totalProduct', 
        'operators', 'totalBatch', 
        'totalTodayOrder','totalWeekOrder','totalMonthOrder',
        'totalOrder', 'latestMovements', 'vendors'));
    }
}
