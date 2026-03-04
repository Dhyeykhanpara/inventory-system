<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $products = Product::all();

        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {

        $products = $request->product_id;
        $quantities = $request->quantity;

        foreach ($products as $key => $product_id) {
            $product = Product::findOrFail($product_id);
            $qty = $quantities[$key];

            if ($product->stock < $qty) {
                return back()->with('error', "Not enough stock for product: {$product->name}");
            }
        }

        DB::beginTransaction();

        try {

            $total = 0;

            $order = Order::create([
                'customer_name' => $request->customer_name,
                'total_amount' => 0,
            ]);

            foreach ($request->product_id as $key => $product_id) {
                $product = Product::findOrFail($product_id);
                $qty = $request->quantity[$key];

                // if ($product->stock < $qty) {
                //     throw new \Exception("Not enough stock for this product ");
                // }

                $price = $product->price * $qty;
                OrderItem::Create([
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'quantity' => $qty,
                    'price' => $product->price,
                ]);
                $product->decrement('stock', $qty);
                $total += $price;
            }
            $order->update(['total_amount' => $total]);
            DB::commit();
            return back()->with('success', 'Order Created Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
