<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Method to list all orders with product and manufacturer information
    public function index()
    {
        // Eager load the product and manufacturer information
        $orders = Order::with(['product.manufacturer'])->get();

        // If you want to include more specific data, you can customize it here
        return response()->json($orders, 200);
    }

    // Method to place an order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'buyer_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'order_type' => 'required|in:individual,merge',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->order_type === 'individual') {
            if ($request->quantity < $product->minimum_order_quantity) {
                return response()->json(['error' => 'Quantity must be at least the minimum order quantity'], 400);
            }
        } elseif ($request->order_type === 'merge') {
            if (is_null($product->merge_buy_limit) || is_null($product->merge_buy_quantity)) {
                return response()->json(['error' => 'Product does not support merge buys'], 400);
            }

            $buyersCount = Order::where('product_id', $product->id)
                                ->where('order_type', 'merge')
                                ->count();

            if ($buyersCount >= $product->merge_buy_limit) {
                return response()->json(['error' => 'Merge buy limit reached'], 400);
            }

            if ($request->quantity % $product->merge_buy_limit !== 0) {
                return response()->json(['error' => 'Quantity must be divisible by the number of buyers for merge buy'], 400);
            }

            $request->merge_buy_quantity_per_buyer = $request->quantity / $product->merge_buy_limit;
        }

        $order = Order::create([
            'product_id' => $request->product_id,
            'buyer_id' => $request->buyer_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
            'order_type' => $request->order_type,
            'merge_buy_quantity_per_buyer' => $request->merge_buy_quantity_per_buyer ?? null,
        ]);

        return response()->json($order, 201);
    }

    // Method to update order status
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully'], 200);
    }
}
