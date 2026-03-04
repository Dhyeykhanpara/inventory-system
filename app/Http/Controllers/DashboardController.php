<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalOrders = Order::count();

        $totalRevenue = Order::sum('total_amount');

        $totalStockProducts = Product::where('stock', '<' , 5)->get();

        return view('dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'totalStockProducts'));
    }
}
