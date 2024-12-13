<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('manufacturer')->get();
    }

    public function show($id)
    {
        return Product::with('manufacturer')->findOrFail($id);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'product_type' => 'required|in:bulk,merge', // "bulk" for individual bulk buy, "merge" for merge buy
            'minimum_order_quantity' => 'required_if:product_type,bulk|integer',
            'available_quantity' => 'required|integer',
            'merge_buy_limit' => 'required_if:product_type,merge|integer',
            'merge_buy_price' => 'required_if:product_type,merge|numeric',
        ]);

        // Create the product
        $product = new Product($request->all());
        
        if ($request->product_type === 'bulk') {
            // Handle Individual Bulk Buy
            $product->minimum_order_quantity = $request->minimum_order_quantity;
        } elseif ($request->product_type === 'merge') {
            // Handle Merge Buy
            $product->merge_buy_limit = $request->merge_buy_limit;
            $product->merge_buy_price = $request->merge_buy_price;
            $product->merge_buy_quantity = $request->available_quantity / $request->merge_buy_limit; // Divide equally
        }

        $product->save();

        return response()->json($product, 201);
    }
    
    public function listBulkBuyProducts()
    {
        // Retrieve products with the 'bulk' product type
        $bulkProducts = Product::where('product_type', 'bulk')->get();

        // Return the list of bulk products as a JSON response
        return response()->json($bulkProducts, 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'product_type' => 'required|in:bulk,merge', // "bulk" for individual bulk buy, "merge" for merge buy
            'minimum_order_quantity' => 'required_if:product_type,bulk|integer',
            'available_quantity' => 'required|integer',
            'merge_buy_limit' => 'required_if:product_type,merge|integer',
            'merge_buy_price' => 'required_if:product_type,merge|numeric',
        ]);

        // Update the product
        $product->update($request->all());

        if ($request->product_type === 'bulk') {
            // Update Individual Bulk Buy
            $product->minimum_order_quantity = $request->minimum_order_quantity;
        } elseif ($request->product_type === 'merge') {
            // Update Merge Buy
            $product->merge_buy_limit = $request->merge_buy_limit;
            $product->merge_buy_price = $request->merge_buy_price;
            $product->merge_buy_quantity = $request->available_quantity / $request->merge_buy_limit; // Divide equally
        }

        $product->save();

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
